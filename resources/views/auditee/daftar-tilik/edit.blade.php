@extends('layouts.app')

@section('title', 'Edit Jawaban Daftar Tilik')

@section('content')
    <div class="max-w-3xl mx-auto py-6">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditor.audit.index')],
            ['label' => 'Daftar Tilik', 'url' => route('auditee.daftar-tilik.index')],
            ['label' => 'Edit Response Daftar Tilik'],
        ]" />
        <h1 class="text-2xl font-bold mb-4">Edit Jawaban Daftar Tilik</h1>

        <form id="tilikForm" method="POST">
        @csrf
        @method('PUT')

            <!-- Kolom Realisasi -->
            <div class="mb-4">
                <label for="Realisasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Realisasi</label>
                <textarea required name="Realisasi" id="Realisasi" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Realisasi..."></textarea>
            </div>

            <!-- Kolom Standar nasional -->
            <div class="mb-4">
                <label for="standar_nasional" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Standar Nasional/POLINES</label>
                <textarea required name="standar_nasional" id="standar_nasional" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Standar Nasional..."></textarea>
            </div>

            <!-- Kolom Uraian Isian -->
            <div class="mb-4">
                <label for="uraian_isian" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Uraian Isian</label>
                <textarea required name="uraian_isian" id="uraian_isian" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Uraian Isian..."></textarea>
            </div>

            <!-- Kolom Akar penyebab -->
            <div class="mb-4">
                <label for="akar_penyebab_penunjang" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Akar Penyebab (Target tidak tercapai)/ Akar Penunjang (Target tercapai)</label>
                <textarea required name="akar_penyebab_penunjang" id="akar_penyebab_penunjang" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Akar Penyebab (Target tidak tercapai)/ Akar Penunjang (Target tercapai)..."></textarea>
            </div>

            <!-- Kolom Rencana Perbaikan -->
            <div class="mb-4">
                <label for="rencana_perbaikan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rencana Perbaikan & Tindak Lanjut</label>
                <textarea required name="rencana_perbaikan" id="rencana_perbaikan" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Rencana Perbaikan & Tindak Lanjut..."></textarea>
            </div>

            <div class="mt-3 flex gap-3">
                <x-button type="submit" color="sky" icon="heroicon-o-plus">
                    Simpan
                </x-button>
                <x-button color="gray" icon="heroicon-o-x-mark" href="{{ route('auditee.daftar-tilik.index') }}">
                    Batal
                </x-button>
            </div>
        </form>

        <!-- Response Message -->
        <div id="responseMessage" class="mt-4 hidden text-sm"></div>
    </div>
    <!-- Modal Toast -->
    <div id="responseModal" class="hidden fixed top-4 end-4 z-50 bg-transparent transition-opacity duration-300">
        <div class="w-full max-w-md p-4 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div id="modalIcon" class="inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-lg">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="sr-only">Ikon Sukses</span>
                </div>
                <div class="ms-3 text-sm font-normal text-gray-500 dark:text-gray-400" id="modalMessage">
                    Action completed successfully.
                </div>
                <button type="button" id="closeResponseModal" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Tutup">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('tilikForm');
        const responseModal = document.getElementById('responseModal');
        const modalIcon = document.getElementById('modalIcon');
        const modalMessage = document.getElementById('modalMessage');
        const closeResponseModal = document.getElementById('closeResponseModal');

        let auditingId = null;
        let tilikId = null;

        // Ambil data awal
        fetch(`http://127.0.0.1:5000/api/response-tilik/{{ $id }}`)
        .then(response => response.json())
        .then(data => {
            if (data && data.response_tilik_id) {
                auditingId = data.auditing_id;
                tilikId = data.tilik_id;
                document.getElementById('Realisasi').value = data.realisasi || '';
                document.getElementById('standar_nasional').value = data.standar_nasional || '';
                document.getElementById('uraian_isian').value = data.uraian_isian || '';
                document.getElementById('akar_penyebab_penunjang').value = data.akar_penyebab_penunjang || '';
                document.getElementById('rencana_perbaikan').value = data.rencana_perbaikan_tindak_lanjut || '';
            } else {
                showModalToast('bg-red-500', 'text-gray-900', 'Data tidak ditemukan.', false);
            }
        })
        .catch(error => {
            showModalToast('bg-red-500', 'text-gray-900', 'Gagal mengambil data: ' + error.message, false);
        });

        // Submit form
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const payload = {
                auditing_id: auditingId,
                tilik_id: tilikId,
                realisasi: document.getElementById('Realisasi').value,
                standar_nasional: document.getElementById('standar_nasional').value,
                uraian_isian: document.getElementById('uraian_isian').value,
                akar_penyebab_penunjang: document.getElementById('akar_penyebab_penunjang').value,
                rencana_perbaikan_tindak_lanjut: document.getElementById('rencana_perbaikan').value
            };

            // For form submission
            fetch(`http://127.0.0.1:5000/api/response-tilik/{{ $id }}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showModalToast('bg-green-500', 'text-gray-900', 'Data berhasil diperbarui!', true);
                        setTimeout(() => {
                            window.location.href = '{{ route("auditee.daftar-tilik.index") }}';
                        }, 2000);
                    } else {
                        showModalToast('bg-red-500', 'text-gray-900', data.message || 'Gagal memperbarui data.', false);
                    }
                })
                .catch(error => {
                    showModalToast('bg-red-500', 'text-gray-900', 'Error: ' + error.message, false);
                });
        });

        function showModalToast(iconBgClass, textClass, message, isSuccess = true) {
            // Remove existing classes from modalIcon
            modalIcon.classList.remove('bg-green-500', 'bg-red-500', 'text-white');
            // Add background and text color for icon
            modalIcon.classList.add(iconBgClass, 'text-white');
            
            // Update the icon based on success or error
            const iconSvg = modalIcon.querySelector('svg');
            if (isSuccess) {
                iconSvg.innerHTML = '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />';
            } else {
                iconSvg.innerHTML = '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />';
            }
            
            // Update message text and class
            modalMessage.className = `ms-3 text-sm font-normal ${textClass}`;
            modalMessage.textContent = message;
            
            // Show the modal
            responseModal.classList.remove('hidden');
            
            // Hide the modal after 3 seconds
            setTimeout(() => {
                responseModal.classList.add('hidden');
            }, 3000);
        }

        // Close modal when close button is clicked
        closeResponseModal.addEventListener('click', () => {
            responseModal.classList.add('hidden');
        });
    });
</script>
@endsection