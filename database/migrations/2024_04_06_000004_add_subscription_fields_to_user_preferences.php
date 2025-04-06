<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_preferences', function (Blueprint $table) {
            $table->foreignId('active_subscription_id')->nullable()->constrained('user_subscriptions')->onDelete('set null');
            $table->boolean('low_credits_notification')->default(true);
            $table->boolean('subscription_expiry_notification')->default(true);
        });
    }

    public function down()
    {
        Schema::table('user_preferences', function (Blueprint $table) {
            $table->dropForeign(['active_subscription_id']);
            $table->dropColumn(['active_subscription_id', 'low_credits_notification', 'subscription_expiry_notification']);
        });
    }
}; 