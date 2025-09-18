<?php

namespace Database\Seeders;

use App\Models\AbsenceSubmission;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbsenceSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::inRandomOrder()->limit(3)->get();

        foreach ($students as $student) {
            AbsenceSubmission::create([
                'student_id' => $student->id,
                'reason' => 'Izin keluarga untuk menghadiri acara.',
                'status' => 'pending',
            ]);
        }
    }
}