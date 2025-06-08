@extends('layouts.app')

@section('title', 'Ploting AMI')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => '#'], ['label' => 'Ploting AMI', 'url' => '#']]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Ploting AMI
        </h1>

        <!-- Tombol Aksi -->
        <div class="mb-4 flex flex-wrap items-center gap-2">
            <form method="GET" action="{{ route('kepala-pmpp.ploting-ami.index') }}" id="periodeFilterForm">
                <select name="periode_id" id="periodeFilter"
                    class="appearance-none rounded-md border border-gray-300 px-4 py-2 pr-10 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    onchange="document.getElementById('periodeFilterForm').submit()">
                    <option value="">Pilih Periode AMI</option>
                    @foreach ($periodes as $periode)
                        <option value="{{ $periode->periode_id }}" {{ (isset($periodeId) && $periodeId == $periode->periode_id) ? 'selected' : '' }}>
                            {{ $periode->nama_periode ?? 'Periode '.$periode->periode_id }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @php
            $statusLabels = [
                1 => 'Pengisian Instrumen',
                2 => 'Desk Evaluation',
                3 => 'Penjadwalan AL',
                4 => 'Pertanyaan Tilik',
                5 => 'Tilik Dijawab',
                6 => 'Laporan Temuan',
                7 => 'Revisi',
                8 => 'Sudah revisi',
                9 => 'Closing',
                10 => 'Selesai',
            ];
        @endphp

        <x-table id="jadwalAuditTable" :headers="[
            '',
            'No',
            'Unit Kerja',
            'Waktu Audit',
            'Auditee 1',
            'Auditee 2',
            'Auditor 1',
            'Auditor 2',
            'Status',
            'Aksi',
        ]" :data="$auditings" :perPage="$auditings->perPage()" :route="route('kepala-pmpp.ploting-ami.index')">
            @forelse ($auditings as $index => $auditing)
                <tr class="border-y border-gray-200 bg-white transition-all duration-200 hover:bg-gray-50 dark:border-gray-500 dark:bg-gray-800 dark:hover:bg-gray-600">
                    <td class="border border-gray-200 px-4 py-4">
                        <input type="checkbox" class="h-4 w-4 rounded border-gray-200 bg-gray-100 text-sky-800">
                    </td>
                    <td class="border border-gray-200 px-4 py-4">
                        {{ $auditings->firstItem() + $index }}
                    </td>
                    <td class="border border-gray-200 px-4 py-4">
                        {{ $auditing->unitKerja->nama_unit_kerja ?? 'N/A' }}
                    </td>
                    <td class="border border-gray-200 px-4 py-4">
                        {{ $auditing->jadwal_audit ? \Carbon\Carbon::parse($auditing->jadwal_audit)->format('d F Y') : 'N/A' }}
                    </td>
                    <td class="border border-gray-200 px-4 py-4">
                        {{ $auditing->auditee1->nama ?? 'N/A' }}
                    </td>
                    <td class="border border-gray-200 px-4 py-4">
                        {{ $auditing->auditee2->nama ?? '-' }}
                    </td>
                    <td class="border border-gray-200 px-4 py-4">
                        {{ $auditing->auditor1->nama ?? 'N/A' }}
                    </td>
                    <td class="border border-gray-200 px-4 py-4">
                        {{ $auditing->auditor2->nama ?? '-' }}
                    </td>
                    <td class="border border-gray-200 px-4 py-4 text-center">
                        <span class="{{ $auditing->status == 10 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300' }} inline-flex rounded-full px-2 py-1 text-xs font-semibold">
                            {{ $statusLabels[$auditing->status] ?? 'Menunggu' }}
                        </span>
                    </td>
                    <td class="border border-gray-200 px-4 py-4 text-center">
                        <a href="#" class="inline-flex items-center px-3 py-1 bg-sky-800 text-white rounded hover:bg-sky-900 text-xs">RTM</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="py-4 text-center text-gray-500">
                        Tidak ada data audit.
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>
@endsection

@push('scripts')
    <script>
        // Placeholder JS
    </script>
@endpush