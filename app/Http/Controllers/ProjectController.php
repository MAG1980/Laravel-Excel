<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ImportStoreRequest;
use App\Jobs\ImportProjectExcelFileJob;
use App\Models\File;

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

        //dispatchSync() блокируют выполнение до завершения и используется только для отладки
        ImportProjectExcelFileJob::dispatchSync($file->path);
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
