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
                        <a href="#" 
                            class="rtm-btn inline-flex items-center px-3 py-1 bg-sky-800 text-white rounded hover:bg-sky-900 text-xs" 
                            data-auditing-id="{{ $auditing->id }}" 
                            data-set-id="{{ $auditing->set_instrumen_unit_kerja_id ?? '' }}">
                            RTM
                        </a>
                    </td>
                </tr>

    <div id="response-modal"
        class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900/50 transition-opacity duration-300">
        <div class="relative max-h-[85vh] w-full max-w-2xl overflow-y-auto rounded-lg bg-white p-6 pb-6 dark:bg-gray-800">
            <button type="button" id="close-modal-btn"
                class="absolute right-4 top-4 text-gray-400 transition-colors duration-200 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 id="modal-title" class="mb-6 text-xl font-bold text-gray-900 dark:text-gray-100"></h2>
            <div class="flex justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-yellow-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
            </div>
            <h1 class="mb-4 text-center font-semibold text-gray-700 dark:text-gray-300">RTM (Rapat tinjauan Manajemen)</h1>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-6 text-center">
                Klik tombol selesai untuk menyelesaikan proses audit <br>
                <strong class="text-red-600">Tindakan ini tidak dapat dibatalkan.</strong>
            </p>
            <form id="response-form">
                <div class="space-y-6">
                    <div class="space-y-4">
                        <div>
                            <label for="luaran"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Luaran
                                {{-- <span class="text-gray-400">(Masukan Luaran)</span> --}}
                            </label>
                            <textarea required name="luaran" id="luaran"
                                class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                                rows="4" placeholder="Masukan Luaran"></textarea>
                            <span id="luaran-error" class="mt-1 hidden text-sm font-medium text-red-600"></span>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-center gap-2">
                    <x-button id="cancel-btn" type="button" color="gray" class="px-4 py-2 text-sm font-medium">
                        Batal
                    </x-button>
                    <x-button type="submit" id="submit-btn" color="sky" class="px-4 py-2 text-sm font-medium">
                        Selesai
                    </x-button>
                </div>
            </form>
        </div>
    </div>
            @empty
                <tr>
                    <td colspan="10" class="py-4 text-center text-gray-500">
                        Tidak ada data audit.
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>
    
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('response-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const rtmButtons = document.querySelectorAll('.rtm-btn');

        rtmButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                // Ambil data dari tombol
                const auditingId = 1;
                const setId = 1;

                // Set data ke input hidden modal (jika dibutuhkan)
                // document.getElementById('auditing_id').value = auditingId;
                // document.getElementById('set_instrumen_unit_kerja_id').value = setId;

                // Tampilkan modal
                modal.classList.remove('hidden');
            });
        });

        // Tombol tutup modal
        [closeModalBtn, cancelBtn].forEach(btn => {
            btn.addEventListener('click', function () {
                modal.classList.add('hidden');
            });
        });
    });
</script>

@endsection

