<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['student.user', 'subject', 'class', 'teacher.user']);

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('class_id')) {
            $query->where('school_class_id', $request->class_id);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $attendances = $query->latest('date')->paginate(20)->withQueryString();

        $classes = SchoolClass::all();
        $students = Student::with('user')->get();

        return view('admin.attendance.index', compact('attendances', 'classes', 'students'));
    }

    public function export(Request $request)
    {
        return Excel::download(new AttendanceExport($request->all()), 'attendance.xlsx');
    }
}