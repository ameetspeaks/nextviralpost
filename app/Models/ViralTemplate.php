<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ViralTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'post_content',
        'post_link',
        'likes',
        'comments',
        'shares',
        'post_type_id',
        'tone_id',
        'is_active',
        'date_posted'
    ];

    protected $casts = [
        'likes' => 'integer',
        'comments' => 'integer',
        'shares' => 'integer',
        'is_active' => 'boolean',
        'date_posted' => 'datetime'
    ];

    public function postType()
    {
        return $this->belongsTo(PostType::class);
    }

    public function tone()
    {
        return $this->belongsTo(PostTone::class);
    }

    public function interactions()
    {
        return $this->hasMany(ViralTemplateInteraction::class);
    }

    public function bookmarks()
    {
        return $this->interactions()->where('type', 'bookmark');
    }

    public function inspirations()
    {
        return $this->interactions()->where('type', 'inspire');
    }

    public function isBookmarkedBy($user)
    {
        if (!$user) return false;
        
        return $this->interactions()
            ->where('user_id', $user->id)
            ->where('type', 'bookmark')
            ->exists();
    }

    public function inspiredBy()
    {
        return $this->interactions()
            ->where('type', 'inspire')
            ->with('user')
            ->latest();
    }
}
