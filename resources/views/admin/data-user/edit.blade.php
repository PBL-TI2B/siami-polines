@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data User', 'url' => route('admin.data-user.index')],
            ['label' => 'Edit Profile'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Edit User
        </h1>

        <!-- Form -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <form action="{{ route('data-user.update', $user['user_id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Upload Foto -->
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Upload Foto</label>
                    <div class="flex items-center">
                        <div class="mr-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-200">
                            <img src="{{ $user['photo'] ?? 'https://via.placeholder.com/40' }}" alt="User Photo"
                                class="h-16 w-16 rounded-full object-cover">
                        </div>
                        <div class="flex items-center space-x-2">
                            <label for="file-upload"
                                class="inline-flex cursor-pointer items-center rounded-lg bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-900">
                                Pilih File
                            </label>
                            <input id="file-upload" name="photo" type="file" class="hidden" accept="image/*">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $user['photo'] ? basename($user['photo']) : 'Tidak ada file yang dipilih' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Kolom Kiri -->
                    <div>
                        <!-- Nama -->
                        <div class="mb-4">
                            <label for="nama"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                            <input type="text" id="nama" name="name" value="{{ old('name', $user['nama']) }}"
                                placeholder="Masukkan nama anda"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600">
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user['email']) }}"
                                placeholder="Masukkan email anda"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div>
                        <!-- NIP -->
                        <div class="mb-4">
                            <label for="nip"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">NIP</label>
                            <input type="text" id="nip" name="nip" value="{{ old('nip', $user['nip']) }}"
                                placeholder="NIP"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600">
                        </div>

                        <!-- Password -->
                        <div class="relative mb-4">
                            <label for="password"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Password (Kosongkan
                                jika tidak ingin mengubah)</label>
                            <input type="password" id="password" name="password" placeholder="********"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600">
                            <button type="button" id="toggle-password"
                                class="absolute inset-y-0 right-0 mt-6 flex items-center pr-3">
                                <svg id="eye-open" class="hidden h-5 w-5 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <svg id="eye-closed" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Role</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach (['Admin', 'Admin Unit', 'Auditor', 'Auditee', 'Kepala PMPP'] as $role)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="roles[]" value="{{ $role }}"
                                    class="h-4 w-4 rounded border-gray-200 bg-gray-100 text-sky-800 focus:ring-sky-500 dark:border-gray-500 dark:bg-gray-600 dark:focus:ring-sky-600"
                                    {{ $user['role'] === $role ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">{{ $role }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-3">
                    <x-button type="submit" color="sky" icon="heroicon-o-check">
                        Simpan Perubahan
                    </x-button>
                    <x-button color="gray" icon="heroicon-o-x-mark" href="{{ route('admin.data-user.index') }}">
                        Batal
                    </x-button>
            </form>
        </div>
    </div>

    <!-- JavaScript for Password Toggle -->
    <script>
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        });
    </script>
@endsection
