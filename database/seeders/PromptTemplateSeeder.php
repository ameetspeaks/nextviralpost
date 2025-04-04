<?php

namespace Database\Seeders;

use App\Models\PostType;
use App\Models\PostTone;
use App\Models\PromptTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PromptTemplateSeeder extends Seeder
{
    public function run(): void
    {
        // Get post types and tones
        $postTypes = PostType::all()->keyBy('name');
        $tones = PostTone::all()->keyBy('name');

        $templates = [
            [
                'post_type_id' => $postTypes['Product Launch']->id,
                'tone_id' => $tones['Professional']->id,
                'title' => 'Professional LinkedIn Post Template',
                'content' => "Create a professional LinkedIn post about {{raw_content}}. 
                Include the following keywords naturally: {{keywords}}. 
                The post should be written from the perspective of a {{role}} in the {{industry}} industry. 
                Keep the content within {{word_limit}} words. 
                Make it engaging and suitable for LinkedIn's professional audience.
                Use a {{tone}} tone throughout the post.
                Structure the post with a compelling hook, main content, and a clear call to action.
                Format: {{post_type}}",
                'category' => 'Professional',
                'post_goal' => 'Engagement',
                'virality_factor' => 'High',
                'is_active' => true
            ],
            [
                'post_type_id' => $postTypes['Product Launch']->id,
                'tone_id' => $tones['Casual']->id,
                'title' => 'Casual LinkedIn Post Template',
                'content' => "Write a casual and friendly LinkedIn post about {{raw_content}}. 
                Use these keywords naturally: {{keywords}}. 
                Write it as a {{role}} in {{industry}}. 
                Keep it under {{word_limit}} words. 
                Make it conversational and relatable while maintaining professionalism.
                Use a {{tone}} tone throughout the post.
                Include a personal touch and end with an engaging question to encourage comments.
                Format: {{post_type}}",
                'category' => 'Casual',
                'post_goal' => 'Engagement',
                'virality_factor' => 'High',
                'is_active' => true,
                'slug' => 'casual-linkedin-post'
            ],
            [
                'post_type_id' => $postTypes['Product Launch']->id,
                'tone_id' => $tones['Professional']->id,
                'title' => 'Professional Twitter Thread Template',
                'content' => "Create a concise Twitter thread about {{raw_content}}. 
                Incorporate these keywords: {{keywords}}. 
                Write from a {{role}}'s perspective in {{industry}}. 
                Each tweet should be engaging and under 280 characters. 
                Total thread should be around {{word_limit}} words.
                Use a {{tone}} tone throughout the thread.
                Start with a hook, provide value in the middle tweets, and end with a call to action.
                Format: {{post_type}}",
                'category' => 'Professional',
                'post_goal' => 'Engagement',
                'virality_factor' => 'High',
                'is_active' => true,
                'slug' => 'professional-twitter-thread'
            ],
            [
                'post_type_id' => $postTypes['Product Launch']->id,
                'tone_id' => $tones['Casual']->id,
                'title' => 'Casual Twitter Thread Template',
                'content' => "Write a casual Twitter thread about {{raw_content}}. 
                Naturally include these keywords: {{keywords}}. 
                Write as a {{role}} in {{industry}}. 
                Each tweet should be conversational and under 280 characters. 
                Total thread should be around {{word_limit}} words.
                Use a {{tone}} tone throughout the thread.
                Make it engaging and relatable, with a mix of information and personality.
                Format: {{post_type}}",
                'category' => 'Casual',
                'post_goal' => 'Engagement',
                'virality_factor' => 'Medium',
                'is_active' => true,
                'slug' => 'casual-twitter-thread'
            ],
            [
                'post_type_id' => $postTypes['Product Launch']->id,
                'tone_id' => $tones['Professional']->id,
                'title' => 'Professional Blog Post Template',
                'content' => "Create a professional blog post about {{raw_content}}. 
                Include these keywords naturally: {{keywords}}. 
                Write from the perspective of a {{role}} in {{industry}}. 
                The post should be approximately {{word_limit}} words.
                Use a {{tone}} tone throughout the post.
                Structure the post with an engaging introduction, clear sections, and a strong conclusion.
                Include relevant examples and data points where appropriate.
                Format: {{post_type}}",
                'category' => 'Professional',
                'post_goal' => 'Engagement',
                'virality_factor' => 'High',
                'is_active' => true,
                'slug' => 'professional-blog-post'
            ],
            [
                'post_type_id' => $postTypes['Product Launch']->id,
                'tone_id' => $tones['Casual']->id,
                'title' => 'Casual Blog Post Template',
                'content' => "Write a casual blog post about {{raw_content}}. 
                Naturally incorporate these keywords: {{keywords}}. 
                Write as a {{role}} in {{industry}}. 
                The post should be around {{word_limit}} words.
                Use a {{tone}} tone throughout the post.
                Make it conversational and engaging, with personal anecdotes and practical tips.
                Include a clear call to action at the end.
                Format: {{post_type}}",
                'category' => 'Casual',
                'post_goal' => 'Engagement',
                'virality_factor' => 'Medium',
                'is_active' => true,
                'slug' => 'casual-blog-post'
            ]
        ];

        foreach ($templates as $template) {
            // Ensure slug is set by using the title if not provided
            if (!isset($template['slug'])) {
                $template['slug'] = Str::slug($template['title']);
            }

            PromptTemplate::updateOrCreate(
                [
                    'post_type_id' => $template['post_type_id'],
                    'tone_id' => $template['tone_id']
                ],
                $template
            );
        }
    }
} 