<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_preferences', function (Blueprint $table) {
            if (!Schema::hasColumn('user_preferences', 'low_credits_threshold')) {
                $table->integer('low_credits_threshold')->default(3);
            }
        });
    }

    public function down()
    {
        Schema::table('user_preferences', function (Blueprint $table) {
            $table->dropColumn('low_credits_threshold');
        });
    }
}; 