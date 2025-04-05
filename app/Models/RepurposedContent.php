<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepurposedContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'viral_template_id',
        'tone_id',
        'raw_thoughts',
        'repurposed_content',
        'prompt_used'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viralTemplate()
    {
        return $this->belongsTo(ViralTemplate::class);
    }

    public function tone()
    {
        return $this->belongsTo(PostTone::class);
    }

    public static function hasUserRepurposedTemplate($userId, $templateId)
    {
        return static::where('user_id', $userId)
            ->where('viral_template_id', $templateId)
            ->exists();
    }
} 