<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $studentId = Auth::user()->student->id;
        $attendances = \App\Models\Attendance::where('student_id', $studentId)
            ->with(['subject', 'teacher.user'])
            ->latest('date')
            ->paginate(15);

        return view('student.attendance.index', compact('attendances'));
    }

    public function scan(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $studentId = Auth::user()->student->id;

        Attendance::updateOrCreate(
            [
                'student_id' => $studentId,
                'date' => Carbon::today(),
                'subject_id' => $request->subject_id,
            ],
            [
                'school_class_id' => $request->school_class_id,
                'teacher_id' => $request->teacher_id,
                'status' => 'present',
            ]
        );

        return redirect()->route('student.dashboard')->with('success', 'Attendance marked successfully!');
    }
}
