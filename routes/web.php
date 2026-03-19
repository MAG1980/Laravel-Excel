<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/import', [ProjectController::class, 'importShow'])->name('projects.import.show');
Route::post('/projects/import', [ProjectController::class, 'importStore'])->name('projects.import.store');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

require __DIR__ . '/settings.php';
