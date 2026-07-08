<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Contracts\PostImageRepositoryInterface;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
        protected ImageService            $imageService,
    )
    {
    }

    /**
     * Создать пост с изображением.
     *
     * @param UploadedFile $image
     *
     * @throws \Exception
     */
    public function createPost(array $data, $image): Post
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
            throw $e; // или логируем и пробрасываем дальше
        }
    }
}
