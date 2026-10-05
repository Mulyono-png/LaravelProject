<x-admin.layout>
    <div class="p-4">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
                <p class="text-sm text-gray-500">{{ $subtitle }}</p>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-4 py-2">
                + Tambah Siswa
            </button>
        </div>

        <!-- Table Card Flowbite -->
        <div class="bg-white shadow-md sm:rounded-lg overflow-hidden border border-gray-200">
            <!-- Filter / Search Header -->
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" placeholder="Cari nama atau NIS..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10 p-2">
                        </div>
                    </form>
                </div>
                <div>
                    <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2">
                        <option>--Semua Kelas--</option>
                        <option>X PPLG 1</option>
                        <option>X PPLG 2</option>
                        <option>XI PPLG 1</option>
                        <option>XI PPLG 2</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th scope="col" class="px-4 py-3">NO</th>
                            <th scope="col" class="px-4 py-3">NAME</th>
                            <th scope="col" class="px-4 py-3">NIS</th>
                            <th scope="col" class="px-4 py-3">CLASS</th>
                            <th scope="col" class="px-4 py-3">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $student['name'] }}</td>
                                <td class="px-4 py-3">{{ $student['nis'] }}</td>
                                <td class="px-4 py-3">{{ $student['class'] }}</td>
                                <td class="px-4 py-3">
                                    @if ($student['status'] === 'Active')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Active</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin.layout>
