<?php

namespace Database\Seeders;

use App\Models\PostType;
use App\Models\PostTone;
use App\Models\PromptTemplate;
use Illuminate\Database\Seeder;

class PromptTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'title' => 'Engagement Question',
                'slug' => 'engagement-question',
                'content' => 'Create an engaging question about {topic} that will encourage audience participation. The question should be thought-provoking and relevant to the target audience.',
                'category' => 'Engagement',
                'post_goal' => 'Increase audience interaction',
                'virality_factor' => 'Thought-provoking questions',
                'is_active' => true,
            ],
            [
                'title' => 'Educational Post',
                'slug' => 'educational-post',
                'content' => 'Create an educational post about {topic} that explains key concepts in a clear and engaging way. Include practical examples and actionable takeaways.',
                'category' => 'Education',
                'post_goal' => 'Share knowledge',
                'virality_factor' => 'Valuable insights',
                'is_active' => true,
            ],
            [
                'title' => 'Product Launch',
                'slug' => 'product-launch',
                'content' => 'Create an exciting product launch announcement for {product_name}. Highlight the key features, benefits, and how it solves customer problems. Include a clear call to action.',
                'category' => 'Marketing',
                'post_goal' => 'Product announcement',
                'virality_factor' => 'Exciting features and benefits',
                'is_active' => true,
            ],
            [
                'title' => 'Tips & Tricks',
                'slug' => 'tips-tricks',
                'content' => 'Create a post sharing {number} practical tips about {topic}. Each tip should be actionable and provide immediate value to the audience.',
                'category' => 'Tips',
                'post_goal' => 'Share practical advice',
                'virality_factor' => 'Actionable tips',
                'is_active' => true,
            ],
            [
                'title' => 'Success Story',
                'slug' => 'success-story',
                'content' => 'Create a compelling success story about how {product/service} helped {customer_type} achieve their goals. Include specific results and testimonials.',
                'category' => 'Case Study',
                'post_goal' => 'Share success stories',
                'virality_factor' => 'Real results and testimonials',
                'is_active' => true,
            ],
            [
                'title' => 'Behind the Scenes',
                'slug' => 'behind-scenes',
                'content' => 'Create a behind-the-scenes post showing {aspect} of our company. Make it personal and engaging while maintaining professionalism.',
                'category' => 'Company Culture',
                'post_goal' => 'Show company culture',
                'virality_factor' => 'Personal insights',
                'is_active' => true,
            ],
            [
                'title' => 'Problem-Solution',
                'slug' => 'problem-solution',
                'content' => 'Create a post addressing the common problem of {problem} in {industry}. Provide practical solutions and explain how {product/service} can help.',
                'category' => 'Solutions',
                'post_goal' => 'Problem solving',
                'virality_factor' => 'Practical solutions',
                'is_active' => true,
            ],
            [
                'title' => 'Industry Insights',
                'slug' => 'industry-insights',
                'content' => 'Create an insightful post about current trends in {industry}. Include data points, expert opinions, and predictions for the future.',
                'category' => 'Industry Analysis',
                'post_goal' => 'Share industry trends',
                'virality_factor' => 'Expert insights',
                'is_active' => true,
            ],
        ];

        // Get post types and tones
        $postTypes = PostType::all()->keyBy('slug');
        $tones = PostTone::all()->keyBy('slug');

        foreach ($templates as $template) {
            // Get matching post type and tone
            $postType = $postTypes->get($template['slug']);
            $tone = $tones->get('professional'); // Default to professional tone

            if ($postType && $tone) {
                $template['post_type_id'] = $postType->id;
                $template['tone_id'] = $tone->id;
                $template['version'] = 1;

                PromptTemplate::updateOrCreate(
                    ['slug' => $template['slug']],
                    $template
                );
            }
        }
    }
} 