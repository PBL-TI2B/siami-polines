<!-- resources/views/admin/data-user/index.blade.php -->
@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Toast Notification -->
        @if (session('success'))
            <x-toast id="toast-success" type="success" :message="session('success')" />
        @endif

        @if (session('error') || $errors->any())
            <x-toast id="toast-danger" type="danger">
                @if (session('error'))
                    {{ session('error') }}<br>
                @endif
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </x-toast>
        @endif

        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data User', 'url' => route('admin.data-user.index')],
            ['label' => 'Daftar User'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Daftar User
        </h1>

        <!-- Tambah Data and Bulk Delete Buttons -->
        <div class="mb-4 flex flex-wrap gap-2">
            <x-button href="{{ route('admin.data-user.create') }}" color="sky" icon="heroicon-o-plus">
                Tambah Data
            </x-button>
        </div>

        <!-- Table Section -->
        <x-table :headers="['No', 'Nama', 'NIP', 'Email', 'Role', 'Aksi']" :data="$users" :perPage="request('entries', 10)" :route="route('admin.data-user.index')">
            @forelse ($users as $index => $user)
                <tr
                    class="border-y border-gray-200 bg-white transition-all duration-200 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                    <td class="border-r border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700">
                        {{ $users->firstItem() + $index }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        {{ $user['nama'] ?? 'N/A' }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        {{ $user['nip'] ?? 'N/A' }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        {{ $user['email'] ?? 'N/A' }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        {{ $user['role']['nama_role'] ?? ($user['role_id'] ?? 'N/A') }}
                    </td>
                    <x-table-row-actions :actions="[
                        [
                            'label' => 'Edit',
                            'color' => 'sky',
                            'icon' => 'heroicon-o-pencil',
                            'href' => !empty($user['user_id']) ? route('admin.data-user.edit', $user['user_id']) : 'javascript:void(0)',
                            'disabled' => empty($user['user_id']),
                        ],
                        [
                            'label' => 'Hapus',
                            'color' => 'red',
                            'icon' => 'heroicon-o-trash',
                            'modalId' => 'delete-user-modal-' . ($user['user_id'] ?? 'invalid'),
                            'disabled' => empty($user['user_id']),
                        ],
                    ]" />
                    @if (empty($user['user_id']))
                        <span class="text-xs text-red-500">Missing user ID: {{ json_encode($user) }}</span>
                    @endif
                </tr>
                @if (!empty($user['user_id']))
                    <x-confirmation-modal id="delete-user-modal-{{ $user['user_id'] }}" title="Konfirmasi Hapus Data"
                        :action="route('admin.data-user.destroy', $user['user_id'])" method="DELETE" type="delete" formClass="delete-modal-form"
                        :itemName="$user['nama'] ?? 'User'" :warningMessage="'Menghapus user ini akan menghapus seluruh data terkait user tersebut.'" />
                @endif
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500 sm:px-6 dark:text-gray-400">
                        Tidak ada data user.
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>

    <!-- JavaScript untuk Select All Checkboxes dan Toast -->
    @push('scripts')
        <script>
            // Select All Checkboxes
            document.getElementById('select-all').addEventListener('change', function() {
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

            // Otomatis tutup toast setelah 5 detik
            document.addEventListener('DOMContentLoaded', function() {
                const toasts = ['toast-success', 'toast-danger'];
                toasts.forEach(toastId => {
                    const toast = document.getElementById(toastId);
                    if (toast) {
                        toast.classList.remove('opacity-0');
                        toast.classList.add('opacity-100');
                        setTimeout(() => {
                            toast.classList.remove('opacity-100');
                            toast.classList.add('opacity-0');
                            setTimeout(() => {
                                toast.classList.add('hidden');
                            }, 300);
                        }, 5000);
                    }
                });
            });
        </script>
    @endpush
@endsection
