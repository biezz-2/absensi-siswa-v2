<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
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
}