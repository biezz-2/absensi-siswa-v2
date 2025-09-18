<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\AbsenceSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenceSubmissionController extends Controller
{
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

        AbsenceSubmission::create([
            'student_id' => Auth::user()->student->id,
            'reason' => $request->reason,
            'document_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Absence submission sent successfully.');
    }
}