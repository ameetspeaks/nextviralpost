<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromptTemplate extends Model
{
    protected $fillable = [
        'title',
        'content',
        'category',
        'post_goal',
        'virality_factor',
        'default_hook_id',
        'version',
        'is_active',
        'post_type_id',
        'tone_id'
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
        return $this->belongsTo(Tone::class);
    }

    public function hook()
    {
        return $this->belongsTo(Hook::class, 'default_hook_id');
    }

    public function generatePrompt(User $user, string $keywords, string $postContent, int $wordLimit): string
    {
        $replacements = [
            '{keywords}' => $keywords,
            '{post_content}' => $postContent,
            '{word_limit}' => $wordLimit,
            '{user_name}' => $user->name,
            '{company_name}' => $user->company_name ?? 'your company',
            '{industry}' => $user->industry ?? 'your industry'
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $this->content
        );
    }
} 