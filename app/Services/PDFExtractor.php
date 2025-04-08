<?php

namespace App\Services;

use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PDFExtractor
{
    protected $parser;
    protected $fallbackMethods = [];

    public function __construct()
    {
        $this->parser = new Parser();
        $this->initializeFallbackMethods();
    }

    protected function initializeFallbackMethods()
    {
        // Add fallback methods in order of preference
        $this->fallbackMethods = [
            'extractWithSmalot',
            'extractWithPdfToText',
            'extractWithOcr'
        ];
    }

    public function extractText($pdfPath)
    {
        $text = null;
        $errors = [];

        foreach ($this->fallbackMethods as $method) {
            try {
                $text = $this->$method($pdfPath);
                if ($text && !empty(trim($text))) {
                    Log::info("Successfully extracted text using {$method}");
                    break;
                }
            } catch (\Exception $e) {
                $errors[$method] = $e->getMessage();
                Log::error("Failed to extract text using {$method}: " . $e->getMessage());
            }
        }

        if (!$text) {
            throw new \Exception("Failed to extract text from PDF. Errors: " . implode(', ', $errors));
        }

        return $this->normalizeText($text);
    }

    protected function extractWithSmalot($pdfPath)
    {
        $pdf = $this->parser->parseFile($pdfPath);
        return $pdf->getText();
    }

    protected function extractWithPdfToText($pdfPath)
    {
        if (!function_exists('shell_exec')) {
            throw new \Exception('shell_exec is not available');
        }

        $output = shell_exec("pdftotext {$pdfPath} -");
        if (!$output) {
            throw new \Exception('pdftotext command failed');
        }

        return $output;
    }

    protected function extractWithOcr($pdfPath)
    {
        // This is a placeholder for OCR implementation
        // You would need to install and configure Tesseract OCR
        throw new \Exception('OCR extraction not implemented');
    }

    protected function normalizeText($text)
    {
        // Normalize line endings
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        
        // Remove multiple spaces
        $text = preg_replace('/\s+/', ' ', $text);
        
        // Remove multiple newlines
        $text = preg_replace('/\n+/', "\n", $text);
        
        return trim($text);
    }

    public function extractTextByPage($pdfPath)
    {
        $pdf = $this->parser->parseFile($pdfPath);
        $pages = $pdf->getPages();
        $textByPage = [];

        foreach ($pages as $page) {
            $textByPage[] = $this->normalizeText($page->getText());
        }

        return $textByPage;
    }

    public function detectFontSizes($pdfPath)
    {
        $pdf = $this->parser->parseFile($pdfPath);
        $pages = $pdf->getPages();
        $fontSizes = [];

        foreach ($pages as $page) {
            $details = $page->getDetails();
            if (isset($details['Font'])) {
                $fontSizes[] = $details['Font'];
            }
        }

        return $fontSizes;
    }
} 