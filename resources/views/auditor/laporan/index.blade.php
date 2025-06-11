@extends('layouts.app')

@section('title', 'Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index')]
    ]" class="mb-6" />

    <!-- Heading -->
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
        Laporan Temuan
    </h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        Isi formulir di bawah untuk menambahkan laporan temuan audit.
    </p>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 rounded-lg text-red-700 dark:text-red-300">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <form action="{{ route('auditor.laporan.store') }}" method="POST" id="laporanForm" class="space-y-6">
            @csrf
            <div class="space-y-6">
                <!-- Audit Selection -->
                <div>
                    <label for="auditing_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Audit <span class="text-red-500">*</span></label>
                    <select id="auditing_id" name="auditing_id" title="Pilih audit yang terkait dengan laporan temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>
                        <option value="" placeholder="Pilih Audit">Pilih Audit</option>
                        @foreach ($audits as $audit)
                            <option value="{{ $audit['id'] }}" {{ old('auditing_id') == $audit['id'] ? 'selected' : '' }}>
                                Audit {{ $audit['id'] }}
                            </option>
                        @endforeach
                    </select>
                    @if (empty($audits))
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">Tidak ada audit tersedia. <a href="#" class="underline hover:text-red-700">Hubungi administrator</a>.</p>
                    @endif
                </div>

                <!-- Kriteria Selection -->
                <div id="kriteriaContainer">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Standar <span class="text-red-500">*</span></label>
                    <div class="mt-1 space-y-6">
                        <div class="kriteria-item transition-opacity duration-200" data-kriteria-index="0">
                            <div class="flex items-end gap-3">
                                <select name="standar[0][kriteria_id]" title="Pilih standar yang relevan untuk laporan temuan" class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>
                                    <option value="" placeholder="Pilih Standar">Pilih Standar</option>
                                    @foreach ($kriterias as $kriteria)
                                        <option value="{{ $kriteria['kriteria_id'] }}" {{ old('standar.0.kriteria_id') == $kriteria['kriteria_id'] ? 'selected' : '' }}>
                                            {{ $kriteria['nama_kriteria'] ?? 'Standar ' . $kriteria['kriteria_id'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" id="addKriteria" class="px-2 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition duration-150 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Kriteria
                                </button>
                            </div>
                            <!-- Temuan Container -->
                            <div class="temuan-container mt-4 space-y-4 pl-4 border-l-2 border-gray-200 dark:border-gray-600">
                                <div class="temuan-item space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Uraian Temuan <span class="text-red-500">*</span></label>
                                        <textarea name="standar[0][uraian_temuan][]" rows="4" title="Masukkan deskripsi temuan audit" placeholder="Tulis uraian temuan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>{{ old('standar.0.uraian_temuan.0') }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Perbaikan <span class="text-red-500">*</span></label>
                                        <select name="standar[0][kategori_temuan][]" title="Pilih kategori perbaikan untuk temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>
                                            <option value="" placeholder="Pilih Kategori">Pilih Kategori</option>
                                            @foreach ($kategori_temuan as $kategori)
                                                <option value="{{ $kategori }}" {{ old('standar.0.kategori_temuan.0') == $kategori ? 'selected' : '' }}>
                                                    {{ $kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Saran Perbaikan</label>
                                        <textarea name="standar[0][saran_perbaikan][]" rows="4" title="Masukkan saran perbaikan (opsional)" placeholder="Tulis saran perbaikan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150">{{ old('standar.0.saran_perbaikan.0') }}</textarea>
                                    </div>
                                    <button type="button" class="remove-temuan px-2 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Hapus Temuan
                                    </button>
                                </div>
                                <button type="button" class="add-temuan px-2 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Temuan
                                </button>
                            </div>
                        </div>
                    </div>
                    @if (empty($kriterias))
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">Tidak ada kriteria tersedia. <a href="#" class="underline hover:text-red-700">Hubungi administrator</a>.</p>
                    @endif
                </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form Submission Confirmation and Loading State
        const laporanForm = document.getElementById('laporanForm');
        const submitButton = document.getElementById('submitButton');
        const loadingSpinner = document.getElementById('loadingSpinner');

        laporanForm.addEventListener('submit', function(event) {
            if (!confirm('Apakah Anda yakin ingin menyimpan laporan temuan ini?')) {
                event.preventDefault();
                return;
            }
            submitButton.disabled = true;
            submitButton.classList.add('opacity-75', 'cursor-not-allowed');
            loadingSpinner.classList.remove('hidden');
        });

        // Kriteria Dynamic Fields
        const addKriteriaButton = document.getElementById('addKriteria');
        const kriteriaContainer = document.getElementById('kriteriaContainer');
        let kriteriaCount = 1;

        function createTemuanFields(kriteriaIndex) {
            return `
                <div class="temuan-item space-y-3 transition-opacity duration-200 opacity-0">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Uraian Temuan <span class="text-red-500">*</span></label>
                        <textarea name="standar[${kriteriaIndex}][uraian_temuan][]" rows="4" title="Masukkan deskripsi temuan audit" placeholder="Tulis uraian temuan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Perbaikan <span class="text-red-500">*</span></label>
                        <select name="standar[${kriteriaIndex}][kategori_temuan][]" title="Pilih kategori perbaikan untuk temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>
                            <option value="" placeholder="Pilih Kategori">Pilih Kategori</option>
                            @foreach ($kategori_temuan as $kategori)
                                <option value="{{ $kategori }}">{{ $kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Saran Perbaikan</label>
                        <textarea name="standar[${kriteriaIndex}][saran_perbaikan][]" rows="4" title="Masukkan saran perbaikan (opsional)" placeholder="Tulis saran perbaikan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150"></textarea>
                    </div>
                    <button type="button" class="remove-temuan px-2 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Hapus Temuan
                    </button>
                </div>
            `;
        }

        addKriteriaButton.addEventListener('click', function() {
            const newKriteria = document.createElement('div');
            newKriteria.className = 'kriteria-item transition-opacity duration-200 opacity-0 mt-6';
            newKriteria.setAttribute('data-kriteria-index', kriteriaCount);
            newKriteria.innerHTML = `
                <div class="flex items-end gap-3">
                    <select name="standar[${kriteriaCount}][kriteria_id]" title="Pilih standar yang relevan untuk laporan temuan" class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>
                        <option value="" placeholder="Pilih Standar">Pilih Standar</option>
                        @foreach ($kriterias as $kriteria)
                            <option value="{{ $kriteria['kriteria_id'] }}">{{ $kriteria['nama_kriteria'] ?? 'Standar ' . $kriteria['kriteria_id'] }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="remove-kriteria px-2 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Hapus Kriteria
                    </button>
                </div>
                <div class="temuan-container mt-4 space-y-4 pl-4 border-l-2 border-gray-200 dark:border-gray-600">
                    ${createTemuanFields(kriteriaCount)}
                    <button type="button" class="add-temuan px-2 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Temuan
                    </button>
                </div>
            `;
            kriteriaContainer.querySelector('div.space-y-6').appendChild(newKriteria);

            // Animate in
            setTimeout(() => newKriteria.classList.remove('opacity-0'), 50);

            // Remove Kriteria
            newKriteria.querySelector('.remove-kriteria').addEventListener('click', function() {
                newKriteria.classList.add('opacity-0');
                setTimeout(() => newKriteria.remove(), 200);
            });

            // Add Temuan
            newKriteria.querySelector('.add-temuan').addEventListener('click', function() {
                const temuanContainer = newKriteria.querySelector('.temuan-container');
                const newTemuan = document.createElement('div');
                newTemuan.innerHTML = createTemuanFields(kriteriaCount);
                temuanContainer.insertBefore(newTemuan, temuanContainer.lastElementChild);
                setTimeout(() => newTemuan.querySelector('.temuan-item').classList.remove('opacity-0'), 50);

                // Remove Temuan
                newTemuan.querySelector('.remove-temuan').addEventListener('click', function() {
                    newTemuan.classList.add('opacity-0');
                    setTimeout(() => newTemuan.remove(), 200);
                });
            });

            // Remove First Temuan
            newKriteria.querySelector('.remove-temuan').addEventListener('click', function() {
                const temuanItem = newKriteria.querySelector('.temuan-item');
                temuanItem.classList.add('opacity-0');
                setTimeout(() => temuanItem.remove(), 200);
            });

            kriteriaCount++;
        });

        // Initial Temuan Handlers
        const initialKriteria = kriteriaContainer.querySelector('.kriteria-item');
        initialKriteria.querySelector('.add-temuan').addEventListener('click', function() {
            const temuanContainer = initialKriteria.querySelector('.temuan-container');
            const newTemuan = document.createElement('div');
            newTemuan.innerHTML = createTemuanFields(0);
            temuanContainer.insertBefore(newTemuan, temuanContainer.lastElementChild);
            setTimeout(() => newTemuan.querySelector('.temuan-item').classList.remove('opacity-0'), 50);

            newTemuan.querySelector('.remove-temuan').addEventListener('click', function() {
                newTemuan.classList.add('opacity-0');
                setTimeout(() => newTemuan.remove(), 200);
            });
        });

        initialKriteria.querySelector('.remove-temuan').addEventListener('click', function() {
            const temuanItem = initialKriteria.querySelector('.temuan-item');
            temuanItem.classList.add('opacity-0');
            setTimeout(() => temuanItem.remove(), 200);
        });
    });
</script>
@endsection
