<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            ['name' => 'Matematika'],
            ['name' => 'Bahasa Indonesia'],
            ['name' => 'Bahasa Inggris'],
            ['name' => 'Fisika'],
            ['name' => 'Biologi'],
            ['name' => 'Kimia'],
            ['name' => 'Sejarah'],
            ['name' => 'Seni Budaya'],
        ]);
    }
}
