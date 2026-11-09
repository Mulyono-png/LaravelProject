<x-admin.layout>
    <section class="mx-auto max-w-3xl rounded-lg bg-white p-6 shadow dark:bg-gray-800">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $teacher ? 'Edit Guru' : 'Tambah Guru' }}</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $teacher ? 'Perbarui data '.$teacher->name.'.' : 'Isi identitas guru dan mata pelajaran yang diajar.' }}
                </p>
            </div>
            <a href="{{ route('admin.teacher.index') }}" class="text-sm font-medium text-blue-700 hover:underline dark:text-blue-400">Kembali</a>
        </div>
        @include('admin.teacher.form')
    </section>
</x-admin.layout>
