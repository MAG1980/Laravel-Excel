<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('failed_rows', function (Blueprint $table) {
            $table->id();
            // Если при валидации файла возникает ошибка, то название столбца, содержащего ошибку, будет помещено в поле key, а текст ошибки - в поле message.
            $table->foreignId('task_id')->index()->constrained('tasks');
            $table->string('key');
            $table->string('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_rows');
    }
};
