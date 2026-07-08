<?php

namespace App\Models\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadsFile
{
    /**
     * Диск хранилища (по умолчанию public).
     */
    protected static string $fileDisk = 'public';

    /**
     * Директория внутри диска для сохранения файлов.
     */
    protected static string $fileDirectory = 'files/';

    /**
     * Сохраняет загруженный файл на диск и возвращает путь.
     *
     * @param UploadedFile $file
     * @return string
     *
     * @throws \Exception
     */
    protected static function saveFileToDisk(UploadedFile $file, ?string $fileDirectory = null): string
    {
        $path = Storage::disk(static::$fileDisk)->put($fileDirectory ?? static::$fileDirectory, $file);

        if ($path === false) {
            throw new \Exception('Не удалось сохранить файл.');
        }

        return $path;
    }

    /**
     * Сохраняет файл на диск в storage.
     * Создаёт запись о файле в БД (в текущей модели) и возвращает модель.
     *
     * @param UploadedFile $file
     * @return static
     *
     * @throws \Exception
     */
    public static function createFromUpload(UploadedFile $file, array $attributes = []): static
    {
        $path = static::saveFileToDisk($file);

        $data = array_merge([
            'path' => $path,
            'title' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
        ], $attributes);

        return static::create($data);
    }
}
