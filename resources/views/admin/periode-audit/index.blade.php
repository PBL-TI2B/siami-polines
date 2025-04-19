@extends('layouts.app')

@section('title', 'Periode Audit')

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
                        <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ml-2">Daftar
                            Periode</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Periode Audit
        </h1>

        <!-- Form Section -->
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm mb-8 border border-gray-200 dark:border-gray-700 transition-all duration-200">
            <form action="{{ route('periode-audit.store') }}" method="POST">
                @csrf
                <div class="grid gap-6 mb-6 grid-cols-1">
                    <!-- Nama Periode -->
                    <div>
                        <label for="nama_periode"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">Nama Periode
                            AMI</label>
                        <input type="text" id="nama_periode" name="nama_periode" value="{{ old('nama_periode') }}"
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
                                value="{{ old('tanggal_mulai') }}"
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
                                value="{{ old('tanggal_berakhir') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Pilih tanggal berakhir">
                        </div>
                        @error('tanggal_berakhir')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button type="submit"
                    class="text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center transition-all duration-200">
                    <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                    Tambah Periode
                </button>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
            <!-- Table Controls -->
            <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Show</span>
                    <form action="{{ route('periode-audit.index') }}" method="GET" class="">
                        <select id="table-entries" name="per_page"
                            class="w-18 gap-4 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200"
                            onchange="this.form.submit()">
                            <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </form>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entries</span>
                </div>
                <div class="relative w-full sm:w-auto">
                    <form action="{{ route('periode-audit.index') }}" method="GET">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="w-4 h-4 text-gray-500 dark:text-gray-400" />
                        </div>
                        <input type="search" name="search" placeholder="Search" value="{{ request('search') }}"
                            class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th scope="col" class="p-4 border-r border-gray-200 dark:border-gray-600">
                                <input type="checkbox"
                                    class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-300 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                            </th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">No
                            </th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                                Nama Periode AMI</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                                Tanggal Mulai</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                                Tanggal Berakhir</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                                Status</th>
                            <th scope="col" class="px-4 py-3 sm:px-6">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($periodeAudits ?? [] as $index => $periode)
                            <tr
                                class="bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                                <td class="w-4 p-4 border-r border-gray-200 dark:border-gray-700">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                                </td>
                                <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                                    {{ $periodeAudits->firstItem() + $index }}</td>
                                <td
                                    class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                                    {{ $periode->nama_periode }}</td>
                                <td
                                    class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                                    {{ $periode->tanggal_mulai->format('d F Y') }}</td>
                                <td
                                    class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                                    {{ $periode->tanggal_berakhir->format('d F Y') }}</td>
                                <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $periode->status == 'Berakhir' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300' }}">
                                        {{ $periode->status }}
                                    </span>
                                </td>
                                <td
                                    class="px-4 py-4 sm:px-6 flex flex-col sm:flex-row gap-2 border-gray-200 dark:border-gray-700">
                                    @if ($periode->status != 'Berakhir')
                                        <!-- Tombol Tutup dengan Modal Trigger -->
                                        <button data-modal-target="close-periode-modal-{{ $periode->periode_id }}"
                                            data-modal-toggle="close-periode-modal-{{ $periode->periode_id }}"
                                            class="text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-600 font-medium rounded-lg text-sm px-3 py-1.5 flex items-center transition-all duration-200">
                                            <x-heroicon-o-lock-closed class="w-4 h-4 mr-1" />
                                            Tutup
                                        </button>
                                    @endif
                                    <a href="{{ route('periode-audit.edit', $periode->periode_id) }}"
                                        class="text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600 font-medium rounded-lg text-sm px-3 py-1.5 flex items-center transition-all duration-200">
                                        <x-heroicon-o-pencil class="w-4 h-4 mr-1" />
                                        Edit
                                    </a>
                                    <!-- Delete Button with Modal Trigger -->
                                    <button data-modal-target="delete-periode-modal-{{ $periode->periode_id }}"
                                        data-modal-toggle="delete-periode-modal-{{ $periode->periode_id }}"
                                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-600 font-medium rounded-lg text-sm px-3 py-1.5 flex items-center transition-all duration-200">
                                        <x-heroicon-o-trash class="w-4 h-4 mr-1" />
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Close Confirmation Modal -->
                            @if ($periode->status != 'Berakhir')
                                <div id="close-periode-modal-{{ $periode->periode_id }}" tabindex="-1"
                                    aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-700">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex items-center justify-center w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900">
                                                        <x-heroicon-o-lock-closed
                                                            class="w-5 h-5 text-yellow-600 dark:text-yellow-300" />
                                                    </div>
                                                    <h3
                                                        class="ml-3 text-lg font-semibold text-gray-900 dark:text-gray-200">
                                                        Konfirmasi Tutup Periode
                                                    </h3>
                                                </div>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white"
                                                    data-modal-hide="close-periode-modal-{{ $periode->periode_id }}">
                                                    <x-heroicon-o-x-mark class="w-5 h-5" />
                                                    <span class="sr-only">Tutup modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-4 md:p-5">
                                                <p class="text-sm text-gray-900 dark:text-gray-200 mb-4">
                                                    Untuk menutup periode pelaksanaan AMI ini, harap masukkan nama
                                                    periode:
                                                </p>
                                                <input type="text" name="confirm_nama_periode"
                                                    id="confirm_nama_periode_close_{{ $periode->periode_id }}"
                                                    class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 mb-4 transition-all duration-200"
                                                    placeholder="Masukkan nama periode">
                                                <div
                                                    class="p-3 mb-4 bg-yellow-50 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 rounded-lg">
                                                    <p class="text-sm">
                                                        <span class="font-semibold">Perhatian:</span> Menutup periode ini
                                                        akan mengakhiri seluruh aktivitas AMI pada periode tersebut dan
                                                        tidak dapat diubah kembali.
                                                    </p>
                                                </div>
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button"
                                                        data-modal-hide="close-periode-modal-{{ $periode->periode_id }}"
                                                        class="px-4 py-2 text-sm font-medium text-gray-900 bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:focus:ring-gray-600">
                                                        Batal
                                                    </button>
                                                    <form
                                                        action="{{ route('periode-audit.close', $periode->periode_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-600">
                                                            Tutup
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- JavaScript untuk Validasi Close Modal -->
                                <script>
                                    document.querySelector('form[action="{{ route('periode-audit.close', $periode->periode_id) }}"]').addEventListener(
                                        'submit',
                                        function(e) {
                                            const input = document.querySelector('#confirm_nama_periode_close_{{ $periode->periode_id }}');
                                            if (input.value !== '{{ $periode->nama_periode }}') {
                                                e.preventDefault();
                                                alert('Nama periode tidak cocok!');
                                            }
                                        });
                                </script>
                            @endif

                            <!-- Delete Confirmation Modal -->
                            <div id="delete-periode-modal-{{ $periode->periode_id }}" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-700">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-red-100 dark:bg-red-900">
                                                    <x-heroicon-o-trash class="w-5 h-5 text-red-600 dark:text-red-300" />
                                                </div>
                                                <h3 class="ml-3 text-lg font-semibold text-gray-900 dark:text-gray-200">
                                                    Konfirmasi Hapus Data
                                                </h3>
                                            </div>
                                            <button type="button"
                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white"
                                                data-modal-hide="delete-periode-modal-{{ $periode->periode_id }}">
                                                <x-heroicon-o-x-mark class="w-5 h-5" />
                                                <span class="sr-only">Tutup modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5">
                                            <p class="text-sm text-gray-900 dark:text-gray-200 mb-4">
                                                Untuk menghapus periode pelaksanaan AMI ini, harap masukkan nama periode:
                                            </p>
                                            <input type="text" name="confirm_nama_periode"
                                                id="confirm_nama_periode_{{ $periode->periode_id }}"
                                                class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 mb-4 transition-all duration-200"
                                                placeholder="Masukkan nama periode">
                                            <div
                                                class="p-3 mb-4 bg-yellow-50 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 rounded-lg">
                                                <p class="text-sm">
                                                    <span class="font-semibold">Perhatian:</span> Menghapus periode ini
                                                    akan menghapus seluruh riwayat pelaksanaan AMI pada periode tanggal
                                                    tersebut.
                                                </p>
                                            </div>
                                            <div class="flex justify-end space-x-2">
                                                <button type="button"
                                                    data-modal-hide="delete-periode-modal-{{ $periode->periode_id }}"
                                                    class="px-4 py-2 text-sm font-medium text-gray-900 bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:focus:ring-gray-600">
                                                    Batal
                                                </button>
                                                <form action="{{ route('periode-audit.destroy', $periode->periode_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-600">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- JavaScript untuk Validasi Delete Modal -->
                            <script>
                                document.querySelector('form[action="{{ route('periode-audit.destroy', $periode->periode_id) }}"]')
                                    .addEventListener('submit', function(e) {
                                        const input = document.querySelector('#confirm_nama_periode_{{ $periode->periode_id }}');
                                        if (input.value !== '{{ $periode->nama_periode }}') {
                                            e.preventDefault();
                                            alert('Nama periode tidak cocok!');
                                        }
                                    });
                            </script>

                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-4 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data periode audit.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    @if (isset($periodeAudits) && $periodeAudits->total() > 0)
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            Showing {{ $periodeAudits->firstItem() }} to {{ $periodeAudits->lastItem() }} of
                            {{ $periodeAudits->total() }} results
                        </span>
                        <nav aria-label="Pagination">
                            <ul class="inline-flex -space-x-px text-sm">
                                <li>
                                    <a href="{{ $periodeAudits->previousPageUrl() }}"
                                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-l-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 {{ $periodeAudits->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }}">
                                        <x-heroicon-s-chevron-left class="w-4 h-4 mr-1" />
                                        Previous
                                    </a>
                                </li>
                                @foreach ($periodeAudits->getUrlRange(1, $periodeAudits->lastPage()) as $page => $url)
                                    <li>
                                        <a href="{{ $url }}"
                                            class="flex items-center justify-center px-3 h-8 leading-tight {{ $page == $periodeAudits->currentPage() ? 'text-sky-800 bg-sky-50 dark:bg-sky-900 dark:text-sky-200 border-sky-300 dark:border-sky-700' : 'text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200' }} border transition-all duration-200">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach
                                <li>
                                    <a href="{{ $periodeAudits->nextPageUrl() }}"
                                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 {{ $periodeAudits->hasMorePages() ? '' : 'cursor-not-allowed opacity-50' }}">
                                        Next
                                        <x-heroicon-s-chevron-right class="w-4 h-4 ml-1" />
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    @else
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            Tidak ada data untuk ditampilkan.
                        </span>
                    @endif
                </div>
            </div>
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
