<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('content_ideas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('topic_id')->constrained('trending_topics')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('platform');
            $table->float('viral_potential');
            $table->enum('status', ['draft', 'in_progress', 'completed'])->default('draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('content_ideas');
    }
}; 