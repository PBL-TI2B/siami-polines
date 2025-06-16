```blade
@extends('layouts.app')

@section('title', 'Daftar Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index', ['auditingId' => $auditingId])],
    ]" class="mb-6" />

    <!-- Heading -->
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
        Daftar Laporan Temuan
    </h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        Berikut adalah daftar laporan temuan untuk audit: {{ $auditing->nama_audit ?? 'Audit ID ' . $auditingId }}.
    </p>

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 rounded-lg text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Add New Button -->
    <div class="mb-6 flex gap-2">
        <x-button href="{{ route('auditor.laporan.create', ['auditingId' => $auditingId]) }}" color="sky" icon="heroicon-o-plus">
            Tambah Laporan Temuan
        </x-button>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if ($laporanTemuans->isEmpty())
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                Belum ada laporan temuan untuk audit ini.
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Standar</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Uraian Temuan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Saran Perbaikan</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($laporanTemuans as $laporan)
                        @php
                            $uraian_temuans = explode(',', $laporan->uraian_temuan);
                            $kategori_temuans = explode(',', $laporan->kategori_temuan);
                            $saran_perbaikans = explode(',', $laporan->saran_perbaikan);
                            $kriteria_names = $laporan->kriterias->pluck('nama_kriteria')->implode(', ');
                        @endphp
                        @foreach ($uraian_temuans as $index => $uraian)
                            <tr>
                                @if ($index == 0)
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100" rowspan="{{ count($uraian_temuans) }}">{{ $kriteria_names ?: 'Tidak ada kriteria' }}</td>
                                @endif
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ str_replace(';', ',', $uraian) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $kategori_temuans[$index] ?? 'NC' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ str_replace(';', ',', $saran_perbaikans[$index] ?? '') }}</td>
                                @if ($index == 0)
                                    <td class="px-6 py-4 text-right text-sm font-medium" rowspan="{{ count($uraian_temuans) }}">
                                        <a href="{{ route('auditor.laporan.edit', ['laporan_temuan_id' => $laporan->laporan_temuan_id]) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-4">Edit</a>
                                        <form action="{{ route('auditor.laporan.destroy', ['laporan_temuan_id' => $laporan->laporan_temuan_id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
```
