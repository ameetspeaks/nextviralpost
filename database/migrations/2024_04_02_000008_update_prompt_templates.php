<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\PostType;
use App\Models\PostTone;

return new class extends Migration
{
    public function up()
    {
        // Get post types and tones
        $postTypes = PostType::all()->keyBy('name');
        $tones = PostTone::all()->keyBy('name');

        // Define new templates
        $templates = [
            [
                'post_type' => 'LinkedIn Post',
                'tone' => 'Professional',
                'template' => "Create a professional LinkedIn post about {{raw_content}}. 
                Include the following keywords naturally: {{keywords}}. 
                The post should be written from the perspective of a {{role}} in the {{industry}} industry. 
                Keep the content within {{word_limit}} words. 
                Make it engaging and suitable for LinkedIn's professional audience.
                Use a {{tone}} tone throughout the post.
                Structure the post with a compelling hook, main content, and a clear call to action."
            ],
            [
                'post_type' => 'LinkedIn Post',
                'tone' => 'Casual',
                'template' => "Write a casual and friendly LinkedIn post about {{raw_content}}. 
                Use these keywords naturally: {{keywords}}. 
                Write it as a {{role}} in {{industry}}. 
                Keep it under {{word_limit}} words. 
                Make it conversational and relatable while maintaining professionalism.
                Use a {{tone}} tone throughout the post.
                Include a personal touch and end with an engaging question to encourage comments."
            ],
            [
                'post_type' => 'Twitter Post',
                'tone' => 'Professional',
                'template' => "Create a concise Twitter thread about {{raw_content}}. 
                Incorporate these keywords: {{keywords}}. 
                Write from a {{role}}'s perspective in {{industry}}. 
                Each tweet should be engaging and under 280 characters. 
                Total thread should be around {{word_limit}} words.
                Use a {{tone}} tone throughout the thread.
                Start with a hook, provide value in the middle tweets, and end with a call to action."
            ],
            [
                'post_type' => 'Twitter Post',
                'tone' => 'Casual',
                'template' => "Write a casual Twitter thread about {{raw_content}}. 
                Naturally include these keywords: {{keywords}}. 
                Write as a {{role}} in {{industry}}. 
                Each tweet should be conversational and under 280 characters. 
                Total thread should be around {{word_limit}} words.
                Use a {{tone}} tone throughout the thread.
                Make it engaging and relatable, with a mix of information and personality."
            ],
            [
                'post_type' => 'Blog Post',
                'tone' => 'Professional',
                'template' => "Create a professional blog post about {{raw_content}}. 
                Include these keywords naturally: {{keywords}}. 
                Write from the perspective of a {{role}} in {{industry}}. 
                The post should be approximately {{word_limit}} words.
                Use a {{tone}} tone throughout the post.
                Structure the post with an engaging introduction, clear sections, and a strong conclusion.
                Include relevant examples and data points where appropriate."
            ],
            [
                'post_type' => 'Blog Post',
                'tone' => 'Casual',
                'template' => "Write a casual blog post about {{raw_content}}. 
                Naturally incorporate these keywords: {{keywords}}. 
                Write as a {{role}} in {{industry}}. 
                The post should be around {{word_limit}} words.
                Use a {{tone}} tone throughout the post.
                Make it conversational and engaging, with personal anecdotes and practical tips.
                Include a clear call to action at the end."
            ]
        ];

        // Update or insert templates
        foreach ($templates as $templateData) {
            $postType = $postTypes->get($templateData['post_type']);
            $tone = $tones->get($templateData['tone']);

            if ($postType && $tone) {
                DB::table('prompt_templates')->updateOrInsert(
                    [
                        'post_type_id' => $postType->id,
                        'tone_id' => $tone->id
                    ],
                    [
                        'template' => $templateData['template'],
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
            }
        }
    }

    public function down()
    {
        // No need to implement down() as this is a data migration
    }
}; 