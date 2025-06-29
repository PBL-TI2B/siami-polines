@extends('layouts.app')

@section('title', 'Tambah Jawaban Daftar Tilik')

@section('content')
    <div class="mx-auto max-w-3xl py-6">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            [
                'label' => 'Daftar Tilik',
                'url' => route('auditee.daftar-tilik.index', ['auditingId' => session('auditing_id')]),
            ],
            ['label' => 'Tambah Response Daftar Tilik'],
        ]" />

        <h1 class="mb-4 text-2xl font-bold">Tambah Jawaban Daftar Tilik</h1>

        <form id="tilikForm" method="POST">
            <!-- Kolom Realisasi -->
            <div class="mb-4">
                <label for="Realisasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Realisasi</label>
                <textarea required name="Realisasi" id="Realisasi" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="Masukkan Realisasi..."></textarea>
            </div>

            <!-- Kolom Standar nasional -->
            <div class="mb-4">
                <label for="standar_nasional" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Standar
                    Nasional/POLINES</label>
                <textarea required name="standar_nasional" id="standar_nasional" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="Masukkan Standar Nasional..."></textarea>
            </div>

            <!-- Kolom Uraian Isian -->
            <div class="mb-4">
                <label for="uraian_isian" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Uraian
                    Isian</label>
                <textarea required name="uraian_isian" id="uraian_isian" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="Masukkan Uraian Isian..."></textarea>
            </div>

            <!-- Kolom Akar penyebab -->
            <div class="mb-4">
                <label for="akar_penyebab_penunjang" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Akar
                    Penyebab (Target tidak tercapai)/ Akar Penunjang (Target tercapai)</label>
                <textarea required name="akar_penyebab_penunjang" id="akar_penyebab_penunjang" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="Masukkan Akar Penyebab (Target tidak tercapai)/ Akar Penunjang (Target tercapai)..."></textarea>
            </div>

            <!-- Kolom Rencana Perbaikan -->
            <div class="mb-4">
                <label for="rencana_perbaikan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rencana
                    Perbaikan & Tindak Lanjut</label>
                <textarea required name="rencana_perbaikan" id="rencana_perbaikan" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="Masukkan Rencana Perbaikan & Tindak Lanjut..."></textarea>
            </div>

            <!-- Kolom Tindakan Pencegahan -->
            <div class="mb-4">
                <label for="tindakan_pencegahan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tindakan
                    Pencegahan</label>
                <textarea required name="tindakan_pencegahan" id="tindakan_pencegahan" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                    placeholder="Masukkan Tindakan Pencegahan..."></textarea>
            </div>

            <div class="mt-3 flex gap-3">
                <x-button type="submit" color="sky" icon="heroicon-o-plus">
                    Simpan
                </x-button>
                <x-button color="gray" icon="heroicon-o-x-mark"
                    href="{{ route('auditee.daftar-tilik.index', ['auditingId' => session('auditing_id')]) }}">
                    Batal
                </x-button>
            </div>
        </form>

        <!-- Response Message -->
        <div id="responseMessage" class="mt-4 hidden text-sm"></div>
    </div>
    <!-- Modal Toast -->
    <div id="responseModal" class="fixed end-4 top-4 hidden bg-transparent transition-opacity duration-300">
        <div class="w-full max-w-md rounded-lg bg-white p-4 shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div id="modalIcon" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg">
                    <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="sr-only">Ikon Sukses</span>
                </div>
                <div class="ms-3 text-sm font-normal text-gray-500 dark:text-gray-400" id="modalMessage">
                    Action completed successfully.
                </div>
                <button type="button" id="closeResponseModal"
                    class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white"
                    aria-label="Tutup">
                    <span class="sr-only">Tutup</span>
                    <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('tilikForm');

            form.addEventListener('submit', async (e) => {
                e.preventDefault(); // Prevent default form submission

                const tilikId = {{ $tilik_id }};
                const auditingId = {{ session('auditing_id') ?? 'null' }};

                const payload = {
                    auditing_id: parseInt(auditingId),
                    tilik_id: parseInt(tilikId),
                    realisasi: document.getElementById('Realisasi').value,
                    standar_nasional: document.getElementById('standar_nasional').value,
                    uraian_isian: document.getElementById('uraian_isian').value,
                    akar_penyebab_penunjang: document.getElementById('akar_penyebab_penunjang')
                        .value,
                    rencana_perbaikan_tindak_lanjut: document.getElementById('rencana_perbaikan')
                        .value,
                    tindakan_pencegahan: document.getElementById('tindakan_pencegahan').value
                };

                try {
                    const response = await fetch('http://127.0.0.1:5000/api/response-tilik', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    });

                    const result = await response.json();

                    if (response.ok) {
                        showToast('Jawaban berhasil disimpan', true);
                        form.reset();
                        setTimeout(() => {
                            window.location.href =
                                '{{ route('auditee.daftar-tilik.index', ['auditingId' => session('auditing_id')]) }}';
                        }, 2000);
                    } else {
                        showToast('Gagal menyimpan: ' + (result.message || 'Terjadi kesalahan'), false);
                    }
                } catch (error) {
                    showToast('Error jaringan: ' + error.message, false);
                }
            });

            function showToast(message, isSuccess) {
                const modal = document.getElementById('responseModal');
                const messageElement = document.getElementById('modalMessage');
                const iconElement = document.getElementById('modalIcon');

                if (modal && messageElement && iconElement) {
                    // Set the message
                    messageElement.textContent = message;

                    // Set the icon based on success or failure
                    iconElement.innerHTML = isSuccess ?
                        `<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                    </svg>
                    <span class="sr-only">Ikon Sukses</span>` :
                        `<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 10 4 4m0 6 6 6m6-6-6-6m0 12 6-6"/>
                    </svg>
                    <span class="sr-only">Ikon Gagal</span>`;

                    // Set modal classes based on success or failure
                    const modalClasses = isSuccess ?
                        'bg-green-100 text-green-800 dark:text-green-100' :
                        'bg-red-100 text-red-800 dark:text-red-100';
                    modal.className =
                        `fixed top-4 end-4 z-50 rounded-md shadow-lg transition-opacity duration-300 ${modalClasses}`;

                    // Show the modal
                    modal.classList.remove('hidden');

                    // Add close button functionality
                    const closeButton = document.getElementById('closeResponseModal');
                    closeButton.addEventListener('click', () => {
                        modal.classList.add('opacity-0');
                        setTimeout(() => modal.classList.add('hidden'), 300);
                    });

                    // Auto-hide after 5 seconds
                    setTimeout(() => {
                        modal.classList.add('opacity-0');
                        setTimeout(() => modal.classList.add('hidden'), 300); // Wait for fade-out animation
                    }, 3000);
                } else {
                    console.error('Modal, message, or icon element not found');
                }
            }
        });
    </script>
@endsection
