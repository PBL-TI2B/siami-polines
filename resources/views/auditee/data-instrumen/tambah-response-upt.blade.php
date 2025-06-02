@extends('layouts.app')

@section('title', isset($response) ? 'Edit Jawaban UPT' : 'Tambah Jawaban UPT')

@section('content')
    <div class="max-w-3xl mx-auto px-6 py-8 sm:px-12 lg:px-16">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            ['label' => 'Response Instrumen UPT', 'url' => '/auditee/data-instrumen/upt'],
            ['label' => isset($response) ? 'Edit Jawaban' : 'Tambah Jawaban'],
        ]" />

        <!-- Heading -->
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
            {{ isset($response) ? 'Edit Jawaban UPT' : 'Tambah Jawaban UPT' }}
        </h1>

        <!-- Loading State -->
        <div id="loading" class="flex items-center justify-center text-gray-600 dark:text-gray-300 mb-6">
            <svg class="animate-spin h-5 w-5 mr-3 text-blue-600" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-16 0z"></path>
            </svg>
            Memuat data instrumen...
        </div>

        <!-- Error State -->
        <div id="error" class="hidden text-center text-red-600 dark:text-red-400 mb-6 bg-red-50 dark:bg-red-900/20 p-4 rounded-lg">
            Gagal memuat data instrumen. Silakan coba lagi.
        </div>

        <!-- Form -->
        <div id="form-container" class="hidden bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-600 rounded-xl p-8">
            <form id="responseForm" method="POST">
                @csrf
                <!-- Detail Instrumen -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Detail Instrumen</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sasaran Strategis</label>
                            <input type="text" id="sasaran_strategis" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-900 dark:text-gray-200" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Indikator Kinerja</label>
                            <input type="text" id="indikator_kinerja" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-900 dark:text-gray-200" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Aktivitas</label>
                            <input type="text" id="aktivitas" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-900 dark:text-gray-200" readonly>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Satuan</label>
                                <input type="text" id="satuan" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-900 dark:text-gray-200" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Target</label>
                                <input type="text" id="target" class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-900 dark:text-gray-200" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Response Fields -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Isi Jawaban</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="capaian" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capaian</label>
                            <input type="text" name="capaian" id="capaian" value="{{ old('capaian', isset($response) ? $response->capaian : '') }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required>
                            <span id="capaian-error" class="mt-1 text-sm text-red-600 hidden"></span>
                        </div>
                        <div>
                            <label for="keteranganan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keteranganan</label>
                            <textarea name="keteranganan" id="keteranganan" rows="4" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">{{ old('keteranganan', isset($response) ? $response->keteranganan : '') }}</textarea>
                            <span id="keteranganan-error" class="mt-1 text-sm text-red-600 hidden"></span>
                        </div>
                        <div>
                            <label for="lokasi_bukti_dukung" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Bukti Dukung</label>
                            <input type="text" name="lokasi_bukti_dukung" id="lokasi_bukti_dukung" value="{{ old('lokasi_bukti_dukung', isset($response) ? $response->lokasi_bukti_dukung : '') }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">
                            <span id="lokasi_bukti_dukung-error" class="mt-1 text-sm text-red-600 hidden"></span>
                        </div>
                        <div>
                            <label for="ofi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">OFI (Saran Tindak Lanjut)</label>
                            <textarea name="ofi" id="ofi" rows="4" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm py-2 px-3 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200">{{ old('ofi', isset($response) ? $response->ofi : '') }}</textarea>
                            <span id="ofi-error" class="mt-1 text-sm text-red-600 hidden"></span>
                        </div>
                    </div>
                </div>

                <!-- Hidden Fields -->
                <input type="hidden" name="set_instrumen_unit_kerja_id" id="set_instrumen_unit_kerja_id" value="{{ isset($response) ? $response->set_instrumen_unit_kerja_id : '' }}">
                <input type="hidden" name="auditing_id" id="auditing_id" value="{{ session('auditing_id') }}">
                @if(isset($response))
                    <input type="hidden" name="response_id" id="response_id" value="{{ $response->response_id }}">
                @endif

                <!-- Form Actions -->
                <div class="flex justify-end gap-4">
                    <a href="/auditee/data-instrumen/upt" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Batal
                    </a>
                    <button type="submit" id="submitResponse" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        {{ isset($response) ? 'Simpan Perubahan' : 'Simpan Jawaban' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('responseForm');
        const submitBtn = document.getElementById('submitResponse');
        const loadingEl = document.getElementById('loading');
        const errorEl = document.getElementById('error');
        const formContainer = document.getElementById('form-container');
        const setInstrumenIdInput = document.getElementById('set_instrumen_unit_kerja_id');

        // Get set_instrumen_unit_kerja_id
        let setInstrumenId = setInstrumenIdInput.value;
        if (!setInstrumenId) {
            const urlParts = window.location.pathname.split('/');
            setInstrumenId = urlParts[urlParts.length - 1];
        }

        // Fetch instrumen data
        fetch(`http://127.0.0.1:5000/api/set-instrumen/${setInstrumenId}`)
            .then(response => {
                if (!response.ok) throw new Error('Gagal mengambil data instrumen');
                return response.json();
            })
            .then(result => {
                const instrumen = result.data;
                if (!instrumen || instrumen.jenis_unit_id !== 2) {
                    throw new Error('Instrumen tidak valid atau bukan UPT');
                }

                document.getElementById('sasaran_strategis').value = instrumen.aktivitas.indikator_kinerja.sasaran_strategis.nama_sasaran || '-';
                document.getElementById('indikator_kinerja').value = instrumen.aktivitas.indikator_kinerja.isi_indikator_kinerja || '-';
                document.getElementById('aktivitas').value = instrumen.aktivitas.nama_aktivitas || '-';
                document.getElementById('satuan').value = instrumen.aktivitas.satuan || '-';
                document.getElementById('target').value = instrumen.aktivitas.target || '-';
                setInstrumenIdInput.value = instrumen.set_instrumen_unit_kerja_id;

                loadingEl.classList.add('hidden');
                formContainer.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                loadingEl.classList.add('hidden');
                errorEl.textContent = error.message || 'Gagal memuat data instrumen. Silakan coba lagi.';
                errorEl.classList.remove('hidden');
            });

        // Client-side validation
        const validateForm = () => {
            let isValid = true;
            const capaian = document.getElementById('capaian');
            const capaianError = document.getElementById('capaian-error');

            if (!capaian.value.trim()) {
                capaianError.textContent = 'Capaian wajib diisi';
                capaianError.classList.remove('hidden');
                isValid = false;
            } else {
                capaianError.classList.add('hidden');
            }

            return isValid;
        };

        // Form submission
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!validateForm()) return;

            const formData = new FormData(form);
            const data = {
                set_instrumen_unit_kerja_id: formData.get('set_instrumen_unit_kerja_id'),
                auditing_id: formData.get('auditing_id'),
                capaian: formData.get('capaian'),
                keteranganan: formData.get('keteranganan') || '',
                lokasi_bukti_dukung: formData.get('lokasi_bukti_dukung') || '',
                ofi: formData.get('ofi') || '',
            };

            const isEdit = !!formData.get('response_id');
            const method = isEdit ? 'PUT' : 'POST';
            const endpoint = isEdit 
                ? `http://127.0.0.1:5000/api/responses/${formData.get('response_id')}`
                : 'http://127.0.0.1:5000/api/responses';

            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2 text-white" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-16 0z"></path>
                </svg>
                Menyimpan...
            `;

            fetch(endpoint, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            })
                .then(response => {
                    if (!response.ok) return response.json().then(err => { throw err; });
                    return response.json();
                })
                .then(result => {
                    alert(isEdit ? 'Jawaban berhasil diperbarui!' : 'Jawaban berhasil disimpan!');
                    window.location.href = '/auditee/data-instrumen/upt';
                })
                .catch(error => {
                    const errorEl = document.getElementById('capaian-error');
                    if (error.errors) {
                        errorEl.textContent = error.errors.capaian?.join(', ') || 'Terjadi kesalahan';
                        errorEl.classList.remove('hidden');
                    } else {
                        alert('Terjadi kesalahan: ' + (error.message || 'Tidak dapat menyimpan jawaban'));
                    }
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = isEdit ? 'Simpan Perubahan' : 'Simpan Jawaban';
                });
        });
    });
    </script>
@endsection