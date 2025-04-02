<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostGenerator extends Model
{
    protected $fillable = [
        'user_id',
        'post_type_id',
        'tone_id',
        'keywords',
        'post_content',
        'word_limit',
        'generated_content',
        'is_bookmarked'
    ];

    protected $casts = [
        'is_bookmarked' => 'boolean',
        'word_limit' => 'integer'
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
        return $this->belongsTo(Tone::class);
    }
} 