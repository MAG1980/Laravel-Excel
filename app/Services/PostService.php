<?php

namespace App\Services;

use App\Exceptions\PostCreationException;
use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class PostService
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
        protected ImageService $imageService,
    ) {}

    public function createPost(array $data, UploadedFile $image, int $userId): Post
    {
        DB::beginTransaction();

        try {
            // Валидация данных
            if (empty($data['title']) || empty($data['content'])) {
                throw PostCreationException::validationError('title', 'Заголовок и контент обязательны');
            }

            $post = $this->createPostRecord($data, $userId);
            $postImage = $this->attachImageToPost($image, $userId, $post->id);

            $post->setRelation('postImage', $postImage);

            DB::commit();

            return $post;

        } catch (PostCreationException $e) {
            DB::rollBack();
            throw $e; // Пробрасываем дальше для обработки в контроллере
        } catch (\Exception $e) {
            DB::rollBack();

            // Обертываем неожиданное исключение в наше кастомное
            throw new PostCreationException(
                'Не удалось создать пост',
                500,
                $e,
                ['user_id' => $userId, 'data' => $data]
            );
        }
    }

    protected function createPostRecord(array $data, int $userId): Post
    {
        try {
            return $this->postRepository->create([
                'user_id' => $userId,
                'title' => $data['title'],
                'content' => $data['content'],
            ]);
        } catch (\Exception $e) {
            throw PostCreationException::transactionError(
                'Ошибка сохранения поста в БД',
                $e
            );
        }
    }

    protected function attachImageToPost(UploadedFile $image, int $userId, int $postId)
    {
        try {
            return $this->imageService->uploadAndCreate($image, $userId, $postId);
        } catch (\Exception $e) {
            throw PostCreationException::uploadError(
                'Ошибка загрузки изображения',
                $e
            );
        }
    }

    /**
     * Получить пост с изображением.
     */
    public function getPostWithImage(int $postId): ?Post
    {
        $post = $this->postRepository->find($postId);

        if ($post) {
            $post->load('postImage');
        }

        return $post;
    }
}
