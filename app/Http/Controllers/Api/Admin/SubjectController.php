<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    public function index()
    {
        return SubjectResource::collection(Subject::paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:subjects']]);
        $subject = Subject::create($validated);
        return new SubjectResource($subject);
    }

    public function show(Subject $subject)
    {
        return new SubjectResource($subject);
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate(['name' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('subjects')->ignore($subject->id)]]);
        $subject->update($validated);
        return new SubjectResource($subject);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response()->noContent();
    }
}