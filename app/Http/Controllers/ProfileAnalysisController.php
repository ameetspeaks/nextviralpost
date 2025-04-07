<?php

namespace App\Http\Controllers;

use App\Models\LinkedinProfile;
use App\Services\ProfileScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileAnalysisController extends Controller
{
    protected $scoringService;

    public function __construct(ProfileScoringService $scoringService)
    {
        $this->scoringService = $scoringService;
    }

    public function analyzeProfile(Request $request, $profileId)
    {
        $profile = LinkedinProfile::where('user_id', Auth::id())
            ->findOrFail($profileId);

        $score = $this->scoringService->analyzeProfile($profile);

        return response()->json([
            'success' => true,
            'data' => [
                'overall_score' => $score->formatted_overall_score,
                'section_scores' => $score->formatted_section_scores,
                'recommendations' => [
                    'headline' => $score->headline_recommendations,
                    'summary' => $score->summary_recommendations,
                    'experience' => $score->experience_recommendations,
                    'skills' => $score->skills_recommendations,
                    'education' => $score->education_recommendations,
                    'other_sections' => $score->other_sections_recommendations,
                ],
                'last_analyzed_at' => $score->last_analyzed_at->toIso8601String(),
            ],
        ]);
    }

    public function getProfileScores(Request $request, $profileId)
    {
        $profile = LinkedinProfile::where('user_id', Auth::id())
            ->findOrFail($profileId);

        $scores = $profile->scores()
            ->latest()
            ->first();

        if (!$scores) {
            return response()->json([
                'success' => false,
                'message' => 'No analysis found for this profile. Please run an analysis first.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'overall_score' => $scores->formatted_overall_score,
                'section_scores' => $scores->formatted_section_scores,
                'recommendations' => [
                    'headline' => $scores->headline_recommendations,
                    'summary' => $scores->summary_recommendations,
                    'experience' => $scores->experience_recommendations,
                    'skills' => $scores->skills_recommendations,
                    'education' => $scores->education_recommendations,
                    'other_sections' => $scores->other_sections_recommendations,
                ],
                'last_analyzed_at' => $scores->last_analyzed_at->toIso8601String(),
            ],
        ]);
    }
} 