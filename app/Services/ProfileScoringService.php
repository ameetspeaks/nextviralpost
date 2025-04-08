<?php

namespace App\Services;

use App\Models\LinkedinProfile;
use App\Models\ProfileScore;
use Illuminate\Support\Str;

class ProfileScoringService
{
    protected $sectionWeights = [
        'headline' => 0.20,
        'summary' => 0.25,
        'experience' => 0.30,
        'education' => 0.15,
        'skills' => 0.10
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

    public function scoreProfile($sections)
    {
        $scores = [];
        $feedback = [];
        $totalScore = 0;

        foreach ($sections as $section => $content) {
            $method = 'score' . ucfirst($section);
            if (method_exists($this, $method)) {
                list($score, $sectionFeedback) = $this->$method($content);
                $scores[$section] = $score;
                $feedback[$section] = $sectionFeedback;
                $totalScore += $score * $this->sectionWeights[$section];
            }
        }

        return [
            'overall_score' => round($totalScore),
            'section_scores' => $scores,
            'feedback' => $feedback
        ];
    }

    protected function scoreHeadline($headline)
    {
        $score = 0;
        $feedback = [];

        // Check length (50-120 characters is optimal)
        $length = strlen($headline);
        if ($length >= 50 && $length <= 120) {
            $score += 25;
        } else {
            $score += 10;
            if ($length < 50) {
                $feedback[] = "Headline is too short. Add relevant keywords to reach 50-120 characters.";
            } else {
                $feedback[] = "Headline exceeds optimal length. Try to be more concise.";
            }
        }

        // Check for job title
        $jobTitles = ['manager', 'developer', 'engineer', 'director', 'specialist', 'analyst', 'consultant'];
        $hasJobTitle = false;
        foreach ($jobTitles as $title) {
            if (stripos($headline, $title) !== false) {
                $hasJobTitle = true;
                break;
            }
        }
        if ($hasJobTitle) {
            $score += 25;
        } else {
            $feedback[] = "Include your job title or role for better visibility.";
        }

        // Check for industry keywords
        $industryKeywords = ['software', 'marketing', 'sales', 'finance', 'healthcare', 'data'];
        $keywordCount = 0;
        foreach ($industryKeywords as $keyword) {
            if (stripos($headline, $keyword) !== false) {
                $keywordCount++;
            }
        }
        if ($keywordCount >= 2) {
            $score += 25;
        } else {
            $feedback[] = "Add industry-specific keywords relevant to your field.";
        }

        // Check for value proposition
        $impactTerms = ['expert in', 'specialist in', 'focused on', 'helping', 'driving'];
        $hasValueProp = false;
        foreach ($impactTerms as $term) {
            if (stripos($headline, $term) !== false) {
                $hasValueProp = true;
                break;
            }
        }
        if ($hasValueProp) {
            $score += 25;
        } else {
            $feedback[] = "Include a value proposition that differentiates you.";
        }

        return [$score, $feedback];
    }

    protected function scoreSummary($summary)
    {
        $score = 0;
        $feedback = [];

        // Check length (1500-2000 characters is optimal)
        $length = strlen($summary);
        if ($length >= 1500 && $length <= 2000) {
            $score += 20;
        } else {
            $score += 10;
            if ($length < 1500) {
                $feedback[] = "Summary is too short. Aim for 1500-2000 characters.";
            } else {
                $feedback[] = "Summary exceeds optimal length. Consider making it more concise.";
            }
        }

        // Check for achievements
        $achievementIndicators = ['increased', 'reduced', 'improved', 'achieved', 'led', 'created', '%', '$'];
        $achievementCount = 0;
        foreach ($achievementIndicators as $indicator) {
            if (stripos($summary, $indicator) !== false) {
                $achievementCount++;
            }
        }
        if ($achievementCount >= 3) {
            $score += 30;
        } else {
            $feedback[] = "Include more quantifiable achievements in your summary.";
        }

        // Check for storytelling elements
        $paragraphs = explode("\n\n", $summary);
        if (count($paragraphs) >= 3) {
            $score += 25;
        } else {
            $feedback[] = "Structure your summary with clear paragraphs for better readability.";
        }

        // Check for call to action
        $ctaTerms = ['contact', 'connect', 'reach out', 'email', 'call', 'visit', 'follow'];
        $hasCTA = false;
        foreach ($ctaTerms as $term) {
            if (stripos($summary, $term) !== false) {
                $hasCTA = true;
                break;
            }
        }
        if ($hasCTA) {
            $score += 25;
        } else {
            $feedback[] = "Add a clear call-to-action at the end of your summary.";
        }

        return [$score, $feedback];
    }

    protected function scoreExperience($experience)
    {
        $score = 0;
        $feedback = [];

        if (empty($experience)) {
            $feedback[] = "No work experience listed.";
            return [$score, $feedback];
        }

        // Check for achievement quantification
        $achievementPatterns = '/\b(?:increased|improved|achieved|reduced|saved|grew|launched)\b.*?(?:\d+%|\$\d+|\d+ million)/i';
        preg_match_all($achievementPatterns, $experience, $matches);
        $achievementCount = count($matches[0]);
        if ($achievementCount >= 3) {
            $score += 30;
        } else {
            $feedback[] = "Add more quantifiable achievements to your experience section.";
        }

        // Check for responsibility description
        $responsibilityTerms = ['managed', 'led', 'directed', 'coordinated', 'developed'];
        $responsibilityCount = 0;
        foreach ($responsibilityTerms as $term) {
            if (stripos($experience, $term) !== false) {
                $responsibilityCount++;
            }
        }
        if ($responsibilityCount >= 3) {
            $score += 30;
        } else {
            $feedback[] = "Expand role descriptions with leadership and impact details.";
        }

        // Check for keyword density
        $keywords = ['developed', 'implemented', 'managed', 'designed', 'analyzed', 'created'];
        $keywordCount = 0;
        foreach ($keywords as $keyword) {
            if (stripos($experience, $keyword) !== false) {
                $keywordCount++;
            }
        }
        if ($keywordCount >= 4) {
            $score += 20;
        } else {
            $feedback[] = "Include more action verbs and technical terms in your experience descriptions.";
        }

        // Check for progression logic
        $positions = explode("\n", $experience);
        if (count($positions) >= 3) {
            $score += 20;
        } else {
            $feedback[] = "Include additional positions to show career progression.";
        }

        return [$score, $feedback];
    }

    protected function scoreEducation($education)
    {
        $score = 0;
        $feedback = [];

        if (empty($education)) {
            $feedback[] = "No education information listed.";
            return [$score, $feedback];
        }

        // Check for relevant coursework
        if (preg_match('/\b(?:coursework|courses|subjects)\b/i', $education)) {
            $score += 30;
        } else {
            $feedback[] = "Include relevant coursework in your education section.";
        }

        // Check for achievements
        if (preg_match('/\b(?:honors|awards|scholarship|dean\'s list)\b/i', $education)) {
            $score += 30;
        } else {
            $feedback[] = "Add academic achievements and honors to your education section.";
        }

        // Check for degree information
        if (preg_match('/\b(?:bachelor|master|phd|doctorate|degree)\b/i', $education)) {
            $score += 40;
        } else {
            $feedback[] = "Include your degree information in the education section.";
        }

        return [$score, $feedback];
    }

    protected function scoreSkills($skills)
    {
        $score = 0;
        $feedback = [];

        if (empty($skills)) {
            $feedback[] = "No skills listed.";
            return [$score, $feedback];
        }

        // Count skills
        $skillCount = count(explode(',', $skills));
        if ($skillCount >= 10) {
            $score += 40;
        } elseif ($skillCount >= 5) {
            $score += 30;
        } else {
            $feedback[] = "Add more skills to your profile.";
        }

        // Check for technical skills
        $technicalTerms = ['programming', 'development', 'analysis', 'design', 'engineering'];
        $technicalCount = 0;
        foreach ($technicalTerms as $term) {
            if (stripos($skills, $term) !== false) {
                $technicalCount++;
            }
        }
        if ($technicalCount >= 2) {
            $score += 30;
        } else {
            $feedback[] = "Include more technical skills relevant to your field.";
        }

        // Check for soft skills
        $softSkills = ['leadership', 'communication', 'teamwork', 'problem-solving', 'management'];
        $softSkillCount = 0;
        foreach ($softSkills as $skill) {
            if (stripos($skills, $skill) !== false) {
                $softSkillCount++;
            }
        }
        if ($softSkillCount >= 2) {
            $score += 30;
        } else {
            $feedback[] = "Add more soft skills to your profile.";
        }

        return [$score, $feedback];
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
            $overallScore += $data['score'] * $this->sectionWeights[$section];
        }
        return min(100, $overallScore);
    }
} 