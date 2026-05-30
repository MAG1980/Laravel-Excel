<?php

namespace App\Imports;

use App\Factories\ProjectFactory;
use App\Models\FailedRow;
use App\Models\Project;
use App\Models\Task;
use App\Models\Type;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ProjectsImport implements SkipsEmptyRows, SkipsOnFailure, ToCollection, WithValidation
{
    private Task $task;

    /**
     * @param $task
     */
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

    public function collection(Collection $collection)
    {
        $types = $this->getTypesMap(Type::all());

        foreach ($collection as $row) {
            if ($row->isEmpty() || $row[0] === 'Тип') {
                continue;
            }

            dump($row);

            $project = ProjectFactory::make($types, $row->toArray());

            Project::updateOrCreate([
                'type_id' => $project['type_id'],
                'title' => $project['title'],
                'comment' => $project['comment'],
                'contracted_at' => $project['contracted_at'],
                'created_at_date' => $project['created_at_date'],
            ], $project);
        }
    }

    public function rules(): array
    {
        return [
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
            11 => 'nullable|integer',
            12 => 'nullable|integer',
            13 => 'required|integer',
            14 => 'nullable|integer',
            15 => 'nullable|string',
            16 => 'nullable|numeric',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        $failuresMap = [];
        foreach ($failures as $failure) {
            foreach ($failure->errors() as $error) {
                $failuresMap[] = [
                    'key' => $this->getAttributeName($failure->attribute()),
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

    private function getAttributeName(int $attribute): string
    {
        $map = [
            0 => 'Тип',
            1 => 'Заголовок',
            2 => 'Дата заключения договора',
            3 => 'Сетевик',
            4 => 'Количество сотрудников',
            5 => 'Аутсорс',
            6 => 'Инвесторы',
            7 => 'Дедлайн',
            8 => 'Закончен в срок',
            9 => 'Оплата первого этапа',
            10 => 'Оплата второго этапа',
            11 => 'Оплата третьего этапа',
            12 => 'Оплата четвёртого этапа',
            13 => 'Законтрактован',
            14 => 'Количество услуг',
            15 => 'Комментарий',
            16 => 'Эффективность',
        ];

        return $map[$attribute];
    }
}
