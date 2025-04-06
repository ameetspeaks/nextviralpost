<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Industry;
use Illuminate\Support\Str;

class IndustrySeeder extends Seeder
{
    public function run()
    {
        $industries = [
            [
                'name' => 'Technology',
                'is_active' => true,
            ],
            [
                'name' => 'Healthcare',
                'is_active' => true,
            ],
            [
                'name' => 'Finance',
                'is_active' => true,
            ],
            [
                'name' => 'Education',
                'is_active' => true,
            ],
            [
                'name' => 'Marketing',
                'is_active' => true,
            ],
        ];

        foreach ($industries as $industry) {
            $slug = Str::slug($industry['name']);
            if (!Industry::where('slug', $slug)->exists()) {
                Industry::create([
                    'name' => $industry['name'],
                    'is_active' => $industry['is_active'],
                    'slug' => $slug
                ]);
            }
        }
    }
} 