<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\PostCreationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\StoreRequest;
use App\Http\Resources\Api\Post\PostResource;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $createdPost = $this->postService->createPost(
                $validated,
                $validated['image'],
                $request->user()->id
            );

            return PostResource::make($createdPost)
                ->additional(['message' => 'Пост успешно создан'])
                ->response()
                ->setStatusCode(201);

        } catch (PostCreationException $e) {
            // Логируем с контекстом
            Log::warning('Ошибка создания поста', [
                'user_id' => $request->user()->id ?? null,
                'message' => $e->getMessage(),
                'context' => $e->getContext(),
                'code' => $e->getCode(),
            ]);

            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $e->getStatusCode());

        } catch (\Exception $e) {
            Log::error('Неожиданная ошибка при создании поста', [
                'user_id' => $request->user()->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'Внутренняя ошибка сервера',
            ], 500);
        }
    }
}
