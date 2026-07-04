<?php

namespace App\Models;

use App\Models\Traits\UploadsFile;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use UploadsFile;

    // Значения свойств trait можно переопределить:
    // protected static string $fileDisk = 's3';        // другой диск
    // protected static string $fileDirectory = 'uploads/images/'; // другая папка

    protected $table = 'post_images';

    // Следует защищать поля, которые не следует изменять при массовом присвоении (методами create(), update() или fill()).
    // Первичные и вторичные ключи, а также чувствительные данные: password, remember_token, api_token и т.п.
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Альтернатива $guarded - явно указать, какие поля могут быть изменены при массовом присвоении
    // protected $fillable = ['title', 'content'];

    public function getUrlAttribute()
    {
        return url('storage/' . $this->path);
    }
}
