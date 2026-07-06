<?php

namespace App\Http\Resources\Api\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'authorId' => $this->user_id,
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->postImage ? [
                'id' => $this->postImage->id,
                'path' => $this->postImage->path,
                'url' => Storage::url($this->image->path),
            ] : null,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
