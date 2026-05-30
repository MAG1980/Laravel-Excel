<?php

namespace App\Http\Controllers;

use App\Http\Resources\FailedRow\FailedRowResource;
use App\Http\Resources\Task\TaskResource;
use App\Models\FailedRow;
use App\Models\Task;
use Inertia\Inertia;

class TaskController extends Controller
{
    //
    public function index()
    {
        /*        $tasks = Task::all();
                return Inertia::render('task/Index', ['tasks' => $tasks->toArray()]);

        return Inertia::render('task/Index', ['tasks' => $tasks->toArray()]);
        */

        $tasks = Task::with(['user', 'file'])->withCount('failedRows')->get();
        $tasks = TaskResource::collection($tasks);

//        return Inertia::render('task/Index', compact('tasks'));
        return Inertia::render('task/Index', compact('tasks'));

    }

    public function failedRows(int $taskId)
    {
        $failedRows = FailedRow::where('task_id', (int)$taskId)->get();
        $failedRows = FailedRowResource::collection($failedRows);

        return Inertia::render('task/FailedRows', compact('failedRows'));
    }
}
