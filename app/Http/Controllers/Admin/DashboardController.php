<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\AbsenceSubmission;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'teachers' => Teacher::count(),
            'students' => Student::count(),
            'classes' => SchoolClass::count(),
            'pending_submissions' => AbsenceSubmission::where('status', 'pending')->count(),
        ];

        $totalStudents = $stats['students'];
        if ($totalStudents > 0) {
            $presentToday = Attendance::where('date', Carbon::today())->where('status', 'present')->distinct('student_id')->count();
            $stats['attendance_percentage'] = round(($presentToday / $totalStudents) * 100);
        } else {
            $stats['attendance_percentage'] = 0;
        }

        $weeklyTrend = $this->getWeeklyAttendanceTrend($totalStudents);

        return view('admin.dashboard', compact('stats', 'weeklyTrend'));
    }

    private function getWeeklyAttendanceTrend($totalStudents)
    {
        if ($totalStudents == 0) {
            return ['labels' => [], 'data' => []];
        }

        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(6);

        $attendances = Attendance::whereBetween('date', [$startDate, $endDate])
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
}
