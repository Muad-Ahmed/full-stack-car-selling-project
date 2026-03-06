<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    /**
     * Handle the AI chat request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'url' => 'required|string',
        ]);

        $userMessage = $request->input('message');
        $currentUrl = $request->input('url');
        $apiKey = env('AI_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'message' => 'AI API Key is not configured in the .env file.',
                'status' => 'error'
            ], 500);
        }

        // Log the message and URL for later training or debugging
        Log::info("AI Chat Request: Message: {$userMessage} | URL: {$currentUrl}");

        try {
            // System prompt to give context to the AI
            $systemPrompt = "You are a helpful AI assistant for a car selling platform. 
            The user is currently browsing the page: {$currentUrl}. 
            Your goal is to help them with queries related to buying, selling, or browsing cars.
            Be concise, professional, and helpful. If you don't know something about specific cars on the site, 
            suggest they browse the search page or contact support.";

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt . "\n\nUser Question: " . $userMessage]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiResponse = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, I couldn\'t generate a response.';
                
                return response()->json([
                    'message' => $aiResponse,
                    'status' => 'success'
                ]);
            } else {
                Log::error("Gemini API Error: " . $response->body());
                return response()->json([
                    'message' => 'There was an error communicating with the AI service.',
                    'status' => 'error'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error("AI Controller Exception: " . $e->getMessage());
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'status' => 'error'
            ], 500);
        }
    }
}
