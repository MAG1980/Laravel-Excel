<?php

namespace App\Imports;

use App\Factories\ProjectDynamicFactory;
use App\Models\FailedRow;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Task;
use App\Models\Type;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Validators\Failure;

class ProjectsDynamicImport implements SkipsOnFailure, ToCollection, WithEvents, WithStartRow, WithValidation
{
    use RegistersEventListeners;

    private Task $task;

    // Строки заголовка получаем из Event во время импорта файла
    private static array $headings = [];

    // Номер последнего столбца, после которого начинаются динамические данные
    const STATIC_ROW = 12;

    public function __construct($task)
    {
        $this->task = $task;
    }

    private function getTypesMap($types): array
    {
        $map = [];

        foreach ($types as $type) {
            $map[$type->title] = $type->id;
        }

        return $map;
    }

    /**
     * @return array{static: array, dynamic: array}
     */
    private function getRowMap(Collection|array $row): array
    {
        $staticMap = [];
        $dynamicMap = [];
        foreach ($row as $key => $value) {
            if (is_null($value)) {
                continue;
            }
            // Безопасное сравнение: только числовые ключи
            if (is_numeric($key) && $key <= self::STATIC_ROW) {
                $staticMap[$key] = $value;
            } else {
                $dynamicMap[$key] = $value;
            }
        }

        return [
            'static' => $staticMap,
            'dynamic' => $dynamicMap,
        ];
    }

    public function collection(Collection $collection)
    {
        $types = $this->getTypesMap(Type::all());

        foreach ($collection as $row) {
            if ($row->isEmpty()) {
                continue;
            }

            ['static' => $staticProps, 'dynamic' => $dynamicProps] = $this->getRowMap($row);

            $project = ProjectDynamicFactory::make($types, $staticProps);

            $dbProject = Project::updateOrCreate([
                'type_id' => $project['type_id'],
                'title' => $project['title'],
                'comment' => $project['comment'],
                'contracted_at' => $project['contracted_at'],
                'created_at_date' => $project['created_at_date'],
            ], $project);

            if (!isset($dynamicProps)) {
                continue;
            }

            // Получаем массив заголовков динамических столбцов
            $dynamicHeadings = $this->getRowMap(self::$headings)['dynamic'];

            foreach ($dynamicProps as $key => $paymentValue) {
                Payment::create([
                    'project_id' => $dbProject->id,
                    'title' => $dynamicHeadings[$key],
                    'value' => $paymentValue,
                ]);
            }
        }
    }

    public function rules(): array
    {
        // Сравнивает ключи и заменяет значения значениями из второго массива,
        // но в нашем случае ключи не повторяются, поэтому получаем массив, содержащий
        // значения обоих массивов, даже разреженных.
        return array_replace([
            0 => 'required|string',
            1 => 'required|string',
            2 => 'required|integer',
            3 => 'nullable|string',
            4 => 'integer',
            5 => 'nullable|string',
            6 => 'nullable|string',
            7 => 'nullable|integer',
            8 => 'nullable|string',
            9 => 'nullable|integer',
            10 => 'nullable|integer',
            11 => 'nullable|string',
            12 => 'nullable|string',
        ], $this->getDynamicValidationRules());
    }

    public function onFailure(Failure ...$failures)
    {
        $failuresMap = [];
        foreach ($failures as $failure) {
            foreach ($failure->errors() as $error) {
                $failuresMap[] = [
                    'key' => $this->getAttributeNames($failure->attribute()),
                    'row' => $failure->row(),
                    'message' => $error,
                    // Временный ID задачи (для тестирования)
                    'task_id' => $this->task->id,
                ];
            }
        }

        // Сохраняем информацию об ошибках в БД.
        if (count($failuresMap)) {
            $this->task->update([
                'status' => Task::STATUS_FAILED,
            ]);

            FailedRow::insertFailedRows($failuresMap, $this->task);
        }
    }

    public function isEmptyWhen(array $row): bool
    {
        // Если в столбце 'Тип' отсутствуют данные или это строка-заголовок таблицы,
        // строка считается пустой для предотвращения ложных ошибок валидации.
        return empty($row['0']) || $row[0] === 'Тип';
    }

    /** Кастомные сообщения валидации
     * @return string[]
     */
    public function customValidationMessages(): array
    {
        return [
            '0.string' => 'Тип данных type_id должен быть string',
            '2.integer' => 'Тип данных created_at_date должен быть integer',
        ];
    }

    private function getAttributeNames(int $attributeColumnNumber): string
    {
        $staticAttributesMap = [
            0 => 'Тип',
            1 => 'Заголовок',
            2 => 'Дата заключения договора',
            3 => 'Сетевик',
            4 => 'Количество сотрудников',
            5 => 'Аутсорс',
            6 => 'Инвесторы',
            7 => 'Дедлайн',
            8 => 'Закончен в срок',
            9 => 'Законтрактован',
            10 => 'Количество услуг',
            11 => 'Комментарий',
            12 => 'Эффективность',
        ];

        $dynamicAttributesMap = $this->getDynamicAttributeNames();

        $resultAttributesMap = array_replace($staticAttributesMap, $dynamicAttributesMap);;

        return $resultAttributesMap[$attributeColumnNumber];
    }

    public function startRow(): int
    {
        // Возвращает номер строки в файле .xls, с которого нужно начинать импорт данных
        return 2;
    }

    public static function beforeSheet(BeforeSheet $beforeSheetEvent)
    {
        self::$headings = $beforeSheetEvent->getSheet()->getDelegate()->toArray()[0];
    }

    private function getDynamicValidationRules(): array
    {
        $dynamicRowHeaders = $this->getRowMap(self::$headings)['dynamic'];
        $rules = [];

        foreach ($dynamicRowHeaders as $key => $value) {
            // Кастомное правило валидации
            $rules[$key] = 'required|integer';
        }

        return $rules;
    }

    private function getDynamicAttributeNames(): array
    {
        return $this->getRowMap(self::$headings)['dynamic'];
    }
}
