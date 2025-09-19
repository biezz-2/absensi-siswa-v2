<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Exports\TeacherAttendanceExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use chillerlan\QRCode\QRCode;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = Auth::user()->teacher->id;

        $schedules = DB::table('class_subject')
            ->join('classes', 'class_subject.school_class_id', '=', 'classes.id')
            ->join('subjects', 'class_subject.subject_id', '=', 'subjects.id')
            ->where('class_subject.teacher_id', $teacherId)
            ->select('classes.id as class_id', 'classes.name as class_name', 'subjects.id as subject_id', 'subjects.name as subject_name')
            ->get();

        $attendances = null;
        if ($request->has('class_id') && $request->has('subject_id') && $request->has('date')) {
            $attendances = Attendance::where('school_class_id', $request->class_id)
                ->where('subject_id', $request->subject_id)
                ->where('date', $request->date)
                ->with('student.user')
                ->get();
        }

        return view('teacher.attendance.index', compact('schedules', 'attendances'));
    }

    public function generateQrCode($school_class_id, $subject_id)
    {
        $url = URL::temporarySignedRoute(
            'student.attendance.scan',
            now()->addMinutes(5),
            [
                'school_class_id' => $school_class_id,
                'subject_id' => $subject_id,
                'teacher_id' => Auth::user()->teacher->id,
            ]
        );

        $qrCode = (new QRCode)->render($url);

        return view('teacher.attendance.qrcode', compact('qrCode'));
    }

    public function edit(Attendance $attendance)
    {
        return view('teacher.attendance.edit', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status' => ['required', 'in:present,sick,permit,absent'],
        ]);

        $attendance->update(['status' => $request->status]);

        return redirect()->route('teacher.attendance.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return back()->with('success', 'Attendance record deleted successfully.');
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

    public function export(Request $request)
    {
        return Excel::download(new TeacherAttendanceExport($request->all()), 'attendance.xlsx');
    }
}
