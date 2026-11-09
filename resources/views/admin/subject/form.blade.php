<form
    method="POST"
    action="{{ $subject ? route('admin.subject.update', $subject) : route('admin.subject.store') }}"
    class="space-y-5"
>
    @csrf
    @if ($subject)
        @method('PUT')
    @endif

    <div>
        <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Nama Mata Pelajaran</label>
        <input id="name" name="name" type="text" maxlength="255" value="{{ old('name', $subject?->name) }}" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.subject.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">Batal</a>
        <button type="submit" class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">
            {{ $subject ? 'Simpan Perubahan' : 'Tambah Mata Pelajaran' }}
        </button>
    </div>
</form>
