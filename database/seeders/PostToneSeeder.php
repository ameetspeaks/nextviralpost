<?php

namespace Database\Seeders;

use App\Models\PostTone;
use Illuminate\Database\Seeder;

class PostToneSeeder extends Seeder
{
    public function run(): void
    {
        $tones = [
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Formal and business-like tone',
                'is_active' => true,
            ],
            [
                'name' => 'Casual',
                'slug' => 'casual',
                'description' => 'Relaxed and conversational tone',
                'is_active' => true,
            ],
            [
                'name' => 'Humorous',
                'slug' => 'humorous',
                'description' => 'Funny and entertaining tone',
                'is_active' => true,
            ],
            [
                'name' => 'Inspirational',
                'slug' => 'inspirational',
                'description' => 'Motivating and uplifting tone',
                'is_active' => true,
            ],
            [
                'name' => 'Educational',
                'slug' => 'educational',
                'description' => 'Informative and instructional tone',
                'is_active' => true,
            ],
            [
                'name' => 'Storytelling',
                'slug' => 'storytelling',
                'description' => 'Narrative and engaging tone',
                'is_active' => true,
            ],
            [
                'name' => 'Urgent',
                'slug' => 'urgent',
                'description' => 'Time-sensitive and action-oriented tone',
                'is_active' => true,
            ],
            [
                'name' => 'Empathetic',
                'slug' => 'empathetic',
                'description' => 'Understanding and supportive tone',
                'is_active' => true,
            ],
        ];

        foreach ($tones as $tone) {
            PostTone::updateOrCreate(
                ['slug' => $tone['slug']],
                $tone
            );
        }
    }
} 