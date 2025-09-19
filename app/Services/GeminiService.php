<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    public function analyzeAbsenceReason(string $reason): ?string
    {
        if (!$this->apiKey) {
            Log::error('GEMINI_API_KEY is not set.');
            return null;
        }

        $prompt = "Analyze the following absence reason and categorize it into one of these categories: Sakit, Izin Keluarga, Acara Sekolah, Lainnya. Return only the category name. Reason: \"{$reason}\"";

        try {
            $response = Http::timeout(15)->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->failed()) {
                Log::error('Gemini API request failed', ['response' => $response->body()]);
                return null;
            }

            return trim($response->json('candidates.0.content.parts.0.text'));
        } catch (\Exception $e) {
            Log::error('Exception calling Gemini API', ['message' => $e->getMessage()]);
            return null;
        }
    }

    public function summarizeAbsenceSubmissions(array $submissions): ?string
    {
        if (!$this->apiKey) {
            Log::error('GEMINI_API_KEY is not set.');
            return null;
        }

        $submissionData = array_map(function ($submission) {
            return "- {$submission['reason']} (Category: {$submission['category']})";
        }, $submissions);

        $prompt = "Summarize the following absence submissions in one sentence. Submissions:\n" . implode("\n", $submissionData);

        try {
            $response = Http::timeout(30)->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->failed()) {
                Log::error('Gemini API request failed', ['response' => $response->body()]);
                return null;
            }

            return trim($response->json('candidates.0.content.parts.0.text'));
        } catch (\Exception $e) {
            Log::error('Exception calling Gemini API', ['message' => $e->getMessage()]);
            return null;
        }
    }

    public function getStudentPerformanceInsights(array $students): ?string
    {
        if (!$this->apiKey) {
            Log::error('GEMINI_API_KEY is not set.');
            return null;
        }

        $studentData = array_map(function ($student) {
            return "- {$student['user']['name']}: " . $student['attendances_count'] . " absences";
        }, $students);

        $prompt = "Analyze the following student attendance data and provide insights in one or two sentences. Data:\n" . implode("\n", $studentData);

        try {
            $response = Http::timeout(30)->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [['parts' => [['text' => $prompt]]]]
            ]);

            if ($response->failed()) {
                Log::error('Gemini API request failed', ['response' => $response->body()]);
                return null;
            }

            return trim($response->json('candidates.0.content.parts.0.text'));
        } catch (\Exception $e) {
            Log::error('Exception calling Gemini API', ['message' => $e->getMessage()]);
            return null;
        }
    }

    public function interpretPrompt(string $prompt): ?array
    {
        if (!$this->apiKey) {
            Log::error('GEMINI_API_KEY is not set.');
            return null;
        }

        $systemPrompt = "You are an intelligent assistant for a school management system. Your task is to interpret user prompts and convert them into structured JSON data. The user will provide a prompt in Indonesian. You need to identify the user's intent and extract the relevant entities.\n\n        Possible intents are: 'add_teacher', 'add_student', 'add_class', 'add_subject', 'assign_subject_to_class'.\n\n        For the 'add_teacher' intent, the required entities are: 'teacher_name', 'subject_name', and 'class_names' (an array of strings).\n\n        Example prompt: 'tambahkan guru baru bernama syarif yang mengajar mata pembelajaran informatika kelas 10 A sampai kelas 10 C'\n        Example JSON output:\n        {\n            \"intent\": \"add_teacher\",\n            \"entities\": {\n                \"teacher_name\": \"syarif\",\n                \"subject_name\": \"informatika\",\n                \"class_names\": [\"10 A\", \"10 B\", \"10 C\"]\n            }\n        }\n\n        Now, interpret the following prompt:\n        \"{$prompt}\"";

        try {
            $response = Http::timeout(30)->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [['parts' => [['text' => $systemPrompt]]]],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                ]
            ]);

            if ($response->failed()) {
                Log::error('Gemini API request failed', ['response' => $response->body()]);
                return null;
            }

            return json_decode($response->json('candidates.0.content.parts.0.text'), true);
        } catch (\Exception $e) {
            Log::error('Exception calling Gemini API', ['message' => $e->getMessage()]);
            return null;
        }
    }
}
