@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard.index')],
            ['label' => 'Data User', 'url' => route('data-user.index')],
            ['label' => 'Daftar User'],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-2">
            Daftar User
        </h1>

        <!-- Tambah Data Button -->
        <div class="flex justify-start mb-4">
            <!-- View -->
        <x-button href="{{ route('data-user.create') }}" color="sky" icon="heroicon-o-plus">
            Tambah Data
        </x-button>
        </div>

        <!-- Table Controls (Show Entries dan Search) -->
        <div class="flex justify-between mb-4">
            <div class="flex items-center space-x-2">
                <label for="entries" class="text-sm text-gray-700 dark:text-gray-200">Show</label>
                <select id="entries" class="border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-1 text-sm focus:ring-sky-500 focus:border-sky-500">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                </select>
                <span class="text-sm text-gray-700 dark:text-gray-200">entries</span>
            </div>
            <div>
                <input type="text" placeholder="Search" class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 text-sm focus:ring-sky-500 focus:border-sky-500">
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                    <tr>
                        <th scope="col" class="w-4 p-4 border-r border-gray-200 dark:border-gray-600">
                            <input type="checkbox" class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                        </th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">No</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Nama</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">NIP</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Email</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Role</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ([
                        ['id' => 1, 'name' => 'Contoh Nama Dosen S.Kom., M.Kom', 'nip' => '192992137283786578', 'email' => 'dosen1@polines.ac.id', 'role' => 'Admin'],
                        ['id' => 2, 'name' => 'Dr. John Doe M.T.', 'nip' => '192992137283786579', 'email' => 'dosen2@polines.ac.id', 'role' => 'Auditee'],
                        ['id' => 3, 'name' => 'Jane Smith S.T., M.Eng.', 'nip' => '192992137283786580', 'email' => 'dosen3@polines.ac.id', 'role' => 'Auditor'],
                        ['id' => 4, 'name' => 'Dr. Ahmad Yani S.Kom., Ph.D.', 'nip' => '192992137283786581', 'email' => 'dosen4@polines.ac.id', 'role' => 'Admin'],
                        ['id' => 5, 'name' => 'Budi Santoso S.T., M.Kom.', 'nip' => '192992137283786582', 'email' => 'dosen5@polines.ac.id', 'role' => 'Auditee'],
                        ['id' => 6, 'name' => 'Siti Aminah S.Kom., M.T.', 'nip' => '192992137283786583', 'email' => 'dosen6@polines.ac.id', 'role' => 'Auditor'],
                        ['id' => 7, 'name' => 'Dr. Rina Wijaya M.Eng.', 'nip' => '192992137283786584', 'email' => 'dosen7@polines.ac.id', 'role' => 'Admin'],
                        ['id' => 8, 'name' => 'Eko Prasetyo S.T., M.Kom.', 'nip' => '192992137283786585', 'email' => 'dosen8@polines.ac.id', 'role' => 'Auditee'],
                        ['id' => 9, 'name' => 'Dewi Lestari S.Kom., M.T.', 'nip' => '192992137283786586', 'email' => 'dosen9@polines.ac.id', 'role' => 'Auditor'],
                        ['id' => 10, 'name' => 'Prof. Hadi Susanto Ph.D.', 'nip' => '192992137283786587', 'email' => 'dosen10@polines.ac.id', 'role' => 'Admin']
                    ] as $index => $user)
                        <tr class="bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                            <td class="w-4 p-4 border-r border-gray-200 dark:border-gray-700">
                                <input type="checkbox"
                                    class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                            </td>
                            <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700 flex items-center">
                                <img src="https://via.placeholder.com/40" alt="Avatar" class="h-8 w-8 rounded-full mr-2">
                                {{ $user['name'] }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                                {{ $user['nip'] }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                                {{ $user['email'] }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                                {{ $user['role'] }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                                <div class="flex space-x-2">
                                    <a href="#" class="text-sky-600 hover:text-sky-800">
                                        <x-button color="sky" icon="heroicon-o-pencil">
                                            Edit
                                        </x-button>
                                    </a>
                                    <a href="#" class="text-red-600 hover:text-red-800" onclick="document.getElementById('delete-user-modal-{{ $user['id'] }}').showModal()">
                                        <x-button color="red" icon="heroicon-o-trash">
                                            Hapus
                                        </x-button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <!-- Confirmation Modal for Delete -->
                        <x-confirmation-modal
                            id="delete-user-modal-{{ $user['id'] }}"
                            title="Konfirmasi Hapus Data"
                            :action="'#'"
                            method="DELETE"
                            type="delete"
                            formClass="delete-modal-form"
                            :itemName="$user['name']"
                            :warningMessage="'Menghapus user ini akan menghapus seluruh data terkait user tersebut.'"
                        />
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
