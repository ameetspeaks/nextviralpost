<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileScore extends Model
{
    protected $fillable = [
        'linkedin_profile_id',
        'overall_score',
        'headline_score',
        'summary_score',
        'experience_score',
        'skills_score',
        'education_score',
        'other_sections_score',
        'headline_recommendations',
        'summary_recommendations',
        'experience_recommendations',
        'skills_recommendations',
        'education_recommendations',
        'other_sections_recommendations',
        'analysis_metadata',
        'last_analyzed_at',
    ];

    protected $casts = [
        'headline_recommendations' => 'array',
        'summary_recommendations' => 'array',
        'experience_recommendations' => 'array',
        'skills_recommendations' => 'array',
        'education_recommendations' => 'array',
        'other_sections_recommendations' => 'array',
        'analysis_metadata' => 'array',
        'last_analyzed_at' => 'datetime',
    ];

    public function linkedinProfile(): BelongsTo
    {
        return $this->belongsTo(LinkedinProfile::class);
    }

    public function getFormattedOverallScoreAttribute(): string
    {
        return number_format($this->overall_score, 1);
    }

    public function getFormattedSectionScoresAttribute(): array
    {
        return [
            'headline' => number_format($this->headline_score, 1),
            'summary' => number_format($this->summary_score, 1),
            'experience' => number_format($this->experience_score, 1),
            'skills' => number_format($this->skills_score, 1),
            'education' => number_format($this->education_score, 1),
            'other_sections' => number_format($this->other_sections_score, 1),
        ];
    }
} 