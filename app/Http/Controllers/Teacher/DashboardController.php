<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AbsenceSubmission;
use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherId = Auth::user()->teacher->id;
        $today = Carbon::today();

        // 1. Today's Schedule
        $schedules = DB::table('class_subject')
            ->join('classes', 'class_subject.school_class_id', '=', 'classes.id')
            ->join('subjects', 'class_subject.subject_id', '=', 'subjects.id')
            ->where('class_subject.teacher_id', $teacherId)
            ->select('classes.name as class_name', 'subjects.name as subject_name', 'classes.id as class_id', 'subjects.id as subject_id')
            ->get();

        // 2. Attendance Summary
        $totalStudents = DB::table('class_subject')
            ->join('students', 'class_subject.school_class_id', '=', 'students.school_class_id')
            ->where('class_subject.teacher_id', $teacherId)
            ->distinct('students.id')
            ->count();

        $presentToday = Attendance::where('date', $today)
            ->where('teacher_id', $teacherId)
            ->where('status', 'present')
            ->distinct('student_id')
            ->count();

        $attendanceSummary = [
            'total_students' => $totalStudents,
            'present' => $presentToday,
            'absent' => $totalStudents - $presentToday,
            'percentage' => $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100) : 0,
        ];

        // 3. Weekly Attendance Trend
        $weeklyTrend = $this->getWeeklyAttendanceTrend($teacherId, $totalStudents);

        // 4. Recent Absence Submissions
        $recentSubmissions = AbsenceSubmission::whereHas('student.schoolClass.subjects', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })
        ->with('student.user')
        ->latest()
        ->take(5)
        ->get();

        // 5. Daily Attendance Chart
        $dailyAttendanceChart = $this->getDailyAttendanceChart($teacherId);

        // 6. Teacher Stats
        $teacherStats = [
            'total_classes' => $schedules->pluck('class_id')->unique()->count(),
            'total_subjects' => $schedules->pluck('subject_id')->unique()->count(),
            'total_students' => $totalStudents,
        ];

        // 7. Student Performance
        $studentPerformance = $this->getStudentPerformance($teacherId);

        return view('teacher.dashboard', compact(
            'schedules', 
            'attendanceSummary', 
            'weeklyTrend', 
            'recentSubmissions', 
            'dailyAttendanceChart', 
            'teacherStats',
            'studentPerformance'
        ));
    }

    private function getWeeklyAttendanceTrend($teacherId, $totalStudents)
    {
        if ($totalStudents == 0) {
            return ['labels' => [], 'data' => []];
        }

        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(6);

        $attendances = Attendance::where('teacher_id', $teacherId)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('status', 'present')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get([
                DB::raw('DATE(date) as date'),
                DB::raw('COUNT(DISTINCT student_id) as present_count')
            ])
            ->keyBy('date');

        $trendData = [];
        $trendLabels = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateString = $date->format('Y-m-d');
            $trendLabels[] = $date->format('D, M j');

            if (isset($attendances[$dateString])) {
                $percentage = round(($attendances[$dateString]->present_count / $totalStudents) * 100);
                $trendData[] = $percentage;
            } else {
                $trendData[] = 0;
            }
        }

        return [
            'labels' => $trendLabels,
            'data' => $trendData,
        ];
    }

    private function getDailyAttendanceChart($teacherId)
    {
        $statuses = ['present', 'sick', 'permit', 'absent'];
        $data = [];

        foreach ($statuses as $status) {
            $data[] = Attendance::where('teacher_id', $teacherId)
                ->where('date', Carbon::today())
                ->where('status', $status)
                ->count();
        }

        return [
            'labels' => array_map('ucfirst', $statuses),
            'data' => $data,
        ];
    }

    private function getStudentPerformance($teacherId)
    {
        $students = Student::whereHas('schoolClass.subjects', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })
        ->with(['user', 'attendances']) // Eager load attendances
        ->get();

        $mostAbsences = $students->sortByDesc(function ($student) {
            return $student->attendances->where('status', 'absent')->count();
        })->take(5);

        $perfectAttendance = $students->filter(function ($student) {
            return $student->attendances->where('status', '!= ', 'present')->count() == 0;
        })->take(5);

        return [
            'most_absences' => $mostAbsences,
            'perfect_attendance' => $perfectAttendance,
        ];
    }
}
