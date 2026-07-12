<?php

namespace App\Repositories\Eloquent;

use App\Models\PostImage;
use App\Repositories\Contracts\PostImageRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class PostImageRepository implements PostImageRepositoryInterface
{
    public function store(?int $userId, ?int $postId, string $path, bool $isActive): PostImage
    {
        return PostImage::create(
            [
                'user_id' => $userId ?? null,
                'post_id' => $postId ?? null,
                'path' => $path,
                'is_active' => $isActive ?? false,
            ]
        );
    }

    public function deleteWithoutPostId(int $userId): int
    {
        // Сначала получаем записи, которые нужно удалить
        $images = PostImage::where('user_id', $userId)
            ->whereNull('post_id')
            ->get();

        // Удаляем файлы из хранилища
        foreach ($images as $image) {
            try {
                if ($image->path && Storage::disk('public')->exists($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }
            } catch (\Exception $e) {
                // Логируем ошибку, но продолжаем выполнение
                \Log::error("Failed to delete image: {$image->path}", ['error' => $e->getMessage()]);
            }
        }

        // Удаляем записи из базы данных и получаем количество удалённых записей
        $deletedCount = PostImage::where('user_id', $userId)
            ->whereNull('post_id')
            ->delete();

        return $deletedCount;
    }
}
