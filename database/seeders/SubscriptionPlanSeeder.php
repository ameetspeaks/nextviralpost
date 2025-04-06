<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free Trial',
                'slug' => 'free-trial',
                'description' => 'Try our service for free with limited features',
                'price' => 0.00,
                'credits_per_month' => 10,
                'max_posts_per_day' => 2,
                'has_viral_recipe' => false,
                'has_analytics' => false,
                'has_priority_support' => false,
                'is_active' => true,
                'badge_color' => 'gray'
            ],
            [
                'name' => 'Creator Plan',
                'slug' => 'creator-plan',
                'description' => 'Perfect for individual content creators',
                'price' => 19.99,
                'credits_per_month' => 50,
                'max_posts_per_day' => 5,
                'has_viral_recipe' => true,
                'has_analytics' => false,
                'has_priority_support' => false,
                'is_active' => true,
                'badge_color' => 'blue'
            ],
            [
                'name' => 'Professional Plan',
                'slug' => 'professional-plan',
                'description' => 'Ideal for professional content creators and small teams',
                'price' => 49.99,
                'credits_per_month' => 150,
                'max_posts_per_day' => 10,
                'has_viral_recipe' => true,
                'has_analytics' => true,
                'has_priority_support' => false,
                'is_active' => true,
                'badge_color' => 'purple'
            ],
            [
                'name' => 'Agency Plan',
                'slug' => 'agency-plan',
                'description' => 'Full-featured plan for agencies and large teams',
                'price' => 99.99,
                'credits_per_month' => 500,
                'max_posts_per_day' => 25,
                'has_viral_recipe' => true,
                'has_analytics' => true,
                'has_priority_support' => true,
                'is_active' => true,
                'badge_color' => 'indigo'
            ]
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
