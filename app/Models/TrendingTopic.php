<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendingTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'trend_score',
        'trend_direction',
        'change_percentage',
        'related_keywords',
        'platform',
        'category',
    ];

    protected $casts = [
        'trend_score' => 'float',
        'change_percentage' => 'float',
        'related_keywords' => 'array',
    ];
} 