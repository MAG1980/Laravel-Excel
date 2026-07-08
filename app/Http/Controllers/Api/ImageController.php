<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Image\StoreRequest;
use App\Http\Resources\PostImage\PostImageResource;
use App\Services\ImageService;

class ImageController extends Controller
{
    public function __construct(
        protected ImageService $imageService
    )
    {
    }

    public function store(StoreRequest $request)
    {
        $validatedRequest = $request->validated();

        if ($request->hasFile('image')) {
            // Загружаем файл в директории 'uploads/images' на диске 'public' и сохраняем в БД
            $image = $this->imageService->uploadAndCreate(
                $request->file('image'),
                auth()->user()->id,
                $validatedRequest['post_id'] ?? null,
                $validatedRequest['is_active'],
                'uploads/images', 'public');

            // Возвращаем JSON-ответ
            return (new PostImageResource($image))
                ->response()
                ->setStatusCode(201);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
