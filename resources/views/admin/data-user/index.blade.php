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
            <x-button href="{{ route('data-user.create') }}" color="sky" icon="heroicon-o-plus">
                Tambah Data
            </x-button>
        </div>

        <!-- Table Controls (Show Entries dan Search) -->
        <div class="flex justify-between mb-4">
            <div class="flex items-center space-x-2">
                <label for="entries" class="text-sm text-gray-700 dark:text-gray-200">Show</label>
                <select id="entries" name="entries" class="border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-1 text-sm focus:ring-sky-500 focus:border-sky-500" onchange="window.location.href='{{ route('data-user.index') }}?entries=' + this.value + '&search={{ request('search') }}'">
                    <option value="10" {{ request('entries') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span class="text-sm text-gray-700 dark:text-gray-200">entries</span>
            </div>
            <div>
                <input type="text" placeholder="Search" name="search" value="{{ request('search') }}" class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 text-sm focus:ring-sky-500 focus:border-sky-500" onkeyup="if(event.key === 'Enter') window.location.href='{{ route('data-user.index') }}?search=' + this.value + '&entries={{ request('entries') }}'">
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                    <tr>
                        <th scope="col" class="w-4 p-4 border-r border-gray-200 dark:border-gray-600">
                            <input type="checkbox" class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600" id="select-all">
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
                    @forelse ($users as $index => $user)
                        <tr class="bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                            <td class="w-4 p-4 border-r border-gray-200 dark:border-gray-700">
                                <input type="checkbox" name="selected_users[]" value="{{ $user['id'] }}" class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600 user-checkbox">
                            </td>
                            <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                                {{ $index + 1 + ($users->currentPage() - 1) * $users->perPage() }}
                            </td>
                            <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700 flex items-center">
                                <img src="{{ $user['photo'] ?? 'https://via.placeholder.com/40' }}" alt="Avatar" class="h-8 w-8 rounded-full mr-2">
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
                                    <a href="{{ route('data-user.edit', $user['id']) }}" class="text-sky-600 hover:text-sky-800">
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
                            :action="route('data-user.destroy', $user['id'])"
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

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- JavaScript for Select All Checkboxes -->
    <script>
        document.getElementById('select-all').addEventListener('change', function () {
            document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
@endsection
