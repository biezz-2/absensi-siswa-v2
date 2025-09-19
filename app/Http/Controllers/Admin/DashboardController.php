<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AbsenceSubmission;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Services\GeminiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

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

        $studentsWithMostAbsences = Student::withCount(['attendances' => function ($query) {
            $query->where('status', 'absent');
        }])->orderBy('attendances_count', 'desc')->take(5)->with('user')->get();

        $insights = $this->geminiService->getStudentPerformanceInsights($studentsWithMostAbsences->toArray());

        return view('admin.dashboard', compact('stats', 'weeklyTrend', 'insights'));
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

    public function handlePrompt(Request $request)
    {
        $request->validate(['prompt' => 'required|string']);
        $prompt = $request->input('prompt');

        $interpreted = $this->geminiService->interpretPrompt($prompt);
        Log::info('Interpreted prompt', ['interpreted' => $interpreted]);

        if (!$interpreted || !isset($interpreted['intent'])) {
            return back()->with('error', 'Could not interpret the prompt.');
        }

        switch ($interpreted['intent']) {
            case 'add_teacher':
                return $this->addTeacher($interpreted['entities']);
            default:
                return back()->with('error', 'Intent not supported yet.');
        }
    }

    private function addTeacher(array $entities)
    {
        try {
            DB::beginTransaction();

            $teacherName = $entities['teacher_name'];
            $subjectName = $entities['subject_name'];
            $classNames = $entities['class_names'];

            // Create User and Teacher
            $user = User::create([
                'name' => $teacherName,
                'email' => strtolower(str_replace(' ', '.', $teacherName)) . '@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // Assuming 2 is the teacher role
            ]);

            $teacher = Teacher::create([
                'user_id' => $user->id,
                'nip' => fake()->unique()->numerify('##################'),
                'gender' => 'male',
            ]);

            // Find or create Subject
            $subject = Subject::firstOrCreate(['name' => $subjectName]);

            // Find or create Classes and assign subject and teacher
            foreach ($classNames as $className) {
                $schoolClass = SchoolClass::firstOrCreate(['name' => $className]);
                $schoolClass->subjects()->attach($subject->id, ['teacher_id' => $teacher->id]);
            }

            DB::commit();

            return back()->with('success', 'Teacher, subject, and classes have been created and assigned successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to add teacher from prompt', ['error' => $e->getMessage()]);
            return back()->with('error', 'An error occurred while processing your request.');
        }
    }
}
