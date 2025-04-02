<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostType;

class PostTypeSeeder extends Seeder
{
    public function run()
    {
        $postTypes = [
            [
                'name' => 'Industry Trends & Insights',
                'description' => 'Analysis and commentary on current industry trends and developments'
            ],
            [
                'name' => 'Technical Deep Dives',
                'description' => 'In-depth technical analysis and explanations'
            ],
            [
                'name' => 'Security & Compliance',
                'description' => 'Updates and insights about security and compliance matters'
            ],
            [
                'name' => 'Product Launch / Feature Updates',
                'description' => 'Announcements and details about new products or features'
            ],
            [
                'name' => 'Success Stories / Case Studies',
                'description' => 'Real-world examples and success stories'
            ],
            [
                'name' => 'Common Mistakes & Best Practices',
                'description' => 'Guidance on avoiding common pitfalls and following best practices'
            ],
            [
                'name' => 'Comparison & Reviews',
                'description' => 'Comparative analysis and product reviews'
            ],
            [
                'name' => 'Hiring & Team Growth',
                'description' => 'Content about recruitment and team development'
            ],
            [
                'name' => 'Customer Testimonials',
                'description' => 'Customer feedback and success stories'
            ],
            [
                'name' => 'Tips & Hacks',
                'description' => 'Quick tips and useful hacks for better productivity'
            ],
            [
                'name' => 'Problem-Solution Posts',
                'description' => 'Addressing common problems with practical solutions'
            ],
            [
                'name' => 'Behind-the-Scenes / Company Culture',
                'description' => 'Insights into company culture and internal processes'
            ],
            [
                'name' => 'Polls & Discussions',
                'description' => 'Engaging content to spark discussions and gather opinions'
            ],
            [
                'name' => 'Motivational & Leadership',
                'description' => 'Inspirational content about leadership and motivation'
            ]
        ];

        foreach ($postTypes as $type) {
            PostType::create($type);
        }
    }
} 