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

            <div class="ml-auto">
                <form method="GET" action="{{ route('admin.ploting-ami.index') }}" id="periodeFilterForm">
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
            'Link', 
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
                        <span
                            class="{{ $auditing->status == 10 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300' }} inline-flex rounded-full px-2 py-1 text-xs font-semibold">
                            {{ $statusLabels[$auditing->status] ?? 'Menunggu' }}
                        </span>
                    </td>
                    <td class="border border-gray-200 px-4 py-4 text-center">
                        @if (!empty($auditing->link))
                            <a href="{{ $auditing->link }}" target="_blank" class="text-blue-600 underline">{{ $auditing->link }}</a>
                        @else
                            <a href="#" class="text-sky-700 underline add-link-btn" data-id="{{ $auditing->auditing_id }}">Tambahkan Link</a>
                        @endif
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
                    <td colspan="11" class="py-4 text-center text-gray-500">
                        Tidak ada data audit.
                    </td>
                </tr>
            @endforelse
        </x-table>

        <!-- Modal Input Link -->
        <div id="modal-link" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900/50 transition-opacity duration-300">
            <div class="relative w-full max-w-md rounded-lg bg-white p-6 dark:bg-gray-800">
                <button type="button" id="close-link-modal" class="absolute right-4 top-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h2 class="mb-4 text-lg font-bold text-gray-900 dark:text-gray-100">Tambahkan Link</h2>
                <form id="form-link">
                    <input type="hidden" name="auditing_id" id="input-auditing-id">
                    <div class="mb-4">
                        <label for="input-link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Link</label>
                        <input type="url" name="link" id="input-link" class="w-full rounded border border-gray-300 px-3 py-2 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" required placeholder="https://...">
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" id="cancel-link-btn" class="px-4 py-2 rounded bg-gray-300 text-gray-800 hover:bg-gray-400">Batal</button>
                        <button type="submit" class="px-4 py-2 rounded bg-sky-700 text-white hover:bg-sky-800">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('modal-link');
                const closeModalBtn = document.getElementById('close-link-modal');
                const cancelBtn = document.getElementById('cancel-link-btn');
                const form = document.getElementById('form-link');
                let currentId = null;

                document.querySelectorAll('.add-link-btn').forEach(btn => {
                    btn.addEventListener('click', function (e) {
                        e.preventDefault();
                        currentId = this.dataset.id;
                        document.getElementById('input-auditing-id').value = currentId;
                        modal.classList.remove('hidden');
                    });
                });

                [closeModalBtn, cancelBtn].forEach(btn => {
                    btn.addEventListener('click', function () {
                        modal.classList.add('hidden');
                        form.reset();
                    });
                });

                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const auditingId = document.getElementById('input-auditing-id').value;
                    const link = document.getElementById('input-link').value;
                    fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ link })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success === true) {
                            // Update tampilan kolom link pada baris yang sesuai
                            const linkBtn = document.querySelector(`a.add-link-btn[data-id='${auditingId}']`);
                            if (linkBtn) {
                                const td = linkBtn.closest('td');
                                td.innerHTML = `<a href="${data.data.link}" target="_blank" class="text-blue-600 underline">${data.data.link}</a>`;
                            }
                            modal.classList.add('hidden');
                            form.reset();
                            window.location.reload(); // Reload page to reflect changes
                        } else {
                            alert('Gagal menyimpan link');
                        }
                    })
                    .catch(() => alert('Terjadi kesalahan'));
                });
            });
        </script>
        @endpush
    </div>
@endsection
