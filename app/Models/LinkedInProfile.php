<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LinkedInProfile extends Model
{
    use HasFactory;

    protected $table = 'linkedin_profiles';

    protected $fillable = [
        'user_id',
        'headline',
        'summary',
        'experience',
        'education',
        'skills',
        'certifications',
        'languages',
        'volunteer_experience',
        'recommendations',
        'overall_score',
        'section_scores',
        'improvement_suggestions',
        'competitor_analysis',
        'pdf_path'
    ];

    protected $casts = [
        'experience' => 'array',
        'education' => 'array',
        'skills' => 'array',
        'certifications' => 'array',
        'languages' => 'array',
        'volunteer_experience' => 'array',
        'recommendations' => 'array',
        'section_scores' => 'array',
        'improvement_suggestions' => 'array',
        'competitor_analysis' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculateScore(): array
    {
        $scores = [
            'headline' => $this->scoreHeadline(),
            'summary' => $this->scoreSummary(),
            'experience' => $this->scoreExperience(),
            'education' => $this->scoreEducation(),
            'skills' => $this->scoreSkills(),
            'certifications' => $this->scoreCertifications(),
            'languages' => $this->scoreLanguages(),
            'volunteer_experience' => $this->scoreVolunteerExperience(),
            'recommendations' => $this->scoreRecommendations()
        ];

        $overallScore = array_sum($scores) / count($scores);
        
        return [
            'overall_score' => round($overallScore),
            'section_scores' => $scores
        ];
    }

    private function scoreHeadline(): int
    {
        if (empty($this->headline)) return 0;
        
        $score = 0;
        $headline = strtolower($this->headline);
        
        // Check for keywords
        $keywords = ['expert', 'specialist', 'professional', 'leader', 'manager', 'director'];
        foreach ($keywords as $keyword) {
            if (strpos($headline, $keyword) !== false) {
                $score += 10;
            }
        }
        
        // Check length
        $length = strlen($this->headline);
        if ($length >= 50 && $length <= 120) {
            $score += 20;
        }
        
        return min($score, 100);
    }

    private function scoreSummary(): int
    {
        if (empty($this->summary)) return 0;
        
        $score = 0;
        $summary = strtolower($this->summary);
        
        // Check length
        $length = strlen($this->summary);
        if ($length >= 200 && $length <= 2000) {
            $score += 30;
        }
        
        // Check for achievements
        if (preg_match('/\d+/', $summary)) {
            $score += 20;
        }
        
        // Check for action words
        $actionWords = ['achieved', 'led', 'managed', 'increased', 'improved', 'developed'];
        foreach ($actionWords as $word) {
            if (strpos($summary, $word) !== false) {
                $score += 10;
            }
        }
        
        return min($score, 100);
    }

    private function scoreExperience(): int
    {
        if (empty($this->experience)) return 0;
        
        $score = 0;
        $experience = $this->experience;
        
        // Check number of experiences
        $count = count($experience);
        if ($count >= 3) {
            $score += 30;
        }
        
        // Check for detailed descriptions
        foreach ($experience as $exp) {
            if (strlen($exp['description'] ?? '') > 100) {
                $score += 10;
            }
        }
        
        return min($score, 100);
    }

    private function scoreEducation(): int
    {
        if (empty($this->education)) return 0;
        
        $score = 0;
        $education = $this->education;
        
        // Check number of education entries
        $count = count($education);
        if ($count >= 1) {
            $score += 50;
        }
        
        // Check for additional details
        foreach ($education as $edu) {
            if (!empty($edu['description'])) {
                $score += 10;
            }
        }
        
        return min($score, 100);
    }

    private function scoreSkills(): int
    {
        if (empty($this->skills)) return 0;
        
        $score = 0;
        $skills = $this->skills;
        
        // Check number of skills
        $count = count($skills);
        if ($count >= 10) {
            $score += 50;
        } elseif ($count >= 5) {
            $score += 30;
        }
        
        // Check for endorsements
        foreach ($skills as $skill) {
            if (($skill['endorsements'] ?? 0) > 0) {
                $score += 5;
            }
        }
        
        return min($score, 100);
    }

    private function scoreCertifications(): int
    {
        if (empty($this->certifications)) return 0;
        
        $score = 0;
        $certifications = $this->certifications;
        
        // Check number of certifications
        $count = count($certifications);
        if ($count >= 3) {
            $score += 50;
        } elseif ($count >= 1) {
            $score += 30;
        }
        
        return min($score, 100);
    }

    private function scoreLanguages(): int
    {
        if (empty($this->languages)) return 0;
        
        $score = 0;
        $languages = $this->languages;
        
        // Check number of languages
        $count = count($languages);
        if ($count >= 2) {
            $score += 50;
        }
        
        return min($score, 100);
    }

    private function scoreVolunteerExperience(): int
    {
        if (empty($this->volunteer_experience)) return 0;
        
        $score = 0;
        $volunteer = $this->volunteer_experience;
        
        // Check number of volunteer experiences
        $count = count($volunteer);
        if ($count >= 1) {
            $score += 50;
        }
        
        return min($score, 100);
    }

    private function scoreRecommendations(): int
    {
        if (empty($this->recommendations)) return 0;
        
        $score = 0;
        $recommendations = $this->recommendations;
        
        // Check number of recommendations
        $count = count($recommendations);
        if ($count >= 5) {
            $score += 50;
        } elseif ($count >= 3) {
            $score += 30;
        }
        
        return min($score, 100);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(ProfileScore::class);
    }

    public function latestScore(): HasOne
    {
        return $this->hasOne(ProfileScore::class)->latest();
    }
} 