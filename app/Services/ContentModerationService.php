<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ContentModerationService
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('CONTENT_MODERATION_API_URL'); 
        $this->apiKey = env('CONTENT_MODERATION_API_KEY'); 
    }

    public function moderateContent($content)
    {
        $response = Http::withOptions([
            'verify' => false, 
        ])->withHeaders([
            'X-API-KEY' => $this->apiKey,
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'language' => 'en',
            'text' => $content,
        ]);

       
        if ($response->failed()) {
            return [
                'status' => 'rejected',
                'message' => 'İçerik denetim servisi ile bağlantı kurulamadı.'
            ];
        }


        $result = $response->json('result');
        $label = $result['label'] ?? null;
        $score = (float)($result['score'] ?? 0);

      
        if ($label === 'NEGATIVE' && $score >= 0.8) {
            return [
                'status' => 'rejected',
                'message' => 'İçerik uygunsuz bulundu: İçeriğin çok olumsuz.'
            ];
        }

        return [
            'status' => 'approved',
            'message' => 'İçerik uygun.'
        ];
    }
}
