<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $teachers = Teacher::query()
            ->with('subjects')
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $teacherQuery) use ($search): void {
                    $teacherQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('niy', 'like', "%{$search}%")
                        ->orWhereHas('subjects', function (Builder $subjectQuery) use ($search): void {
                            $subjectQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.teacher', compact('teachers'));
    }

    public function create(): View
    {
        return view('admin.teacher.form-page', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        DB::transaction(function () use ($validated): void {
            $teacher = Teacher::create([
                'name' => $validated['name'],
                'niy' => $validated['niy'],
            ]);

            $teacher->subjects()->sync($this->subjectAssignments($validated['subjects']));
        });

        return redirect()
            ->route('admin.teacher.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher): View
    {
        $teacher->load('subjects');

        return view('admin.teacher.form-page', $this->formData($teacher));
    }

    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
        $validated = $request->validate($this->rules($teacher));

        DB::transaction(function () use ($teacher, $validated): void {
            $teacher->update([
                'name' => $validated['name'],
                'niy' => $validated['niy'],
            ]);

            $teacher->subjects()->sync($this->subjectAssignments($validated['subjects']));
        });

        return redirect()
            ->route('admin.teacher.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->delete();

        return redirect()
            ->route('admin.teacher.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    /**
     * @param  array<int, array{subject_id: int|string, lesson_hours: int|string}>  $subjects
     * @return array<int, array{lesson_hours: int}>
     */
    private function subjectAssignments(array $subjects): array
    {
        $assignments = [];

        foreach ($subjects as $subject) {
            $assignments[(int) $subject['subject_id']] = [
                'lesson_hours' => (int) $subject['lesson_hours'],
            ];
        }

        return $assignments;
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(?Teacher $teacher = null): array
    {
        return [
            'teacher' => $teacher,
            'subjects' => Subject::query()->orderBy('name')->get(),
        ];
    }

    /**
     * @return array<string, array<int, string|Unique>>
     */
    private function rules(?Teacher $teacher = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'niy' => [
                'required',
                'string',
                'regex:/\A1990\d{4}\z/',
                $teacher
                    ? Rule::unique('teachers', 'niy')->ignore($teacher)
                    : 'unique:teachers,niy',
            ],
            'subjects' => ['required', 'array', 'min:1'],
            'subjects.*.subject_id' => ['required', 'integer', 'distinct', 'exists:subjects,id'],
            'subjects.*.lesson_hours' => ['required', 'integer', 'min:1', 'max:60'],
        ];
    }
}
