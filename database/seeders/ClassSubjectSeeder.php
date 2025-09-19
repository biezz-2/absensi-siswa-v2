<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();

        $classes->each(function ($class) use ($subjects) {
            $subjectsToAttach = $subjects->random(5)->pluck('id')->toArray();
            $teachers = \App\Models\Teacher::pluck('id');

            foreach ($subjectsToAttach as $subjectId) {
                $class->subjects()->attach($subjectId, ['teacher_id' => $teachers->random()]);
            }
        });
    }
}