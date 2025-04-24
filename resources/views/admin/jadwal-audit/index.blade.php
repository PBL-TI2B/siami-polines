@extends('layouts.app')

@section('title', 'Jadwal Audit')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">

    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => '#'],
        ['label' => 'Jadwal Audit', 'url' => '#'],
    ]" />

    <!-- Heading -->
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
        Jadwal Audit
    </h1>

    <!-- Tombol Aksi -->
    <div class="flex flex-wrap items-center gap-2 mb-4">
        <a href="{{ route('jadwal-audit.create') }}" class="bg-sky-800 text-white px-5 py-2.5 rounded hover:bg-sky-900 inline-flex items-center text-sm font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Data
        </a>

        <a href="{{ route('jadwal-audit.download') }}" class="bg-sky-800 text-white px-5 py-2.5 rounded hover:bg-sky-900 inline-flex items-center text-sm font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
            </svg>
            Unduh Data
        </a>

        <form action="{{ route('jadwal-audit.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset semua jadwal audit?')">
    @csrf
    <button type="submit" class="bg-red-600 text-white px-5 py-2.5 rounded hover:bg-red-700 inline-flex items-center text-sm font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 4v6h6M20 20v-6h-6M4 14a8 8 0 0114-6.32M20 10a8 8 0 01-14 6.32"/>
        </svg>
        Reset Semua Jadwal
    </button>
</form>

        <div class="ml-auto">
            <select id="periodeFilter"
                class="border border-gray-300 rounded-md px-4 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                <option value="">Pilih Periode AMI</option>
            </select>
        </div>
    </div>

    <x-table
    id="jadwalAuditTable"
    :headers="['', 'No', 'Unit Kerja', 'Waktu Audit', 'Auditee', 'Auditee 2', 'Auditor 1', 'Auditor 2', 'Status','Aksi']"
    :data="$auditings"
    :perPage="$auditings->perPage()"
    :route="route('jadwal-audit.index')">

    @forelse ($auditings as $index => $auditing)
        <tr class="bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
            <td class="px-4 py-4 border border-gray-200">
                <input type="checkbox" class="w-4 h-4 text-sky-800 bg-gray-100 border-gray-200 rounded">
            </td>
            <td class="px-4 py-4 border border-gray-200">
                {{ $auditings->firstItem() + $index }}
            </td>
            <td class="px-4 py-4 border border-gray-200">
                {{ $auditing->unitKerja->nama_unit_kerja ?? 'N/A' }}
            </td>
            <td class="px-4 py-4 border border-gray-200">
                {{ $auditing->periode->tanggal_mulai ? \Carbon\Carbon::parse($auditing->periode->waktu_audit)->format('d F Y') : 'N/A' }}
            </td>
            <td class="px-4 py-4 border border-gray-200">
    {{ $auditing->auditee1->nama ?? 'N/A' }}
</td>
<td class="px-4 py-4 border border-gray-200">
    {{ $auditing->auditee2->nama ?? '-' }}
</td>
<td class="px-4 py-4 border border-gray-200">
    {{ $auditing->auditor1->nama ?? 'N/A' }}
</td>
<td class="px-4 py-4 border border-gray-200">
    {{ $auditing->auditor2->nama ?? '-' }}
</td>
            <td class="px-4 py-4 border border-gray-200">
                <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full
                    {{ $auditing->status == 'Selesai' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300' }}">
                    {{ $auditing->status ?? 'Menunggu' }}
                </span>
            </td>

            <x-table-row-actions :actions="[
                [
                    'label' => 'Edit',
                    'color' => 'sky',
                    'icon' => 'heroicon-o-pencil',
                    'href' => route('jadwal-audit.edit', $auditing->auditing_id),
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
        <x-confirmation-modal
            id="delete-jadwal-modal-{{ $auditing->auditing_id }}"
            title="Konfirmasi Hapus Jadwal"
            :action="route('jadwal-audit.destroy', $auditing->auditing_id)"
            method="DELETE"
            type="delete"
            formClass="delete-modal-form"
            :itemName="$auditing->unitKerja->nama ?? 'Jadwal'"
            :warningMessage="'Menghapus jadwal ini akan menghapus seluruh data audit yang terkait.'"
        />
    @empty
        <tr>
            <td colspan="10" class="text-center text-gray-500 py-4">
                Tidak ada data jadwal audit.
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
