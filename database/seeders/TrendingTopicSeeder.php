<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrendingTopic;

class TrendingTopicSeeder extends Seeder
{
    public function run()
    {
        $topics = [
            [
                'name' => 'Artificial Intelligence',
                'trend_score' => 95,
                'trend_direction' => 'up',
                'change_percentage' => 15
            ],
            [
                'name' => 'Remote Work',
                'trend_score' => 88,
                'trend_direction' => 'up',
                'change_percentage' => 12
            ],
            [
                'name' => 'Sustainability',
                'trend_score' => 92,
                'trend_direction' => 'up',
                'change_percentage' => 18
            ],
            [
                'name' => 'Digital Marketing',
                'trend_score' => 85,
                'trend_direction' => 'up',
                'change_percentage' => 8
            ],
            [
                'name' => 'Mental Health',
                'trend_score' => 90,
                'trend_direction' => 'up',
                'change_percentage' => 20
            ],
            [
                'name' => 'Blockchain',
                'trend_score' => 75,
                'trend_direction' => 'down',
                'change_percentage' => 5
            ],
            [
                'name' => 'Personal Development',
                'trend_score' => 87,
                'trend_direction' => 'up',
                'change_percentage' => 10
            ],
            [
                'name' => 'E-commerce',
                'trend_score' => 82,
                'trend_direction' => 'up',
                'change_percentage' => 7
            ]
        ];

        foreach ($topics as $topic) {
            TrendingTopic::create($topic);
        }
    }
} 