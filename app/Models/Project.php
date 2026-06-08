<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $guarded = [];
    protected $table = 'projects';

    // Глобальная жадная загрузка для часто используемых отношений
    // Можно временно отключить, добавив 'without' в запрос
    // Laravel автоматически подгрузит связанную модель type (через отношение, определённое в методе type())
    protected $with = ['type'];

    // каждый из этих атрибутов будет автоматически преобразован в объект Carbon (или DateTime) при обращении к ним из модели
//    protected $dates = ['created_at_date', 'contracted_at', 'deadline'];
    protected $casts = [
        'created_at_date' => 'datetime',
        'contracted_at' => 'datetime',
        'deadline' => 'datetime',
    ];


    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
