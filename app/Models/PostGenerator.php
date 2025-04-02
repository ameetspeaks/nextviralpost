<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostGenerator extends Model
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
        'generated_content'
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
        return $this->belongsTo(PostTone::class);
    }
} 