<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ImportStoreRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Jobs\ImportProjectExcelFileJob;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Controller
{
    /**
     * @param ImportStoreRequest $request
     * @return void
     * @throws \Exception
     */
    public function importStore(ImportStoreRequest $request)
    {
        $data = $request->validated();
        $file = File::createFile($data['file']);

        $task = Task::create([
            'user_id' => auth()->id(),
            'file_id' => $file->id,
            'status' => Task::STATUS_IN_PROGRESS,
            'type' => $data['type'],
        ]);


        //dispatchSync() блокируют выполнение до завершения и используется только для отладки
        ImportProjectExcelFileJob::dispatchSync($file->path, $task);
    }

    //

    public function index()
    {
        $projects = Project::paginate(5);
        $projects = ProjectResource::collection($projects);

        return inertia('project/Index', compact('projects'));
    }

    public function importShow()
    {
        return inertia('project/Import');
    }
}
