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
        Schema::table('viral_templates', function (Blueprint $table) {
            $table->foreignId('post_type_id')->nullable()->constrained('post_types')->nullOnDelete();
            $table->foreignId('tone_id')->nullable()->constrained('post_tones')->nullOnDelete();
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('viral_templates', function (Blueprint $table) {
            $table->dropForeign(['post_type_id']);
            $table->dropForeign(['tone_id']);
            $table->dropColumn(['post_type_id', 'tone_id', 'is_active']);
        });
    }
};
