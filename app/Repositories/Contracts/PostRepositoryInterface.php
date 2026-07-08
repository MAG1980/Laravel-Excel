<?php

namespace App\Repositories\Contracts;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function create(array $data): Post;
    // другие методы: find, update, delete, paginate и т.д.
}
