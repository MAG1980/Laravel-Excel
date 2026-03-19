<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ImportStoreRequest;
use Illuminate\Http\Request;

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
        dd($data);
    }
}
