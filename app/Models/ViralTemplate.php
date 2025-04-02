<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'date_posted',
        'bookmark_count',
        'inspiration_count'
    ];

    protected $casts = [
        'date_posted' => 'datetime',
        'likes' => 'integer',
        'comments' => 'integer',
        'shares' => 'integer',
        'bookmark_count' => 'integer',
        'inspiration_count' => 'integer'
    ];

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
