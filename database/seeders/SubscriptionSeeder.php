<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        $plans = [
            [
                'name' => 'Free Trial',
                'plan_type' => 'free',
                'duration' => 7,
                'credits' => 10,
                'price' => 0,
                'billing_cycle' => 'one-time',
                'discount_percentage' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Creator Plan',
                'plan_type' => 'paid',
                'duration' => 30,
                'credits' => 200,
                'price' => 29.99,
                'billing_cycle' => 'monthly',
                'discount_percentage' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Agency Plan',
                'plan_type' => 'paid',
                'duration' => 30,
                'credits' => 1000,
                'price' => 99.99,
                'billing_cycle' => 'monthly',
                'discount_percentage' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Subscription::create($plan);
        }
    }
} 