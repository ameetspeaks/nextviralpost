<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Log;

class ProfilePdfProcessor
{
    protected $parser;

    public function __construct()
    {
        $this->parser = new Parser();
    }

    public function extractText($pdfPath)
    {
        try {
            $pdf = $this->parser->parseFile($pdfPath);
            return $pdf->getText();
        } catch (\Exception $e) {
            Log::error('PDF Processing Error: ' . $e->getMessage());
            throw new \Exception('Failed to process PDF: ' . $e->getMessage());
        }
    }

    public function identifySections($text)
    {
        $sections = [];
        
        // Common LinkedIn section headers
        $sectionPatterns = [
            'headline' => '/^(?:Professional\s+Headline|Title):\s*(.*?)(?=\n|$)/im',
            'summary' => '/^(?:Summary|About):\s*([\s\S]*?)(?=\n\s*\n|\Z)/im',
            'experience' => '/^(?:Experience|Work\s+Experience):\s*([\s\S]*?)(?=\n\s*\n|\Z)/im',
            'education' => '/^(?:Education):\s*([\s\S]*?)(?=\n\s*\n|\Z)/im',
            'skills' => '/^(?:Skills|Expertise):\s*([\s\S]*?)(?=\n\s*\n|\Z)/im'
        ];

        foreach ($sectionPatterns as $section => $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                $sections[$section] = trim($matches[1]);
            } else {
                $sections[$section] = '';
            }
        }

        return $sections;
    }
} 