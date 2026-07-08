<?php

namespace App\Repositories\Eloquent;

use App\Models\PostImage;
use App\Repositories\Contracts\PostImageRepositoryInterface;

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
}
