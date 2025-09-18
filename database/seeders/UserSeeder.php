<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $teacherRole = Role::where('name', 'guru')->first();
        $studentRole = Role::where('name', 'siswa')->first();

        // Create Specific Admins
        User::create([
            'name' => 'Muhammad Syarif Attabi',
            'email' => 'biezzpanel@gmail.com',
            'password' => Hash::make('attabi123'),
            'role_id' => $adminRole->id,
            'phone_number' => '+62895323405669',
        ]);
        User::create([
            'name' => 'Muhammad Syarif Attabi',
            'email' => 'biezzbackup2@gmail.com',
            'password' => Hash::make('attabi123'),
            'role_id' => $adminRole->id,
            'phone_number' => '+6282267270438',
        ]);

        // Create Generic Admin for testing
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        // Create Teachers
        User::factory(5)->create(['role_id' => $teacherRole->id])->each(function ($user) {
            Teacher::create([
                'user_id' => $user->id,
                'nip' => fake()->unique()->numerify('##################'),
                'gender' => fake()->randomElement(['male', 'female']),
                'phone_number' => fake()->phoneNumber(),
            ]);
        });

        // Create Students
        User::factory(20)->create(['role_id' => $studentRole->id])->each(function ($user) {
            Student::create([
                'user_id' => $user->id,
                'nisn' => fake()->unique()->numerify('##########'),
                'gender' => fake()->randomElement(['male', 'female']),
                'address' => fake()->address(),
                'phone_number' => fake()->phoneNumber(),
            ]);
        });
    }
}
