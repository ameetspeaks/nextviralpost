<?php

namespace App\Http\Controllers;

use App\Models\LinkedInProfile;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Smalot\PdfParser\Parser;

class LinkedInProfileController extends Controller
{
    protected $geminiService;
    protected $pdfParser;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
        $this->pdfParser = new Parser();
    }

    public function index()
    {
        $profile = LinkedInProfile::where('user_id', Auth::id())->first();
        return view('linkedin-profile.index', compact('profile'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'pdf_file' => 'required|file|mimes:pdf|max:100'
            ]);

            $file = $request->file('pdf_file');
            $path = $file->store('linkedin-profiles', 'public');

            // Extract text from PDF
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($file->path());
            $text = $pdf->getText();

            if (empty($text)) {
                throw new \Exception('Could not extract text from PDF');
            }

            // Extract profile data using AI
            $profileData = $this->extractProfileData($text);
            
            // Calculate scores and generate suggestions
            $analysisResults = $this->calculateScores($profileData);

            // Create or update profile record
            $profile = LinkedInProfile::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'headline' => $profileData['headline'] ?? null,
                    'summary' => $profileData['summary'] ?? null,
                    'experience' => $profileData['experience'] ?? null,
                    'education' => $profileData['education'] ?? null,
                    'skills' => $profileData['skills'] ?? null,
                    'certifications' => $profileData['certifications'] ?? null,
                    'languages' => $profileData['languages'] ?? null,
                    'volunteer_experience' => $profileData['volunteer_experience'] ?? null,
                    'recommendations' => $profileData['recommendations'] ?? null,
                    'overall_score' => $analysisResults['overall_score'],
                    'section_scores' => $analysisResults['sections'],
                    'improvement_suggestions' => $analysisResults['improvement_suggestions'],
                    'pdf_path' => $path
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Profile analyzed successfully',
                'data' => $analysisResults
            ]);

        } catch (\Exception $e) {
            \Log::error('Error analyzing profile: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error analyzing profile: ' . $e->getMessage()
            ], 500);
        }
    }

    private function extractProfileData($text)
    {
        $prompt = "Extract the following information from this LinkedIn profile text in JSON format:
        1. headline
        2. summary
        3. experience (array of objects with title, company, duration, description)
        4. education (array of objects with institution, degree, duration)
        5. skills (array of objects with name and endorsements)
        6. certifications (array of objects with name, issuer, date)
        7. languages (array of objects with name and proficiency)
        8. volunteer_experience (array of objects with role, organization, duration, description)
        9. recommendations (array of objects with name, title, text)

        Profile text: " . $text;

        $response = $this->geminiService->generateContent($prompt);
        
        // Ensure we have a valid JSON response
        $data = json_decode($response, true);
        
        // If JSON decoding fails or returns null, return an empty array with default structure
        if (!is_array($data)) {
            Log::warning('Failed to decode Gemini response: ' . $response);
            return [
                'headline' => '',
                'summary' => '',
                'experience' => [],
                'education' => [],
                'skills' => [],
                'certifications' => [],
                'languages' => [],
                'volunteer_experience' => [],
                'recommendations' => []
            ];
        }

        // Ensure all required fields exist with default values
        return array_merge([
            'headline' => '',
            'summary' => '',
            'experience' => [],
            'education' => [],
            'skills' => [],
            'certifications' => [],
            'languages' => [],
            'volunteer_experience' => [],
            'recommendations' => []
        ], $data);
    }

    protected function calculateScores($profileData)
    {
        $sections = [
            'headline' => [
                'weight' => 0.15,
                'criteria' => [
                    'keyword_optimization' => 0.3,
                    'clarity_and_impact' => 0.4,
                    'length_and_format' => 0.3
                ]
            ],
            'summary' => [
                'weight' => 0.20,
                'criteria' => [
                    'storytelling' => 0.25,
                    'achievement_focus' => 0.25,
                    'keyword_inclusion' => 0.2,
                    'call_to_action' => 0.15,
                    'readability' => 0.15
                ]
            ],
            'experience' => [
                'weight' => 0.25,
                'criteria' => [
                    'role_progression' => 0.3,
                    'achievement_metrics' => 0.3,
                    'keyword_relevance' => 0.2,
                    'description_quality' => 0.2
                ]
            ],
            'education' => [
                'weight' => 0.10,
                'criteria' => [
                    'relevance' => 0.4,
                    'completeness' => 0.3,
                    'achievements' => 0.3
                ]
            ],
            'skills' => [
                'weight' => 0.15,
                'criteria' => [
                    'relevance' => 0.4,
                    'endorsements' => 0.3,
                    'variety' => 0.3
                ]
            ],
            'additional' => [
                'weight' => 0.15,
                'criteria' => [
                    'certifications' => 0.3,
                    'volunteer_work' => 0.2,
                    'languages' => 0.2,
                    'recommendations' => 0.3
                ]
            ]
        ];

        $scores = [];
        $suggestions = [];
        $overall_score = 0;

        foreach ($sections as $section => $config) {
            $sectionScore = $this->calculateSectionScore($section, $profileData, $config['criteria']);
            $scores[$section] = [
                'score' => $sectionScore,
                'weight' => $config['weight']
            ];
            $overall_score += $sectionScore * $config['weight'];

            // Generate suggestions based on section score
            $sectionSuggestions = $this->generateSuggestions($section, $sectionScore, $profileData);
            if (!empty($sectionSuggestions)) {
                $suggestions[] = [
                    'section' => ucfirst(str_replace('_', ' ', $section)),
                    'score' => $sectionScore,
                    'suggestions' => $sectionSuggestions
                ];
            }
        }

        return [
            'overall_score' => round($overall_score),
            'sections' => $scores,
            'improvement_suggestions' => $suggestions
        ];
    }

    protected function calculateSectionScore($section, $profileData, $criteria)
    {
        $score = 0;
        
        switch ($section) {
            case 'headline':
                $score = $this->scoreHeadline($profileData['headline'] ?? '', $criteria);
                break;
            case 'summary':
                $score = $this->scoreSummary($profileData['summary'] ?? '', $criteria);
                break;
            case 'experience':
                $score = $this->scoreExperience($profileData['experience'] ?? [], $criteria);
                break;
            case 'education':
                $score = $this->scoreEducation($profileData['education'] ?? [], $criteria);
                break;
            case 'skills':
                $score = $this->scoreSkills($profileData['skills'] ?? [], $criteria);
                break;
            case 'additional':
                $score = $this->scoreAdditional($profileData, $criteria);
                break;
        }

        return round($score);
    }

    protected function generateSuggestions($section, $score, $profileData)
    {
        $suggestions = [];
        
        switch ($section) {
            case 'headline':
                if ($score < 80) {
                    $suggestions[] = [
                        'priority' => 'HIGH',
                        'message' => 'Add industry-specific keywords to your headline',
                        'impact' => 'Improves visibility in LinkedIn searches'
                    ];
                }
                if ($score < 70) {
                    $suggestions[] = [
                        'priority' => 'MEDIUM',
                        'message' => 'Make your headline more impactful by highlighting your value proposition',
                        'impact' => 'Increases profile engagement'
                    ];
                }
                break;
                
            case 'summary':
                if ($score < 80) {
                    $suggestions[] = [
                        'priority' => 'HIGH',
                        'message' => 'Include specific achievements with measurable results',
                        'impact' => 'Demonstrates concrete value to potential employers'
                    ];
                }
                if ($score < 70) {
                    $suggestions[] = [
                        'priority' => 'MEDIUM',
                        'message' => 'Add a clear call-to-action at the end of your summary',
                        'impact' => 'Encourages profile visitors to take action'
                    ];
                }
                break;
                
            // Add similar suggestion logic for other sections
        }
        
        return $suggestions;
    }

    protected function scoreHeadline($headline, $criteria)
    {
        if (empty($headline)) {
            return 0;
        }

        $score = 0;
        $words = str_word_count($headline);

        // Keyword optimization (30%)
        $keywordScore = $this->analyzeKeywords($headline);
        $score += $keywordScore * $criteria['keyword_optimization'];

        // Clarity and impact (40%)
        $clarityScore = min(100, max(0, 
            ($words >= 3 && $words <= 12 ? 100 : 70) +
            (strpos(strtolower($headline), '|') !== false ? 10 : 0) +
            (preg_match('/\d+/', $headline) ? 10 : 0)
        ));
        $score += $clarityScore * $criteria['clarity_and_impact'];

        // Length and format (30%)
        $lengthScore = min(100, max(0,
            ($words >= 5 && $words <= 10) ? 100 : 
            ($words < 5 ? $words * 20 : 
             max(0, 100 - ($words - 10) * 10))
        ));
        $score += $lengthScore * $criteria['length_and_format'];

        return $score;
    }

    protected function scoreSummary($summary, $criteria)
    {
        if (empty($summary)) {
            return 0;
        }

        $score = 0;
        $words = str_word_count($summary);

        // Storytelling (25%)
        $storytellingScore = min(100, max(0,
            ($words >= 100 ? 80 : $words * 0.8) +
            (preg_match('/\b(achieved|led|grew|improved|developed)\b/i', $summary) ? 20 : 0)
        ));
        $score += $storytellingScore * $criteria['storytelling'];

        // Achievement focus (25%)
        $achievementScore = min(100, max(0,
            (preg_match_all('/\d+%|\d+x|\$\d+|\d+ million/i', $summary) * 20) +
            (preg_match_all('/\b(increased|decreased|reduced|improved|achieved|won|awarded)\b/i', $summary) * 15)
        ));
        $score += $achievementScore * $criteria['achievement_focus'];

        // Keyword inclusion (20%)
        $keywordScore = $this->analyzeKeywords($summary);
        $score += $keywordScore * $criteria['keyword_inclusion'];

        // Call to action (15%)
        $ctaScore = min(100, max(0,
            (preg_match('/\b(contact|connect|reach out|email|call|visit|follow)\b/i', $summary) ? 100 : 0)
        ));
        $score += $ctaScore * $criteria['call_to_action'];

        // Readability (15%)
        $readabilityScore = min(100, max(0,
            ($words >= 200 && $words <= 500) ? 100 : (
                $words < 200 ? $words / 2 : 
                max(0, 100 - ($words - 500) / 10)
            )
        ));
        $score += $readabilityScore * $criteria['readability'];

        return $score;
    }

    protected function analyzeKeywords($text)
    {
        // Industry-specific keywords (customize based on user's industry)
        $industryKeywords = [
            'leadership', 'management', 'strategy', 'innovation',
            'development', 'analysis', 'optimization', 'growth',
            'technology', 'solutions', 'experience', 'professional'
        ];

        $score = 0;
        $text = strtolower($text);
        
        foreach ($industryKeywords as $keyword) {
            if (strpos($text, $keyword) !== false) {
                $score += 20;
            }
        }

        return min(100, $score);
    }

    private function scoreExperience($experience, $criteria)
    {
        $score = 0;
        $details = [
            'achievement_quantification' => ['score' => 0, 'max' => 30, 'feedback' => []],
            'responsibility_description' => ['score' => 0, 'max' => 25, 'feedback' => []],
            'keyword_density' => ['score' => 0, 'max' => 20, 'feedback' => []],
            'progression_logic' => ['score' => 0, 'max' => 25, 'feedback' => []]
        ];

        if (empty($experience)) {
            return ['score' => 0, 'details' => $details];
        }

        $positionScores = [];
        foreach ($experience as $position) {
            $description = $position['description'] ?? '';
            
            // Achievement Quantification (30 points)
            $achievementPatterns = '/\b(?:increased|improved|achieved|reduced|saved|grew|launched)\b.*?(?:\d+%|\$\d+|\d+ million)/i';
            preg_match_all($achievementPatterns, $description, $matches);
            $achievementCount = count($matches[0]);
            $positionScores[] = min(30, $achievementCount * 10);
            
            if ($achievementCount < 2) {
                $details['achievement_quantification']['feedback'][] = "Add more quantifiable achievements to position: " . ($position['title'] ?? 'Unknown');
            }

            // Responsibility Description (25 points)
            $responsibilityScore = 0;
            if (strlen($description) > 200) {
                $responsibilityScore += 15;
            }
            if (preg_match('/\b(?:managed|led|directed|coordinated|developed)\b/i', $description)) {
                $responsibilityScore += 10;
            }
            $positionScores[] = $responsibilityScore;
            
            if ($responsibilityScore < 20) {
                $details['responsibility_description']['feedback'][] = "Expand role description with leadership and impact details";
            }

            // Keyword Density (20 points)
            $keywords = ['developed', 'implemented', 'managed', 'designed', 'analyzed', 'created'];
            $keywordCount = 0;
            foreach ($keywords as $keyword) {
                if (stripos($description, $keyword) !== false) {
                    $keywordCount++;
                }
            }
            $positionScores[] = min(20, $keywordCount * 4);
            
            if ($keywordCount < 4) {
                $details['keyword_density']['feedback'][] = "Include more action verbs and technical terms";
            }
        }

        // Progression Logic (25 points)
        if (count($experience) >= 3) {
            $details['progression_logic']['score'] = 25;
        } elseif (count($experience) >= 2) {
            $details['progression_logic']['score'] = 15;
            $details['progression_logic']['feedback'][] = "Add more positions to show career progression";
        } else {
            $details['progression_logic']['feedback'][] = "Include additional work experience to demonstrate growth";
        }

        // Calculate average scores
        $totalScore = array_sum($positionScores) / count($experience);
        $details['achievement_quantification']['score'] = min(30, $totalScore * 0.3);
        $details['responsibility_description']['score'] = min(25, $totalScore * 0.25);
        $details['keyword_density']['score'] = min(20, $totalScore * 0.2);

        $totalScore = array_sum(array_column($details, 'score'));
        return ['score' => $totalScore, 'details' => $details];
    }

    private function scoreEducation($education, $criteria)
    {
        $score = 0;
        if (empty($education)) return $score;

        $count = count($education);
        if ($count >= 1) $score += 50;

        foreach ($education as $edu) {
            // Check for relevant coursework
            if (preg_match('/\b(?:coursework|courses|subjects)\b/i', $edu['description'] ?? '')) {
                $score += 25;
            }

            // Check for achievements
            if (preg_match('/\b(?:honors|awards|scholarship|dean\'s list)\b/i', $edu['description'] ?? '')) {
                $score += 25;
            }
        }

        return min($score, 100);
    }

    private function scoreSkills($skills, $criteria)
    {
        $score = 0;
        if (empty($skills)) return $score;

        $count = count($skills);
        if ($count >= 10) $score += 40;
        elseif ($count >= 5) $score += 30;
        elseif ($count >= 3) $score += 20;

        foreach ($skills as $skill) {
            // Check for endorsements
            if (($skill['endorsements'] ?? 0) > 0) {
                $score += 5;
            }

            // Check for relevant keywords
            if (preg_match('/\b(?:programming|development|management|leadership|communication)\b/i', $skill['name'] ?? '')) {
                $score += 5;
            }
        }

        return min($score, 100);
    }

    private function scoreAdditional($profileData, $criteria)
    {
        // Implementation of scoreAdditional method
        // This method should return a score based on the additional criteria
        return 0; // Placeholder return, actual implementation needed
    }

    private function generateImprovementSuggestions($scores)
    {
        $suggestions = [];
        
        foreach ($scores['sections'] as $section => $data) {
            $sectionSuggestions = [];
            $details = $data['details'];
            
            foreach ($details as $category => $info) {
                if (!empty($info['feedback'])) {
                    foreach ($info['feedback'] as $feedback) {
                        $priority = $this->calculatePriority($info['score'], $info['max'], $data['weight']);
                        $sectionSuggestions[] = [
                            'priority' => $priority,
                            'message' => $feedback,
                            'impact' => $this->getImpactMessage($category, $section)
                        ];
                    }
                }
            }
            
            if (!empty($sectionSuggestions)) {
                $suggestions[] = [
                    'section' => ucfirst(str_replace('_', ' ', $section)),
                    'score' => $data['score'],
                    'suggestions' => $sectionSuggestions
                ];
            }
        }

        // Sort suggestions by section weight and priority
        usort($suggestions, function($a, $b) {
            return $b['score'] - $a['score'];
        });

        return $suggestions;
    }

    private function calculatePriority($score, $maxScore, $sectionWeight)
    {
        $percentage = ($score / $maxScore) * 100;
        if ($percentage < 50 && $sectionWeight >= 0.15) {
            return 'HIGH';
        } elseif ($percentage < 70) {
            return 'MEDIUM';
        }
        return 'LOW';
    }

    private function getImpactMessage($category, $section)
    {
        $impacts = [
            'keyword_optimization' => 'Improves visibility in recruiter searches by up to 40%',
            'clarity_impact' => 'Increases profile views by up to 30%',
            'achievement_focus' => 'Makes your profile 2x more likely to be contacted',
            'storytelling' => 'Increases engagement with your profile by 25%',
            'call_to_action' => 'Doubles the likelihood of receiving connection requests'
        ];

        return $impacts[$category] ?? 'Improves overall profile effectiveness';
    }

    private function generateCompetitorAnalysis($profileData)
    {
        $analysis = [];

        // Content Quality
        $analysis['Content Quality'] = $this->analyzeContentQuality($profileData);

        // Profile Completeness
        $analysis['Profile Completeness'] = $this->analyzeProfileCompleteness($profileData);

        // Keyword Optimization
        $analysis['Keyword Optimization'] = $this->analyzeKeywordOptimization($profileData);

        // Engagement Potential
        $analysis['Engagement Potential'] = $this->analyzeEngagementPotential($profileData);

        // Industry Alignment
        $analysis['Industry Alignment'] = $this->analyzeIndustryAlignment($profileData);

        return $analysis;
    }

    private function analyzeContentQuality($profileData)
    {
        $quality = 'Good';
        $issues = [];

        if (empty($profileData['summary'])) {
            $issues[] = 'Missing professional summary';
        }

        if (empty($profileData['experience'])) {
            $issues[] = 'No work experience listed';
        }

        if (empty($profileData['skills'])) {
            $issues[] = 'No skills listed';
        }

        if (!empty($issues)) {
            $quality = 'Needs Improvement';
        }

        return $quality . (empty($issues) ? '' : ': ' . implode(', ', $issues));
    }

    private function analyzeProfileCompleteness($profileData)
    {
        $completeness = 0;
        $totalSections = 9; // Total number of profile sections
        $filledSections = 0;

        foreach ($profileData as $section => $data) {
            if (!empty($data)) {
                $filledSections++;
            }
        }

        $completeness = ($filledSections / $totalSections) * 100;

        return $completeness >= 80 ? 'Complete' : 'Incomplete: ' . round($completeness) . '% filled';
    }

    private function analyzeKeywordOptimization($profileData)
    {
        $keywords = [];
        $text = '';

        // Combine all text content
        $text .= $profileData['headline'] ?? '';
        $text .= ' ' . $profileData['summary'] ?? '';
        foreach ($profileData['experience'] ?? [] as $exp) {
            $text .= ' ' . ($exp['description'] ?? '');
        }

        // Count keyword occurrences
        $commonKeywords = ['leadership', 'management', 'development', 'strategy', 'innovation'];
        foreach ($commonKeywords as $keyword) {
            $count = substr_count(strtolower($text), $keyword);
            if ($count > 0) {
                $keywords[$keyword] = $count;
            }
        }

        return empty($keywords) ? 'Needs more industry keywords' : 'Good keyword usage: ' . implode(', ', array_keys($keywords));
    }

    private function analyzeEngagementPotential($profileData)
    {
        $potential = 'Moderate';
        $factors = [];

        if (!empty($profileData['summary']) && strlen($profileData['summary']) > 200) {
            $factors[] = 'Detailed professional summary';
        }

        if (count($profileData['experience'] ?? []) >= 3) {
            $factors[] = 'Comprehensive work history';
        }

        if (count($profileData['skills'] ?? []) >= 10) {
            $factors[] = 'Extensive skills list';
        }

        if (count($profileData['recommendations'] ?? []) >= 3) {
            $factors[] = 'Strong recommendations';
        }

        if (count($factors) >= 3) {
            $potential = 'High';
        }

        return $potential . ' engagement potential: ' . implode(', ', $factors);
    }

    private function analyzeIndustryAlignment($profileData)
    {
        $alignment = 'Good';
        $text = '';

        // Combine relevant text
        $text .= $profileData['headline'] ?? '';
        $text .= ' ' . $profileData['summary'] ?? '';
        foreach ($profileData['experience'] ?? [] as $exp) {
            $text .= ' ' . ($exp['description'] ?? '');
        }

        // Check for industry-specific terms
        $industryTerms = ['software', 'technology', 'development', 'engineering', 'digital'];
        $matches = 0;
        foreach ($industryTerms as $term) {
            if (stripos($text, $term) !== false) {
                $matches++;
            }
        }

        if ($matches < 2) {
            $alignment = 'Needs Improvement: Add more industry-specific terminology';
        }

        return $alignment;
    }
} 