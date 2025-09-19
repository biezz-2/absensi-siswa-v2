<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $studentId = Auth::user()->student->id;
        $today = Carbon::today();

        // 1. Today's Schedule
        $schedules = DB::table('class_subject')
            ->join('subjects', 'class_subject.subject_id', '=', 'subjects.id')
            ->where('class_subject.school_class_id', Auth::user()->student->school_class_id)
            ->select('subjects.name as subject_name')
            ->get();

        // 2. Attendance Summary
        $totalSubjects = $schedules->count();
        $presentToday = Attendance::where('date', $today)
            ->where('student_id', $studentId)
            ->where('status', 'present')
            ->count();

        $attendanceSummary = [
            'total_subjects' => $totalSubjects,
            'present' => $presentToday,
            'absent' => $totalSubjects - $presentToday,
            'percentage' => $totalSubjects > 0 ? round(($presentToday / $totalSubjects) * 100) : 0,
        ];

        // 3. Recent Absences
        $recentAbsences = Attendance::where('student_id', $studentId)
            ->where('status', '!=', 'present')
            ->with('subject')
            ->latest('date')
            ->take(5)
            ->get();

        return view('student.dashboard', compact('schedules', 'attendanceSummary', 'recentAbsences'));
    }
}