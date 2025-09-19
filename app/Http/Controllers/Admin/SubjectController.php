<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::latest()->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('admin.subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:subjects']]);
        Subject::create($validated);
        return redirect()->route('admin.subjects.index')->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject)
    {
        return view('admin.subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('subjects')->ignore($subject->id)]]);
        $subject->update($validated);
        return redirect()->route('admin.subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('admin.subjects.index')->with('success', 'Subject deleted successfully.');
    }
}