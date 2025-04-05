<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\PostType;
use App\Models\PostTone;

class PostSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        
        // Get the first post type and tone since we know they exist
        $postType = PostType::first();
        $postTone = PostTone::first();

        $posts = [
            [
                'user_id' => $user->id,
                'post_type_id' => $postType->id,
                'tone_id' => $postTone->id,
                'keywords' => 'leadership, management, success',
                'raw_content' => 'How effective leadership drives business success',
                'word_limit' => 500,
                'prompt' => 'Write a professional article about effective leadership in business',
                'generated_content' => 'Leadership is the cornerstone of business success...',
                'is_bookmarked' => false,
            ],
            [
                'user_id' => $user->id,
                'post_type_id' => $postType->id,
                'tone_id' => $postTone->id,
                'keywords' => 'productivity, work-life balance, tips',
                'raw_content' => 'Quick productivity hacks for busy professionals',
                'word_limit' => 200,
                'prompt' => 'Share some quick productivity tips in a casual tone',
                'generated_content' => 'Want to boost your productivity without burning out?...',
                'is_bookmarked' => true,
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
} 