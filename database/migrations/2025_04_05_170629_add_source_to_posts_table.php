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
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('source', ['generated', 'repurposed'])->default('generated')->after('is_bookmarked');
            $table->foreignId('viral_template_id')->nullable()->after('source')->constrained('viral_templates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['viral_template_id']);
            $table->dropColumn(['source', 'viral_template_id']);
        });
    }
}; 