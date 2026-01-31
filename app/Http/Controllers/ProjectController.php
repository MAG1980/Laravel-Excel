<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function index()
    {
        return inertia('project/Index');
    }

    public function import()
    {
        return inertia('project/Import');
    }
}
