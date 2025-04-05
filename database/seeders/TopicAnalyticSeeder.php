<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TopicAnalytic;
use App\Models\User;

class TopicAnalyticSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();

        TopicAnalytic::create([
            'user_id' => $user->id,
            'total_views' => 1500,
            'views_change' => 12,
            'engagement_rate' => 8.5,
            'engagement_change' => 2.3,
            'top_topic' => 'Artificial Intelligence',
            'top_topic_views' => 450,
            'avg_time' => 3.5,
            'time_change' => 0.5,
            'period' => '7days'
        ]);
    }
} 