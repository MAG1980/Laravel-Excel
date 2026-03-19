<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ImportStoreRequest;
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

    public function importStore(ImportStoreRequest $request)
    {
        $data = $request->validated();
        $file = $data['file'];
        $path = Storage::disk('public')->put('files/', $data['file']);
        File::create([
            'title'=>$file->getClientOriginalName(),
            'path'=>$path,
            'mime_type'=>$file->getClientOriginalExtension(),

        ]);
        dd($data);
    }
}
