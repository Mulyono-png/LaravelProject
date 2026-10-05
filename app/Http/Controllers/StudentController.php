<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = [
            ['nis' => '20260001', 'name' => 'Ahmad Fauzan', 'class' => 'XI PPLG 1', 'status' => 'Active'],
            ['nis' => '20260002', 'name' => 'Muhammad Rizky', 'class' => 'XI PPLG 2', 'status' => 'Active'],
            ['nis' => '20260003', 'name' => 'Bagus Setiawan', 'class' => 'XI PPLG 1', 'status' => 'Active'],
            ['nis' => '20260004', 'name' => 'Dimas Pratama', 'class' => 'X PPLG 1', 'status' => 'Inactive'],
            ['nis' => '20260005', 'name' => 'Rizky Ramadhan', 'class' => 'X PPLG 2', 'status' => 'Active'],
            ['nis' => '20260006', 'name' => 'Siti Aminah', 'class' => 'XI PPLG 1', 'status' => 'Active'],
            ['nis' => '20260007', 'name' => 'Dwi Cahyo', 'class' => 'XI PPLG 2', 'status' => 'Inactive'],
            ['nis' => '20260008', 'name' => 'Eka Putri', 'class' => 'X PPLG 1', 'status' => 'Active'],
            ['nis' => '20260009', 'name' => 'Fajar Nugraha', 'class' => 'X PPLG 2', 'status' => 'Active'],
            ['nis' => '20260010', 'name' => 'Gita Gutawa', 'class' => 'XI PPLG 1', 'status' => 'Active'],
        ];

        return view('admin.student', [
            'title' => 'Students',
            'subtitle' => 'Kelola data siswa.',
            'students' => $students
        ]);
    }
}
