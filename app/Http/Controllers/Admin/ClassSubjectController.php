<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassSubjectController extends Controller
{
    public function index(SchoolClass $class)
    {
        $subjects = $class->subjects;
        foreach ($subjects as $subject) {
            $subject->teacher = Teacher::with('user')->find($subject->pivot->teacher_id);
        }
        return view('admin.classes.subjects', compact('class', 'subjects'));
    }

    public function create(SchoolClass $class)
    {
        $subjects = Subject::all();
        $teachers = Teacher::with('user')->get();
        return view('admin.classes.add_subject', compact('class', 'subjects', 'teachers'));
    }

    public function store(Request $request, SchoolClass $class)
    {
        $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
        ]);

        $class->subjects()->attach($request->subject_id, ['teacher_id' => $request->teacher_id]);

        return redirect()->route('admin.classes.subjects.index', $class)->with('success', 'Subject added to class successfully.');
    }

    public function edit(SchoolClass $class, Subject $subject)
    {
        $teachers = Teacher::with('user')->get();
        $currentTeacherId = DB::table('class_subject')
            ->where('school_class_id', $class->id)
            ->where('subject_id', $subject->id)
            ->value('teacher_id');

        return view('admin.classes.edit_subject', compact('class', 'subject', 'teachers', 'currentTeacherId'));
    }

    public function update(Request $request, SchoolClass $class, Subject $subject)
    {
        $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
        ]);

        $class->subjects()->updateExistingPivot($subject->id, ['teacher_id' => $request->teacher_id]);

        return redirect()->route('admin.classes.subjects.index', $class)->with('success', 'Teacher for subject updated successfully.');
    }

    public function destroy(SchoolClass $class, Subject $subject)
    {
        $class->subjects()->detach($subject->id);

        return redirect()->route('admin.classes.subjects.index', $class)->with('success', 'Subject removed from class successfully.');
    }
}