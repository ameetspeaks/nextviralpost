<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prompt_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('post_type_id')->constrained('post_types')->onDelete('cascade');
            $table->foreignId('tone_id')->constrained('tones')->onDelete('cascade');
            $table->string('category')->nullable();
            $table->string('post_goal');
            $table->string('virality_factor')->nullable();
            $table->integer('version')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Add unique constraint to prevent duplicate templates for same post type and tone
            $table->unique(['post_type_id', 'tone_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('prompt_templates');
    }
}; 