<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['nis' => 20260001, 'name' => 'Ahmad Fauzan', 'kelas' => 'XI PPLG 1', 'status' => 'Active'],
            ['nis' => 20260002, 'name' => 'Muhammad Rizky', 'kelas' => 'XI PPLG 2', 'status' => 'Active'],
            ['nis' => 20260003, 'name' => 'Bagus Setiawan', 'kelas' => 'XI PPLG 1', 'status' => 'Active'],
            ['nis' => 20260004, 'name' => 'Dimas Pratama', 'kelas' => 'X PPLG 1', 'status' => 'Inactive'],
            ['nis' => 20260005, 'name' => 'Rizky Ramadhan', 'kelas' => 'X PPLG 2', 'status' => 'Active'],
            ['nis' => 20260006, 'name' => 'Siti Aminah', 'kelas' => 'XI PPLG 1', 'status' => 'Active'],
            ['nis' => 20260007, 'name' => 'Dwi Cahyo', 'kelas' => 'XI PPLG 2', 'status' => 'Inactive'],
            ['nis' => 20260008, 'name' => 'Eka Putri', 'kelas' => 'X PPLG 1', 'status' => 'Active'],
            ['nis' => 20260009, 'name' => 'Fajar Nugraha', 'kelas' => 'X PPLG 2', 'status' => 'Active'],
            ['nis' => 20260010, 'name' => 'Gita Gutawa', 'kelas' => 'XI PPLG 1', 'status' => 'Active'],
        ];

        foreach ($students as $student) {
            Student::updateOrCreate(
                ['nis' => $student['nis']],
                [
                    'name' => $student['name'],
                    'kelas' => $student['kelas'],
                    'status' => $student['status'],
                ],
            );
        }
    }
}
