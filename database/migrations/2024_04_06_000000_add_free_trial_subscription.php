<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Subscription;

return new class extends Migration
{
    public function up()
    {
        // Create free trial subscription
        Subscription::create([
            'name' => 'Free Trial',
            'plan_type' => 'trial',
            'duration' => 7, // 7 days trial
            'credits' => 10,
            'price' => 0,
            'billing_cycle' => 'one-time',
            'discount_percentage' => 0,
            'is_active' => true
        ]);
    }

    public function down()
    {
        // Remove free trial subscription
        Subscription::where('name', 'Free Trial')->delete();
    }
}; 