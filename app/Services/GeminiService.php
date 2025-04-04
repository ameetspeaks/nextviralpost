<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
use GuzzleHttp\Client;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->baseUrl = config('services.gemini.base_url');
        
        if (empty($this->apiKey)) {
            Log::error('Gemini API key is not configured');
            throw new Exception('Gemini API key is not configured. Please check your .env file for GEMINI_API_KEY');
        }
    }

    public function generateContent($prompt)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'verify' => false, // Disable SSL verification (not recommended for production)
                'timeout' => 30, // Increase timeout
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

            // Add API key to the URL
            $url = $this->baseUrl . '?key=' . $this->apiKey;

            Log::info('Making request to Gemini API', [
                'url' => $url,
                'prompt' => $prompt
            ]);

            $response = $client->post($url, [
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $prompt
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                Log::info('Successfully generated content from Gemini API', [
                    'content_length' => strlen($data['candidates'][0]['content']['parts'][0]['text'])
                ]);
                return $data['candidates'][0]['content']['parts'][0]['text'];
            }

            Log::error('Unexpected response format from Gemini API', [
                'response' => $data
            ]);
            throw new \Exception('Unexpected response format from Gemini API');
        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            throw new \Exception('Failed to generate content: ' . $e->getMessage());
        }
    }
} 