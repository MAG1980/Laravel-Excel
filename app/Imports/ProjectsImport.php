<?php

namespace App\Imports;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProjectsImport implements ToCollection
{
    private function StringToBoolean(string|null $word): bool
    {
        return $word === 'Да';
    }

    /**
     * @param numeric $excelDate
     */
    private function ExcelDateToDate($excelDate): string
    {
        // Проверяем, что значение не пустое и является числом
        if (is_numeric($excelDate)) {
            // Конвертируем Excel-дату в объект DateTime, а затем в нужный формат
            $convertedDate = Date::excelToDateTimeObject($excelDate);

            return $convertedDate->format('Y-m-d'); // или любой другой нужный вам формат
        } else {
            // Обработка случая, если в ячейке уже текст
            return Carbon::parse($excelDate)->format('Y-m-d');
        }
    }

    private function getTypesMap($types): array
    {
        $map = [];

        foreach ($types as $type) {
            $map[$type->title] = $type->id;
        }

        return $map;
    }

    private function getTypeId($array, $title): int
    {
        // Если в таблице types типа не существует, то добавляем его в таблицу
        return isset($array[$title]) ? $array[$title] : Type::create(['title' => $title])->id;
    }


    public function collection(Collection $collection)
    {
        $types = $this->getTypesMap(Type::all());

        foreach ($collection as $row) {
            if ($row->isEmpty() || $row[0] === 'Тип') {
                continue;
            }

            dump($row[2]);

            Project::create([
                'type_id' => $this->getTypeId($types, $row[0]),
                'title' => $row[1],
                'created_at_date' => $this->ExcelDateToDate($row[2]),
                'is_network' => $this->StringToBoolean($row[3]),
                'worker_count' => $row[4],
                'has_outsource' => $this->StringToBoolean($row[5]),
                'has_investors' => $this->StringToBoolean($row[6]),
                'deadline' => $this->ExcelDateToDate($row[7]),
                'is_on_time' => $this->StringToBoolean($row[8]),
                'payment_first_step' => $row[9],
                'payment_second_step' => $row[10],
                'payment_third_step' => $row[11],
                'payment_fourth_step' => $row[12],
                'contracted_at' => $this->ExcelDateToDate($row[13]),
                'service_count' => $row[14],
                'comment' => $row[15],
                'efficiency' => $row[16],
            ]);
        }
    }
}
