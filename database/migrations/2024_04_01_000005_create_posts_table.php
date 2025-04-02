<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_type_id')->constrained('post_types');
            $table->foreignId('tone_id')->constrained('tones');
            $table->string('keywords');
            $table->text('raw_content'); // User's input about what the post is about
            $table->integer('word_limit');
            $table->text('prompt'); // The actual prompt sent to Gemini API
            $table->text('generated_content'); // Response from Gemini API
            $table->boolean('is_bookmarked')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}; 