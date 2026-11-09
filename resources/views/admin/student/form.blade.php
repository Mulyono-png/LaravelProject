<form
    method="POST"
    action="{{ $student ? route('admin.student.update', $student) : route('admin.student.store') }}"
    class="space-y-5"
>
    @csrf
    @if ($student)
        @method('PUT')
    @endif

    <div>
        <label for="nis" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">NIS</label>
        <input id="nis" name="nis" type="number" min="1" value="{{ old('nis', $student?->nis) }}" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
        @error('nis')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nama Siswa</label>
        <input id="name" name="name" type="text" maxlength="255" value="{{ old('name', $student?->name) }}" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="kelas" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Kelas</label>
        <select id="kelas" name="kelas" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            @foreach (['X PPLG 1', 'X PPLG 2', 'X PPLG 3', 'XI PPLG 1', 'XI PPLG 2', 'XI PPLG 3'] as $kelas)
                <option value="{{ $kelas }}" @selected(old('kelas', $student?->kelas) === $kelas)>{{ $kelas }}</option>
            @endforeach
        </select>
        @error('kelas')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Status</label>
        <select id="status" name="status" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            <option value="Active" @selected(old('status', $student?->status ?? 'Active') === 'Active')>Active</option>
            <option value="Inactive" @selected(old('status', $student?->status) === 'Inactive')>Inactive</option>
        </select>
        @error('status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.student.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">Batal</a>
        <button type="submit" class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">
            {{ $student ? 'Simpan Perubahan' : 'Tambah Siswa' }}
        </button>
    </div>
</form>
