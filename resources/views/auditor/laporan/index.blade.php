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
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-5">
        Daftar Laporan Temuan
    </h1>
    <p class="text-gray-600 dark:text-gray-400 mb-4">
        Berikut adalah daftar laporan temuan untuk audit ini. Anda dapat menambahkan, mengedit, atau menghapus laporan temuan sesuai kebutuhan.
    </p>
    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 rounded-lg text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 rounded-lg text-red-700 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <!-- Add New Button -->
    <div class="mb-4 flex gap-2">
        <x-button href="{{ route('auditor.laporan.create', ['auditingId' => $auditingId]) }}" color="sky" icon="heroicon-o-plus">
            Tambah Laporan Temuan
        </x-button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto mt-5 rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        @if (empty($laporanTemuans))
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                Belum ada laporan temuan untuk audit ini.
            </div>
        @else
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th scope="col" class="rounded-lg border-l border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">No</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Standar</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Uraian Temuan</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Kategori</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Saran Perbaikan</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($laporanTemuans as $index => $laporan)
                        @php
                            // Ensure $laporan is an array for safety
                            $laporan = is_array($laporan) ? $laporan : [];

                            // Get kriteria names (the API response has a 'kriterias' array inside each 'laporan')
                            $kriteria_names = isset($laporan['kriterias']) && is_array($laporan['kriterias'])
                                ? collect($laporan['kriterias'])->pluck('nama_kriteria')->filter()->implode(', ')
                                : 'Tidak ada kriteria';

                            // Ensure laporan_temuan_id exists for action links
                            $laporan_temuan_id = $laporan['laporan_temuan_id'] ?? null;
                        @endphp
                        @if ($laporan_temuan_id)
                            <tr>
                                <td class="px-4 py-2 sm:px-6">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 sm:px-6">{{ $kriteria_names }}</td>
                                <td class="px-4 py-2 sm:px-6">{{ $laporan['uraian_temuan'] ?? '-' }}</td>
                                <td class="px-4 py-2 sm:px-6">{{ $laporan['kategori_temuan'] ?? '-' }}</td>
                                <td class="px-4 py-2 sm:px-6">{{ $laporan['saran_perbaikan'] ?? '-' }}</td>
                                <td class="px-4 py-2 sm:px-6">
                                    <a href="{{ route('auditor.laporan.edit', ['auditingId' => $auditingId, 'laporan_temuan_id' => $laporan_temuan_id]) }}"
                                    class="inline-flex items-center rounded bg-blue-600 px-2 py-1 text-sm font-medium text-white hover:bg-blue-700">
                                        Edit
                                    </a>
                                    <form action="{{ route('auditor.laporan.destroy', ['auditingId' => $auditingId, 'laporan_temuan_id' => $laporan_temuan_id]) }}"
                                          method="POST"
                                          class="inline-block ml-2"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center rounded bg-red-800 px-2 py-1 text-sm font-medium text-white hover:bg-red-900">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Action Buttons (Directly Below Table) -->
    <div class="mb-4 flex gap-2 justify-start mt-6">
        <x-button href="#" color="sky" class="bg-blue-600 hover:bg-blue-700">
            Submit & Kunci Jawaban
        </x-button>
        <x-button href="#" color="green" class="bg-green-600 hover:bg-green-700">
            Diterima
        </x-button>
        <x-button href="#" color="yellow" class="bg-amber-700 hover:bg-amber-800">
            Revisi
        </x-button>
    </div>
</div>
@endsection
