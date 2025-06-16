```blade
@extends('layouts.app')

@section('title', 'Tambah Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index', ['auditingId' => $auditingId])],
    ]" class="mb-6" />

    <!-- Heading -->
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
        Tambah Laporan Temuan
    </h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        Isi formulir di bawah untuk menambahkan laporan temuan untuk audit: {{ $auditing->nama_audit ?? 'Audit ID ' . $auditingId }}.
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

    <!-- Success Message -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 rounded-lg text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <form action="{{ route('auditor.laporan.store', ['auditingId' => $auditingId]) }}" method="POST" id="laporanForm" class="space-y-6">
            @csrf
            <input type="hidden" name="auditing_id" value="{{ $auditingId }}">

            <!-- Kriteria Selection -->
            <div id="kriteriaContainer">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Standar <span class="text-red-500">*</span></label>
                @if (empty($kriterias))
                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">
                        Tidak ada kriteria tersedia.
                        <button type="button" onclick="window.location.reload()" class="underline hover:text-red-700">Coba lagi</button> atau
                        <a href="#" class="underline hover:text-red-700">hubungi administrator</a>.
                    </div>
                @else
                    <div class="mt-1 space-y-6">
                        <div class="kriteria-item transition-opacity duration-200" data-kriteria-index="0">
                            <div class="flex items-end gap-3">
                                <select name="standar[0][kriteria_id]" title="Pilih standar yang relevan untuk laporan temuan" class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>
                                    <option value="" disabled selected>Pilih Standar</option>
                                    @foreach ($kriterias as $kriteria)
                                        <option value="{{ $kriteria['kriteria_id'] }}" {{ old('standar.0.kriteria_id') == $kriteria['kriteria_id'] ? 'selected' : '' }}>
                                            {{ $kriteria['nama_kriteria'] ?? 'Standar ' . $kriteria['kriteria_id'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" id="addKriteria" class="px-2 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition duration-150 flex items-center gap-1" aria-label="Tambah kriteria baru">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Kriteria
                                </button>
                            </div>
                            <!-- Temuan Container -->
                            <div class="temuan-container mt-4 space-y-4 pl-4 border-l-2 border-gray-200 dark:border-gray-600">
                                <div class="temuan-item space-y-3 transition-opacity duration-200" data-temuan-index="0">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Uraian Temuan <span class="text-red-500">*</span></label>
                                        <textarea name="standar[0][uraian_temuan][0]" rows="4" title="Masukkan deskripsi temuan audit" placeholder="Tulis uraian temuan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>{{ old('standar.0.uraian_temuan.0') }}</textarea>
                                        @error('standar.0.uraian_temuan.0')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Temuan <span class="text-red-500">*</span></label>
                                        <select name="standar[0][kategori_temuan][0]" title="Pilih kategori temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>
                                            <option value="" disabled {{ old('standar.0.kategori_temuan.0') ? '' : 'selected' }}>Pilih Kategori</option>
                                            @foreach (['NC', 'AOC', 'OFI'] as $kategori)
                                                <option value="{{ $kategori }}" {{ old('standar.0.kategori_temuan.0') == $kategori ? 'selected' : '' }}>
                                                    {{ $kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('standar.0.kategori_temuan.0')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Saran Perbaikan</label>
                                        <textarea name="standar[0][saran_perbaikan][0]" rows="4" title="Masukkan saran perbaikan (opsional)" placeholder="Tulis saran perbaikan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150">{{ old('standar.0.saran_perbaikan.0') }}</textarea>
                                    </div>
                                    <button type="button" class="remove-temuan px-2 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-1" aria-label="Hapus temuan ini">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Hapus Temuan
                                    </button>
                                </div>
                                <button type="button" class="add-temuan px-2 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-1" aria-label="Tambah temuan baru">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Temuan
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" id="submitButton" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition duration-150 flex items-center gap-2 {{ empty($kriterias) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ empty($kriterias) ? 'disabled' : '' }}>
                    <span>Simpan Laporan</span>
                    <svg id="loadingSpinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const laporanForm = document.getElementById('laporanForm');
    const submitButton = document.getElementById('submitButton');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const kriteriaContainer = document.getElementById('kriteriaContainer');
    const addKriteriaButton = document.getElementById('addKriteria');

    // Form Submission Validation and Loading State
    laporanForm.addEventListener('submit', function(event) {
        const temuanItems = kriteriaContainer.querySelectorAll('.temuan-item');
        if (temuanItems.length === 0) {
            event.preventDefault();
            alert('Harap tambahkan setidaknya satu temuan.');
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-75', 'cursor-not-allowed');
            loadingSpinner.classList.add('hidden');
            return;
        }
        if (!confirm('Apakah Anda yakin ingin menyimpan laporan temuan ini?')) {
            event.preventDefault();
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-75', 'cursor-not-allowed');
            loadingSpinner.classList.add('hidden');
            return;
        }
        submitButton.disabled = true;
        submitButton.classList.add('opacity-75', 'cursor-not-allowed');
        loadingSpinner.classList.remove('hidden');
    });

    // Dynamic Kriteria and Temuan Fields
    let kriteriaCount = 1;

    function createTemuanFields(kriteriaIndex, temuanIndex) {
        return `
            <div class="temuan-item space-y-3 transition-opacity duration-200 opacity-0" data-temuan-index="${temuanIndex}">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Uraian Temuan <span class="text-red-500">*</span></label>
                    <textarea name="standar[${kriteriaIndex}][uraian_temuan][${temuanIndex}]" rows="4" title="Masukkan deskripsi temuan audit" placeholder="Tulis uraian temuan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required></textarea>
                    <div class="error-message text-sm text-red-600 dark:text-red-400 hidden"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Temuan <span class="text-red-500">*</span></label>
                    <select name="standar[${kriteriaIndex}][kategori_temuan][${temuanIndex}]" title="Pilih kategori temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach (['NC', 'AOC', 'OFI'] as $kategori)
                            <option value="${kategori}">${kategori}</option>
                        @endforeach
                    </select>
                    <div class="error-message text-sm text-red-600 dark:text-red-400 hidden"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Saran Perbaikan</label>
                    <textarea name="standar[${kriteriaIndex}][saran_perbaikan][${temuanIndex}]" rows="4" title="Masukkan saran perbaikan (opsional)" placeholder="Tulis saran perbaikan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150"></textarea>
                </div>
                <button type="button" class="remove-temuan px-2 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-1" aria-label="Hapus temuan ini">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Hapus Temuan
                </button>
            </div>
        `;
    }

    if (addKriteriaButton) {
        addKriteriaButton.addEventListener('click', function() {
            const newKriteria = document.createElement('div');
            newKriteria.className = 'kriteria-item transition-opacity duration-200 opacity-0 mt-6';
            newKriteria.setAttribute('data-kriteria-index', kriteriaCount);
            newKriteria.innerHTML = `
                <div class="flex items-end gap-3">
                    <select name="standar[${kriteriaCount}][kriteria_id]" title="Pilih standar yang relevan untuk laporan temuan" class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>
                        <option value="" disabled selected>Pilih Standar</option>
                        @foreach ($kriterias as $kriteria)
                            <option value="{{ $kriteria['kriteria_id'] }}">{{ $kriteria['nama_kriteria'] ?? 'Standar ' . $kriteria['kriteria_id'] }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="remove-kriteria px-2 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-1" aria-label="Hapus kriteria ini">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Hapus Kriteria
                    </button>
                </div>
                <div class="temuan-container mt-4 space-y-4 pl-4 border-l-2 border-gray-200 dark:border-gray-600">
                    ${createTemuanFields(kriteriaCount, 0)}
                    <button type="button" class="add-temuan px-2 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-1" aria-label="Tambah temuan baru">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Temuan
                    </button>
                </div>
            `;
            kriteriaContainer.querySelector('div.space-y-6').appendChild(newKriteria);

            setTimeout(() => newKriteria.classList.remove('opacity-0'), 50);

            newKriteria.querySelector('.remove-kriteria').addEventListener('click', function() {
                newKriteria.classList.add('opacity-0');
                setTimeout(() => newKriteria.remove(), 200);
            });

            let temuanCount = 1;
            newKriteria.querySelector('.add-temuan').addEventListener('click', function() {
                const temuanContainer = newKriteria.querySelector('.temuan-container');
                const newTemuan = document.createElement('div');
                newTemuan.innerHTML = createTemuanFields(kriteriaCount, temuanCount);
                temuanContainer.insertBefore(newTemuan, temuanContainer.lastElementChild);
                setTimeout(() => newTemuan.querySelector('.temuan-item').classList.remove('opacity-0'), 50);

                newTemuan.querySelector('.remove-temuan').addEventListener('click', function() {
                    newTemuan.classList.add('opacity-0');
                    setTimeout(() => newTemuan.remove(), 200);
                });

                temuanCount++;
            });

            newKriteria.querySelector('.remove-temuan').addEventListener('click', function() {
                const temuanItem = newKriteria.querySelector('.temuan-item');
                temuanItem.classList.add('opacity-0');
                setTimeout(() => temuanItem.remove(), 200);
            });

            kriteriaCount++;
        });
    }

    const initialKriteria = kriteriaContainer.querySelector('.kriteria-item');
    if (initialKriteria) {
        let initialTemuanCount = 1;
        initialKriteria.querySelector('.add-temuan').addEventListener('click', function() {
            const temuanContainer = initialKriteria.querySelector('.temuan-container');
            const newTemuan = document.createElement('div');
            newTemuan.innerHTML = createTemuanFields(0, initialTemuanCount);
            temuanContainer.insertBefore(newTemuan, temuanContainer.lastElementChild);
            setTimeout(() => newTemuan.querySelector('.temuan-item').classList.remove('opacity-0'), 50);

            newTemuan.querySelector('.remove-temuan').addEventListener('click', function() {
                newTemuan.classList.add('opacity-0');
                setTimeout(() => newTemuan.remove(), 200);
            });

            initialTemuanCount++;
        });

        initialKriteria.querySelector('.remove-temuan').addEventListener('click', function() {
            const temuanItem = initialKriteria.querySelector('.temuan-item');
            temuanItem.classList.add('opacity-0');
            setTimeout(() => temuanItem.remove(), 200);
        });
    }

    // Display server-side validation errors for dynamic fields
    @if ($errors->any())
        document.querySelectorAll('.kriteria-item').forEach((kriteriaItem, kriteriaIndex) => {
            kriteriaItem.querySelectorAll('.temuan-item').forEach((temuanItem, temuanIndex) => {
                const uraianError = @json($errors->get(`standar.${kriteriaIndex}.uraian_temuan.${temuanIndex}`));
                const kategoriError = @json($errors->get(`standar.${kriteriaIndex}.kategori_temuan.${temuanIndex}`));

                if (uraianError && uraianError.length > 0) {
                    const errorDiv = temuanItem.querySelector('.error-message:nth-child(1)');
                    errorDiv.textContent = uraianError[0];
                    errorDiv.classList.remove('hidden');
                }
                if (kategoriError && kategoriError.length > 0) {
                    const errorDiv = temuanItem.querySelector('.error-message:nth-child(2)');
                    errorDiv.textContent = kategoriError[0];
                    errorDiv.classList.remove('hidden');
                }
            });
        });
    @endif
});
</script>
@endsection
```
