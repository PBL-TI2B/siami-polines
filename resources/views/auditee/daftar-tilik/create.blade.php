@extends('layouts.app')

@section('title', 'Tambah Jawaban Daftar Tilik')

@section('content')
    <div class="max-w-3xl mx-auto py-6">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Daftar Tilik', 'url' => route('auditee.daftar-tilik.index')],
            ['label' => 'Tambah Jawaban Daftar Tilik', 'url' => '#'],
        ]" />

        <h1 class="text-2xl font-bold mb-4">Tambah Jawaban Daftar Tilik</h1>

        <!-- Flash Message Container -->
        <div id="flashMessage" class="hidden fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg"></div>

        <form id="tilikForm" method="POST" data-tilik-id={{ $tilik_id }} data-auditing-id=1>

            <!-- Kolom Realisasi -->
            <div class="mb-4">
                <label for="Realisasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Realisasi</label>
                <textarea name="Realisasi" id="Realisasi" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Realisasi..."></textarea>
            </div>

            <!-- Kolom Standar nasional -->
            <div class="mb-4">
                <label for="standar_nasional" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Standar Nasional/POLINES</label>
                <textarea name="standar_nasional" id="standar_nasional" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Standar Nasional..."></textarea>
            </div>

            <!-- Kolom Uraian Isian -->
            <div class="mb-4">
                <label for="uraian_isian" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Uraian Isian</label>
                <textarea name="uraian_isian" id="uraian_isian" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Uraian Isian..."></textarea>
            </div>

            <!-- Kolom Akar penyebab -->
            <div class="mb-4">
                <label for="akar_penyebab_penunjang" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Akar Penyebab (Target tidak tercapai)/ Akar Penunjang (Target tercapai)</label>
                <textarea name="akar_penyebab_penunjang" id="akar_penyebab_penunjang" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Akar Penyebab (Target tidak tercapai)/ Akar Penunjang (Target tercapai)..."></textarea>
            </div>

            <!-- Kolom Rencana Perbaikan -->
            <div class="mb-4">
                <label for="rencana_perbaikan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rencana Perbaikan & Tindak Lanjut</label>
                <textarea name="rencana_perbaikan" id="rencana_perbaikan" rows="4"
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('tilikForm');

            form.addEventListener('submit', async (e) => {
                e.preventDefault(); // Hindari submit bawaan

                const tilikId = form.dataset.tilikId;
                const auditingId = form.dataset.auditingId;

                const payload = {
                    auditing_id: parseInt(auditingId),
                    tilik_id: parseInt(tilikId),
                    realisasi: document.getElementById('Realisasi').value,
                    standar_nasional: document.getElementById('standar_nasional').value,
                    uraian_isian: document.getElementById('uraian_isian').value,
                    akar_penyebab_penunjang: document.getElementById('akar_penyebab_penunjang').value,
                    rencana_perbaikan_tindak_lanjut: document.getElementById('rencana_perbaikan').value,
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
                        showFlashMessage('Jawaban berhasil disimpan', 'bg-green-100 text-green-800');
                        form.reset();
                        setTimeout(() => {
                            window.location.href = '{{ route("auditee.daftar-tilik.index") }}';
                        }, 2000);
                    } else {
                        showFlashMessage('Gagal menyimpan: ' + (result.message || 'Terjadi kesalahan'), 'bg-red-100 text-red-800');
                    }

                } catch (error) {
                    showFlashMessage('Error jaringan: ' + error.message, 'bg-red-100 text-red-800');
                }
            });

            function showFlashMessage(message, classes) {
                const flash = document.getElementById('flashMessage');
                flash.textContent = message;
                flash.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${classes}`;
                flash.classList.remove('hidden');
                setTimeout(() => flash.classList.add('hidden'), 5000);
            }
        });
    </script>
@endsection