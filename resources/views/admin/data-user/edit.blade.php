@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard.index')],
            ['label' => 'Data User', 'url' => route('data-user.index')],
            ['label' => 'Edit Profile'],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-4">
            Daftar User
        </h1>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <form>
                <!-- Upload Foto -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Upload Foto</label>
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label for="file-upload" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 cursor-pointer">
                                Pilih File
                            </label>
                            <input id="file-upload" type="file" class="hidden">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada file yang dipilih</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div>
                        <!-- Nama -->
                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama</label>
                            <input type="text" id="nama" placeholder="Masukkan nama anda" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Email</label>
                            <input type="email" id="email" placeholder="Masukkan email anda" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring-sky-500 focus:border-sky-500">
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div>
                        <!-- NIP -->
                        <div class="mb-4">
                            <label for="nip" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">NIP</label>
                            <input type="text" id="nip" placeholder="NIP" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <!-- Password -->
                        <div class="mb-4 relative">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Password</label>
                            <input type="password" id="password" placeholder="********" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring-sky-500 focus:border-sky-500">
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-3 mt-6">
                                <svg id="eye-open" class="w-5 h-5 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eye-closed" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Role</label>
                    <div class="flex flex-wrap gap-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Admin</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Admin Unit</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Auditor</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Auditee</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Kepala PMPP</span>
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-3">
                    <button type="submit" class="px-4 py-2 bg-sky-600 text-white text-sm font-medium rounded-lg hover:bg-sky-700 focus:ring-4 focus:ring-sky-200">
                        Simpan
                    </button>
                    <a href="#" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
