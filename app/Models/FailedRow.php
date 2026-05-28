<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedRow extends Model
{
    protected $guarded = [];
    protected $table = 'failed_rows';

    public static function insertFailedRows($items, Task $task): void
    {
        // Записываем строки в таблицу failed_rows с добавлением task_id.
        foreach ($items as $item) {
            FailedRow::create([
                ...$item,
                'task_id' => $task->id,
            ]);
        }

        // Обновляем статус задачи на "Ошибка".
        $task->update([
            'status' => Task::STATUS_FAILED,
        ]);
    }
}
