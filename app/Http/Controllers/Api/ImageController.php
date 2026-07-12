<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Image\StoreRequest;
use App\Http\Resources\PostImage\PostImageResource;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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

    /**
     * Удалить записи авторизованного пользователя об изображениях,
     * не связанные с постами, и файлы, связанные с этими записями.
     */
    public function deleteWithoutPostId(): JsonResponse
    {
        try {
            $userId = auth()->user()->id;

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], Response::HTTP_UNAUTHORIZED); // 401
            }

            $countDeletedImages = $this->imageService->deleteWithoutPostId($userId);

            return response()->json([
                'success' => true,
                'message' => $countDeletedImages > 0
                    ? "Successfully deleted {$countDeletedImages} images"
                    : 'No images to delete',
                'count_deleted_images' => $countDeletedImages
            ], Response::HTTP_OK); // 200

        } catch (\Exception $e) {
            Log::error('Failed to delete images', [
                'user_id' => auth()->user()->id ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete images: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR); // 500
        }
    }
}
