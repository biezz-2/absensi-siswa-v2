<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolClassResource;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        return SchoolClassResource::collection(SchoolClass::with('homeroomTeacher.user')->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        $schoolClass = SchoolClass::create($validated);

        return new SchoolClassResource($schoolClass->load('homeroomTeacher.user'));
    }

    public function show(SchoolClass $schoolClass)
    {
        return new SchoolClassResource($schoolClass->load('homeroomTeacher.user'));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        $schoolClass->update($validated);

        return new SchoolClassResource($schoolClass->load('homeroomTeacher.user'));
    }

    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();
        return response()->noContent();
    }
}