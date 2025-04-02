<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tone;

class ToneSeeder extends Seeder
{
    public function run()
    {
        $tones = [
            [
                'name' => 'Professional',
                'description' => 'Formal and business-appropriate communication style'
            ],
            [
                'name' => 'Conversational',
                'description' => 'Friendly and engaging, like talking to a colleague'
            ],
            [
                'name' => 'Casual',
                'description' => 'Relaxed and informal, suitable for social media'
            ],
            [
                'name' => 'Motivational',
                'description' => 'Inspiring and uplifting content that drives action'
            ],
            [
                'name' => 'Analytical',
                'description' => 'Data-driven and detailed analysis of topics'
            ],
            [
                'name' => 'Educational',
                'description' => 'Informative and instructional content'
            ],
            [
                'name' => 'Cautionary',
                'description' => 'Warning and advisory content about potential risks'
            ],
            [
                'name' => 'Exciting',
                'description' => 'Enthusiastic and energetic content'
            ],
            [
                'name' => 'Storytelling',
                'description' => 'Narrative-driven content that engages readers'
            ],
            [
                'name' => 'Engaging',
                'description' => 'Interactive and participatory content style'
            ]
        ];

        foreach ($tones as $tone) {
            Tone::create($tone);
        }
    }
} 