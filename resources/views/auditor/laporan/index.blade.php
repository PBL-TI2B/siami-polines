@extends('layouts.app')

@section('title', 'Daftar Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index', ['auditingId' => $auditingId])],
    ]" class="mb-6" />

    <!-- Heading -->
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-6">
        Daftar Laporan Temuan
    </h1>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
        Berikut adalah daftar laporan temuan untuk audit ini. Anda dapat menambahkan, mengedit, atau menghapus laporan temuan sesuai kebutuhan.
    </p>

    <!-- Toast Notifications -->
    @if (session('success'))
        <x-toast id="toast-success" type="success" :message="session('success')" />
    @endif

    @if (session('error') || $errors->any())
        <x-toast id="toast-danger" type="danger">
            @if (session('error'))
                {{ session('error') }}<br>
            @endif
            {{-- In index page, $errors->any() typically comes from a redirect with errors,
                 which is less common for a pure list view unless it's a delete operation.
                 But including it for completeness if any other action might redirect with errors. --}}
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </x-toast>
    @endif

    <!-- Toolbar -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-2">
            <x-button href="{{ route('auditor.laporan.create', ['auditingId' => $auditingId]) }}" color="sky" icon="heroicon-o-plus" class="shadow-md hover:shadow-lg transition-all">
                Tambah Laporan Temuan
            </x-button>
        </div>
    </div>

    <!-- Table and Pagination -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
        <!-- Table Controls -->
        <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 rounded-t-2xl border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                <form id="perPageForm" method="GET" action="{{ route('auditor.laporan.index', ['auditingId' => $auditingId]) }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select id="perPageSelect" name="per_page" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200" onchange="document.getElementById('perPageForm').submit()">
                        <option value="5" {{ request('per_page', $laporanTemuansPaginated->perPage()) == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page', $laporanTemuansPaginated->perPage()) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page', $laporanTemuansPaginated->perPage()) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', $laporanTemuansPaginated->perPage()) == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="text-sm text-gray-700 dark:text-gray-300">standar</span>
            </div>

            <div class="relative w-full sm:w-auto">
                <form id="search-form" method="GET" action="{{ route('auditor.laporan.index', ['auditingId' => $auditingId]) }}">
                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search" name="search" id="search-input" placeholder="Cari uraian temuan atau standar" value="{{ request('search') }}" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                    <tr>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">No</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Standar</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Uraian Temuan</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Kategori</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Saran Perbaikan</th>
                        <th scope="col" class="px-4 py-3 sm:px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    {{-- Menggunakan variabel baru: $laporanTemuansPaginated --}}
                    @if ($laporanTemuansPaginated->isEmpty())
                        <tr>
                            <td colspan="6" class="px-4 py-3 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                                Belum ada laporan temuan untuk audit ini.
                            </td>
                        </tr>
                    @else
                        @php
                            // Index global untuk nomor urut baris di seluruh paginasi
                            $globalNo = ($laporanTemuansPaginated->currentPage() - 1) * $laporanTemuansPaginated->perPage();
                        @endphp
                        {{-- Loop melalui SETIAP GRUP standar unik yang dipaginasi --}}
                        @foreach ($laporanTemuansPaginated as $group)
                            @php
                                $groupRowSpan = count($group['findings']); // Jumlah temuan dalam satu grup standar ini
                                $globalNo++; // Nomor urut untuk grup standar ini
                            @endphp
                            {{-- Loop melalui SETIAP FINDING dalam grup standar ini --}}
                            @foreach ($group['findings'] as $indexInGroup => $laporan)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                                    {{-- Kolom "No" hanya ditampilkan di baris pertama grup --}}
                                    @if ($indexInGroup === 0)
                                        <td rowspan="{{ $groupRowSpan }}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 align-top">
                                            {{ $globalNo }}
                                        </td>
                                    @endif

                                    {{-- Kolom "Standar" hanya ditampilkan di baris pertama grup --}}
                                    @if ($indexInGroup === 0)
                                        <td rowspan="{{ $groupRowSpan }}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 align-top">
                                            {{ $group['nama_kriteria'] }}
                                        </td>
                                    @endif

                                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">{{ $laporan['uraian_temuan'] ?? '-' }}</td>
                                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">{{ $laporan['kategori_temuan'] ?? '-' }}</td>
                                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">{{ $laporan['saran_perbaikan'] ?? '-' }}</td>

                                    <td class="px-4 py-3 sm:px-6">
                                        <div class="flex items-center gap-2">
                                            {{-- Link Edit --}}
                                            <a href="{{ route('auditor.laporan.edit', ['auditingId' => $auditingId, 'laporan_temuan_id' => $laporan['laporan_temuan_id']]) }}"
                                                class="text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-200 transition-colors duration-200">
                                                <x-heroicon-o-pencil class="w-5 h-5" />
                                            </a>
                                            {{-- Form Delete --}}
                                            <form action="{{ route('auditor.laporan.destroy', ['auditingId' => $auditingId, 'laporan_temuan_id' => $laporan['laporan_temuan_id']]) }}"
                                                method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan temuan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors duration-200">
                                                    <x-heroicon-o-trash class="w-5 h-5" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <span class="text-sm text-gray-700 dark:text-gray-300">
                    {{-- Menampilkan informasi paginasi berdasarkan paginator grup --}}
                    Menampilkan <strong>{{ $laporanTemuansPaginated->firstItem() }}</strong> hingga <strong>{{ $laporanTemuansPaginated->lastItem() }}</strong> dari <strong>{{ $laporanTemuansPaginated->total() }}</strong> standar
                </span>
                <nav aria-label="Navigasi Paginasi">
                    {{-- Render link paginasi untuk paginator grup --}}
                    {{ $laporanTemuansPaginated->links() }}
                </nav>
            </div>
        </div>
    </div>

    <!-- Action Buttons (Below Table) -->
    <div class="mt-6 flex gap-2 justify-start">
        <x-button href="{{ route('auditor.laporan.submit', ['auditingId' => $auditingId]) }}" color="sky" class="shadow-md hover:shadow-lg transition-all bg-blue-600 hover:bg-blue-700">
            Submit & Kunci Jawaban
        </x-button>
        <x-button href="{{ route('auditor.laporan.accept', ['auditingId' => $auditingId]) }}" color="green" class="shadow-md hover:shadow-lg transition-all bg-green-600 hover:bg-green-700">
            Diterima
        </x-button>
        <x-button href="{{ route('auditor.laporan.revise', ['auditingId' => $auditingId]) }}" color="yellow" class="shadow-md hover:shadow-lg transition-all bg-amber-600 hover:bg-amber-700">
            Revisi
        </x-button>
    </div>
</div>
@endsection
