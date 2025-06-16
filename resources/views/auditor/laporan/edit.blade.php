@extends('layouts.app')

@section('title', 'Edit Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index', ['auditingId' => $auditingId])],
    ]" class="mb-6" />

    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
        Edit Laporan Temuan
    </h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        Perbarui formulir di bawah untuk mengedit laporan temuan audit.
    </p>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 rounded-lg text-red-700 dark:text-red-300">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 rounded-lg text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <form action="{{ route('auditor.laporan.update', ['laporan_temuan_id' => $laporan->laporan_temuan_id]) }}" method="POST" id="laporanForm" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="auditing_id" value="{{ $auditingId ?? old('auditing_id') }}">

            <div id="kriteriaContainer">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Standar <span class="text-red-500">*</span></label>
                @if (empty($kriterias))
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">Tidak ada kriteria tersedia. <a href="#" class="underline hover:text-red-700">Hubungi administrator</a>.</p>
                @else
                    <div class="mt-1 space-y-6">
                        @php $initialKriteriaIndex = 0; @endphp
                        <div class="kriteria-item transition-opacity duration-200" data-kriteria-index="{{ $initialKriteriaIndex }}">
                            <div class="flex items-end gap-3">
                                <select name="standar[{{ $initialKriteriaIndex }}][kriteria_id]" title="Pilih standar yang relevan untuk laporan temuan" class="w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>
                                    <option value="" disabled>Pilih Standar</option>
                                    @foreach ($kriterias as $kriteria)
                                        <option value="{{ $kriteria['kriteria_id'] }}" {{ (isset($standar[$initialKriteriaIndex]) && $standar[$initialKriteriaIndex] == $kriteria['kriteria_id']) || old("standar.${initialKriteriaIndex}.kriteria_id") == $kriteria['kriteria_id'] ? 'selected' : '' }}>
                                            {{ $kriteria['nama_kriteria'] ?? 'Standar ' . $kriteria['kriteria_id'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" id="addKriteria" class="px-2 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition duration-150 flex items-center gap-1" aria-label="Tambah kriteria baru">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Kriteria
                                </button>
                            </div>
                            <div class="temuan-container mt-4 space-y-4 pl-4 border-l-2 border-gray-200 dark:border-gray-600">
                                @php $initialTemuanIndex = 0; @endphp
                                <div class="temuan-item space-y-3 transition-opacity duration-200" data-temuan-index="{{ $initialTemuanIndex }}">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Uraian Temuan <span class="text-red-500">*</span></label>
                                        <textarea name="standar[{{ $initialKriteriaIndex }}][uraian_temuan][{{ $initialTemuanIndex }}]" rows="4" title="Masukkan deskripsi temuan audit" placeholder="Tulis uraian temuan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>{{ $uraian_temuan[$initialTemuanIndex] ?? old("standar.${initialKriteriaIndex}.uraian_temuan.${initialTemuanIndex}") }}</textarea>
                                        @error("standar.${initialKriteriaIndex}.uraian_temuan.${initialTemuanIndex}")
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Temuan <span class="text-red-500">*</span></label>
                                        <select name="standar[{{ $initialKriteriaIndex }}][kategori_temuan][{{ $initialTemuanIndex }}]" title="Pilih kategori temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required>
                                            <option value="" disabled>Pilih Kategori</option>
                                            @foreach ($kategori_temuan as $kategori)
                                                <option value="{{ $kategori }}" {{ (isset($kategori_temuan[$initialTemuanIndex]) && $kategori_temuan[$initialTemuanIndex] == $kategori) || old("standar.${initialKriteriaIndex}.kategori_temuan.${initialTemuanIndex}") == $kategori ? 'selected' : '' }}>
                                                    {{ $kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error("standar.${initialKriteriaIndex}.kategori_temuan.${initialTemuanIndex}")
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Saran Perbaikan</label>
                                        <textarea name="standar[{{ $initialKriteriaIndex }}][saran_perbaikan][{{ $initialTemuanIndex }}]" rows="4" title="Masukkan saran perbaikan (opsional)" placeholder="Tulis saran perbaikan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150">{{ $saran_perbaikan[$initialTemuanIndex] ?? old("standar.${initialKriteriaIndex}.saran_perbaikan.${initialTemuanIndex}") }}</textarea>
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

            <div class="flex justify-end">
                <button type="submit" id="submitButton" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition duration-150 flex items-center gap-2 {{ empty($kriterias) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ empty($kriterias) ? 'disabled' : '' }}>
                    <span>Simpan Perubahan</span>
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

        laporanForm.addEventListener('submit', function(event) {
            if (!confirm('Apakah Anda yakin ingin menyimpan perubahan laporan temuan ini?')) {
                event.preventDefault();
                return;
            }
            submitButton.disabled = true;
            submitButton.classList.add('opacity-75', 'cursor-not-allowed');
            loadingSpinner.classList.remove('hidden');
        });

        const addKriteriaButton = document.getElementById('addKriteria');
        const kriteriaContainer = document.getElementById('kriteriaContainer');
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
                            @foreach ($kategori_temuan as $kategori)
                                <option value="{{ $kategori }}">{{ $kategori }}</option>
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
                    if (temuanItem) {
                        temuanItem.classList.add('opacity-0');
                        setTimeout(() => temuanItem.remove(), 200);
                    }
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
                if (temuanItem) {
                    temuanItem.classList.add('opacity-0');
                    setTimeout(() => temuanItem.remove(), 200);
                }
            });
        }
    });
</script>
@endsection
