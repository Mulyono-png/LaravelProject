@php
    $assignments = old('subjects');

    if (! is_array($assignments)) {
        $assignments = null;
    }

    if ($assignments === null) {
        $assignments = $teacher
            ? $teacher->subjects->map(fn ($subject) => [
                'subject_id' => $subject->id,
                'lesson_hours' => $subject->pivot->lesson_hours,
            ])->all()
            : [['subject_id' => '', 'lesson_hours' => '']];
    }

    $assignments = array_filter($assignments, fn ($assignment) => is_array($assignment));

    if ($assignments === []) {
        $assignments = [['subject_id' => '', 'lesson_hours' => '']];
    }

    $nextSubjectRowIndex = max(array_map('intval', array_keys($assignments))) + 1;
@endphp

<form
    method="POST"
    action="{{ $teacher ? route('admin.teacher.update', $teacher) : route('admin.teacher.store') }}"
    class="space-y-5"
>
    @csrf
    @if ($teacher)
        @method('PUT')
    @endif

    <div>
        <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nama Guru</label>
        <input id="name" name="name" type="text" maxlength="255" value="{{ old('name', $teacher?->name) }}" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="niy" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">NIY</label>
        <input id="niy" name="niy" type="text" maxlength="30" value="{{ old('niy', $teacher?->niy) }}" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
        @error('niy')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <div class="mb-2 flex items-center justify-between gap-3">
            <span class="text-sm font-medium text-gray-900 dark:text-white">Mata Pelajaran dan Jam Pelajaran</span>
            <button type="button" id="add-subject-row" class="text-sm font-medium text-blue-700 hover:underline dark:text-blue-400">+ Tambah Mapel</button>
        </div>

        @if ($subjects->isEmpty())
            <p class="mb-3 rounded-lg bg-yellow-50 p-3 text-sm text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                Belum ada mata pelajaran. <a href="{{ route('admin.subject.create') }}" class="font-medium underline">Tambahkan mata pelajaran dulu.</a>
            </p>
        @endif

        <div id="teacher-subject-rows" class="space-y-3">
            @foreach ($assignments as $index => $assignment)
                <div data-subject-row class="grid gap-3 rounded-lg border border-gray-200 p-3 dark:border-gray-700 sm:grid-cols-[1fr_10rem_auto] sm:items-end">
                    <div>
                        <label for="subject-{{ $index }}" class="mb-2 block text-sm text-gray-700 dark:text-gray-300">Mapel</label>
                        <select id="subject-{{ $index }}" name="subjects[{{ $index }}][subject_id]" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="">Pilih mata pelajaran</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" @selected((string) ($assignment['subject_id'] ?? '') === (string) $subject->id)>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error("subjects.$index.subject_id")
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="lesson-hours-{{ $index }}" class="mb-2 block text-sm text-gray-700 dark:text-gray-300">Jam Pelajaran</label>
                        <input id="lesson-hours-{{ $index }}" name="subjects[{{ $index }}][lesson_hours]" type="number" min="1" max="60" value="{{ $assignment['lesson_hours'] ?? '' }}" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        @error("subjects.$index.lesson_hours")
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="button" data-remove-subject class="rounded-lg border border-gray-300 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">Hapus</button>
                </div>
            @endforeach
        </div>
        @error('subjects')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <template id="teacher-subject-template">
        <div data-subject-row class="grid gap-3 rounded-lg border border-gray-200 p-3 dark:border-gray-700 sm:grid-cols-[1fr_10rem_auto] sm:items-end">
            <div>
                <label for="subject-__INDEX__" class="mb-2 block text-sm text-gray-700 dark:text-gray-300">Mapel</label>
                <select id="subject-__INDEX__" name="subjects[__INDEX__][subject_id]" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    <option value="">Pilih mata pelajaran</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="lesson-hours-__INDEX__" class="mb-2 block text-sm text-gray-700 dark:text-gray-300">Jam Pelajaran</label>
                <input id="lesson-hours-__INDEX__" name="subjects[__INDEX__][lesson_hours]" type="number" min="1" max="60" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            </div>
            <button type="button" data-remove-subject class="rounded-lg border border-gray-300 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">Hapus</button>
        </div>
    </template>

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.teacher.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">Batal</a>
        <button type="submit" @disabled($subjects->isEmpty()) class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 disabled:cursor-not-allowed disabled:opacity-50">
            {{ $teacher ? 'Simpan Perubahan' : 'Tambah Guru' }}
        </button>
    </div>
</form>

<script>
    const subjectRows = document.getElementById('teacher-subject-rows');
    const subjectTemplate = document.getElementById('teacher-subject-template');
    let subjectRowIndex = {{ $nextSubjectRowIndex }};

    document.getElementById('add-subject-row').addEventListener('click', () => {
        const row = subjectTemplate.innerHTML.replaceAll('__INDEX__', String(subjectRowIndex++));
        subjectRows.insertAdjacentHTML('beforeend', row);
    });

    subjectRows.addEventListener('click', (event) => {
        const removeButton = event.target.closest('[data-remove-subject]');

        if (removeButton) {
            removeButton.closest('[data-subject-row]').remove();
        }
    });
</script>
