<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE prompt_templates CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    }

    public function down()
    {
        DB::statement('ALTER TABLE prompt_templates CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci');
    }
}; 