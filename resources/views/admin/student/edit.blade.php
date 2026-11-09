<x-admin.layout>
    <section class="mx-auto max-w-3xl rounded-lg bg-white p-6 shadow dark:bg-gray-800">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Siswa</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Perbarui data {{ $student->name }}.</p>
            </div>
            <a href="{{ route('admin.student.index') }}" class="text-sm font-medium text-blue-700 hover:underline dark:text-blue-400">Kembali</a>
        </div>

        @include('admin.student.form', ['student' => $student])
    </section>
</x-admin.layout>
