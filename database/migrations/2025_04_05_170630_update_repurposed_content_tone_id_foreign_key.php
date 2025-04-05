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
        Schema::table('repurposed_content', function (Blueprint $table) {
            $table->dropForeign(['tone_id']);
            $table->foreign('tone_id')->references('id')->on('post_tones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repurposed_content', function (Blueprint $table) {
            $table->dropForeign(['tone_id']);
            $table->foreign('tone_id')->references('id')->on('tones');
        });
    }
}; 