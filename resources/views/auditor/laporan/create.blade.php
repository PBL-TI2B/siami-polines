@extends('layouts.app')

@section('title', 'Tambah Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index', ['auditingId' => $auditingId])],
        ['label' => 'Tambah Laporan', 'url' => '#'],
    ]" />

    <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
        Tambah Laporan Temuan
    </h1>

    <div class="mb-3 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
        {{-- Message Container for JavaScript messages (no longer strictly needed for form submission, but kept if client-side hints are desired) --}}
        <div id="js-message-container" class="mb-6 hidden">
            <div id="js-message" class="p-4 rounded-lg text-sm" role="alert"></div>
        </div>

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

        <form id="laporan-form" method="POST" action="{{ route('auditor.laporan.store', ['auditingId' => $auditingId]) }}" class="space-y-6">
            @csrf
            {{-- auditing_id will be sent as part of the form data --}}
            <input type="hidden" name="auditing_id" value="{{ $auditingId }}">

            <div id="findings-container" class="space-y-6">
                @if (empty($kriterias) || empty($standards))
                    <div class="mt-1 text-sm text-red-600 dark:text-red-400">
                        Tidak ada kriteria atau standar tersedia. <button type="button" onclick="window.location.reload()" class="underline hover:text-red-700">Coba lagi</button> atau
                        <a href="#" class="underline hover:text-red-700">hubungi administrator</a>.
                    </div>
                @else
                    {{-- Initial Finding Item --}}
                    <div class="finding-item mb-6 p-4 border border-gray-200 rounded-lg dark:border-gray-600" data-finding-index="0">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="kriteria_id_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kriteria <span class="text-red-500">*</span></label>
                                <select name="findings[0][kriteria_id]" id="kriteria_id_0" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>
                                    <option value="" disabled selected>Pilih Kriteria</option>
                                    @foreach ($kriterias as $kriteria)
                                        <option value="{{ $kriteria['kriteria_id'] }}" {{ old('findings.0.kriteria_id') == $kriteria['kriteria_id'] ? 'selected' : '' }}>
                                            {{ $kriteria['nama_kriteria'] ?? 'Kriteria ' . $kriteria['kriteria_id'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="standar_id_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Standar <span class="text-red-500">*</span></label>
                                <select name="findings[0][standar_id]" id="standar_id_0" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>
                                    <option value="" disabled selected>Pilih Standar</option>
                                    @foreach ($standards as $standar)
                                        <option value="{{ $standar['standar_id'] }}" {{ old('findings.0.standar_id') == $standar['standar_id'] ? 'selected' : '' }}>
                                            {{ $standar['nama_standar'] ?? 'Standar ' . $standar['standar_id'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="uraian_temuan_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Uraian Temuan <span class="text-red-500">*</span></label>
                                <textarea name="findings[0][uraian_temuan]" id="uraian_temuan_0" rows="4" placeholder="Masukkan uraian temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>{{ old('findings.0.uraian_temuan') }}</textarea>
                            </div>
                            <div>
                                <label for="kategori_temuan_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Temuan <span class="text-red-500">*</span></label>
                                <select name="findings[0][kategori_temuan]" id="kategori_temuan_0" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach (['NC', 'AOC', 'OFI'] as $kategori)
                                        <option value="{{ $kategori }}" {{ old('findings.0.kategori_temuan') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="saran_perbaikan_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Saran Perbaikan</label>
                                <textarea name="findings[0][saran_perbaikan]" id="saran_perbaikan_0" rows="4" placeholder="Masukkan saran perbaikan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm">{{ old('findings.0.saran_perbaikan') }}</textarea>
                            </div>
                        </div>
                        {{-- Remove button for the initial item. Will be managed by JS based on count. --}}
                        <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-finding">
                            Hapus Temuan
                        </button>
                        <button type="button" class="mt-2 ml-2 bg-green-100 text-green-600 hover:text-green-800 text-sm font-medium py-1 px-3 rounded add-same-kriteria">
                            Tambah Temuan pada Kriteria Ini
                        </button>
                    </div>
                @endif
            </div>

            {{-- Deskripsi Kategori Temuan --}}
            <div class="mt-6 text-sm text-gray-700 dark:text-gray-300 space-y-3">
                <p><strong>NC (Non-Conformity)</strong> adalah temuan yang bersifat ketidaksesuaian mayor, yaitu temuan-temuan yang memiliki dampak luas/kritikal terhadap persyaratan mutu produk/pelayanan dan persyaratan sistem manajemen mutu.</p>
                <p class="pl-4 italic">Contoh: Pelanggaran sistem secara total (sistem tidak dilaksanakan).</p>

                <p><strong>AOC (Area of Concern)</strong> adalah temuan yang bersifat ketidaksesuaian minor, yaitu temuan-temuan yang memiliki dampak kecil/terbatas terhadap persyaratan mutu produk/pelayanan dan persyaratan sistem manajemen mutu.</p>
                <p class="pl-4 italic">Contoh: Ketidaksempurnaan dan ketidakkonsistenan dalam penerapan sistem.</p>

                <p><strong>OFI (Opportunity for Improvement)</strong> adalah temuan yang bukan merupakan ketidaksesuaian yang dimaksudkan untuk penyempurnaan-penyempurnaan.</p>
                <p class="pl-4 italic">** Catatan: Hanya diisi bila auditor dapat memastikan saran perbaikannya adalah efektif.</p>
            </div>

            <button type="button" id="add-finding" class="mt-3 bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 text-sm font-medium py-1.5 px-4 rounded {{ empty($kriterias) || empty($standards) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ empty($kriterias) || empty($standards) ? 'disabled' : '' }}>
                Tambah Temuan
            </button>
            <div class="mt-6 flex gap-3 justify-end">
                <button type="submit" class="bg-sky-600 text-white text-sm font-medium py-2 px-4 rounded hover:bg-blue-700 {{ empty($kriterias) || empty($standards) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ empty($kriterias) || empty($standards) ? 'disabled' : '' }}>
                    Simpan
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
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('laporan-form');
        const findingsContainer = document.getElementById('findings-container');
        const addFindingBtn = document.getElementById('add-finding');
        const jsMessageContainer = document.getElementById('js-message-container');
        const jsMessage = document.getElementById('js-message');

        // Function to display messages (now mostly for client-side hints, not submission errors)
        function displayMessage(message, type = 'info') {
            jsMessage.innerHTML = message;
            jsMessageContainer.classList.remove('hidden', 'bg-green-50', 'bg-red-50', 'text-green-700', 'text-red-700', 'border', 'border-green-200', 'border-red-200', 'dark:bg-green-900/50', 'dark:border-green-700', 'dark:text-green-300', 'dark:bg-red-900/50', 'dark:border-red-700', 'dark:text-red-300');
            jsMessageContainer.classList.add('flex');
            if (type === 'success') {
                jsMessage.classList.add('bg-green-50', 'text-green-700', 'border', 'border-green-200', 'dark:bg-green-900/50', 'dark:border-green-700', 'dark:text-green-300');
            } else if (type === 'error') {
                jsMessage.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-200', 'dark:bg-red-900/50', 'dark:border-red-700', 'dark:text-red-300');
            }
            // Hide message after a few seconds
            setTimeout(() => jsMessageContainer.classList.add('hidden'), 5000);
        }

        const kriterias = @json($kriterias);
        const standards = @json($standards); // Standards are now passed from the backend

        // Generate select options for kriteria
        function generateCriteriaOptions(selectedValue = '') {
            let optionsHtml = '<option value="" disabled selected>Pilih Kriteria</option>';
            kriterias.forEach(kriteria => {
                const selectedAttr = (kriteria.kriteria_id == selectedValue) ? 'selected' : '';
                optionsHtml += `<option value="${kriteria.kriteria_id}" ${selectedAttr}>${kriteria.nama_kriteria ?? 'Kriteria ' + kriteria.kriteria_id}</option>`;
            });
            return optionsHtml;
        }

        // Generate select options for standar
        function generateStandardOptions(selectedValue = '') {
            let optionsHtml = '<option value="" disabled selected>Pilih Standar</option>';
            standards.forEach(standar => {
                const selectedAttr = (standar.standar_id == selectedValue) ? 'selected' : '';
                optionsHtml += `<option value="${standar.standar_id}" ${selectedAttr}>${standar.nama_standar}</option>`;
            });
            return optionsHtml;
        }

        // Generate select options for kategori temuan
        function generateKategoriTemuanOptions(selectedValue = '') {
            let optionsHtml = '<option value="" disabled selected>Pilih Kategori</option>';
            ['NC', 'AOC', 'OFI'].forEach(kategori => {
                const selectedAttr = (kategori == selectedValue) ? 'selected' : '';
                optionsHtml += `<option value="${kategori}" ${selectedAttr}>${kategori}</option>`;
            });
            return optionsHtml;
        }

        let findingCounter = findingsContainer.querySelectorAll('.finding-item').length;

        // Add Finding Item
        addFindingBtn.addEventListener('click', () => {
            if (kriterias.length === 0 || standards.length === 0) {
                displayMessage('Tidak ada kriteria atau standar tersedia untuk ditambahkan.', 'error');
                return;
            }
            addFindingItem();
        });

        function addFindingItem(kriteriaId = null, standarId = null) {
            const newFindingItemHtml = `
                <div class="finding-item mb-6 p-4 border border-gray-200 rounded-lg dark:border-gray-600" data-finding-index="${findingCounter}">
                    {{-- Close button for removing --}}
                    <button type="button" class="float-right text-red-600 hover:text-red-800 dark:hover:text-red-400 remove-finding">×</button>
                    <div class="grid grid-cols-1 gap-4">
                        <div><label for="kriteria_id_${findingCounter}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kriteria <span class="text-red-500">*</span></label><select name="findings[${findingCounter}][kriteria_id]" id="kriteria_id_${findingCounter}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>${generateCriteriaOptions(kriteriaId)}</select></div>
                        <div><label for="standar_id_${findingCounter}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Standar <span class="text-red-500">*</span></label><select name="findings[${findingCounter}][standar_id]" id="standar_id_${findingCounter}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>${generateStandardOptions(standarId)}</select></div>
                        <div><label for="uraian_temuan_${findingCounter}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Uraian Temuan <span class="text-red-500">*</span></label><textarea name="findings[${findingCounter}][uraian_temuan]" id="uraian_temuan_${findingCounter}" rows="4" placeholder="Masukkan uraian temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required></textarea></div>
                        <div><label for="kategori_temuan_${findingCounter}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Temuan <span class="text-red-500">*</span></label><select name="findings[${findingCounter}][kategori_temuan]" id="kategori_temuan_${findingCounter}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>${generateKategoriTemuanOptions()}</select></div>
                        <div><label for="saran_perbaikan_${findingCounter}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Saran Perbaikan</label><textarea name="findings[${findingCounter}][saran_perbaikan]" id="saran_perbaikan_${findingCounter}" rows="4" placeholder="Masukkan saran perbaikan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm"></textarea></div>
                    </div>
                    <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-finding">Hapus Temuan</button>
                    <button type="button" class="mt-2 ml-2 bg-green-100 text-green-600 hover:text-green-800 text-sm font-medium py-1 px-3 rounded add-same-kriteria">Tambah Temuan pada Kriteria Ini</button>
                </div>
            `;
            findingsContainer.insertAdjacentHTML('beforeend', newFindingItemHtml);
            findingCounter++;
            updateFindingIndices();
        }

        // Add Finding with Same Kriteria & Remove Finding via delegation
        findingsContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('add-same-kriteria')) {
                if (kriterias.length === 0 || standards.length === 0) {
                    displayMessage('Tidak ada kriteria atau standar tersedia untuk ditambahkan.', 'error');
                    return;
                }
                const findingItem = e.target.closest('.finding-item');
                const kriteriaSelect = findingItem.querySelector(`select[name^="findings["][name$="[kriteria_id]"]`);
                const kriteriaId = kriteriaSelect ? kriteriaSelect.value : '';

                if (!kriteriaId) {
                    displayMessage('Silakan pilih kriteria terlebih dahulu sebelum menambahkan temuan pada kriteria ini.', 'error');
                    return;
                }
                // Pass null for standarId to reset the standard dropdown
                addFindingItem(kriteriaId, null);

            } else if (e.target.classList.contains('remove-finding')) {
                const findingItem = e.target.closest('.finding-item');
                if (findingsContainer.querySelectorAll('.finding-item').length > 1) {
                    findingItem.remove();
                    updateFindingIndices();
                } else {
                    displayMessage('Setidaknya harus ada satu temuan.', 'error');
                }
            }
        });

        // Function to update data-finding-index, name, and id attributes for all inputs
        function updateFindingIndices() {
            findingsContainer.querySelectorAll('.finding-item').forEach((item, newIndex) => {
                item.setAttribute('data-finding-index', newIndex);
                item.querySelectorAll('[name^="findings["]').forEach(input => {
                    const oldName = input.getAttribute('name');

                    const newName = oldName.replace(/findings\[\d+\]/, `findings[${newIndex}]`);
                    input.setAttribute('name', newName);
                });
                item.querySelectorAll('[id^="kriteria_id_"], [id^="standar_id_"], [id^="uraian_temuan_"], [id^="kategori_temuan_"], [id^="saran_perbaikan_"]').forEach(input => {
                    const oldId = input.getAttribute('id');
                    const newId = oldId.replace(/_\d+$/, `_${newIndex}`);
                    input.setAttribute('id', newId);
                });
            });
            findingCounter = findingsContainer.querySelectorAll('.finding-item').length;
        }

        // Disable buttons if no kriterias or standards are available on initial load
        function updateButtonStates() {
            if (kriterias.length === 0 || standards.length === 0) {
                addFindingBtn.disabled = true;
                addFindingBtn.classList.add('opacity-50', 'cursor-not-allowed');
                form.querySelector('button[type="submit"]').disabled = true;
                form.querySelector('button[type="submit"]').classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                addFindingBtn.disabled = false;
                addFindingBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                form.querySelector('button[type="submit"]').disabled = false;
                form.querySelector('button[type="submit"]').classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
        updateButtonStates(); // Call initially
    });
</script>
@endpush
