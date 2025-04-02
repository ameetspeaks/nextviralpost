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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('post_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tone_id')->constrained('post_tones')->cascadeOnDelete();
            $table->string('keywords')->nullable();
            $table->text('raw_content')->nullable();
            $table->integer('word_limit')->default(100);
            $table->text('prompt')->nullable();
            $table->text('generated_content')->nullable();
            $table->boolean('is_bookmarked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
}; 