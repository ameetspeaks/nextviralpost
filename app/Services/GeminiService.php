<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
        
        if (empty($this->apiKey)) {
            Log::error('Gemini API key is not configured');
            throw new Exception('Gemini API key is not configured. Please check your .env file for GEMINI_API_KEY');
        }
    }

    public function generateContent($prompt)
    {
        try {
            Log::info('Making Gemini API request', [
                'url' => $this->baseUrl,
                'prompt' => $prompt
            ]);

            $requestData = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ],
                'safetySettings' => [
                    [
                        'category' => 'HARM_CATEGORY_HARASSMENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_HATE_SPEECH',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ],
                    [
                        'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                        'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                    ]
                ]
            ];

            Log::info('Request payload', ['data' => $requestData]);

            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for development
                'timeout' => 30,
            ])->withHeaders([
                'Content-Type' => 'application/json',
                'x-goog-api-key' => $this->apiKey
            ])->post($this->baseUrl, $requestData);

            Log::info('Gemini API response', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }
                throw new Exception('Invalid response format from Gemini API');
            }

            $errorBody = $response->json();
            $errorMessage = $errorBody['error']['message'] ?? $response->body();
            
            // Check for specific API key errors
            if (strpos($errorMessage, 'API key') !== false || strpos($errorMessage, 'authentication') !== false) {
                Log::error('Gemini API key error', [
                    'error' => $errorMessage,
                    'api_key_length' => strlen($this->apiKey)
                ]);
                throw new Exception('Invalid API key. Please check your GEMINI_API_KEY in the .env file.');
            }

            throw new Exception('Gemini API Error: ' . $errorMessage);
        } catch (Exception $e) {
            Log::error('Gemini API Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw new Exception('Error generating content: ' . $e->getMessage());
        }
    }
} 