<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ImportStoreRequest;
use App\Jobs\ImportProjectExcelFileJob;
use App\Models\File;
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
        ]);


        //dispatchSync() блокируют выполнение до завершения и используется только для отладки
        ImportProjectExcelFileJob::dispatchSync($file->path, $task);
    }

    //

    public function index()
    {
        return inertia('project/Index');
    }

    public function importShow()
    {
        return inertia('project/Import');
    }
}
