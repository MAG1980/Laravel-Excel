<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $guarded = [];
    protected $table = 'tasks';

    const STATUS_IN_PROGRESS = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_FAILED = 3;

    public static function getStatus(int $status): string
    {
        return match ($status) {
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_SUCCESS => 'Success',
            self::STATUS_FAILED => 'Failed',
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
