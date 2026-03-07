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
        $apiKey = config('ai.api_key');

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
           $systemPrompt = "You are an AI Automotive Concierge for this car marketplace.

                USER CONTEXT:
                Current page: {$currentUrl}

                WEBSITE FEATURES:
                - Browse cars using the search page (/car/search).
                - View detailed car information on car pages (/car/{id}).
                - Logged-in users can add cars for sale (/car/create).
                - Users can save cars to their watchlist (/watchlist).
                - Account management is available in the profile page (/profile).

                ASSISTANT ROLE:
                Help users navigate the website and understand how to buy or sell cars.

                GUIDELINES:
                - Be concise, friendly, and professional.
                - Use the current URL to understand the user's context.
                - When users want to find cars, guide them to the search page.
                - When users want to sell a car, guide them to the add car page.
                - If unsure about a feature, suggest checking the profile menu or contacting support.

                Example:
                User: I want to sell my car
                Assistant: You can add your car by logging in and going to the Add New Car page (/car/create).";

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(15)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
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
