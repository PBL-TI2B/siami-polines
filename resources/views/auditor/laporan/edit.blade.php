@extends('layouts.app')

@section('title', 'Edit Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index', ['auditingId' => $auditingId])],
        ['label' => 'Edit Laporan', 'url' => '#'],
    ]" />

    <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
        Edit Laporan Temuan
    </h1>

    <div class="mb-3 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
        {{-- Toast Notifications --}}
        @if (session('success'))
            <x-toast id="toast-success" type="success" :message="session('success')" />
        @endif

        @if (session('error') || $errors->any())
            <x-toast id="toast-danger" type="danger">
                @if (session('error'))
                    {{ session('error') }}<br>
                @endif
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </x-toast>
        @endif

        <form id="laporan-form" method="POST" action="{{ route('auditor.laporan.update', ['auditingId' => $auditingId, 'laporan_temuan_id' => $findingData['laporan_temuan_id']]) }}" class="space-y-6">
            @csrf {{-- Required for Laravel --}}
            @method('PUT') {{-- Use PUT method for update --}}
            <input type="hidden" name="auditing_id" value="{{ $auditingId }}">
            <input type="hidden" name="laporan_temuan_id" value="{{ $findingData['laporan_temuan_id'] }}">

            @if (empty($kriterias) || empty($allStandardsData))
                <div class="mt-1 text-sm text-red-600 dark:text-red-400">
                    Tidak ada kriteria atau standar tersedia. <button type="button" onclick="window.location.reload()" class="underline hover:text-red-700">Coba lagi</button> atau
                    <a href="#" class="underline hover:text-red-700">hubungi administrator</a>.
                </div>
            @else
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="kriteria_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kriteria <span class="text-red-500">*</span></label>
                        <select name="kriteria_id" id="kriteria_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>
                            <option value="" disabled>Pilih Kriteria</option>
                            @foreach ($kriterias as $kriteria)
                                <option value="{{ $kriteria['kriteria_id'] }}" {{ old('kriteria_id', $findingData['kriteria_id'] ?? '') == $kriteria['kriteria_id'] ? 'selected' : '' }}>
                                    {{ $kriteria['nama_kriteria'] ?? 'Kriteria ' . $kriteria['kriteria_id'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="standar_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Standar <span class="text-red-500">*</span></label>
                        <select name="standar_id" id="standar_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>
                            <option value="" disabled>Pilih Standar</option>
                            {{-- Options will be populated by JavaScript based on selected kriteria --}}
                        </select>
                    </div>
                    <div>
                        <label for="uraian_temuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Uraian Temuan <span class="text-red-500">*</span></label>
                        <textarea name="uraian_temuan" id="uraian_temuan" rows="4" placeholder="Masukkan uraian temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>{{ old('uraian_temuan', $findingData['uraian_temuan'] ?? '') }}</textarea>
                    </div>
                    <div>
                        <label for="kategori_temuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Temuan <span class="text-red-500">*</span></label>
                        <select name="kategori_temuan" id="kategori_temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>
                            <option value="" disabled>Pilih Kategori</option>
                            @foreach (['NC', 'AOC', 'OFI'] as $kategori)
                                <option value="{{ $kategori }}" {{ old('kategori_temuan', $findingData['kategori_temuan'] ?? '') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="saran_perbaikan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Saran Perbaikan</label>
                        <textarea name="saran_perbaikan" id="saran_perbaikan" rows="4" placeholder="Masukkan saran perbaikan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm">{{ old('saran_perbaikan', $findingData['saran_perbaikan'] ?? '') }}</textarea>
                    </div>
                </div>
            @endif

            {{-- Deskripsi Kategori Temuan --}}
            <div class="mt-6 text-sm text-gray-700 dark:text-gray-300 space-y-3">
                <p><strong>NC (Non-Conformity)</strong> adalah temuan yang bersifat ketidaksesuaian mayor, yaitu temuan-temuan yang memiliki dampak luas/kritikal terhadap persyaratan mutu produk/pelayanan dan persyaratan sistem manajemen mutu.</p>
                <p class="pl-4 italic">Contoh: Pelanggaran sistem secara total (sistem tidak dilaksanakan).</p>

                <p><strong>AOC (Area of Concern)</strong> adalah temuan yang bersifat ketidaksesuaian minor, yaitu temuan-temuan yang memiliki dampak kecil/terbatas terhadap persyaratan mutu produk/pelayanan dan persyaratan sistem manajemen mutu.</p>
                <p class="pl-4 italic">Contoh: Ketidaksempurnaan dan ketidakkonsistenan dalam penerapan sistem.</p>

                <p><strong>OFI (Opportunity for Improvement)</strong> adalah temuan yang bukan merupakan ketidaksesuaian yang dimaksudkan untuk penyempurnaan-penyempurnaan.</p>
                <p class="pl-4 italic">** Catatan: Hanya diisi bila auditor dapat memastikan saran perbaikannya adalah efektif.</p>
            </div>

            <div class="mt-6 flex gap-3 justify-end">
                <button type="submit" class="bg-sky-600 text-white text-sm font-medium py-2 px-4 rounded hover:bg-blue-700 {{ (empty($kriterias) || empty($allStandardsData)) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ (empty($kriterias) || empty($allStandardsData)) ? 'disabled' : '' }}>
                    Perbarui
                </button>
                <button type="button" class="bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 text-sm font-medium py-2 px-4 rounded hover:bg-gray-300 dark:hover:bg-gray-600" onclick="window.location.href='{{ route('auditor.laporan.index', ['auditingId' => $auditingId]) }}'">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Pass the data from PHP to JavaScript
    const standardsByKriteria = @json($standardsByKriteria ?? []);
    const findingData = @json($findingData ?? []);
    
    console.log('Standards by Kriteria:', standardsByKriteria);
    console.log('Finding Data:', findingData);
    
    // Function to populate standar dropdown based on selected kriteria
    function populateStandardDropdown(kriteriaId, selectedStandardId = null) {
        const standardSelect = document.getElementById('standar_id');
        standardSelect.innerHTML = '<option value="" disabled>Pilih Standar</option>';
        
        if (kriteriaId && standardsByKriteria[kriteriaId]) {
            standardSelect.disabled = false;
            
            standardsByKriteria[kriteriaId].forEach(function(standar) {
                const option = document.createElement('option');
                option.value = standar.standar_id;
                option.textContent = standar.nama_standar || ('Standar ' + standar.standar_id);
                
                // Set selected if this matches the selected standard ID
                if (selectedStandardId && standar.standar_id == selectedStandardId) {
                    option.selected = true;
                }
                
                standardSelect.appendChild(option);
            });
        } else {
            standardSelect.disabled = true;
        }
        
        // Trigger form validation update
        updateSubmitButton();
    }
    
    // Function to update submit button state
    function updateSubmitButton() {
        const submitButton = document.querySelector('button[type="submit"]');
        const form = document.getElementById('laporan-form');
        
        if (submitButton && form) {
            const isValid = form.checkValidity();
            submitButton.disabled = !isValid;
            submitButton.classList.toggle('opacity-50', !isValid);
            submitButton.classList.toggle('cursor-not-allowed', !isValid);
        }
    }
    
    // Function to create and display a dynamic toast message
    function showToast(message, type) {
        let toastContainer = document.getElementById('toast-notification-container');
        if (!toastContainer) {
            const newContainer = document.createElement('div');
            newContainer.id = 'toast-notification-container';
            newContainer.className = 'fixed top-4 right-4 z-50 flex flex-col items-end space-y-3';
            document.body.appendChild(newContainer);
            toastContainer = newContainer;
        }

        const toast = document.createElement('div');
        let bgColorClass = '';
        let textColorClass = '';
        let borderColorClass = '';

        if (type === 'success') {
            bgColorClass = 'bg-green-50 dark:bg-green-900/50';
            textColorClass = 'text-green-700 dark:text-green-300';
            borderColorClass = 'border-green-200 dark:border-green-700';
        } else if (type === 'danger') {
            bgColorClass = 'bg-red-50 dark:bg-red-900/50';
            textColorClass = 'text-red-700 dark:text-red-300';
            borderColorClass = 'border-red-200 dark:border-red-700';
        } else {
            bgColorClass = 'bg-blue-50 dark:bg-blue-900/50';
            textColorClass = 'text-blue-700 dark:text-blue-300';
            borderColorClass = 'border-blue-200 dark:border-blue-700';
        }

        toast.className = `p-4 rounded-lg text-sm border shadow-md transition-all duration-300 ease-out transform translate-x-full opacity-0 ${bgColorClass} ${textColorClass} ${borderColorClass}`;
        toast.innerHTML = `<div>${message}</div>`;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
        }, 100);

        setTimeout(() => {
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            toast.addEventListener('transitionend', () => toast.remove());
        }, 5000);
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('laporan-form');
        const submitButton = form.querySelector('button[type="submit"]');
        
        // Event listener for kriteria dropdown change
        document.getElementById('kriteria_id').addEventListener('change', function() {
            const selectedKriteriaId = this.value;
            console.log('Kriteria changed to:', selectedKriteriaId);
            
            // Clear and populate standar dropdown
            populateStandardDropdown(selectedKriteriaId);
        });
        
        // Event listeners for form validation
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        inputs.forEach(function(input) {
            input.addEventListener('change', updateSubmitButton);
            input.addEventListener('input', updateSubmitButton);
        });
        
        // Initialize form with existing data
        const currentKriteriaId = findingData.kriteria_id || '{{ old("kriteria_id", $findingData["kriteria_id"] ?? "") }}';
        const currentStandardId = findingData.standar_id || '{{ old("standar_id", $findingData["standar_id"] ?? "") }}';
        
        console.log('Current Kriteria ID:', currentKriteriaId);
        console.log('Current Standard ID:', currentStandardId);
        
        if (currentKriteriaId) {
            // Set the kriteria dropdown value
            document.getElementById('kriteria_id').value = currentKriteriaId;
            
            // Populate the standar dropdown with the current selection
            populateStandardDropdown(currentKriteriaId, currentStandardId);
        }
        
        // Form submission handler
        form.addEventListener('submit', (e) => {
            // Disable button immediately on submit
            submitButton.disabled = true;

            // Client-side validation before sending (basic check for required fields)
            const kriteriaIdInput = form.querySelector('[name="kriteria_id"]');
            const standarIdInput = form.querySelector('[name="standar_id"]');
            const uraianTemuanInput = form.querySelector('[name="uraian_temuan"]');
            const kategoriTemuanInput = form.querySelector('[name="kategori_temuan"]');

            if (!kriteriaIdInput.value || !standarIdInput.value || !uraianTemuanInput.value.trim() || !kategoriTemuanInput.value) {
                showToast('Harap lengkapi semua kolom wajib.', 'danger');
                submitButton.disabled = false;
                e.preventDefault(); // Prevent form submission if client-side validation fails
                return;
            }
        });
        
        // Initial validation check
        updateSubmitButton();
        
        // Logic to disable submit button if no kriterias are available on initial load
        if (@json($kriterias).length === 0) {
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
    });
</script>
@endpush
