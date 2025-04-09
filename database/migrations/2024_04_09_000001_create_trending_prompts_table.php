<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trending_prompts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('prompt_template');
            $table->json('requirements')->nullable(); // For storing requirements like image, video etc.
            $table->string('llm_model');
            $table->boolean('is_paid')->default(false);
            $table->integer('free_user_limit')->default(3);
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trending_prompts');
    }
}; 