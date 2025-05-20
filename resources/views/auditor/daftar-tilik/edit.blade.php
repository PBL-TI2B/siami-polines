@extends('layouts.app')

@section('title', 'Edit Pertanyaan')

@section('content')
<div class="max-w-3xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Edit Pertanyaan</h1>

    <!-- Flash Message Container -->
    <div id="flashMessage" class="hidden fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg"></div>

    <form id="tilikForm" method="POST">
        @csrf
        @method('PUT')

        <!-- Dropdown Kriteria -->
        <div class="mb-4">
            <label for="kriteria" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kriteria</label>
            <select name="kriteria_id" id="kriteria"
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('kriteria');
        const form = document.getElementById('tilikForm');
        const flashMessage = document.getElementById('flashMessage');
        const responseMessage = document.getElementById('responseMessage');

        // Kriteria mapping
        const kriteriaList = [
            { id: 1, nama: "Visi, Misi, Tujuan, Strategi" },
            { id: 2, nama: "Tata Kelola, Tata Pamong, dan Kerjasama" },
            { id: 3, nama: "Kurikulum dan Pembelajaran" },
            { id: 4, nama: "Penelitian" },
            { id: 5, nama: "Luaran Tridharma" }
        ];

        // Populate select options
        kriteriaList.forEach(k => {
            const option = document.createElement('option');
            option.value = k.id;
            option.textContent = k.nama;
            select.appendChild(option);
        });

        // Fetch existing data
        fetch('http://127.0.0.1:5000/api/tilik/{{ $id }}')
            .then(response => response.json())
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
                    showFlashMessage('bg-red-500', 'text-white', data.message || 'Gagal memuat data.');
                }
            })
            .catch(error => {
                showFlashMessage('bg-red-500', 'text-white', 'Error fetching data: ' + error.message);
            });

        // Handle form submission
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = {
                tilik_id: {{ $id }},
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
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showFlashMessage('bg-green-500', 'text-white', 'Data berhasil disimpan!');
                    responseMessage.classList.remove('hidden');
                    responseMessage.classList.add('text-green-600');
                    responseMessage.textContent = 'Data berhasil disimpan!';
                    setTimeout(() => {
                        window.location.href = '{{ route("auditor.daftar-tilik.index") }}';
                    }, 2000);
                } else {
                    showFlashMessage('bg-red-500', 'text-white', data.message || 'Gagal menyimpan data.');
                }
            })
            .catch(error => {
                showFlashMessage('bg-red-500', 'text-white', 'Error: ' + error.message);
            });
        });

        function showFlashMessage(bgClass, textClass, message) {
            flashMessage.classList.remove('hidden');
            flashMessage.classList.add(bgClass, textClass);
            flashMessage.textContent = message;
            setTimeout(() => {
                flashMessage.classList.add('hidden');
                flashMessage.classList.remove(bgClass, textClass);
            }, 3000);
        }
    });
</script>
@endsection