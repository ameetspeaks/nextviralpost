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

            // Replace placeholders with actual values
            $replacements = [
                '{raw_content}' => $userData['raw_content'],
                '{keywords}' => $userData['keywords'],
                '{word_limit}' => $userData['word_limit'],
                '{industry}' => $userData['industry'],
                '{role}' => $userData['role'],
                '{post_type}' => $userData['post_type'],
                '{tone}' => $userData['tone']
            ];

            $processedPrompt = str_replace(
                array_keys($replacements),
                array_values($replacements),
                $template
            );

            Log::info('Generated prompt', [
                'template_id' => $this->id,
                'original_template' => $template,
                'processed_prompt' => $processedPrompt,
                'user_data' => $userData
            ]);

            return $processedPrompt;
        } catch (\Exception $e) {
            Log::error('Error generating prompt', [
                'template_id' => $this->id,
                'error' => $e->getMessage(),
                'user_data' => $userData
            ]);
            throw $e;
        }
    }
} 