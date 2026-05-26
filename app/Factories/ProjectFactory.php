<?php

namespace App\Factories;

use App\Models\Type;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProjectFactory
{
    /**
     * Создаёт массив атрибутов для модели Project из строки Excel.
     *
     * @param  array  $types  Ассоциативный массив [название_типа => id_типа]
     * @param  array  $row  Массив значений строки Excel (индексы от 0)
     */
    public static function make(array $types, array  $row): array
    {
        return [
            'type_id' => self::getTypeId($types, $row[0]),
            'title' => $row[1],
            'created_at_date' => self::ExcelDateToDate($row[2]),
            'is_network' => self::StringToBoolean($row[3]),
            'worker_count' => $row[4] ?? null,
            'has_outsource' => self::StringToBoolean($row[5]),
            'has_investors' => self::StringToBoolean($row[6]),
            'deadline' => isset($row[7]) ? self::ExcelDateToDate($row[7]) : null,
            'is_on_time' => self::StringToBoolean($row[8]),
            'payment_first_step' => $row[9] ?? null,
            'payment_second_step' => $row[10] ?? null,
            'payment_third_step' => $row[11] ?? null,
            'payment_fourth_step' => $row[12] ?? null,
            'contracted_at' => self::ExcelDateToDate($row[13]),
            'service_count' => $row[14] ?? null,
            'comment' => $row[15] ?? null,
            'efficiency' => $row[16] ?? null,
        ];
    }

    /**
     * Возвращает ID типа, создавая новый тип, если его ещё нет.
     */
    private static function getTypeId(array $types, ?string $title): int
    {
        if ($title === null || $title === '') {
            throw new \InvalidArgumentException('Название типа не может быть пустым');
        }

        return $types[$title] ?? Type::create(['title' => $title])->id;
    }

    private static function stringToBoolean(?string $value): ?bool
    {
        if ($value === null) {
            return null;
        }

        return mb_strtolower($value) === 'да';
    }

    private static function excelDateToDate($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        return Carbon::parse($value)->format('Y-m-d');
    }
}
