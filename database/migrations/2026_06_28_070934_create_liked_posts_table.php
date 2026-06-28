<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('liked_posts', function (Blueprint $table) {
            $table->id();
            // $table->primary(['user_id', 'post_id']);
            $table->foreignId('user_id')->index()->constrained('users')->cascadeOnDelete();
            $table->foreignId('post_id')->index()->constrained('posts')->cascadeOnDelete();
            $table->unique(['user_id', 'post_id']); // гарантирует, что пара не повторится
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liked_posts');
    }
};
