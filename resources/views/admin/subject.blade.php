<x-admin.layout>
    <section class="bg-gray-50 p-3 dark:bg-gray-900 sm:p-5">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="relative overflow-hidden rounded-lg bg-white shadow-md dark:bg-gray-800">
                <div class="flex flex-col items-center justify-between gap-3 p-4 md:flex-row">
                    <form method="GET" action="{{ route('admin.subject.index') }}" class="flex w-full gap-2 md:w-1/2">
                        <label for="subject-search" class="sr-only">Cari mata pelajaran</label>
                        <input id="subject-search" name="search" type="search" value="{{ request('search') }}" placeholder="Cari mata pelajaran..." class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <button type="submit" class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">Cari</button>
                    </form>
                    <a href="{{ route('admin.subject.create') }}" class="rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800">+ Tambah Mata Pelajaran</a>
                </div>

                @if (session('success'))
                    <div class="mx-4 mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-800 dark:bg-green-900 dark:text-green-300" role="status">{{ session('success') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">No</th>
                                <th scope="col" class="px-4 py-3">Mata Pelajaran</th>
                                <th scope="col" class="px-4 py-3">Jumlah Guru</th>
                                <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subjects as $index => $subject)
                                <tr class="border-b hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-600">
                                    <td class="px-4 py-3">{{ $subjects->firstItem() + $index }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $subject->name }}</td>
                                    <td class="px-4 py-3">{{ $subject->teachers_count }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.subject.edit', $subject) }}" class="font-medium text-blue-700 hover:underline dark:text-blue-400">Edit</a>
                                            <form action="{{ route('admin.subject.destroy', $subject) }}" method="POST" onsubmit="return confirm('Hapus mata pelajaran ini dari semua data guru?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 hover:underline dark:text-red-400">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Belum ada data mata pelajaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">{{ $subjects->links() }}</div>
            </div>
        </div>
    </section>
</x-admin.layout>
