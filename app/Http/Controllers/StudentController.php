<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $students = Student::query()
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $studentQuery) use ($search): void {
                    $studentQuery
                        ->where('nis', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('kelas', 'like', "%{$search}%");
                });
            })
            ->orderBy('nis')
            ->paginate(10)
            ->withQueryString();

        return view('admin.student', [
            'title' => 'Students',
            'subtitle' => 'Kelola data siswa.',
            'students' => $students,
        ]);
    }

    public function create(): View
    {
        return view('admin.student.create', ['student' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'integer', 'min:1', 'unique:students,nis'],
            'name' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        Student::create($validated);

        return redirect()
            ->route('admin.student.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student): View
    {
        return view('admin.student.edit', compact('student'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'nis' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('students', 'nis')->ignore($student),
            ],
            'name' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $student->update($validated);

        return redirect()
            ->route('admin.student.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()
            ->route('admin.student.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
