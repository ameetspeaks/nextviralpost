<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trending_topics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('trend_score');
            $table->enum('trend_direction', ['up', 'down']);
            $table->float('change_percentage');
            $table->json('related_keywords');
            $table->string('platform');
            $table->string('category');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trending_topics');
    }
}; 