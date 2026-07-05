<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\StoreRequest;
use App\Http\Resources\Api\Post\PostResource;
use App\Models\Post;
use App\Models\PostImage;

class PostController extends Controller
{
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();


        $createdPost = Post::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        // Сохранение загруженного файла в storage
        $postImage = $this->saveImage($validated['image'], auth()->id(), $createdPost->id);

        // Вручную устанавливаем отношение, чтобы оно было доступно в ресурсе
        // без лишнего запроса к БД.
        $createdPost->setRelation('postImage', $postImage);

        return PostResource::make($createdPost);
    }

    private function saveImage($image, $authorId, $postId)
    {
        return PostImage::createFromUpload($image,
            [
                'user_id' => $authorId,
                'post_id' => $postId,
                'is_active' => true,
            ]);
    }
}
