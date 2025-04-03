<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromptTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'post_type_id',
        'tone_id',
        'category',
        'post_goal',
        'virality_factor',
        'version',
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
        $prompt = $this->content;
        
        // Get user preferences for industry and role
        $userPreferences = UserPreference::where('user_id', auth()->id())->first();
        
        // Get post type and tone names
        $postType = PostType::find($userData['post_type_id']);
        $tone = PostTone::find($userData['tone_id']);
        
        // Replace placeholders with user data
        $replacements = [
            '{industry}' => $userPreferences->industry->name ?? 'Professional',
            '{role}' => $userPreferences->role->name ?? 'Professional',
            '{roles}' => $userPreferences->role->name ?? 'Professional',
            '{keywords}' => $userData['keywords'] ?? '',
            '{word_limit}' => $userData['word_limit'] ?? 50,
            '{raw_content}' => $userData['raw_content'] ?? '',
            '[Industry]' => $userPreferences->industry->name ?? 'Professional',
            '[Role]' => $userPreferences->role->name ?? 'Professional',
            '[What is Post About]' => $userData['raw_content'] ?? '',
            '[Keyword(s)]' => $userData['keywords'] ?? '',
            '[Word Limit]' => $userData['word_limit'] ?? 50,
            '[post_type]' => $postType->name ?? 'LinkedIn Post',
            '[Tone]' => $tone->name ?? 'Professional'
        ];

        foreach ($replacements as $placeholder => $value) {
            // Skip empty placeholders if the value is empty
            if (empty($value) && strpos($prompt, $placeholder) !== false) {
                // Remove the placeholder and any surrounding text that might be affected
                $prompt = preg_replace('/\s*' . preg_quote($placeholder, '/') . '\s*/', '', $prompt);
            } else {
                $prompt = str_replace($placeholder, $value, $prompt);
            }
        }

        // Clean up any double spaces or empty lines
        $prompt = preg_replace('/\s+/', ' ', $prompt);
        return trim($prompt);
    }
} 