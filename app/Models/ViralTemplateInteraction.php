<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViralTemplateInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'viral_template_id',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viralTemplate()
    {
        return $this->belongsTo(ViralTemplate::class);
    }
}
