<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpenAIController extends Controller
{
    public function generateText(Request $request)
    {
        $apiKey = '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';
        $baseUrl = 'https://api.openai.com/v1/chat/completions';

        $data = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                ["role" => "user", "content" => "hey"]
            ],
            "temperature" => 0.7,
            "max_tokens" => 1000
            
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post($baseUrl, $data);

        // You can then access the response data as needed, for example:
        $responseData = $response->json();
        echo "<pre>";
        print_r($responseData);
        dd();
    }
}
