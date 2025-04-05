<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_type_id',
        'tone_id',
        'keywords',
        'raw_content',
        'word_limit',
        'prompt',
        'generated_content',
        'is_bookmarked',
        'feedback',
        'feedback_at',
        'regeneration_attempts',
        'source',
        'viral_template_id'
    ];

    protected $casts = [
        'is_bookmarked' => 'boolean',
        'word_limit' => 'integer',
        'feedback_at' => 'datetime',
        'regeneration_attempts' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postType()
    {
        return $this->belongsTo(PostType::class);
    }

    public function tone()
    {
        return $this->belongsTo(PostTone::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function viralTemplate()
    {
        return $this->belongsTo(ViralTemplate::class);
    }

    public function isBookmarkedBy(User $user)
    {
        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }
} 