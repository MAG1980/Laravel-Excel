<?php

namespace App\Http\Resources\PostImage;

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
            'message' => 'File uploaded successfully',
            'path' => $this->path,
            // Публичный URL для доступа
            'url' => Storage::url($this->path),
            'publicUrl' => $this->getUrlAttribute($this->path),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
