<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ViralTemplate;
use App\Models\PostType;
use App\Models\PostTone;
use Carbon\Carbon;

class ViralTemplateSeeder extends Seeder
{
    public function run()
    {
        // Get some post types and tones for reference
        $postTypes = PostType::all();
        $tones = PostTone::all();

        $templates = [
            [
                'username' => 'marketing_expert',
                'post_content' => '5 proven strategies to increase your social media engagement by 200% in just 30 days! 🚀

1. Create content that solves problems
2. Use eye-catching visuals
3. Engage with your audience
4. Post consistently
5. Analyze and optimize

Which strategy will you try first? #SocialMediaTips #Marketing',
                'post_link' => 'https://example.com/social-media-strategies',
                'likes' => 1250,
                'comments' => 89,
                'shares' => 45,
                'post_type_id' => $postTypes->first()->id,
                'tone_id' => $tones->first()->id,
                'is_active' => true,
                'date_posted' => Carbon::now()->subDays(7),
                'repurpose_count' => 0,
                'user_ids' => null
            ],
            [
                'username' => 'tech_innovator',
                'post_content' => 'The future of AI in business is here! 🤖

Here\'s how companies are leveraging AI to:
- Automate repetitive tasks
- Improve customer service
- Enhance decision making
- Boost productivity

Are you ready for the AI revolution? #AI #BusinessInnovation',
                'post_link' => 'https://example.com/ai-in-business',
                'likes' => 980,
                'comments' => 67,
                'shares' => 32,
                'post_type_id' => $postTypes->first()->id,
                'tone_id' => $tones->first()->id,
                'is_active' => true,
                'date_posted' => Carbon::now()->subDays(5),
                'repurpose_count' => 0,
                'user_ids' => null
            ],
            [
                'username' => 'startup_mentor',
                'post_content' => '3 critical mistakes that kill startups in their first year:

1. Not validating the market
2. Running out of cash
3. Hiring the wrong team

Learn from these mistakes and build a sustainable business! #StartupTips #Entrepreneurship',
                'post_link' => 'https://example.com/startup-mistakes',
                'likes' => 750,
                'comments' => 45,
                'shares' => 28,
                'post_type_id' => $postTypes->first()->id,
                'tone_id' => $tones->first()->id,
                'is_active' => true,
                'date_posted' => Carbon::now()->subDays(3),
                'repurpose_count' => 0,
                'user_ids' => null
            ]
        ];

        foreach ($templates as $template) {
            ViralTemplate::create($template);
        }
    }
} 