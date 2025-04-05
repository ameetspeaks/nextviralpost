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
        Schema::create('repurposed_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('viral_template_id')->constrained('viral_templates');
            $table->foreignId('tone_id')->constrained('post_tones');
            $table->text('raw_thoughts');
            $table->text('repurposed_content');
            $table->text('prompt_used');
            $table->timestamps();
            
            // Ensure one user can only repurpose a template once
            $table->unique(['user_id', 'viral_template_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repurposed_content');
    }
};
