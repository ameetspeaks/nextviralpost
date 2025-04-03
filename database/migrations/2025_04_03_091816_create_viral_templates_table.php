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
        Schema::create('viral_templates', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->text('post_content');
            $table->string('post_link')->nullable();
            $table->unsignedBigInteger('likes')->default(0);
            $table->unsignedBigInteger('comments')->default(0);
            $table->unsignedBigInteger('shares')->default(0);
            $table->foreignId('post_type_id')->nullable()->constrained('post_types')->nullOnDelete();
            $table->foreignId('tone_id')->nullable()->constrained('post_tones')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viral_templates');
    }
};
