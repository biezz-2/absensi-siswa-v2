<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NicknameController extends Controller
{
    public function suggest(Request $request)
    {
        $request->validate(['full_name' => 'required|string|max:100']);

        $apiKey = config('services.gemini.api_key');
        if (!$apiKey) {
            Log::error('GEMINI_API_KEY is not set.');
            return response()->json(['error' => 'AI service is not configured.'], 503);
        }

        $fullName = $request->input('full_name');
        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$apiKey}";
        $prompt = "Berikan 3 saran nama panggilan yang unik dan singkat berdasarkan nama lengkap ini: \"{$fullName}\". Kembalikan hanya sebagai array JSON berisi string. Contoh: [\"Alex\", \"Lex\", \"Xander\"]";
        
        $payload = [
            'contents' => [['parts' => [['text' => $prompt]]]] ,
            'generationConfig' => [
                'responseMimeType' => "application/json",
            ]
        ];

        try {
            $response = Http::timeout(15)->post($apiUrl, $payload);

            if ($response->failed()) {
                Log::error('Gemini API request failed', ['response' => $response->body()]);
                return response()->json(['error' => 'Failed to get suggestions from AI service.'], 500);
            }

            // The Gemini API response for JSON can be complex. We need to extract the text part.
            $suggestions = $response->json('candidates.0.content.parts.0.text');

            return response()->json(['suggestions' => json_decode($suggestions)]);

        } catch (
Exception $e) {
            Log::error('Exception calling Gemini API', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }
}