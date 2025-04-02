<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTone extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
} 