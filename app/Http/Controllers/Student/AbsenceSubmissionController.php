<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AbsenceSubmission;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceSubmissionController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function create()
    {
        return view('student.absence.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => ['required', 'string'],
            'document' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('documents', 'public');
        }

        $category = $this->geminiService->analyzeAbsenceReason($request->reason);

        AbsenceSubmission::create([
            'student_id' => Auth::user()->student->id,
            'reason' => $request->reason,
            'document_path' => $path,
            'status' => 'pending',
            'category' => $category,
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Absence submission sent successfully.');
    }
}
