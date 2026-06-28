<?php

namespace App\Models;

use App\Models\Traits\UploadsFile;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use UploadsFile;
   // Значения свойств trait можно переопределить:
   // protected static string $fileDisk = 's3';        // другой диск
   // protected static string $fileDirectory = 'uploads/images/'; // другая папка

    protected $guarded = [];

    protected $table = 'files';

}
