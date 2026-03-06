<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        $message = $request->input('message');
        $url = $request->input('url');

        // Log the message and URL for later training or debugging
        Log::info("AI Chat Request: Message: {$message} | URL: {$url}");

        // Placeholder response
        
        $response = "This is a placeholder response until the AI API is configured. I see you are on: " . $url;

        return response()->json([
            'message' => $response,
            'status' => 'success'
        ]);
    }
}
