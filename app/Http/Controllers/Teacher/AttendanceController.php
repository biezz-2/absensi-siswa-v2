<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $teacherId = Auth::user()->teacher->id;

        $schedules = DB::table('class_subject')
            ->join('classes', 'class_subject.school_class_id', '=', 'classes.id')
            ->join('subjects', 'class_subject.subject_id', '=', 'subjects.id')
            ->where('class_subject.teacher_id', $teacherId)
            ->select('classes.id as class_id', 'classes.name as class_name', 'subjects.id as subject_id', 'subjects.name as subject_name')
            ->get();

        return view('teacher.attendance.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_class_id' => ['required', 'exists:classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'date' => ['required', 'date'],
            'students' => ['required', 'array'],
        ]);

        $teacherId = Auth::user()->teacher->id;

        foreach ($request->students as $studentData) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentData['student_id'],
                    'date' => $request->date,
                    'subject_id' => $request->subject_id,
                ],
                [
                    'school_class_id' => $request->school_class_id,
                    'teacher_id' => $teacherId,
                    'status' => $studentData['status'],
                ]
            );
        }

        return back()->with('success', 'Attendance saved successfully!');
    }
}