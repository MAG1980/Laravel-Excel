<?php

use App\Http\Controllers\Api\GetController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::get('/get', GetController::class)->name('api.get');
        Route::post('/posts', [PostController::class, 'store'])->name('api.posts.store');

        Route::post('/images', [ImageController::class, 'store'])->name('api.image.store');
    });




