<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('prompt_templates', function (Blueprint $table) {
            if (!Schema::hasColumn('prompt_templates', 'title')) {
                $table->string('title')->after('id');
            }
            if (!Schema::hasColumn('prompt_templates', 'content')) {
                $table->text('content')->after('title');
            }
            if (!Schema::hasColumn('prompt_templates', 'category')) {
                $table->string('category')->nullable()->after('content');
            }
            if (!Schema::hasColumn('prompt_templates', 'post_goal')) {
                $table->string('post_goal')->after('category');
            }
            if (!Schema::hasColumn('prompt_templates', 'virality_factor')) {
                $table->string('virality_factor')->nullable()->after('post_goal');
            }
            if (!Schema::hasColumn('prompt_templates', 'version')) {
                $table->integer('version')->default(1)->after('virality_factor');
            }
        });
    }

    public function down()
    {
        Schema::table('prompt_templates', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'content',
                'category',
                'post_goal',
                'virality_factor',
                'version'
            ]);
        });
    }
}; 