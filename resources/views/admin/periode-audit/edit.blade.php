@extends('layouts.app')

@section('title', 'Edit Periode Audit')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Notifikasi Toast -->
        <div id="toast-success"
            class="z-60 fixed right-5 top-20 mb-4 flex hidden w-full max-w-xs items-center rounded-lg bg-white p-4 text-gray-500 shadow-sm transition-opacity duration-300 dark:bg-gray-800 dark:text-gray-400"
            role="alert">
            <div
                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-500 dark:bg-green-800 dark:text-green-200">
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Ikon Sukses</span>
            </div>
            <div class="ms-3 text-sm font-normal">
                Periode audit berhasil diperbarui.
            </div>
            <button type="button"
                class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white"
                data-dismiss-target="#toast-success" aria-label="Tutup">
                <span class="sr-only">Tutup</span>
                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        <div id="toast-danger"
            class="z-60 fixed right-5 top-20 mb-4 flex hidden w-full max-w-xs items-center rounded-lg bg-white p-4 text-gray-500 shadow-sm transition-opacity duration-300 dark:bg-gray-800 dark:text-gray-400"
            role="alert">
            <div
                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-500 dark:bg-red-800 dark:text-red-200">
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                </svg>
                <span class="sr-only">Ikon Error</span>
            </div>
            <div class="ms-3 text-sm font-normal">
                Gagal memproses permintaan.
            </div>
            <button type="button"
                class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white"
                data-dismiss-target="#toast-danger" aria-label="Tutup">
                <span class="sr-only">Tutup</span>
                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <!-- Breadcrumb -->
        <nav class="mb-8 flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-sky-600 dark:text-gray-400 dark:hover:text-white">
                        <x-heroicon-o-home class="mr-2 h-4 w-4" />
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="mx-1 h-3 w-3 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('periode-audit.index') }}"
                            class="ml-1 text-sm font-medium text-gray-700 hover:text-sky-600 dark:text-gray-400 dark:hover:text-white">
                            Periode Audit
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="mx-1 h-3 w-3 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Edit Periode</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Judul Halaman -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Edit Periode Audit
        </h1>

        <!-- Bagian Form -->
        <div
            class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
            <form id="periode-audit-form" action="{{ route('periode-audit.update', $periodeAudit->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-6 grid grid-cols-1 gap-6">
                    <!-- Input Nama Periode -->
                    <div>
                        <label for="nama_periode" class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-200">
                            Nama Periode AMI
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_periode" name="nama_periode"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-sky-600 dark:focus:ring-sky-600"
                            placeholder="Masukkan nama periode" required maxlength="255"
                            value="{{ old('nama_periode', $periodeAudit->nama_periode) }}">
                        @error('nama_periode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Input Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai"
                            class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-200">
                            Tanggal Mulai
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-sky-600 dark:focus:ring-sky-600"
                            placeholder="Pilih tanggal mulai" required
                            value="{{ old('tanggal_mulai', $periodeAudit->tanggal_mulai) }}">
                        @error('tanggal_mulai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Input Tanggal Berakhir -->
                    <div>
                        <label for="tanggal_berakhir"
                            class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-200">
                            Tanggal Berakhir
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_berakhir" name="tanggal_berakhir"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-sky-600 dark:focus:ring-sky-600"
                            placeholder="Pilih tanggal berakhir" required
                            value="{{ old('tanggal_berakhir', $periodeAudit->tanggal_berakhir) }}">
                        @error('tanggal_berakhir')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- Tombol Simpan -->
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-sky-800 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-sky-900 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800">
                    <svg class="mr-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <!-- Skrip JavaScript -->
    @push('scripts')
        <script>
            // Fungsi untuk menampilkan notifikasi toast
            function showToast(id, message = null) {
                const toast = document.getElementById(id);
                if (message) {
                    toast.querySelector('.ms-3').textContent = message;
                }
                toast.classList.remove('hidden');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 5000);
            }

            // Inisialisasi saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function() {
                // Cek apakah ada error dari server
                @if ($errors->any())
                    showToast('toast-danger', 'Gagal memproses permintaan: {{ $errors->first() }}');
                @endif

                // Cek apakah ada pesan sukses dari session
                @if (session('success'))
                    showToast('toast-success', '{{ session('success') }}');
                @endif
            });
        </script>
    @endpush
@endsection
