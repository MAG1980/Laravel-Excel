<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    // Следует защищать поля, которые не следует изменять при массовом присвоении (методами create(), update() или fill()).
    // Первичные и вторичные ключи, а также чувствительные данные: password, remember_token, api_token и т.п.
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Альтернатива $guarded - явно указать, какие поля могут быть изменены при массовом присвоении
    // protected $fillable = ['title', 'content'];

    // Извлекать связанные изображения при извлечении поста из БД
    protected $with = ['image'];

    public function image(): HasOne
    {
        return $this->hasOne(PostImage::class, 'post_id', 'id')
            ->whereNotNull('post_id');
    }
}
