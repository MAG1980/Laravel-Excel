<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $guarded = [];

    protected $table = 'files';

    /**
     * Сохраняет файл на диск и возвращает путь.
     *
     * @param UploadedFile $dataFile
     *
     * @throws \Exception
     */
    private static function getPath($dataFile): string
    {
        $path = Storage::disk('public')->put('files/', $dataFile);
        if ($path === false) {
            throw new \Exception('Failed to save file.');
        }

        return $path;
    }

    /**
     * Сохраняет информацию о файле в БД.
     *
     * @param UploadedFile $dataFile
     *
     * @throws \Exception
     */
    public static function createFile($dataFile)
    {
        $path = self::getPath($dataFile);

        return File::create([
            'path' => $path,
            'title' => $dataFile->getClientOriginalName(),
            'mime_type' => $dataFile->getClientMimeType(),
        ]);
    }
}
