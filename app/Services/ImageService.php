<?php

namespace App\Services;

use App\Models\PostImage;
use App\Repositories\Contracts\PostImageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{
    public function __construct(
        protected PostImageRepositoryInterface $imageRepository
    )
    {
    }

    private function store(?int $userId, ?int $postId, string $path, bool $isActive = false): PostImage
    {
        return $this->imageRepository->store($userId, $postId, $path, $isActive);
    }

    private function saveFileToDisk(UploadedFile $uploadedFile, string $path = 'uploads/images', string $disk = 'public'): string
    {
        return $uploadedFile->store($path, $disk);
    }

    /**
     * Сохранить файл на диск и создать запись в БД (основной метод для контроллера).
     */
    public function uploadAndCreate(
        UploadedFile $file,
        int          $userId,
        ?int         $postId,
        bool         $isActive = true,
        string       $directory = 'uploads/images',
        string       $disk = 'public'
    ): PostImage
    {
        $path = $this->saveFileToDisk($file, $directory, $disk);
        return $this->store($userId, $postId, $path, $isActive);
    }

    /**
     * Удалить записи, не связанные с постами, и файлы, связанные с этими записями.
     */
    public function deleteWithoutPostId(int $userId): int
    {
        return $this->imageRepository->deleteWithoutPostId($userId);
    }

    public function index(int $userId): Collection
    {
        return $this->imageRepository->index($userId);
    }
}
