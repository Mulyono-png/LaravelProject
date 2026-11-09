<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $subjects = Subject::query()
            ->withCount('teachers')
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.subject', compact('subjects'));
    }

    public function create(): View
    {
        return view('admin.subject.form-page', ['subject' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());

        Subject::create($validated);

        return redirect()
            ->route('admin.subject.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(Subject $subject): View
    {
        return view('admin.subject.form-page', compact('subject'));
    }

    public function update(Request $request, Subject $subject): RedirectResponse
    {
        $validated = $request->validate($this->rules($subject));

        $subject->update($validated);

        return redirect()
            ->route('admin.subject.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();

        return redirect()
            ->route('admin.subject.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }

    /**
     * @return array<string, array<int, string|Unique>>
     */
    private function rules(?Subject $subject = null): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $subject
                    ? Rule::unique('subjects', 'name')->ignore($subject)
                    : 'unique:subjects,name',
            ],
        ];
    }
}
