<?php

namespace App\Http\Controllers;

use App\Http\Resources\Task\TaskResource;
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

        $tasks = Task::with(['user', 'file'])->get();
        $tasks = TaskResource::collection($tasks);

//        return Inertia::render('task/Index', compact('tasks'));
        return Inertia::render('task/Index', compact('tasks'));

    }
}
