<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\AbsenceSubmission;
use Illuminate\Http\Request;

class AbsenceSubmissionController extends Controller
{
    public function index()
    {
        $submissions = AbsenceSubmission::with('student.user')->latest()->paginate(15);
        return view('admin.absence.index', compact('submissions'));
    }

    public function update(Request $request, AbsenceSubmission $absenceSubmission)
    {
        $request->validate(['status' => ['required', 'in:approved,rejected']]);

        $absenceSubmission->update(['status' => $request->status]);

        // Here you would typically trigger a notification to the student.

        return back()->with('success', 'Submission status updated successfully.');
    }
}