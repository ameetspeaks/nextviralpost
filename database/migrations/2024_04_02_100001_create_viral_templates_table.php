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
            $table->foreignId('post_type_id')->nullable()->constrained('post_types')->onDelete('set null');
            $table->foreignId('tone_id')->nullable()->constrained('post_tones')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamp('date_posted')->nullable();
            $table->integer('repurpose_count')->default(0);
            $table->text('user_ids')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('viral_templates');
    }
}; 