<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacherRole = Role::where('name', 'guru')->first();
        $studentRole = Role::where('name', 'siswa')->first();

        // Create Teacher
        $teacherUser = User::create([
            'name' => 'Guru Demo',
            'email' => 'guru@example.com',
            'password' => Hash::make('password'),
            'role_id' => $teacherRole->id,
        ]);

        Teacher::create([
            'user_id' => $teacherUser->id,
            'nip' => '123456789012345678',
            'gender' => 'male',
            'phone_number' => '081234567890',
        ]);

        // Create Student
        $studentUser = User::create([
            'name' => 'Siswa Demo',
            'email' => 'siswa@example.com',
            'password' => Hash::make('password'),
            'role_id' => $studentRole->id,
        ]);

        Student::create([
            'user_id' => $studentUser->id,
            'nisn' => '1234567890',
            'gender' => 'female',
            'address' => 'Jl. Demo No. 123',
            'phone_number' => '089876543210',
        ]);
    }
}
