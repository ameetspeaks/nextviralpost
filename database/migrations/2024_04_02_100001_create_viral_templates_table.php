<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('viral_templates', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->text('post_content');
            $table->string('post_link')->nullable();
            $table->integer('likes')->default(0);
            $table->integer('comments')->default(0);
            $table->integer('shares')->default(0);
            $table->timestamp('date_posted');
            $table->integer('bookmark_count')->default(0);
            $table->integer('inspiration_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('viral_templates');
    }
}; 