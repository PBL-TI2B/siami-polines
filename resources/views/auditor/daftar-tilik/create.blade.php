@extends('layouts.app')

@section('title', 'Tambah Pertanyaan Tilik')

@section('content')
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Tambah Pertanyaan Tilik</h1>

        <!-- Flash Message Container -->
        <div id="flashMessage" class="hidden fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg"></div>

        <form id="tilikForm" method="POST">
            <!-- Dropdown Kriteria -->
            <div class="mb-4">
                <label for="kriteria" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kriteria</label>
                <select name="kriteria" id="kriteria"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="" disabled selected class="text-gray-400">Pilih Kriteria</option>
                </select>
            </div>

            <!-- Kolom Pertanyaan -->
            <div class="mb-4">
                <label for="pertanyaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pertanyaan</label>
                <textarea name="pertanyaan" id="pertanyaan" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan pertanyaan..."></textarea>
            </div>

            <!-- Kolom Indikator -->
            <div class="mb-4">
                <label for="indikator" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Indikator Kinerja Renstra & LKPS</label>
                <textarea name="indikator" id="indikator" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Indikator..."></textarea>
            </div>

            <!-- Kolom Sumber Data -->
            <div class="mb-4">
                <label for="sumber_data" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sumber Bukti</label>
                <input type="text" name="sumber_data" id="sumber_data"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan bukti...">
            </div>

            <!-- Kolom Metode Perhitungan -->
            <div class="mb-4">
                <label for="metode_perhitungan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Metode Perhitungan</label>
                <input type="text" name="metode_perhitungan" id="metode_perhitungan"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan metode perhitungan...">
            </div>

            <!-- Kolom Target -->
            <div class="mb-4">
                <label for="target" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Target</label>
                <input type="text" name="target" id="target"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan target...">
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
        // Fetch Kriteria Data on Page Load
        async function loadKriteria() {
            const kriteriaSelect = document.getElementById('kriteria');
            try {
                const response = await fetch('http://127.0.0.1:5000/api/kriteria', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Failed to fetch kriteria data');
                }

                const kriterias = await response.json();

                // Clear existing options except the placeholder
                kriteriaSelect.innerHTML = '<option value="" disabled selected classbtn btn-sm btn-success text-gray-400">Pilih Kriteria</option>';

                // Populate dropdown with kriteria data
                kriterias.forEach(kriteria => {
                    const option = document.createElement('option');
                    option.value = kriteria.kriteria_id; // Use kriteria_id as the value
                    // Use nama_kriteria if available, otherwise fallback to "Kriteria {nomor}"
                    option.textContent = kriteria.nama_kriteria || `Kriteria ${kriteria.nomor}`;
                    kriteriaSelect.appendChild(option);
                });
            } catch (error) {
                // Display error message using modal toast
                showFlashMessage('Error loading kriteria: ' + error.message, 'error');
            }
        }

        // Function to show modal toast
        function showFlashMessage(message, type = 'success') {
            const responseModal = document.getElementById('responseModal');
            const modalMessage = document.getElementById('modalMessage');
            const modalIcon = document.getElementById('modalIcon');

            // Update modal message
            modalMessage.textContent = message;

            // Update styling based on type
            if (type === 'success') {
                modalIcon.classList.remove('text-red-500', 'bg-red-100', 'dark:text-red-200', 'dark:bg-red-800');
                modalIcon.classList.add('text-green-500', 'bg-green-100', 'dark:text-green-200', 'dark:bg-green-800');
            } else {
                modalIcon.classList.remove('text-green-500', 'bg-green-100', 'dark:text-green-200', 'dark:bg-green-800');
                modalIcon.classList.add('text-red-500', 'bg-red-100', 'dark:text-red-200', 'dark:bg-red-800');
            }

            // Show modal
            responseModal.classList.remove('hidden');

            // Auto-hide after 3 seconds
            setTimeout(() => {
                responseModal.classList.add('hidden');
            }, 3000);
        }

        // Close modal on button click
        document.getElementById('closeResponseModal').addEventListener('click', () => {
            document.getElementById('responseModal').classList.add('hidden');
        });

        // Handle Form Submission
        document.getElementById('tilikForm').addEventListener('submit', async function (event) {
            event.preventDefault(); // Prevent default form submission

            // Collect form data
            const formData = {
                kriteria_id: document.getElementById('kriteria').value,
                pertanyaan: document.getElementById('pertanyaan').value,
                indikator: document.getElementById('indikator').value,
                sumber_data: document.getElementById('sumber_data').value,
                metode_perhitungan: document.getElementById('metode_perhitungan').value,
                target: document.getElementById('target').value,
            };

            try {
                // Send POST request to the API
                const response = await fetch('http://127.0.0.1:5000/api/tilik', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData),
                });

                const result = await response.json();

                // Display response using modal toast
                if (result.success) {
                    showFlashMessage(result.message);

                    // Reset form
                    document.getElementById('tilikForm').reset();

                    // Redirect to index route after 3 seconds
                    setTimeout(() => {
                        window.location.href = "{{ route('auditor.daftar-tilik.index') }}";
                    }, 3000);
                } else {
                    showFlashMessage('Gagal menyimpan data: ' + (result.message || 'Unknown error'), 'error');
                }
            } catch (error) {
                // Handle network or other errors
                showFlashMessage('Error: ' + error.message, 'error');
            }
        });

        // Call loadKriteria when the page loads
        document.addEventListener('DOMContentLoaded', loadKriteria);
    </script>
@endsection