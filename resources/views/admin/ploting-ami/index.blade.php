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
            <a href="{{ route('admin.ploting-ami.create') }}"
                class="inline-flex items-center rounded bg-sky-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-sky-900">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Data
            </a>

            <a href="{{ route('admin.ploting-ami.download') }}"
                class="inline-flex items-center rounded bg-sky-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-sky-900">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                </svg>
                Unduh Data
            </a>

            <!-- Tombol Reset Semua Jadwal -->
            <button type="button"
                class="inline-flex items-center rounded bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700"
                data-modal-target="reset-jadwal-modal" data-modal-toggle="reset-jadwal-modal">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 4v6h6M20 20v-6h-6M4 14a8 8 0 0114-6.32M20 10a8 8 0 01-14 6.32" />
                </svg>
                Reset Semua Ploting
            </button>

            <!-- Modal Reset Semua Jadwal -->
            <x-reset-jadwal-modal id="reset-jadwal-modal" :action="route('admin.ploting-ami.reset')"
                warningMessage="Reset ini akan menghapus seluruh data jadwal audit yang telah dibuat." />


            <div class="ml-auto">
                <select id="periodeFilter"
                    class="appearance-none rounded-md border border-gray-300 px-4 py-2 pr-10 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Periode AMI</option>
                </select>
            </div>
        </div>

        <x-table id="jadwalAuditTable" :headers="[
            '',
            'No',
            'Unit Kerja',
            'Waktu Audit',
            'Auditee',
            'Auditee 2',
            'Auditor 1',
            'Auditor 2',
            'Status',
            'Aksi',
        ]" :data="$auditings" :perPage="$auditings->perPage()" :route="route('admin.ploting-ami.index')">

            @forelse ($auditings as $index => $auditing)
                <tr
                    class="border-y border-gray-200 bg-white transition-all duration-200 hover:bg-gray-50 dark:border-gray-500 dark:bg-gray-800 dark:hover:bg-gray-600">
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
                        {{ $auditing->periode->tanggal_mulai ? \Carbon\Carbon::parse($auditing->periode->waktu_audit)->format('d F Y') : 'N/A' }}
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
                    <td class="border border-gray-200 px-4 py-4">
                        <span
                            class="{{ $auditing->status == 'Selesai' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300' }} inline-flex rounded-full px-2 py-1 text-xs font-semibold">
                            {{ $auditing->status ?? 'Menunggu' }}
                        </span>
                    </td>

                    <x-table-row-actions :actions="[
                        [
                            'label' => 'Edit',
                            'color' => 'sky',
                            'icon' => 'heroicon-o-pencil',
                            'href' => route('admin.ploting-ami.edit', $auditing->auditing_id),
                        ],
                        [
                            'label' => 'Hapus',
                            'color' => 'red',
                            'icon' => 'heroicon-o-trash',
                            'modalId' => 'delete-jadwal-modal-' . $auditing->auditing_id,
                        ],
                    ]" />
                </tr>

                <!-- Modal Hapus -->
                <x-confirmation-modal id="delete-jadwal-modal-{{ $auditing->auditing_id }}" title="Konfirmasi Hapus Jadwal"
                    :action="route('admin.ploting-ami.destroy', $auditing->auditing_id)" method="DELETE" type="delete" formClass="delete-modal-form" :warningMessage="'Menghapus jadwal ini akan menghapus seluruh data audit yang terkait.'" />
            @empty
                <tr>
                    <td colspan="10" class="py-4 text-center text-gray-500">
                        Tidak ada data audit.
                    </td>
                </tr>
            @endforelse
        </x-table>
    @endsection

    @push('scripts')
        <script>
            // Placeholder JS
        </script>
    @endpush
