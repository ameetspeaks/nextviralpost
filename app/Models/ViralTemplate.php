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
        'date_posted',
        'repurpose_count',
        'user_ids'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'date_posted' => 'datetime',
        'likes' => 'integer',
        'comments' => 'integer',
        'shares' => 'integer',
        'repurpose_count' => 'integer'
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

    public function incrementRepurposeCount($userId)
    {
        $this->increment('repurpose_count');
        
        $userIds = $this->user_ids ? explode(',', $this->user_ids) : [];
        if (!in_array($userId, $userIds)) {
            $userIds[] = $userId;
            $this->user_ids = implode(',', $userIds);
            $this->save();
        }
    }

    public function getUsersAttribute()
    {
        if (!$this->user_ids) {
            return collect();
        }
        return User::whereIn('id', explode(',', $this->user_ids))->get();
    }
}
