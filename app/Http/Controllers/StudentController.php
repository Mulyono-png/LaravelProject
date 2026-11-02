<?php

namespace App\Http\Controllers;

use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::query()
            ->orderBy('nis')
            ->get()
            ->map(fn (Student $student) => [
                'nis' => $student->nis,
                'name' => $student->name,
                'class' => $student->kelas,
                'status' => $student->status,
            ])
            ->all();

        return view('admin.student', [
            'title' => 'Students',
            'subtitle' => 'Kelola data siswa.',
            'students' => $students,
        ]);
    }
}
