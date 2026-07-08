<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\StoreRequest;
use App\Http\Resources\Api\Post\PostResource;
use App\Services\PostService;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        $createdPost = $this->postService->createPost($validated, $validated['image']);

        return PostResource::make($createdPost);
    }
}
