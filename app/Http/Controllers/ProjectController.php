<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ImportStoreRequest;
use App\Jobs\ImportProjectExcelFileJob;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    //
    public function index()
    {
        return inertia('project/Index');
    }

    public function importShow()
    {
        return inertia('project/Import');
    }

    /**
     * @param ImportStoreRequest $request
     * @return void
     * @throws \Exception
     */
    public function importStore(ImportStoreRequest $request)
    {
        $data = $request->validated();
        $path = File::createFile($data['file']);

        //dispatchSync() блокируют выполнение до завершения и используется только для отладки
        ImportProjectExcelFileJob::dispatchSync($path);
    }
}
