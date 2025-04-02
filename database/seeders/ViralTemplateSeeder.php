<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ViralTemplate;
use Carbon\Carbon;

class ViralTemplateSeeder extends Seeder
{
    public function run()
    {
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
                'inspiration_count' => 2
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
                'inspiration_count' => 45
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
                'inspiration_count' => 12
            ],
        ];

        foreach ($templates as $template) {
            ViralTemplate::create($template);
        }
    }
} 