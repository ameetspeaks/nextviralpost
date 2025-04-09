<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrendingPrompt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'prompt_template',
        'requirements',
        'llm_model',
        'is_paid',
        'free_user_limit',
        'paid_amount',
        'is_active'
    ];

    protected $casts = [
        'requirements' => 'array',
        'is_paid' => 'boolean',
        'is_active' => 'boolean',
        'paid_amount' => 'decimal:2'
    ];
} 