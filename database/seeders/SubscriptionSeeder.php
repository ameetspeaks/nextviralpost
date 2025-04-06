<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free Trial',
                'plan_type' => 'free',
                'duration' => 7,
                'credits' => 10,
                'price' => 0,
                'billing_cycle' => 'one-time',
                'discount_percentage' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Creator Plan',
                'plan_type' => 'creator',
                'duration' => 30,
                'credits' => 50,
                'price' => 5,
                'billing_cycle' => 'monthly',
                'discount_percentage' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Agency Plan',
                'plan_type' => 'agency',
                'duration' => 30,
                'credits' => 150,
                'price' => 19,
                'billing_cycle' => 'monthly',
                'discount_percentage' => 50,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Subscription::create($plan);
        }
    }
} 