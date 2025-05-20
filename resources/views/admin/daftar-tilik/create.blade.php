@extends('layouts.app')

@section('title', 'Tambah Pertanyaan')

@section('content')
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Tambah Pertanyaan</h1>

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
                <x-button color="gray" icon="heroicon-o-x-mark" href="{{ route('admin.daftar-tilik.index') }}">
                    Batal
                </x-button>
            </div>
        </form>

        <!-- Response Message -->
        <div id="responseMessage" class="mt-4 hidden text-sm"></div>
    </div>

    <script>
        // Fetch Kriteria Data on Page Load
        async function loadKriteria() {
            const kriteriaSelect = document.getElementById('kriteria');
            const responseMessage = document.getElementById('responseMessage');

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

                // Clear existing options except therape
                kriteriaSelect.innerHTML = '<option value="" disabled selected class="text-gray-400">Pilih Kriteria</option>';

                // Populate dropdown with kriteria data
                kriterias.forEach(kriteria => {
                    const option = document.createElement('option');
                    option.value = kriteria.kriteria_id; // Use kriteria_id as the value
                    // Use nama_kriteria if available, otherwise fallback to "Kriteria {nomor}"
                    option.textContent = kriteria.nama_kriteria || `Kriteria ${kriteria.nomor}`;
                    kriteriaSelect.appendChild(option);
                });
            } catch (error) {
                // Display error message
                responseMessage.classList.remove('hidden');
                responseMessage.classList.add('text-red-600');
                responseMessage.textContent = 'Error loading kriteria: ' + error.message;
            }
        }

        // Function to show flash message
        function showFlashMessage(message, type = 'success') {
            const flashMessage = document.getElementById('flashMessage');
            flashMessage.classList.remove('hidden');
            flashMessage.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500', 'text-white');
            flashMessage.textContent = message;

            // Hide flash message after 3 seconds
            setTimeout(() => {
                flashMessage.classList.add('hidden');
                flashMessage.classList.remove('bg-green-500', 'bg-red-500');
            }, 3000);
        }

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

            // Response message element
            const responseMessage = document.getElementById('responseMessage');

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

                // Display response
                responseMessage.classList.remove('hidden');
                if (result.success) {
                    responseMessage.classList.add('text-green-600');
                    responseMessage.textContent = result.message;

                    // Show flash message
                    showFlashMessage(result.message);

                    // Reset form
                    document.getElementById('tilikForm').reset();

                    // Redirect to index route after 3 seconds
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.daftar-tilik.index') }}";
                    }, 3000);
                } else {
                    responseMessage.classList.add('text-red-600');
                    responseMessage.textContent = 'Gagal menyimpan data: ' + (result.message || 'Unknown error');
                    showFlashMessage('Gagal menyimpan data: ' + (result.message || 'Unknown error'), 'error');
                }
            } catch (error) {
                // Handle network or other errors
                responseMessage.classList.remove('hidden');
                responseMessage.classList.add('text-red-600');
                responseMessage.textContent = 'Error: ' + error.message;
                showFlashMessage('Error: ' + error.message, 'error');
            }
        });

        // Call loadKriteria when the page loads
        document.addEventListener('DOMContentLoaded', loadKriteria);
    </script>
@endsection