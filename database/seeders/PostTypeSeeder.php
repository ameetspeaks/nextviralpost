<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostType;

class PostTypeSeeder extends Seeder
{
    public function run(): void
    {
        $postTypes = [
            [
                'name' => 'Engagement Post',
                'slug' => 'engagement-post',
                'description' => 'Posts designed to encourage audience interaction and engagement',
                'is_active' => true,
            ],
            [
                'name' => 'Educational Post',
                'slug' => 'educational-post',
                'description' => 'Posts that share knowledge and educate the audience',
                'is_active' => true,
            ],
            [
                'name' => 'Story Post',
                'slug' => 'story-post',
                'description' => 'Posts that tell a compelling story or share experiences',
                'is_active' => true,
            ],
            [
                'name' => 'Question Post',
                'slug' => 'question-post',
                'description' => 'Posts that ask questions to engage the audience',
                'is_active' => true,
            ],
            [
                'name' => 'Tips & Tricks',
                'slug' => 'tips-tricks',
                'description' => 'Posts sharing useful tips and tricks',
                'is_active' => true,
            ],
            [
                'name' => 'Product Launch',
                'slug' => 'product-launch',
                'description' => 'Posts announcing or promoting new products',
                'is_active' => true,
            ],
            [
                'name' => 'Behind the Scenes',
                'slug' => 'behind-scenes',
                'description' => 'Posts showing the behind-the-scenes of your business',
                'is_active' => true,
            ],
            [
                'name' => 'Customer Success',
                'slug' => 'customer-success',
                'description' => 'Posts highlighting customer success stories',
                'is_active' => true,
            ],
        ];

        foreach ($postTypes as $postType) {
            PostType::updateOrCreate(
                ['slug' => $postType['slug']],
                $postType
            );
        }
    }
} 