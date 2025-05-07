<!-- resources/views/admin/data-user/index.blade.php -->
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
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-6">
            Daftar User
        </h1>

        <!-- Tambah Data and Bulk Delete Buttons -->
        <div class="flex flex-wrap mb-4 gap-2">
            <x-button href="{{ route('data-user.create') }}" color="sky" icon="heroicon-o-plus">
                Tambah Data
            </x-button>
            <x-button onclick="document.getElementById('bulk-delete-form').submit()" color="red" icon="heroicon-o-trash">
                Hapus Terpilih
            </x-button>
        </div>

        <!-- Table Section -->
        <x-table
            :headers="['', 'No', 'Nama', 'NIP', 'Email', 'Role', 'Aksi']"
            :data="$users"
            :perPage="request('entries', 10)"
            :route="route('data-user.index')"
        >
        @forelse ($users as $index => $user)
            <tr class="bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                <td class="w-4 p-4 border-r border-gray-200 dark:border-gray-700">
                    @if ($user->id)
                        <input type="checkbox" name="selected_users[]" value="{{ $user->id }}" class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600 user-checkbox">
                    @else
                        <input type="checkbox" name="selected_users[]" value="" class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600 user-checkbox" disabled>
                    @endif
                </td>
                <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                    {{ $users->firstItem() + $index }}
                </td>
                <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                    {{ $user->nama ?? 'N/A' }}
                </td>
                <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                    {{ $user->nip ?? 'N/A' }}
                </td>
                <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                    {{ $user->email ?? 'N/A' }}
                </td>
                <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                    {{ $user->role['nama_role'] ?? 'N/A' }}
                </td>
                <x-table-row-actions :actions="[
                    [
                        'label' => 'Edit',
                        'color' => 'sky',
                        'icon' => 'heroicon-o-pencil',
                        'href' => $user->user_id ? route('data-user.edit', $user->user_id) : 'javascript:void(0)',
                        'disabled' => !$user->user_id,
                    ],
                    [
                        'label' => 'Hapus',
                        'color' => 'red',
                        'icon' => 'heroicon-o-trash',
                        'modalId' => 'delete-user-modal-' . ($user->user_id ?? 'invalid'),
                        'disabled' => !$user->user_id,
                    ],
                ]" />
                @if (!$user->user_id)
                    <span class="text-red-500 text-xs">Missing user ID: {{ json_encode($user->toArray()) }}</span>
                @endif
            </tr>
            @if ($user->user_id)
                <x-confirmation-modal
                    id="delete-user-modal-{{ $user->user_id }}"
                    title="Konfirmasi Hapus Data"
                    :action="route('data-user.destroy', $user->user_id)"
                    method="DELETE"
                    type="delete"
                    formClass="delete-modal-form"
                    :itemName="$user->name ?? $user->nama"
                    :warningMessage="'Menghapus user ini akan menghapus seluruh data terkait user tersebut.'"
                />
            @endif
        @empty
            <tr>
                <td colspan="7" class="px-4 py-4 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                    Tidak ada data user.
                </td>
            </tr>
        @endforelse
        </x-table>

        <!-- Bulk Delete Form -->
        <form id="bulk-delete-form" action="{{ route('data-user.bulk-delete') }}" method="POST">
            @csrf
            @method('DELETE')
        </form>

        <!-- JavaScript for Select All Checkboxes -->
        <script>
            document.getElementById('select-all').addEventListener('change', function () {
                document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                    checkbox.checked = this.checked;
                    const form = document.getElementById('bulk-delete-form');
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.querySelectorAll('.user-checkbox:checked').forEach(checkbox => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected_users[]';
                        input.value = checkbox.value;
                        form.appendChild(input);
                    });
                });
            });

            document.querySelectorAll('.user-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const form = document.getElementById('bulk-delete-form');
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.querySelectorAll('.user-checkbox:checked').forEach(checkbox => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected_users[]';
                        input.value = checkbox.value;
                        form.appendChild(input);
                    });
                });
            });
        </script>
    </div>
@endsection
