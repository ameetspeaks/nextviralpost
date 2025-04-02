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
        
        // Replace placeholders with user data
        $replacements = [
            '[Industry]' => $userData['industry'] ?? 'Professional',
            '[Role]' => $userData['role'] ?? 'Professional',
            '[What is Post About]' => $userData['content'] ?? '',
            '{topic}' => $userData['content'] ?? '',
            '[Keyword(s)]' => $userData['keywords'] ?? '',
            '[Word Limit]' => $userData['word_limit'] ?? 100
        ];

        foreach ($replacements as $placeholder => $value) {
            $prompt = str_replace($placeholder, $value, $prompt);
        }

        return trim($prompt);
    }
} 