@extends('layouts.app')

@section('title', 'Edit Periode Audit')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Toast Notification -->
        @if (session('success'))
            <div id="toast-success"
                class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 z-60"
                role="alert">
                <div
                    class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    data-dismiss-target="#toast-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div id="toast-danger"
                class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 z-60"
                role="alert">
                <div
                    class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                    </svg>
                    <span class="sr-only">Error icon</span>
                </div>
                <div class="ms-3 text-sm font-normal">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    data-dismiss-target="#toast-danger" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Breadcrumb -->
        <nav class="flex mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-sky-800 dark:text-gray-400 dark:hover:text-sky-200 transition-all duration-200">
                        <x-heroicon-o-home class="w-4 h-4 mr-2 text-gray-600 dark:text-gray-400" />
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-s-chevron-right class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                        <a href="{{ route('periode-audit.index') }}"
                            class="ml-1 text-sm font-medium text-gray-600 hover:text-sky-800 dark:text-gray-400 dark:hover:text-sky-200 md:ml-2 transition-all duration-200">
                            Periode Audit
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-heroicon-s-chevron-right class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                        <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ml-2">Edit
                            Periode</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Edit Periode Audit
        </h1>

        <!-- Form Section -->
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm mb-8 border border-gray-200 dark:border-gray-700 transition-all duration-200">
            <form action="{{ route('periode-audit.update', $periodeAudit->periode_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid gap-6 mb-6 grid-cols-1">
                    <!-- Nama Periode -->
                    <div>
                        <label for="nama_periode"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Nama Periode
                            AMI</label>
                        <input type="text" id="nama_periode" name="nama_periode"
                            value="{{ old('nama_periode', $periodeAudit->nama_periode) }}"
                            class="bg-gray-50 dark:bg-gray-700 border {{ $errors->has('nama_periode') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 transition-all duration-200"
                            placeholder="Masukkan nama periode">
                        @error('nama_periode')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid gap-6 mb-6 grid-cols-1 md:grid-cols-2">
                    <!-- Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Tanggal
                            Mulai</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="tanggal_mulai" name="tanggal_mulai" datepicker datepicker-buttons
                                datepicker-autoselect-today datepicker-format="dd-mm-yyyy" type="text"
                                value="{{ old('tanggal_mulai', $periodeAudit->tanggal_mulai->format('d-m-Y')) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Pilih tanggal mulai">
                        </div>
                        @error('tanggal_mulai')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Tanggal Berakhir -->
                    <div>
                        <label for="tanggal_berakhir"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Tanggal
                            Berakhir</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="tanggal_berakhir" name="tanggal_berakhir" datepicker datepicker-buttons
                                datepicker-autoselect-today datepicker-format="dd-mm-yyyy" type="text"
                                value="{{ old('tanggal_berakhir', $periodeAudit->tanggal_berakhir->format('d-m-Y')) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Pilih tanggal berakhir">
                        </div>
                        @error('tanggal_berakhir')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button type="submit"
                        class="text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center transition-all duration-200">
                        <x-heroicon-o-check class="w-5 h-5 mr-2" />
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('periode-audit.index') }}"
                        class="text-gray-900 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:focus:ring-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center transition-all duration-200">
                        <x-heroicon-o-x-mark class="w-5 h-5 mr-2" />
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Script untuk mengatur toast -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Otomatis tutup toast setelah 5 detik
                const toasts = ['toast-success', 'toast-danger'];
                toasts.forEach(toastId => {
                    const toast = document.getElementById(toastId);
                    if (toast) {
                        setTimeout(() => {
                            toast.classList.add('hidden');
                        }, 5000);
                    }
                });
            });
        </script>
    @endpush
@endsection
