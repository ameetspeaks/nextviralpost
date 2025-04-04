<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class PromptTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_type_id',
        'tone_id',
        'title',
        'content',
        'category',
        'post_goal',
        'virality_factor',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'version' => 'integer'
    ];

    public function postType()
    {
        return $this->belongsTo(PostType::class);
    }

    public function tone()
    {
        return $this->belongsTo(PostTone::class);
    }

    public function generatePrompt($userData)
    {
        try {
            $template = $this->content;
            
            // Validate required user data
            $requiredFields = ['raw_content', 'keywords', 'word_limit', 'industry', 'role', 'post_type', 'tone'];
            foreach ($requiredFields as $field) {
                if (empty($userData[$field])) {
                    throw new \Exception("Missing required field: {$field}");
                }
            }
            
            // Extract values from nested objects
            $industry = is_object($userData['industry']) ? $userData['industry']->name : $userData['industry'];
            $role = is_object($userData['role']) ? $userData['role']->name : $userData['role'];
            
            // Define all placeholders and their values
            $replacements = [
                '{{raw_content}}' => $userData['raw_content'],
                '{{keywords}}' => $userData['keywords'],
                '{{word_limit}}' => $userData['word_limit'],
                '{{industry}}' => $industry,
                '{{role}}' => $role,
                '{{post_type}}' => $userData['post_type'],
                '{{tone}}' => $userData['tone']
            ];

            // Replace all placeholders in the template
            $prompt = str_replace(
                array_keys($replacements),
                array_values($replacements),
                $template
            );

            // Verify all placeholders were replaced
            $unreplacedPlaceholders = [];
            foreach ($replacements as $placeholder => $value) {
                if (strpos($prompt, $placeholder) !== false) {
                    $unreplacedPlaceholders[] = $placeholder;
                }
            }

            if (!empty($unreplacedPlaceholders)) {
                throw new \Exception("Failed to replace placeholders: " . implode(', ', $unreplacedPlaceholders));
            }

            // Clean up any double spaces or empty lines
            $prompt = preg_replace('/\s+/', ' ', $prompt);
            $prompt = trim($prompt);

            // Log the generated prompt for debugging
            Log::debug('Generated prompt', [
                'template_id' => $this->id,
                'original_template' => $template,
                'generated_prompt' => $prompt,
                'user_data' => $userData
            ]);

            return $prompt;

        } catch (\Exception $e) {
            Log::error('Error generating prompt', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'template_id' => $this->id,
                'user_data' => $userData
            ]);
            throw new \Exception('Error generating prompt: ' . $e->getMessage());
        }
    }
} 