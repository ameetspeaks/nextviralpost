<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicAnalytic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_views',
        'views_change',
        'engagement_rate',
        'engagement_change',
        'top_topic',
        'top_topic_views',
        'avg_time',
        'time_change',
        'period',
    ];

    protected $casts = [
        'total_views' => 'integer',
        'views_change' => 'float',
        'engagement_rate' => 'float',
        'engagement_change' => 'float',
        'top_topic_views' => 'integer',
        'avg_time' => 'float',
        'time_change' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 