<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('post_generators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_type_id')->constrained('post_types')->onDelete('cascade');
            $table->foreignId('tone_id')->constrained('tones')->onDelete('cascade');
            $table->string('keywords');
            $table->text('post_content');
            $table->integer('word_limit')->default(50);
            $table->text('generated_content')->nullable();
            $table->boolean('is_bookmarked')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_generators');
    }
}; 