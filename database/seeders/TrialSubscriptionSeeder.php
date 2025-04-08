<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;

class TrialSubscriptionSeeder extends Seeder
{
    public function run()
    {
        Subscription::create([
            'name' => 'Trial Plan',
            'plan_type' => 'trial',
            'duration' => 7, // 7 days trial
            'credits' => 10,
            'price' => 0,
            'billing_cycle' => 'one_time',
            'discount_percentage' => 0,
            'is_active' => true
        ]);
    }
} 