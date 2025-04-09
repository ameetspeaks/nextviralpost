<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrendingPrompt;

class TrendingPromptsSeeder extends Seeder
{
    public function run()
    {
        TrendingPrompt::create([
            'title' => 'Collectible Toy',
            'description' => 'Make your Own Collectible Toy',
            'prompt_template' => 'A unique collectible toy blister pack featuring [Your Name], dressed in [outfit]. Accessories: [items]. The packaging is [color] with bold black “[Your Brand]” branding and a [color] price tag that reads “[Price]”. Inspired by vintage toys with a modern twist.',
            'requirements' => json_encode(['image']),
            'llm_model' => 'gpt-4',
            'is_paid' => false,
            'free_user_limit' => 1,
            'paid_amount' => null,
            'is_active' => true,
        ]);
    }
}