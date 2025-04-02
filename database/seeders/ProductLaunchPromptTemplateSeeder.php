<?php

namespace Database\Seeders;

use App\Models\PostType;
use App\Models\PromptTemplate;
use App\Models\PostTone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductLaunchPromptTemplateSeeder extends Seeder
{
    public function run()
    {
        // Get or create the Product Launch post type
        $productLaunchType = PostType::firstOrCreate(
            ['name' => 'Product Launch / Feature Updates'],
            [
                'slug' => 'product-launch-feature-updates',
                'description' => 'Announcements and details about new products or features',
                'is_active' => true
            ]
        );

        // Define templates with their respective tones
        $templates = [
            [
                'tone' => 'Professional',
                'title' => 'Professional Product Launch Announcement',
                'content' => 'Write a professional LinkedIn post for a [Industry] [Role] announcing the launch of [What is Post About]. Emphasize how [Keyword(s)] make it a game-changer. Provide key insights on how it benefits users. Keep it within [Word Limit] words.',
                'category' => 'Product Launch',
                'post_goal' => 'Announce new product professionally',
                'virality_factor' => 'Professional product announcement with clear benefits'
            ],
            [
                'tone' => 'Conversational',
                'title' => 'Conversational Product Introduction',
                'content' => 'Create an engaging LinkedIn post for a [Industry] [Role] introducing [What is Post About]. Use simple language and storytelling to explain why [Keyword(s)] make it exciting. Keep it within [Word Limit] words.',
                'category' => 'Product Launch',
                'post_goal' => 'Introduce product in friendly manner',
                'virality_factor' => 'Relatable product story'
            ],
            [
                'tone' => 'Casual',
                'title' => 'Fun Product Launch Post',
                'content' => 'Generate a fun and informal LinkedIn post for a [Industry] [Role] showcasing the launch of [What is Post About]. Use humor, memes, or relatable situations to make it stand out. Keep it within [Word Limit] words.',
                'category' => 'Product Launch',
                'post_goal' => 'Create buzz with informal tone',
                'virality_factor' => 'Humor and relatability'
            ],
            [
                'tone' => 'Motivational',
                'title' => 'Inspiring Product Journey',
                'content' => 'Write an inspiring LinkedIn post for a [Industry] [Role] highlighting the journey behind launching [What is Post About]. Share the struggles, wins, and the role of [Keyword(s)] in making it a success. Keep it within [Word Limit] words.',
                'category' => 'Product Launch',
                'post_goal' => 'Share inspiring product journey',
                'virality_factor' => 'Emotional journey and success story'
            ],
            [
                'tone' => 'Analytical',
                'title' => 'Product Analysis Deep-Dive',
                'content' => 'Create an analytical LinkedIn post for a [Industry] [Role] breaking down how [Keyword(s)] enhance [What is Post About]. Compare it with past solutions and showcase its impact. Keep it within [Word Limit] words.',
                'category' => 'Product Launch',
                'post_goal' => 'Provide detailed product analysis',
                'virality_factor' => 'Data-driven insights'
            ],
            [
                'tone' => 'Educational',
                'title' => 'Educational Product Overview',
                'content' => 'Generate an educational LinkedIn post for a [Industry] [Role] explaining the features and benefits of [What is Post About]. Use [Keyword(s)] to highlight how it solves industry problems. Keep it within [Word Limit] words.',
                'category' => 'Product Launch',
                'post_goal' => 'Educate about product benefits',
                'virality_factor' => 'Educational value and problem-solving'
            ],
            [
                'tone' => 'Cautionary',
                'title' => 'Product Risk Management',
                'content' => 'Write a cautionary LinkedIn post for a [Industry] [Role] discussing potential pitfalls of using [What is Post About]. Provide guidance on how [Keyword(s)] can help navigate risks. Keep it within [Word Limit] words.',
                'category' => 'Product Launch',
                'post_goal' => 'Address product risks proactively',
                'virality_factor' => 'Risk awareness and solutions'
            ],
            [
                'tone' => 'Exciting',
                'title' => 'Exciting Product Breakthrough',
                'content' => 'Create an exciting LinkedIn post for a [Industry] [Role] announcing [What is Post About]. Use energetic language to make [Keyword(s)] sound like a breakthrough innovation. Keep it within [Word Limit] words.',
                'category' => 'Product Launch',
                'post_goal' => 'Generate excitement about product',
                'virality_factor' => 'Innovation excitement'
            ],
            [
                'tone' => 'Storytelling',
                'title' => 'Product Origin Story',
                'content' => 'Tell a compelling story on LinkedIn about a real-life experience that led to the creation of [What is Post About]. Show how [Keyword(s)] played a crucial role in the journey. Keep it within [Word Limit] words.',
                'category' => 'Product Launch',
                'post_goal' => 'Share product origin story',
                'virality_factor' => 'Compelling narrative'
            ],
            [
                'tone' => 'Engaging',
                'title' => 'Interactive Product Discussion',
                'content' => 'Generate an interactive LinkedIn post for a [Industry] [Role] about [What is Post About]. Ask for opinions, conduct a poll, or invite questions about how [Keyword(s)] impact the industry. Keep it within [Word Limit] words.',
                'category' => 'Product Launch',
                'post_goal' => 'Encourage product discussion',
                'virality_factor' => 'Community engagement'
            ]
        ];

        // Create templates
        foreach ($templates as $template) {
            $tone = PostTone::firstOrCreate(
                ['name' => $template['tone']],
                [
                    'slug' => Str::slug($template['tone']),
                    'description' => 'Auto-generated tone for ' . $template['tone'],
                    'is_active' => true
                ]
            );

            PromptTemplate::firstOrCreate(
                [
                    'title' => $template['title'],
                    'post_type_id' => $productLaunchType->id,
                    'tone_id' => $tone->id
                ],
                [
                    'slug' => Str::slug($template['title']),
                    'content' => $template['content'],
                    'category' => $template['category'],
                    'post_goal' => $template['post_goal'],
                    'virality_factor' => $template['virality_factor'],
                    'version' => 1,
                    'is_active' => true
                ]
            );
        }
    }
} 