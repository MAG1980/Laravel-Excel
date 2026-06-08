<?php

use App\Models\FailedRow;
use App\Models\Task;

if (!function_exists('processFailures')){
    function processFailures($failures, array $attributesNames, Task $task) {
        $failuresMap = [];
        foreach ($failures as $failure) {
            foreach ($failure->errors() as $error) {
                $failuresMap[] = [
                    'key' => $attributesNames[$failure->attribute()],
                    'row' => $failure->row(),
                    'message' => $error,
                    // Временный ID задачи (для тестирования)
                    'task_id' => $task->id,
                ];
            }

            // Сохраняем информацию об ошибках в БД.
            if (count($failuresMap)) {
                $task->update([
                    'status' => Task::STATUS_FAILED,
                ]);

                FailedRow::insertFailedRows($failuresMap, $task);
            }
        }

    }
}
