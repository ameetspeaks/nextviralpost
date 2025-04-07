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
        Schema::create('profile_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('linkedin_profile_id')->constrained()->onDelete('cascade');
            $table->decimal('overall_score', 5, 2);
            
            // Section scores
            $table->decimal('headline_score', 5, 2);
            $table->decimal('summary_score', 5, 2);
            $table->decimal('experience_score', 5, 2);
            $table->decimal('skills_score', 5, 2);
            $table->decimal('education_score', 5, 2);
            $table->decimal('other_sections_score', 5, 2);
            
            // Section recommendations (stored as JSON)
            $table->json('headline_recommendations');
            $table->json('summary_recommendations');
            $table->json('experience_recommendations');
            $table->json('skills_recommendations');
            $table->json('education_recommendations');
            $table->json('other_sections_recommendations');
            
            // Analysis metadata
            $table->json('analysis_metadata')->nullable();
            $table->timestamp('last_analyzed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_scores');
    }
}; 