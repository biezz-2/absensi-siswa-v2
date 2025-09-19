<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        $classNames = ['10-A', '11-B', '12-C'];

        foreach ($classNames as $className) {
            SchoolClass::create([
                'name' => $className,
                'teacher_id' => $teachers->random()->id,
            ]);
        }

        $students = Student::all();
        $classes = SchoolClass::all();

        $students->each(function ($student) use ($classes) {
            $student->update(['school_class_id' => $classes->random()->id]);
        });
    }
}
