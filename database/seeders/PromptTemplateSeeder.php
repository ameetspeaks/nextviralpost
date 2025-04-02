<?php

namespace Database\Seeders;

use App\Models\PostType;
use App\Models\PromptTemplate;
use App\Models\Tone;
use Illuminate\Database\Seeder;

class PromptTemplateSeeder extends Seeder
{
    public function run()
    {
        // Ensure post type exists
        $trendPostType = PostType::firstOrCreate(
            ['name' => 'Industry Trends & Insights'],
            [
                'description' => 'Analysis and commentary on current industry trends and developments',
                'is_active' => true
            ]
        );
        
        // Ensure tones exist
        $professionalTone = Tone::firstOrCreate(
            ['name' => 'Professional'],
            [
                'description' => 'Formal and business-appropriate communication style',
                'is_active' => true
            ]
        );
        
        $conversationalTone = Tone::firstOrCreate(
            ['name' => 'Conversational'],
            [
                'description' => 'Friendly and engaging, like talking to a colleague',
                'is_active' => true
            ]
        );
        
        $analyticalTone = Tone::firstOrCreate(
            ['name' => 'Analytical'],
            [
                'description' => 'Data-driven and detailed analysis of topics',
                'is_active' => true
            ]
        );

        // Create templates
        $templates = [
            [
                'title' => 'Professional Industry Trends Analysis',
                'content' => 'Write a professional LinkedIn post for a [Industry] [Role] analyzing the latest trends in [What is Post About]. Incorporate data-driven insights, industry reports, and expert opinions. Discuss the impact of [Keyword(s)] and provide a well-researched perspective on where the industry is headed. Ensure it is structured, clear, and adds value to professionals in the field. Keep it within [Word Limit] words.',
                'category' => 'Industry Analysis',
                'post_goal' => 'Establish thought leadership',
                'virality_factor' => 'Expert insights and data-driven analysis',
                'post_type_id' => $trendPostType->id,
                'tone_id' => $professionalTone->id,
                'version' => 1
            ],
            [
                'title' => 'Conversational Industry Trends Discussion',
                'content' => 'Create a friendly and engaging LinkedIn post as a [Industry] [Role] discussing the exciting trends in [What is Post About]. Share your thoughts on [Keyword(s)] and what they mean for our industry. Make it relatable and conversational while maintaining professionalism. Keep the length to [Word Limit] words.',
                'category' => 'Industry Analysis',
                'post_goal' => 'Engage and connect with audience',
                'virality_factor' => 'Relatable insights and engaging discussion',
                'post_type_id' => $trendPostType->id,
                'tone_id' => $conversationalTone->id,
                'version' => 1
            ],
            [
                'title' => 'Analytical Industry Trends Deep Dive',
                'content' => 'Compose a detailed LinkedIn post analyzing [What is Post About] from a [Industry] [Role] perspective. Deep dive into the data behind [Keyword(s)], examine patterns, and provide quantitative insights. Include relevant statistics and analytical observations. Maintain a clear, logical flow within [Word Limit] words.',
                'category' => 'Industry Analysis',
                'post_goal' => 'Provide data-driven insights',
                'virality_factor' => 'Deep analysis and statistical insights',
                'post_type_id' => $trendPostType->id,
                'tone_id' => $analyticalTone->id,
                'version' => 1
            ]
        ];

        foreach ($templates as $template) {
            PromptTemplate::firstOrCreate(
                [
                    'title' => $template['title'],
                    'post_type_id' => $template['post_type_id'],
                    'tone_id' => $template['tone_id']
                ],
                $template
            );
        }
    }
} 