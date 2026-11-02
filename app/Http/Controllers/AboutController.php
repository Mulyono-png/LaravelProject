<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = [
            ['nis' => '20260001', 'name' => 'Ahmad Fauzan', 'class' => 'XI PPLG 1', 'status' => 'Active'],
            ['nis' => '20260002', 'name' => 'Muhammad Rizky', 'class' => 'XI PPLG 2', 'status' => 'Active'],
            ['nis' => '20260003', 'name' => 'Bagus Setiawan', 'class' => 'XI PPLG 1', 'status' => 'Active'],
            ['nis' => '20260004', 'name' => 'Dimas Pratama', 'class' => 'X PPLG 1', 'status' => 'Inactive'],
            ['nis' => '20260005', 'name' => 'Rizky Ramadhan', 'class' => 'X PPLG 2', 'status' => 'Active'],
        ];

        return view('admin.about', [
            'title' => 'About Siswa',
            'subtitle' => 'Kelola data siswa.',
            'students' => $students,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
