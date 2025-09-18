<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolClassController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        // This automatically authorizes all resource methods against the SchoolClassPolicy
        $this->authorizeResource(SchoolClass::class, 'school_class');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = SchoolClass::with('homeroomTeacher.user');

        if ($user->role->name === 'guru') {
            // A teacher can only be a homeroom teacher for one class in this design
            $query->where('teacher_id', $user->teacher->id);
        }

        $classes = $query->latest()->paginate(10);

        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = \App\Models\Teacher::with('user')->get();
        return view('classes.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        SchoolClass::create($request->all());

        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolClass $schoolClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolClass $schoolClass)
    {
        $teachers = \App\Models\Teacher::with('user')->get();
        return view('classes.edit', ['class' => $schoolClass, 'teachers' => $teachers]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        $schoolClass->update($request->all());

        $route = Auth::user()->role->name === 'admin' ? 'admin.classes.index' : 'teacher.classes.index';

        return redirect()->route($route)->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully.');
    }
}
