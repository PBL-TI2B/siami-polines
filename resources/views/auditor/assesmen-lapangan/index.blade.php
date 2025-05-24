@extends('layouts.app')

@section('title', 'Asesmen Lapangan')

{{-- @if(session('user'))
    <meta name="user-id" content="{{ session('user')['user_id'] }}">
@endif --}}

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[['label' => 'Assesmen Lapangan', 'url' => route('auditor.assesmen-lapangan.index')]]" />

    <!-- Page Title -->
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
        Jadwal Audit
    </h1>

    <x-table id="jadwalAuditTable" :headers="[
            'No',
            'Unit Kerja',
            'Waktu Audit',
            'Auditee',
            'Auditee 2',
            'Auditor 1',
            'Auditor 2',
            'Status',
            'Aksi',
        ]" :data="$auditings" :perPage="$auditings->perPage()" :route="route('auditor.assesmen-lapangan.index')">

            @forelse ($auditings as $index => $auditing)
                <tr
                    class="border-y border-gray-200 bg-white transition-all duration-200 hover:bg-gray-50 dark:border-gray-500 dark:bg-gray-800 dark:hover:bg-gray-600">
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
                            'href' => route('auditor.assesmen-lapangan.edit', $auditing->auditing_id),
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
                {{-- <x-confirmation-modal id="delete-jadwal-modal-{{ $auditing->auditing_id }}" title="Konfirmasi Hapus Jadwal"
                    :action="route('auditor.assesmen-lapangan.destroy', $auditing->auditing_id)" method="DELETE" type="delete" formClass="delete-modal-form" :warningMessage="'Menghapus jadwal ini akan menghapus seluruh data audit yang terkait.'" /> --}}
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
