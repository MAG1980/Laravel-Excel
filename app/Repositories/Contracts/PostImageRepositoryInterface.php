<?php

namespace App\Repositories\Contracts;

use App\Models\PostImage;
use Illuminate\Database\Eloquent\Collection;

interface PostImageRepositoryInterface
{
    public function index(): Collection;

    public function store(int $userId, ?int $postId, string $path, bool $isActive): PostImage;

    public function deleteWithoutPostId(int $userId):int;
}
