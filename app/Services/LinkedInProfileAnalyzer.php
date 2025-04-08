<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class LinkedInProfileAnalyzer
{
    protected $extractor;
    protected $sectionWeights = [
        "headline" => 0.15,
        "summary" => 0.20,
        "experience" => 0.25,
        "education" => 0.10,
        "skills" => 0.15,
        "other" => 0.15
    ];

    public function __construct(PDFExtractor $extractor)
    {
        $this->extractor = $extractor;
    }

    public function analyzeProfile($pdfPath)
    {
        try {
            Log::info('Starting profile analysis', ['pdf_path' => $pdfPath]);

            // Extract text with multiple fallback methods
            $text = $this->extractor->extractText($pdfPath);
            if (empty($text)) {
                throw new \Exception('Failed to extract text from PDF');
            }

            // Extract text by page to maintain structure
            $textByPage = $this->extractor->extractTextByPage($pdfPath);
            
            // Detect font sizes to identify headers
            $fontSizes = $this->extractor->detectFontSizes($pdfPath);

            // Identify sections with improved structure detection
            $sections = $this->identifySections($text, $textByPage, $fontSizes);
            
            // Analyze each section
            $results = [
                "section_scores" => [],
                "recommendations" => [],
                "overall_score" => 0
            ];
            
            $weightedSum = 0;
            foreach ($sections as $section => $content) {
                $method = "score" . ucfirst($section);
                if (method_exists($this, $method)) {
                    list($score, $recommendations) = $this->$method($content);
                    
                    $results["section_scores"][$section] = $score;
                    $results["recommendations"][$section] = $recommendations;
                    
                    $weight = $this->sectionWeights[$section] ?? 0;
                    $weightedSum += $score * $weight;
                }
            }
            
            $results["overall_score"] = round($weightedSum);
            
            Log::info('Profile analysis completed', ['results' => $results]);
            return $results;

        } catch (\Exception $e) {
            Log::error('Profile analysis failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    protected function identifySections($text, $textByPage, $fontSizes)
    {
        $sections = [];
        
        // Enhanced section patterns with font size consideration
        $sectionPatterns = [
            "headline" => '/(?i)(professional\s+headline|title|position)[\s:]+([^\n]+)/',
            "summary" => '/(?i)(summary|about|profile)[\s:]+([^\n]+(?:\n(?!Education|Experience|Skills)[^\n]+)*)/',
            "experience" => '/(?i)(experience|work\s+experience|employment)[\s:]+([^\n]+(?:\n(?!Education|Skills|Summary)[^\n]+)*)/',
            "education" => '/(?i)(education|academic|studies)[\s:]+([^\n]+(?:\n(?!Experience|Skills|Summary)[^\n]+)*)/',
            "skills" => '/(?i)(skills|expertise|competencies)[\s:]+([^\n]+(?:\n(?!Experience|Education|Summary)[^\n]+)*)/',
            "certifications" => '/(?i)(certifications|certificates|qualifications)[\s:]+([^\n]+(?:\n(?!Experience|Education|Skills)[^\n]+)*)/',
            "languages" => '/(?i)(languages|language\s+proficiency)[\s:]+([^\n]+(?:\n(?!Experience|Education|Skills)[^\n]+)*)/'
        ];
        
        foreach ($sectionPatterns as $section => $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                $sections[$section] = trim($matches[2]);
            } else {
                $sections[$section] = '';
            }
        }
        
        return $sections;
    }

    protected function scoreHeadline($content)
    {
        $score = 0;
        $recommendations = [];
        
        // Length check
        $length = strlen($content);
        if ($length >= 50 && $length <= 120) {
            $score += 25;
        } else {
            if ($length < 50) {
                $recommendations[] = "Your headline is too short. Add more relevant keywords to reach 50-120 characters.";
                $score += 10;
            } else {
                $recommendations[] = "Your headline exceeds the optimal length. Consider making it more concise.";
                $score += 15;
            }
        }
        
        // Job title check
        $jobTitles = ["manager", "developer", "engineer", "director", "specialist", "analyst", "consultant"];
        $hasJobTitle = false;
        foreach ($jobTitles as $title) {
            if (stripos($content, $title) !== false) {
                $hasJobTitle = true;
                break;
            }
        }
        if ($hasJobTitle) {
            $score += 25;
        } else {
            $recommendations[] = "Include your specific job title or role for better visibility.";
        }
        
        // Industry keywords check
        $industryKeywords = ["software", "marketing", "sales", "finance", "healthcare", "data", "design"];
        $keywordCount = 0;
        foreach ($industryKeywords as $keyword) {
            if (stripos($content, $keyword) !== false) {
                $keywordCount++;
            }
        }
        if ($keywordCount >= 2) {
            $score += 25;
        } else {
            $recommendations[] = "Add industry-specific keywords relevant to your field.";
        }
        
        // Value proposition check
        $impactTerms = ["expert in", "specialist in", "focused on", "helping", "driving"];
        $hasValueProp = false;
        foreach ($impactTerms as $term) {
            if (stripos($content, $term) !== false) {
                $hasValueProp = true;
                break;
            }
        }
        if ($hasValueProp) {
            $score += 25;
        } else {
            $recommendations[] = "Include a value proposition that differentiates you from others.";
        }
        
        return [$score, $recommendations];
    }

    protected function scoreSummary($content)
    {
        $score = 0;
        $recommendations = [];
        
        // Length check
        $length = strlen($content);
        if ($length >= 1500 && $length <= 2000) {
            $score += 20;
        } elseif ($length >= 1000 && $length < 1500) {
            $score += 15;
            $recommendations[] = "Your summary is slightly short. Consider expanding to 1500-2000 characters.";
        } elseif ($length < 1000) {
            $score += 5;
            $recommendations[] = "Your summary is too brief. Aim for 1500-2000 characters for better impact.";
        } else {
            $score += 10;
            $recommendations[] = "Your summary exceeds the optimal length. Consider making it more concise.";
        }
        
        // Paragraph structure check
        $paragraphs = array_filter(explode("\n", $content), function($p) { return trim($p) !== ''; });
        if (count($paragraphs) >= 3) {
            $score += 20;
        } else {
            $recommendations[] = "Structure your summary with at least 3 paragraphs for better readability.";
        }
        
        // Achievement check
        $achievementTerms = ["increased", "achieved", "led", "improved", "reduced", "delivered", "created"];
        $achievementCount = 0;
        foreach ($achievementTerms as $term) {
            if (stripos($content, $term) !== false) {
                $achievementCount++;
            }
        }
        if ($achievementCount >= 3) {
            $score += 30;
        } elseif ($achievementCount >= 1) {
            $score += 15;
            $recommendations[] = "Include more quantifiable achievements in your summary.";
        } else {
            $recommendations[] = "Add specific achievements with metrics to your summary.";
        }
        
        // Call to action check
        $ctaTerms = ["contact", "reach out", "connect", "email", "message", "call"];
        $hasCTA = false;
        foreach ($ctaTerms as $term) {
            if (stripos($content, $term) !== false) {
                $hasCTA = true;
                break;
            }
        }
        if ($hasCTA) {
            $score += 30;
        } else {
            $recommendations[] = "Add a call to action at the end of your summary.";
        }
        
        return [$score, $recommendations];
    }

    protected function scoreExperience($content)
    {
        $score = 0;
        $recommendations = [];
        
        // Position count check
        $positionIndicators = ["title:", "role:", "position:"];
        $positionCount = 0;
        foreach ($positionIndicators as $indicator) {
            if (stripos($content, $indicator) !== false) {
                $positionCount++;
            }
        }
        if ($positionCount >= 3) {
            $score += 15;
        } elseif ($positionCount >= 1) {
            $score += 10;
        } else {
            $recommendations[] = "Ensure each position has a clear title and role description.";
        }
        
        // Duration check
        $durationPatterns = ['/\d+\s+years?/', '/\d+\s+months?/', '/present/', '/current/'];
        $hasDurations = false;
        foreach ($durationPatterns as $pattern) {
            if (preg_match($pattern, strtolower($content))) {
                $hasDurations = true;
                break;
            }
        }
        if ($hasDurations) {
            $score += 15;
        } else {
            $recommendations[] = "Include employment durations for all positions.";
        }
        
        // Bullet points check
        $bulletIndicators = ["-", "•", "*", "✓"];
        $hasBullets = false;
        foreach ($bulletIndicators as $indicator) {
            if (strpos($content, $indicator) !== false) {
                $hasBullets = true;
                break;
            }
        }
        if ($hasBullets) {
            $score += 20;
        } else {
            $recommendations[] = "Format your achievements using bullet points for better readability.";
        }
        
        // Metrics check
        $metricsPatterns = ['/\d+%/', '/\$\d+/', '/\d+\s+million/', '/\d+x/'];
        $metricsCount = 0;
        foreach ($metricsPatterns as $pattern) {
            $metricsCount += preg_match_all($pattern, $content);
        }
        if ($metricsCount >= 5) {
            $score += 25;
        } elseif ($metricsCount >= 2) {
            $score += 15;
        } else {
            $recommendations[] = "Include more quantifiable metrics to demonstrate your impact.";
        }
        
        // Action verbs check
        $actionVerbs = ["led", "managed", "created", "developed", "implemented", "designed", "launched"];
        $actionVerbCount = 0;
        foreach ($actionVerbs as $verb) {
            if (stripos($content, $verb) !== false) {
                $actionVerbCount++;
            }
        }
        if ($actionVerbCount >= 10) {
            $score += 25;
        } elseif ($actionVerbCount >= 5) {
            $score += 15;
        } else {
            $recommendations[] = "Use more strong action verbs to describe your accomplishments.";
        }
        
        return [$score, $recommendations];
    }

    protected function scoreSkills($content)
    {
        $score = 0;
        $recommendations = [];
        
        // Skills count check
        $skillsCount = substr_count($content, ',') + substr_count($content, ';') + substr_count($content, '•') + 1;
        if ($skillsCount >= 15) {
            $score += 40;
        } elseif ($skillsCount >= 10) {
            $score += 30;
        } elseif ($skillsCount >= 5) {
            $score += 20;
        } else {
            $recommendations[] = "List at least 15 relevant skills for better visibility.";
        }
        
        // Category check
        $categoryIndicators = ["technical skills", "soft skills", "industry knowledge", "tools"];
        $hasCategories = false;
        foreach ($categoryIndicators as $indicator) {
            if (stripos($content, $indicator) !== false) {
                $hasCategories = true;
                break;
            }
        }
        if ($hasCategories) {
            $score += 30;
        } else {
            $recommendations[] = "Organize your skills into categories for better readability.";
        }
        
        // Trending skills check
        $trendingSkills = [
            "artificial intelligence", "machine learning", "blockchain", "data science",
            "cloud", "digital transformation", "devops", "cybersecurity"
        ];
        $trendingCount = 0;
        foreach ($trendingSkills as $skill) {
            if (stripos($content, $skill) !== false) {
                $trendingCount++;
            }
        }
        if ($trendingCount >= 3) {
            $score += 30;
        } elseif ($trendingCount >= 1) {
            $score += 15;
        } else {
            $recommendations[] = "Include some trending skills relevant to your industry.";
        }
        
        return [$score, $recommendations];
    }
} 