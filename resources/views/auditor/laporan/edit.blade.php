@extends('layouts.app')

@section('title', 'Edit Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index', ['auditingId' => $auditingId])],
        ['label' => 'Edit', 'url' => '#'],
    ]" class="mb-6" />

    <!-- Heading -->
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
        Edit Laporan Temuan
    </h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        Perbarui temuan dengan memilih standar dan mengisi detail temuan di bawah.
    </p>

    <!-- Validation Errors Display -->
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-700 rounded-lg text-red-700 dark:text-red-300">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Success Message Display -->
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-700 rounded-lg text-green-700 dark:text-green-300">
            {!! session('success') !!}
        </div>
    @endif

    <!-- Form Section -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <form action="{{ route('auditor.laporan.update', ['auditingId' => $auditingId, 'laporan_temuan_id' => $findingData['laporan_temuan_id']]) }}" method="POST" id="laporanForm" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="hidden" name="auditing_id" value="{{ $auditingId }}">

            <!-- Container for dynamically added finding items -->
            <div id="findingsContainer" class="space-y-6">
                @if (empty($kriterias))
                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">
                        Tidak ada kriteria tersedia.
                        <button type="button" onclick="window.location.reload()" class="underline hover:text-red-700">Coba lagi</button> atau
                        <a href="#" class="underline hover:text-red-700">hubungi administrator</a>.
                    </div>
                @else
                    @if (empty(old('findings')) && !empty($findingData))
                        <!-- Initial Finding Item (from existing data) -->
                        <div class="finding-item p-4 border border-gray-200 dark:border-gray-600 rounded-lg space-y-3 transition-opacity duration-200" data-finding-index="0">
                            <div>
                                <label for="kriteria_id_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Standar <span class="text-red-500">*</span></label>
                                <select name="findings[0][kriteria_id]" id="kriteria_id_0" title="Pilih standar untuk temuan ini" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required aria-describedby="kriteria-error-0">
                                    <option value="" disabled>Pilih Standar</option>
                                    @foreach ($kriterias as $kriteria)
                                        <option value="{{ $kriteria['kriteria_id'] }}" {{ ($findingData['selected_kriteria_ids'][0] ?? '') == $kriteria['kriteria_id'] ? 'selected' : '' }}>
                                            {{ $kriteria['nama_kriteria'] ?? 'Standar ' . $kriteria['kriteria_id'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="kriteria-error-0" class="error-message text-sm text-red-600 dark:text-red-400 @error('findings.0.kriteria_id') @else hidden @enderror">@error('findings.0.kriteria_id'){{ $message }}@enderror</div>
                            </div>
                            <div>
                                <label for="uraian_temuan_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Uraian Temuan <span class="text-red-500">*</span></label>
                                <textarea name="findings[0][uraian_temuan]" id="uraian_temuan_0" rows="4" title="Masukkan deskripsi temuan audit" placeholder="Tulis uraian temuan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required aria-describedby="uraian-error-0">{{ old('findings.0.uraian_temuan', $findingData['uraian_temuan'] ?? '') }}</textarea>
                                <div id="uraian-error-0" class="error-message text-sm text-red-600 dark:text-red-400 @error('findings.0.uraian_temuan') @else hidden @enderror">@error('findings.0.uraian_temuan'){{ $message }}@enderror</div>
                            </div>
                            <div>
                                <label for="kategori_temuan_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Temuan <span class="text-red-500">*</span></label>
                                <select name="findings[0][kategori_temuan]" id="kategori_temuan_0" title="Pilih kategori temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required aria-describedby="kategori-error-0">
                                    <option value="" disabled>Pilih Kategori</option>
                                    @foreach ($kategori_temuan as $kategori)
                                        <option value="{{ $kategori }}" {{ old('findings.0.kategori_temuan', $findingData['kategori_temuan'] ?? '') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                    @endforeach
                                </select>
                                <div id="kategori-error-0" class="error-message text-sm text-red-600 dark:text-red-400 @error('findings.0.kategori_temuan') @else hidden @enderror">@error('findings.0.kategori_temuan'){{ $message }}@enderror</div>
                            </div>
                            <div>
                                <label for="saran_perbaikan_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Saran Perbaikan</label>
                                <textarea name="findings[0][saran_perbaikan]" id="saran_perbaikan_0" rows="4" title="Masukkan saran perbaikan (opsional)" placeholder="Tulis saran perbaikan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" aria-describedby="saran-error-0">{{ old('findings.0.saran_perbaikan', $findingData['saran_perbaikan'] ?? '') }}</textarea>
                                <div id="saran-error-0" class="error-message text-sm text-red-600 dark:text-red-400 @error('findings.0.saran_perbaikan') @else hidden @enderror">@error('findings.0.saran_perbaikan'){{ $message }}@enderror</div>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" class="remove-finding px-3 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-1" aria-label="Hapus temuan ini">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Hapus Temuan Ini
                                </button>
                                <button type="button" class="add-same-kriteria px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-1" aria-label="Tambah temuan pada kriteria ini">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Temuan pada Kriteria Ini
                                </button>
                            </div>
                        </div>
                    @else
                        @foreach (old('findings', []) as $index => $finding)
                            <div class="finding-item p-4 border border-gray-200 dark:border-gray-600 rounded-lg space-y-3 transition-opacity duration-200" data-finding-index="{{ $index }}">
                                <div>
                                    <label for="kriteria_id_{{ $index }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Standar <span class="text-red-500">*</span></label>
                                    <select name="findings[{{ $index }}][kriteria_id]" id="kriteria_id_{{ $index }}" title="Pilih standar untuk temuan ini" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required aria-describedby="kriteria-error-{{ $index }}">
                                        <option value="" disabled>Pilih Standar</option>
                                        @foreach ($kriterias as $kriteria)
                                            <option value="{{ $kriteria['kriteria_id'] }}" {{ ($finding['kriteria_id'] ?? '') == $kriteria['kriteria_id'] ? 'selected' : '' }}>
                                                {{ $kriteria['nama_kriteria'] ?? 'Standar ' . $kriteria['kriteria_id'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="kriteria-error-{{ $index }}" class="error-message text-sm text-red-600 dark:text-red-400 @error('findings.' . $index . '.kriteria_id') @else hidden @enderror">@error('findings.' . $index . '.kriteria_id'){{ $message }}@enderror</div>
                                </div>
                                <div>
                                    <label for="uraian_temuan_{{ $index }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Uraian Temuan <span class="text-red-500">*</span></label>
                                    <textarea name="findings[{{ $index }}][uraian_temuan]" id="uraian_temuan_{{ $index }}" rows="4" title="Masukkan deskripsi temuan audit" placeholder="Tulis uraian temuan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required aria-describedby="uraian-error-{{ $index }}">{{ $finding['uraian_temuan'] ?? '' }}</textarea>
                                    <div id="uraian-error-{{ $index }}" class="error-message text-sm text-red-600 dark:text-red-400 @error('findings.' . $index . '.uraian_temuan') @else hidden @enderror">@error('findings.' . $index . '.uraian_temuan'){{ $message }}@enderror</div>
                                </div>
                                <div>
                                    <label for="kategori_temuan_{{ $index }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Temuan <span class="text-red-500">*</span></label>
                                    <select name="findings[{{ $index }}][kategori_temuan]" id="kategori_temuan_{{ $index }}" title="Pilih kategori temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required aria-describedby="kategori-error-{{ $index }}">
                                        <option value="" disabled>Pilih Kategori</option>
                                        @foreach ($kategori_temuan as $kategori)
                                            <option value="{{ $kategori }}" {{ ($finding['kategori_temuan'] ?? '') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                        @endforeach
                                    </select>
                                    <div id="kategori-error-{{ $index }}" class="error-message text-sm text-red-600 dark:text-red-400 @error('findings.' . $index . '.kategori_temuan') @else hidden @enderror">@error('findings.' . $index . '.kategori_temuan'){{ $message }}@enderror</div>
                                </div>
                                <div>
                                    <label for="saran_perbaikan_{{ $index }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Saran Perbaikan</label>
                                    <textarea name="findings[{{ $index }}][saran_perbaikan]" id="saran_perbaikan_{{ $index }}" rows="4" title="Masukkan saran perbaikan (opsional)" placeholder="Tulis saran perbaikan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" aria-describedby="saran-error-{{ $index }}">{{ $finding['saran_perbaikan'] ?? '' }}</textarea>
                                    <div id="saran-error-{{ $index }}" class="error-message text-sm text-red-600 dark:text-red-400 @error('findings.' . $index . '.saran_perbaikan') @else hidden @enderror">@error('findings.' . $index . '.saran_perbaikan'){{ $message }}@enderror</div>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" class="remove-finding px-3 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-1" aria-label="Hapus temuan ini">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Hapus Temuan Ini
                                    </button>
                                    <button type="button" class="add-same-kriteria px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-1" aria-label="Tambah temuan pada kriteria ini">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Temuan pada Kriteria Ini
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>

            <!-- Button to add new finding block -->
            <div class="flex justify-start mt-6">
                <button type="button" id="addFinding" class="px-3 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition duration-150 flex items-center gap-1 {{ empty($kriterias) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ empty($kriterias) ? 'disabled' : '' }} aria-label="Tambah temuan baru">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Temuan
                </button>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-6">
                <button type="submit" id="submitButton" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition duration-150 flex items-center gap-2 {{ empty($kriterias) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ empty($kriterias) ? 'disabled' : '' }}>
                    <span>Perbarui Laporan</span>
                    <svg id="loadingSpinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Enhanced Modal Structure -->
<div id="customModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center hidden z-50 transition-opacity duration-300">
    <div id="modalContent" class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full mx-4 p-6 transform scale-95 transition-transform duration-300">
        <div class="flex items-center gap-3 mb-4">
            <svg id="modalIcon" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-gray-100"></h3>
        </div>
        <p id="modalMessage" class="text-sm text-gray-600 dark:text-gray-300 mb-6"></p>
        <div id="modalActions" class="flex justify-end gap-3">
            <button id="modalCancel" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-150 text-sm font-medium">Batal</button>
            <button id="modalConfirm" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-150 text-sm font-medium">OK</button>
        </div>
    </div>
</div>

<style>
/* Modal Animations */
#customModal.show {
    opacity: 1;
}
#customModal.show #modalContent {
    transform: scale(1);
}
#customModal {
    opacity: 0;
}
#customModal #modalContent {
    transform: scale(0.95);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const laporanForm = document.getElementById('laporanForm');
    const submitButton = document.getElementById('submitButton');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const findingsContainer = document.getElementById('findingsContainer');
    const criteriasData = @json($kriterias);
    const categories = @json($kategori_temuan);
    let isRemoving = false;

    const customModal = document.getElementById('customModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const modalActions = document.getElementById('modalActions');
    const modalCancel = document.getElementById('modalCancel');
    const modalConfirm = document.getElementById('modalConfirm');
    const modalIcon = document.getElementById('modalIcon');

    function showCustomModal(title, message, isConfirm = false) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;

        // Update icon based on title
        if (title === 'Peringatan') {
            modalIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>`;
            modalIcon.classList.remove('text-indigo-600', 'dark:text-indigo-400');
            modalIcon.classList.add('text-yellow-600', 'dark:text-yellow-400');
        } else {
            modalIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>`;
            modalIcon.classList.remove('text-yellow-600', 'dark:text-yellow-400');
            modalIcon.classList.add('text-indigo-600', 'dark:text-indigo-400');
        }

        if (isConfirm) {
            modalActions.classList.remove('hidden');
            modalConfirm.classList.remove('hidden');
            modalCancel.classList.remove('hidden');
        } else {
            modalActions.classList.remove('hidden');
            modalConfirm.classList.remove('hidden');
            modalCancel.classList.add('hidden');
        }

        customModal.classList.remove('hidden');
        setTimeout(() => customModal.classList.add('show'), 10);

        return new Promise((resolve) => {
            modalConfirm.onclick = null;
            modalCancel.onclick = null;
            customModal.onclick = null;

            if (isConfirm) {
                modalConfirm.onclick = () => {
                    customModal.classList.remove('show');
                    setTimeout(() => {
                        customModal.classList.add('hidden');
                        resolve(true);
                    }, 300);
                };
                modalCancel.onclick = () => {
                    customModal.classList.remove('show');
                    setTimeout(() => {
                        customModal.classList.add('hidden');
                        resolve(false);
                    }, 300);
                };
            } else {
                modalConfirm.onclick = () => {
                    customModal.classList.remove('show');
                    setTimeout(() => {
                        customModal.classList.add('hidden');
                        resolve(true);
                    }, 300);
                };
                customModal.addEventListener('click', function dismissOnClickOutside(e) {
                    if (e.target === customModal) {
                        customModal.classList.remove('show');
                        setTimeout(() => {
                            customModal.classList.add('hidden');
                            resolve(true);
                            customModal.removeEventListener('click', dismissOnClickOutside);
                        }, 300);
                    }
                });
            }
        });
    }

    function createFindingFields(findingIndex, kriteriaId = '') {
        let criteriaField = kriteriaId
            ? `<input type="hidden" name="findings[${findingIndex}][kriteria_id]" value="${kriteriaId}">`
            : `
                <div>
                    <label for="kriteria_id_${findingIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Standar <span class="text-red-500">*</span></label>
                    <select name="findings[${findingIndex}][kriteria_id]" id="kriteria_id_${findingIndex}" title="Pilih standar untuk temuan ini" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required aria-describedby="kriteria-error-${findingIndex}">
                        <option value="" disabled>Pilih Standar</option>
                        ${criteriasData.map(kriteria => `<option value="${kriteria.kriteria_id}">${kriteria.nama_kriteria || 'Standar ' + kriteria.kriteria_id}</option>`).join('')}
                    </select>
                    <div id="kriteria-error-${findingIndex}" class="error-message text-sm text-red-600 dark:text-red-400 hidden"></div>
                </div>
            `;
        let categoryOptions = categories.map(category =>
            `<option value="${category}">${category}</option>`
        ).join('');

        return `
            <div class="finding-item p-4 border border-gray-200 dark:border-gray-600 rounded-lg space-y-3 transition-opacity duration-200 opacity-0" data-finding-index="${findingIndex}">
                ${criteriaField}
                <div>
                    <label for="uraian_temuan_${findingIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Uraian Temuan <span class="text-red-500">*</span></label>
                    <textarea name="findings[${findingIndex}][uraian_temuan]" id="uraian_temuan_${findingIndex}" rows="4" title="Masukkan deskripsi temuan audit" placeholder="Tulis uraian temuan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required aria-describedby="uraian-error-${findingIndex}"></textarea>
                    <div id="uraian-error-${findingIndex}" class="error-message text-sm text-red-600 dark:text-red-400 hidden"></div>
                </div>
                <div>
                    <label for="kategori_temuan_${findingIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori Temuan <span class="text-red-500">*</span></label>
                    <select name="findings[${findingIndex}][kategori_temuan]" id="kategori_temuan_${findingIndex}" title="Pilih kategori temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" required aria-describedby="kategori-error-${findingIndex}">
                        <option value="" disabled>Pilih Kategori</option>
                        ${categoryOptions}
                    </select>
                    <div id="kategori-error-${findingIndex}" class="error-message text-sm text-red-600 dark:text-red-400 hidden"></div>
                </div>
                <div>
                    <label for="saran_perbaikan_${findingIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Saran Perbaikan</label>
                    <textarea name="findings[${findingIndex}][saran_perbaikan]" id="saran_perbaikan_${findingIndex}" rows="4" title="Masukkan saran perbaikan (opsional)" placeholder="Tulis saran perbaikan di sini..." class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm transition duration-150" aria-describedby="saran-error-${findingIndex}"></textarea>
                    <div id="saran-error-${findingIndex}" class="error-message text-sm text-red-600 dark:text-red-400 hidden"></div>
                </div>
                <div class="flex gap-2">
                    <button type="button" class="remove-finding px-3 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition duration-150 flex items-center gap-1" aria-label="Hapus temuan ini">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Hapus Temuan Ini
                    </button>
                    <button type="button" class="add-same-kriteria px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-150 flex items-center gap-1" aria-label="Tambah temuan pada kriteria ini">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Temuan pada Kriteria Ini
                    </button>
                </div>
            </div>
        `;
    }

    function reindexFindings() {
        const findingItems = findingsContainer.querySelectorAll('.finding-item');
        findingItems.forEach((item, index) => {
            item.setAttribute('data-finding-index', index);

            item.querySelectorAll('[name*="[kriteria_id]"]').forEach(el => {
                el.name = `findings[${index}][kriteria_id]`;
                el.id = `kriteria_id_${index}`;
                el.setAttribute('aria-describedby', `kriteria-error-${index}`);
            });
            item.querySelectorAll('[id^="kriteria-error-"]').forEach(el => el.id = `kriteria-error-${index}`);

            item.querySelectorAll('[name*="[uraian_temuan]"]').forEach(el => {
                el.name = `findings[${index}][uraian_temuan]`;
                el.id = `uraian_temuan_${index}`;
                el.setAttribute('aria-describedby', `uraian-error-${index}`);
            });
            item.querySelectorAll('[id^="uraian-error-"]').forEach(el => el.id = `uraian-error-${index}`);

            item.querySelectorAll('[name*="[kategori_temuan]"]').forEach(el => {
                el.name = `findings[${index}][kategori_temuan]`;
                el.id = `kategori_temuan_${index}`;
                el.setAttribute('aria-describedby', `kategori-error-${index}`);
            });
            item.querySelectorAll('[id^="kategori-error-"]').forEach(el => el.id = `kategori-error-${index}`);

            item.querySelectorAll('[name*="[saran_perbaikan]"]').forEach(el => {
                el.name = `findings[${index}][saran_perbaikan]`;
                el.id = `saran_perbaikan_${index}`;
                el.setAttribute('aria-describedby', `saran-error-${index}`);
            });
            item.querySelectorAll('[id^="saran-error-"]').forEach(el => el.id = `saran-error-${index}`);
        });
    }

    document.getElementById('addFinding').addEventListener('click', function() {
        const currentFindingItemsCount = findingsContainer.querySelectorAll('.finding-item').length;
        const newFindingIndex = currentFindingItemsCount;

        const newFindingWrapper = document.createElement('div');
        newFindingWrapper.innerHTML = createFindingFields(newFindingIndex);
        const newFindingItem = newFindingWrapper.firstElementChild;

        findingsContainer.appendChild(newFindingItem);
        setTimeout(() => newFindingItem.classList.remove('opacity-0'), 50);
        reindexFindings();
    });

    findingsContainer.addEventListener('click', async function(event) {
        const removeTarget = event.target.closest('.remove-finding');
        const addSameKriteriaTarget = event.target.closest('.add-same-kriteria');

        if (removeTarget) {
            if (isRemoving) return;

            const findingItem = removeTarget.closest('.finding-item');
            const allFindingItems = findingsContainer.querySelectorAll('.finding-item');

            if (allFindingItems.length <= 1) {
                await showCustomModal('Peringatan', 'Minimal satu temuan harus tetap ada.', false);
                return;
            }

            isRemoving = true;
            if (findingItem) {
                findingItem.classList.add('opacity-0');
                setTimeout(() => {
                    findingItem.remove();
                    reindexFindings();
                    isRemoving = false;
                }, 200);
            } else {
                isRemoving = false;
            }
        }

        if (addSameKriteriaTarget) {
            const findingItem = addSameKriteriaTarget.closest('.finding-item');
            const kriteriaInput = findingItem.querySelector('[name*="[kriteria_id]"]');
            if (!kriteriaInput || !kriteriaInput.value) {
                await showCustomModal('Peringatan', 'Silakan pilih standar terlebih dahulu.', false);
                return;
            }

            const kriteriaId = kriteriaInput.value;
            const currentFindingItemsCount = findingsContainer.querySelectorAll('.finding-item').length;
            const newFindingIndex = currentFindingItemsCount;

            const newFindingWrapper = document.createElement('div');
            newFindingWrapper.innerHTML = createFindingFields(newFindingIndex, kriteriaId);
            const newFindingItem = newFindingWrapper.firstElementChild;

            findingsContainer.appendChild(newFindingItem);
            setTimeout(() => newFindingItem.classList.remove('opacity-0'), 50);
            reindexFindings();
        }
    });

    laporanForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        let isValid = true;

        const allFindingItems = findingsContainer.querySelectorAll('.finding-item');

        if (allFindingItems.length === 0) {
            await showCustomModal('Peringatan', 'Harap tambahkan setidaknya satu temuan.', false);
            isValid = false;
        } else {
            document.querySelectorAll('.finding-item .error-message').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            allFindingItems.forEach((findingItem, index) => {
                const kriteriaInput = findingItem.querySelector(`[name="findings[${index}][kriteria_id]"]`);
                const uraianInput = findingItem.querySelector(`textarea[name="findings[${index}][uraian_temuan]"]`);
                const kategoriInput = findingItem.querySelector(`select[name="findings[${index}][kategori_temuan]"]`);

                const kriteria = kriteriaInput ? kriteriaInput.value : '';
                const uraian = uraianInput ? uraianInput.value.trim() : '';
                const kategori = kategoriInput ? kategoriInput.value : '';

                const kriteriaErrorDiv = findingItem.querySelector(`#kriteria-error-${index}`);
                const uraianErrorDiv = findingItem.querySelector(`#uraian-error-${index}`);
                const kategoriErrorDiv = findingItem.querySelector(`#kategori-error-${index}`);

                if (!kriteria) {
                    if (kriteriaErrorDiv) {
                        kriteriaErrorDiv.textContent = 'Standar wajib dipilih.';
                        kriteriaErrorDiv.classList.remove('hidden');
                    }
                    isValid = false;
                }
                if (!uraian) {
                    if (uraianErrorDiv) {
                        uraianErrorDiv.textContent = 'Uraian temuan wajib diisi.';
                        uraianErrorDiv.classList.remove('hidden');
                    }
                    isValid = false;
                }
                if (!kategori) {
                    if (kategoriErrorDiv) {
                        kategoriErrorDiv.textContent = 'Kategori temuan wajib dipilih.';
                        kategoriErrorDiv.classList.remove('hidden');
                    }
                    isValid = false;
                }
            });
        }

        if (isValid) {
            const confirmed = await showCustomModal('Konfirmasi', 'Apakah Anda yakin ingin memperbarui laporan temuan ini?', true);
            if (confirmed) {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-75', 'cursor-not-allowed');
                loadingSpinner.classList.remove('hidden');
                laporanForm.submit();
            } else {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-75', 'cursor-not-allowed');
                loadingSpinner.classList.add('hidden');
            }
        } else {
            submitButton.disabled = false;
            submitButton.classList.remove('opacity-75', 'cursor-not-allowed');
            loadingSpinner.classList.add('hidden');
        }
    });

    reindexFindings();

    @if ($errors->any() && old('findings'))
        document.querySelectorAll('.finding-item').forEach((item, index) => {
            const errorKriteria = document.querySelector(`#kriteria-error-${index}`);
            const errorUraian = document.querySelector(`#uraian-error-${index}`);
            const errorKategori = document.querySelector(`#kategori-error-${index}`);
            const errorSaran = document.querySelector(`#saran-error-${index}`);

            @error('findings.' . $index . '.kriteria_id')
                if (errorKriteria) { errorKriteria.textContent = "{{ $message }}"; errorKriteria.classList.remove('hidden'); }
            @enderror
            @error('findings.' . $index . '.uraian_temuan')
                if (errorUraian) { errorUraian.textContent = "{{ $message }}"; errorUraian.classList.remove('hidden'); }
            @enderror
            @error('findings.' . $index . '.kategori_temuan')
                if (errorKategori) { errorKategori.textContent = "{{ $message }}"; errorKategori.classList.remove('hidden'); }
            @enderror
            @error('findings.' . $index . '.saran_perbaikan')
                if (errorSaran) { errorSaran.textContent = "{{ $message }}"; errorSaran.classList.remove('hidden'); }
            @enderror
        });
    @endif
});
</script>
@endsection
