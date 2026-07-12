<?php

namespace App\Http\Resources\Api\PostImage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PostImageResource extends JsonResource
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
            'post_id' => $this->post_id,
            'path' => $this->path,
            // Публичный URL для доступа
            'url' => Storage::url($this->path),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
