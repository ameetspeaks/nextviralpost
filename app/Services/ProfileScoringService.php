<?php

namespace App\Services;

use App\Models\LinkedinProfile;
use App\Models\ProfileScore;
use Illuminate\Support\Str;

class ProfileScoringService
{
    private const SECTION_WEIGHTS = [
        'headline' => 0.15,
        'summary' => 0.20,
        'experience' => 0.25,
        'skills' => 0.15,
        'education' => 0.10,
        'other_sections' => 0.15,
    ];

    public function analyzeProfile(LinkedinProfile $profile): ProfileScore
    {
        $scores = [
            'headline' => $this->scoreHeadline($profile->headline),
            'summary' => $this->scoreSummary($profile->summary),
            'experience' => $this->scoreExperience($profile->experience),
            'skills' => $this->scoreSkills($profile->skills),
            'education' => $this->scoreEducation($profile->education),
            'other_sections' => $this->scoreOtherSections($profile),
        ];

        $overallScore = $this->calculateOverallScore($scores);

        return ProfileScore::create([
            'linkedin_profile_id' => $profile->id,
            'overall_score' => $overallScore,
            'headline_score' => $scores['headline']['score'],
            'summary_score' => $scores['summary']['score'],
            'experience_score' => $scores['experience']['score'],
            'skills_score' => $scores['skills']['score'],
            'education_score' => $scores['education']['score'],
            'other_sections_score' => $scores['other_sections']['score'],
            'headline_recommendations' => $scores['headline']['recommendations'],
            'summary_recommendations' => $scores['summary']['recommendations'],
            'experience_recommendations' => $scores['experience']['recommendations'],
            'skills_recommendations' => $scores['skills']['recommendations'],
            'education_recommendations' => $scores['education']['recommendations'],
            'other_sections_recommendations' => $scores['other_sections']['recommendations'],
            'analysis_metadata' => [
                'version' => '1.0',
                'analyzed_at' => now()->toIso8601String(),
            ],
            'last_analyzed_at' => now(),
        ]);
    }

    private function scoreHeadline(string $headline): array
    {
        $score = 0;
        $recommendations = [];

        // Length check (50-120 characters optimal)
        $length = strlen($headline);
        if ($length >= 50 && $length <= 120) {
            $score += 30;
        } elseif ($length < 50) {
            $score += 10;
            $recommendations[] = [
                'priority' => 'high',
                'message' => 'Your headline is too short. Aim for 50-120 characters to include more relevant keywords.',
            ];
        } else {
            $score += 15;
            $recommendations[] = [
                'priority' => 'medium',
                'message' => 'Your headline exceeds the optimal length. Consider making it more concise.',
            ];
        }

        // Keyword optimization
        $keywordScore = $this->checkKeywords($headline, ['professional', 'experienced']);
        $score += $keywordScore['score'];
        $recommendations = array_merge($recommendations, $keywordScore['recommendations']);

        // Clarity & Impact
        $impactScore = $this->checkImpactTerms($headline);
        $score += $impactScore['score'];
        $recommendations = array_merge($recommendations, $impactScore['recommendations']);

        return [
            'score' => min(100, $score),
            'recommendations' => $recommendations,
        ];
    }

    private function scoreSummary(string $summary): array
    {
        $score = 0;
        $recommendations = [];

        // Length check (1500-2000 characters optimal)
        $length = strlen($summary);
        if ($length >= 1500 && $length <= 2000) {
            $score += 15;
        } elseif ($length < 1500) {
            $score += 5;
            $recommendations[] = [
                'priority' => 'high',
                'message' => 'Your summary is too brief. Aim for 1500-2000 characters to tell your story effectively.',
            ];
        } else {
            $score += 10;
            $recommendations[] = [
                'priority' => 'medium',
                'message' => 'Your summary exceeds the optimal length. Consider making it more concise.',
            ];
        }

        // Storytelling and structure
        $paragraphs = explode("\n\n", $summary);
        if (count($paragraphs) >= 3) {
            $score += 25;
        } else {
            $score += 10;
            $recommendations[] = [
                'priority' => 'medium',
                'message' => 'Structure your summary with clear paragraphs for better readability.',
            ];
        }

        // Achievement focus
        $achievementScore = $this->checkAchievements($summary);
        $score += $achievementScore['score'];
        $recommendations = array_merge($recommendations, $achievementScore['recommendations']);

        return [
            'score' => min(100, $score),
            'recommendations' => $recommendations,
        ];
    }

    private function scoreExperience(array $experience): array
    {
        $score = 0;
        $recommendations = [];

        foreach ($experience as $position) {
            // Achievement quantification
            $achievementScore = $this->checkAchievements($position['description'] ?? '');
            $score += $achievementScore['score'];

            // Responsibility description
            if (strlen($position['description'] ?? '') > 100) {
                $score += 25;
            } else {
                $score += 10;
                $recommendations[] = [
                    'priority' => 'medium',
                    'message' => "Add more detail to your {$position['title']} role description.",
                ];
            }
        }

        $score = $score / max(1, count($experience)); // Average score per position

        return [
            'score' => min(100, $score),
            'recommendations' => $recommendations,
        ];
    }

    private function scoreSkills(array $skills): array
    {
        $score = 0;
        $recommendations = [];

        $skillCount = count($skills);
        if ($skillCount >= 10) {
            $score += 50;
        } elseif ($skillCount >= 5) {
            $score += 30;
            $recommendations[] = [
                'priority' => 'low',
                'message' => 'Consider adding more skills to showcase your expertise.',
            ];
        } else {
            $score += 10;
            $recommendations[] = [
                'priority' => 'high',
                'message' => 'Add more skills to improve your profile visibility.',
            ];
        }

        return [
            'score' => min(100, $score),
            'recommendations' => $recommendations,
        ];
    }

    private function scoreEducation(array $education): array
    {
        $score = 0;
        $recommendations = [];

        foreach ($education as $edu) {
            if (!empty($edu['degree']) && !empty($edu['field_of_study'])) {
                $score += 20;
            } else {
                $recommendations[] = [
                    'priority' => 'medium',
                    'message' => "Complete your education details for {$edu['school']}.",
                ];
            }
        }

        return [
            'score' => min(100, $score),
            'recommendations' => $recommendations,
        ];
    }

    private function scoreOtherSections(LinkedinProfile $profile): array
    {
        $score = 0;
        $recommendations = [];

        // Check for certifications
        if (!empty($profile->certifications)) {
            $score += 30;
        } else {
            $recommendations[] = [
                'priority' => 'low',
                'message' => 'Consider adding relevant certifications to enhance your profile.',
            ];
        }

        // Check for volunteer experience
        if (!empty($profile->volunteer_experience)) {
            $score += 20;
        }

        return [
            'score' => min(100, $score),
            'recommendations' => $recommendations,
        ];
    }

    private function calculateOverallScore(array $scores): float
    {
        $overallScore = 0;
        foreach ($scores as $section => $data) {
            $overallScore += $data['score'] * self::SECTION_WEIGHTS[$section];
        }
        return min(100, $overallScore);
    }

    private function checkKeywords(string $text, array $genericTerms): array
    {
        $score = 0;
        $recommendations = [];

        $genericCount = 0;
        foreach ($genericTerms as $term) {
            if (stripos($text, $term) !== false) {
                $genericCount++;
            }
        }

        if ($genericCount === 0) {
            $score += 30;
        } else {
            $score += max(0, 30 - ($genericCount * 10));
            $recommendations[] = [
                'priority' => 'high',
                'message' => 'Avoid generic terms like "' . implode('", "', $genericTerms) . '". Use more specific industry terms instead.',
            ];
        }

        return [
            'score' => $score,
            'recommendations' => $recommendations,
        ];
    }

    private function checkImpactTerms(string $text): array
    {
        $score = 0;
        $recommendations = [];

        $impactTerms = ['leader', 'expert', 'specialist', 'professional'];
        $hasImpact = false;

        foreach ($impactTerms as $term) {
            if (stripos($text, $term) !== false) {
                $hasImpact = true;
                break;
            }
        }

        if ($hasImpact) {
            $score += 40;
        } else {
            $score += 10;
            $recommendations[] = [
                'priority' => 'medium',
                'message' => 'Add terms that demonstrate your expertise or specialization.',
            ];
        }

        return [
            'score' => $score,
            'recommendations' => $recommendations,
        ];
    }

    private function checkAchievements(string $text): array
    {
        $score = 0;
        $recommendations = [];

        $achievementIndicators = ['increased', 'reduced', 'improved', 'achieved', 'led', 'created', '%', '$'];
        $achievementCount = 0;

        foreach ($achievementIndicators as $indicator) {
            if (stripos($text, $indicator) !== false) {
                $achievementCount++;
            }
        }

        if ($achievementCount >= 3) {
            $score += 25;
        } elseif ($achievementCount >= 1) {
            $score += 15;
            $recommendations[] = [
                'priority' => 'medium',
                'message' => 'Include more quantifiable achievements in your description.',
            ];
        } else {
            $recommendations[] = [
                'priority' => 'high',
                'message' => 'Add specific achievements with metrics to your description.',
            ];
        }

        return [
            'score' => $score,
            'recommendations' => $recommendations,
        ];
    }
} 