<?php
// app/Services/GeminiAIService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAIService
{
    protected string $apiKey;
    protected string $apiUrl;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->model = config('services.gemini.model', 'gemini-pro');
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    /**
     * Generate AI response based on customer feedback and rating
     */
    public function generateFeedbackResponse(string $customerName, string $feedback, int $rating): array
    {
        try {
            $prompt = $this->buildPrompt($customerName, $feedback, $rating);
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . "?key={$this->apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 500,
                ]
            ]);

            if ($response->successful()) {
                return $this->parseResponse($response->json());
            }

            Log::error('Gemini API Error: ' . $response->body());
            return $this->getFallbackResponse($rating);

        } catch (\Exception $e) {
            Log::error('Gemini Service Error: ' . $e->getMessage());
            return $this->getFallbackResponse($rating);
        }
    }

    /**
     * Build the prompt for Gemini
     */
    protected function buildPrompt(string $customerName, string $feedback, int $rating): string
    {
        $ratingEmojis = [
            1 => '😞',
            2 => '😕',
            3 => '😐',
            4 => '😊',
            5 => '🌟'
        ];

        $ratingLabels = [
            1 => 'very dissatisfied',
            2 => 'dissatisfied',
            3 => 'neutral',
            4 => 'satisfied',
            5 => 'extremely satisfied'
        ];

        return "You are a professional customer service representative for Moonzio. 
        A customer named {$customerName} has provided feedback with a rating of {$rating}/5 ({$ratingLabels[$rating]}) {$ratingEmojis[$rating]}.
        
        Customer Feedback: \"{$feedback}\"
        
        Please provide:
        1. A professional, empathetic response to this customer (max 100 words)
        2. 3-5 actionable suggestions to improve based on this feedback
        3. Sentiment analysis (positive, negative, or neutral)
        
        Format your response as:
        RESPONSE: [your response here]
        SUGGESTIONS: [suggestion1, suggestion2, suggestion3]
        SENTIMENT: [positive/negative/neutral]";
    }

    /**
     * Parse Gemini API response
     */
    protected function parseResponse(array $response): array
    {
        $text = $response['candidates'][0]['content']['parts'][0]['text'] ?? '';
        
        // Parse the response
        $responseText = '';
        $suggestions = [];
        $sentiment = 'neutral';

        // Extract RESPONSE
        if (preg_match('/RESPONSE:\s*(.*?)(?=SUGGESTIONS:|$)/s', $text, $matches)) {
            $responseText = trim($matches[1]);
        }

        // Extract SUGGESTIONS
        if (preg_match('/SUGGESTIONS:\s*(.*?)(?=SENTIMENT:|$)/s', $text, $matches)) {
            $suggestions = array_map('trim', explode(',', $matches[1]));
            $suggestions = array_filter($suggestions);
        }

        // Extract SENTIMENT
        if (preg_match('/SENTIMENT:\s*(\w+)/', $text, $matches)) {
            $sentiment = strtolower(trim($matches[1]));
        }

        // Clean up response text
        $responseText = str_replace(['RESPONSE:', 'SUGGESTIONS:', 'SENTIMENT:'], '', $responseText);
        $responseText = trim($responseText);

        return [
            'response' => $responseText ?: $this->getFallbackResponse(0)['response'],
            'suggestions' => !empty($suggestions) ? $suggestions : ['Thank you for your feedback. We will review and improve.'],
            'sentiment' => in_array($sentiment, ['positive', 'negative', 'neutral']) ? $sentiment : 'neutral',
            'raw_response' => $text
        ];
    }

    /**
     * Fallback response if API fails
     */
    protected function getFallbackResponse(int $rating): array
    {
        $responses = [
            5 => [
                'response' => "Thank you so much for your wonderful feedback! We're thrilled to know you had an excellent experience. Your kind words motivate us to continue providing the best service possible.",
                'suggestions' => ['Keep up the great work', 'Maintain service quality', 'Continue innovating'],
                'sentiment' => 'positive'
            ],
            4 => [
                'response' => "Thank you for your positive feedback! We appreciate your satisfaction and will continue to work hard to exceed your expectations.",
                'suggestions' => ['Focus on areas of improvement', 'Maintain good practices', 'Enhance user experience'],
                'sentiment' => 'positive'
            ],
            3 => [
                'response' => "Thank you for your honest feedback. We appreciate your input and will work on improving our services to better meet your needs.",
                'suggestions' => ['Identify improvement areas', 'Gather more detailed feedback', 'Implement quality checks'],
                'sentiment' => 'neutral'
            ],
            2 => [
                'response' => "We sincerely apologize that your experience didn't meet expectations. Please know that we take your feedback seriously and are committed to making things right.",
                'suggestions' => ['Immediate service review', 'Staff training', 'Process improvement'],
                'sentiment' => 'negative'
            ],
            1 => [
                'response' => "We are truly sorry to hear about your disappointing experience. Please accept our sincere apologies. We are investigating this matter thoroughly to ensure it doesn't happen again.",
                'suggestions' => ['Urgent review needed', 'Customer service overhaul', 'Policy updates'],
                'sentiment' => 'negative'
            ],
        ];

        return $responses[$rating] ?? $responses[3];
    }
}