<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('viral_template_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viral_template_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['bookmark', 'inspire']);
            $table->timestamps();

            // Add unique constraint with a shorter name
            $table->unique(['viral_template_id', 'user_id', 'type'], 'vti_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('viral_template_interactions');
    }
}; 