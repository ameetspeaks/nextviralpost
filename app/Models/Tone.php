<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tone extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function postGenerators()
    {
        return $this->hasMany(PostGenerator::class);
    }
} 