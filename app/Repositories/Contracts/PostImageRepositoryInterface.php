<?php

namespace App\Repositories\Contracts;

use App\Models\PostImage;

interface PostImageRepositoryInterface
{
    public function store(int $userId, ?int $postId, string $path, bool $isActive): PostImage;
}
