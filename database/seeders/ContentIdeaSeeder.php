<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContentIdea;
use App\Models\User;
use App\Models\TrendingTopic;

class ContentIdeaSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $topics = TrendingTopic::take(2)->get();

        $ideas = [
            [
                'title' => '5 Ways AI is Transforming Business Operations',
                'description' => 'Explore how artificial intelligence is revolutionizing business processes and creating new opportunities.',
                'platform' => 'linkedin',
                'viral_potential' => 85,
                'topic_id' => $topics->first()->id,
                'user_id' => $user->id
            ],
            [
                'title' => 'The Future of Remote Work: Expert Predictions',
                'description' => 'Industry leaders share their insights on the evolution of remote work and its impact on the workplace.',
                'platform' => 'linkedin',
                'viral_potential' => 90,
                'topic_id' => $topics->first()->id,
                'user_id' => $user->id
            ],
            [
                'title' => 'Sustainable Business Practices That Drive Growth',
                'description' => 'Learn how companies are integrating sustainability into their core business strategies.',
                'platform' => 'linkedin',
                'viral_potential' => 88,
                'topic_id' => $topics->last()->id,
                'user_id' => $user->id
            ],
            [
                'title' => 'Digital Marketing Trends to Watch in 2024',
                'description' => 'Stay ahead of the curve with these emerging digital marketing trends and strategies.',
                'platform' => 'linkedin',
                'viral_potential' => 82,
                'topic_id' => $topics->last()->id,
                'user_id' => $user->id
            ]
        ];

        foreach ($ideas as $idea) {
            ContentIdea::create($idea);
        }
    }
} 