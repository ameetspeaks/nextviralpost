<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentIdea extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'platform',
        'viral_potential',
        'status',
        'topic_id',
    ];

    protected $casts = [
        'viral_potential' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(TrendingTopic::class, 'topic_id');
    }
} 