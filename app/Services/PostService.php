<?php

namespace App\Services;

use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
        protected ImageService $imageService,
    ) {}

    /**
     * Создать пост с изображением.
     *
     * @param  UploadedFile  $image
     */
    public function createPost(array $data, $image): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userId = auth()->id();

            // Создаём пост
            $post = $this->postRepository->create([
                'user_id' => $userId,
                'title' => $data['title'],
                'content' => $data['content'],
            ]);

            // Сохраняем файл изображения на диск в БД
            $postImage = $this->imageService->uploadAndCreate(
                $image, $userId, $post->id
            );

            // Устанавливаем отношение для избежания лишнего запроса
            $post->setRelation('postImage', $postImage);

            DB::commit();

            return $post;
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage(),
            ]);
            // throw $e; // или логируем и пробрасываем дальше
        }
    }
}
