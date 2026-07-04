<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Image\StoreRequest;
use App\Http\Resources\PostImage\PostImageResource;
use App\Models\PostImage;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(StoreRequest $request)
    {
        $validatedRequest = $request->validated();

        if ($request->hasFile('image')) {
            // Сохраняем файл в директории 'uploads' на диске 'public'
            $path = $request->file('image')->store('/files/uploads/images', 'public');

            $image = PostImage::create([
                'user_id' => auth()->user()->id ?? null,
                'post_id' => $validatedRequest['post_id'] ?? null,
                'path' => $path,
                'is_active' => $validatedRequest['is_active'] ?? false,
            ]);

            // Возвращаем JSON-ответ
            return (new PostImageResource($image))
                ->response()
                ->setStatusCode(201);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
