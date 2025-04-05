<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('topic_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total_views');
            $table->float('views_change');
            $table->float('engagement_rate');
            $table->float('engagement_change');
            $table->string('top_topic');
            $table->integer('top_topic_views');
            $table->float('avg_time');
            $table->float('time_change');
            $table->string('period');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('topic_analytics');
    }
}; 