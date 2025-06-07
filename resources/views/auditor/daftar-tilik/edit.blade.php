@extends('layouts.app')

@section('title', 'Edit Pertanyaan')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Buat Pertanyaan Daftar Tilik', 'url' => route('auditor.daftar-tilik.index')],
        ['label' => 'Edit Pertanyaan Daftar Tilik'],
    ]" />
    <h1 class="text-2xl font-bold mb-4">Edit Pertanyaan</h1>

    <!-- Flash Message Container -->
    <div id="flashMessage" class="hidden fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg"></div>

    <!-- Session-based Toast Notification -->
    @if (session('success'))
        <x-toast id="toast-success" type="success" :message="session('success')" />
    @endif

    <form id="tilikForm" method="POST" action="{{ route('auditor.daftar-tilik.index', $id) }}">
        @csrf
        @method('PUT')

        <!-- Dropdown Kriteria -->
        <div class="mb-4">
            <label for="kriteria" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kriteria</label>
            <select name="kriteria" id="kriteria"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                <option value="" disabled selected class="text-gray-400">Pilih Kriteria</option>
            </select>
        </div>

        <!-- Kolom lainnya -->
        <div class="mb-4">
            <label for="pertanyaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pertanyaan</label>
            <textarea name="pertanyaan" id="pertanyaan" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                placeholder="Masukkan pertanyaan...">{{ $tilik['pertanyaan'] ?? '' }}</textarea>
        </div>

        <div class="mb-4">
            <label for="indikator" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Indikator Kinerja Renstra & LKPS</label>
            <textarea name="indikator" id="indikator" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                placeholder="Masukkan Indikator...">{{ $tilik['indikator'] ?? '' }}</textarea>
        </div>

        <div class="mb-4">
            <label for="sumber_data" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sumber Bukti</label>
            <input type="text" name="sumber_data" id="sumber_data"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                placeholder="Masukkan bukti..." value="{{ $tilik['sumber_data'] ?? '' }}">
        </div>

        <div class="mb-4">
            <label for="metode_perhitungan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Metode Perhitungan</label>
            <input type="text" name="metode_perhitungan" id="metode_perhitungan"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                placeholder="Masukkan metode perhitungan..." value="{{ $tilik['metode_perhitungan'] ?? '' }}">
        </div>

        <div class="mb-4">
            <label for="target" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Target</label>
            <input type="text" name="target" id="target"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                placeholder="Masukkan target..." value="{{ $tilik['target'] ?? '' }}">
        </div>

        <div class="mt-3 flex gap-3">
            <x-button type="submit" color="sky" icon="heroicon-o-plus">
                Simpan
            </x-button>
            <x-button color="gray" icon="heroicon-o-x-mark" href="{{ route('auditor.daftar-tilik.index') }}">
                Batal
            </x-button>
        </div>
    </form>

    <!-- Response Message -->
    <div id="responseMessage" class="mt-4 hidden text-sm"></div>
</div>
<!-- Toast Notification -->
    <div id="responseToast" class="hidden fixed top-4 end-4 z-50 bg-transparent transition-opacity duration-300">
        <div class="w-full max-w-md p-4 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div id="toastIcon" class="inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-lg">
                    <svg id="toastSuccessIcon" class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <svg id="toastErrorIcon" class="w-5 h-5 hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m13 7-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <span class="sr-only">Toast Icon</span>
                </div>
                <div class="ms-3 text-sm font-normal text-gray-500 dark:text-gray-400" id="toastMessage">
                    Action completed.
                </div>
                <button type="button" id="closeToast" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Tutup">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('kriteria');

    const kriteriaList = [
        { id: 1, nama: "1. Visi, Misi, Tujuan, Strategi" },
        { id: 2, nama: "2. Tata Kelola, Tata Pamong, dan Kerjasama" },
        { id: 3, nama: "3. Mahasiswa" },
        { id: 4, nama: "4. Sumber Daya Manusia" },
        { id: 5, nama: "5. Keuangan, Sarana, dan Prasarana" },
        { id: 6, nama: "6. Pendidikan / Kurikulum dan Pembelajaran" },
        { id: 7, nama: "7. Penelitian" },
        { id: 8, nama: "8. Pengabdian Kepada Masyarakat" },
        { id: 9, nama: "9. Luaran Tridharma" }
    ];

    kriteriaList.forEach(k => {
        const option = document.createElement('option');
        option.value = k.id;
        option.textContent = k.nama;
        select.appendChild(option);
    });

    // Function to show toast notification
    function showToast(message, type = 'success') {
        const responseToast = document.getElementById('responseToast');
        const toastMessage = document.getElementById('toastMessage');
        const toastIcon = document.getElementById('toastIcon');
        const toastSuccessIcon = document.getElementById('toastSuccessIcon');
        const toastErrorIcon = document.getElementById('toastErrorIcon');

        // Update toast message
        toastMessage.textContent = message;

        // Update styling and icon based on type
        if (type === 'success') {
            toastIcon.classList.remove('text-red-500', 'bg-red-100', 'dark:text-red-200', 'dark:bg-red-800');
            toastIcon.classList.add('text-green-500', 'bg-green-100', 'dark:text-green-200', 'dark:bg-green-800');
            toastSuccessIcon.classList.remove('hidden');
            toastErrorIcon.classList.add('hidden');
        } else {
            toastIcon.classList.remove('text-green-500', 'bg-green-100', 'dark:text-green-200', 'dark:bg-green-800');
            toastIcon.classList.add('text-red-500', 'bg-red-100', 'dark:text-red-200', 'dark:bg-red-800');
            toastSuccessIcon.classList.add('hidden');
            toastErrorIcon.classList.remove('hidden');
        }

        // Show toast
        responseToast.classList.remove('hidden');

        // Auto-hide after 3 seconds
        setTimeout(() => {
            responseToast.classList.add('hidden');
        }, 3000);
    }

    // Close toast on button click
    document.getElementById('closeToast').addEventListener('click', () => {
        document.getElementById('responseToast').classList.add('hidden');
    });

    // Fetch existing data
    fetch('http://127.0.0.1:5000/api/tilik/{{ $id }}')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const tilik = data.data;
                document.getElementById('kriteria').value = tilik.kriteria_id || '';
                document.getElementById('pertanyaan').value = tilik.pertanyaan || '';
                document.getElementById('indikator').value = tilik.indikator || '';
                document.getElementById('sumber_data').value = tilik.sumber_data || '';
                document.getElementById('metode_perhitungan').value = tilik.metode_perhitungan || '';
                document.getElementById('target').value = tilik.target || '';
            } else {
                showToast(data.message || 'Gagal memuat data.', 'error');
            }
        })
        .catch(error => {
            showToast('Error fetching data: ' + error.message, 'error');
        });

    // Handle form submission
    document.getElementById('tilikForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Stop form default

        const payload = {
            kriteria_id: parseInt(document.getElementById('kriteria').value),
            pertanyaan: document.getElementById('pertanyaan').value,
            indikator: document.getElementById('indikator').value,
            sumber_data: document.getElementById('sumber_data').value,
            metode_perhitungan: document.getElementById('metode_perhitungan').value,
            target: document.getElementById('target').value
        };

        fetch('http://127.0.0.1:5000/api/tilik/{{ $id }}', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => {
            if (!res.ok) {
                throw new Error(`HTTP error! Status: ${res.status}`);
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                showToast(data.message || 'Data berhasil diperbarui.', 'success');
                // Redirect to trigger session-based toast
                setTimeout(() => {
                    window.location.href = "{{ route('auditor.daftar-tilik.index') }}";
                }, 3000);
            } else {
                showToast('Gagal update: ' + data.message, 'error');
            }
        })
        .catch(error => {
            showToast('Terjadi kesalahan: ' + error.message, 'error');
        });
    });
});
</script>
@endsection