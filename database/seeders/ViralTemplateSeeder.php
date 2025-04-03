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
                'username' => 'Peredox Digital',
                'post_content' => "3 simple tips make sure you're on the right track and set up for success before you start creating content:\n\n✅ Identity your audience\n✅ Do your research\n✅ Define your post schedule",
                'post_link' => 'https://linkedin.com/post/1',
                'likes' => 103,
                'comments' => 1,
                'shares' => 1,
                'date_posted' => Carbon::now()->subYears(3),
                'bookmark_count' => 5,
                'inspiration_count' => 2,
                'post_type_id' => $postTypes->first()?->id,
                'tone_id' => $tones->first()?->id,
                'is_active' => true
            ],
            [
                'username' => 'GREG ISENBERG',
                'post_content' => "If distribution is the new moat, where is the Y-Combinator for creating distribution, not software?\n\nI don't think it exists.\n\nThere isn't much product risk anymore in most startups.",
                'post_link' => 'https://linkedin.com/post/2',
                'likes' => 1400,
                'comments' => 215,
                'shares' => 86,
                'date_posted' => Carbon::now()->subMonths(7),
                'bookmark_count' => 120,
                'inspiration_count' => 45,
                'post_type_id' => $postTypes->skip(1)->first()?->id,
                'tone_id' => $tones->skip(1)->first()?->id,
                'is_active' => true
            ],
            [
                'username' => 'Ubaid Ur Rehman',
                'post_content' => "How I create Tweet Carousels in Canva.\n(perfect for content creators)\n\nHit Repost, if you found it helpful.",
                'post_link' => 'https://linkedin.com/post/3',
                'likes' => 137,
                'comments' => 143,
                'shares' => 4,
                'date_posted' => Carbon::now()->subYear(),
                'bookmark_count' => 25,
                'inspiration_count' => 12,
                'post_type_id' => $postTypes->skip(2)->first()?->id,
                'tone_id' => $tones->skip(2)->first()?->id,
                'is_active' => true
            ],
            [
                'username' => 'Alex Hormozi',
                'post_content' => "The secret to viral content:\n\n1. Solve a real problem\n2. Make it simple to understand\n3. Share your unique perspective\n4. Be consistent\n\nThat's it. No magic formula.",
                'post_link' => 'https://linkedin.com/post/4',
                'likes' => 2500,
                'comments' => 180,
                'shares' => 320,
                'date_posted' => Carbon::now()->subMonths(2),
                'bookmark_count' => 450,
                'inspiration_count' => 280,
                'post_type_id' => $postTypes->first()?->id,
                'tone_id' => $tones->first()?->id,
                'is_active' => true
            ],
            [
                'username' => 'Sahil Bloom',
                'post_content' => "10 lessons I learned from building a $100M business:\n\n1. Focus on distribution\n2. Build in public\n3. Network effectively\n4. Stay consistent\n5. Learn from failures\n\n(Thread) 🧵",
                'post_link' => 'https://linkedin.com/post/5',
                'likes' => 3200,
                'comments' => 420,
                'shares' => 580,
                'date_posted' => Carbon::now()->subMonths(1),
                'bookmark_count' => 680,
                'inspiration_count' => 420,
                'post_type_id' => $postTypes->skip(1)->first()?->id,
                'tone_id' => $tones->skip(1)->first()?->id,
                'is_active' => true
            ]
        ];

        foreach ($templates as $template) {
            ViralTemplate::create($template);
        }
    }
} 