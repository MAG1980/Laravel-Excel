<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Image\StoreRequest;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(StoreRequest $request)
    {
        $validatedRequest = $request->validated();

        if ($request->hasFile('image')) {
            // Сохраняем файл в директории 'uploads' на диске 'public'
            $path = $request->file('image')->store('/files/uploads/images', 'public');

            // Возвращаем JSON-ответ
            return response()->json([
                'message' => 'File uploaded successfully',
                'path'    => $path,
                // Публичный URL для доступа
                'url'     => Storage::url($path),
            ], 200);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
