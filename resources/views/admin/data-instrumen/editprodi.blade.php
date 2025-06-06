@extends('layouts.app')

@section('title', 'Edit Data Instrumen (Prodi)')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data Instrumen Prodi', 'url' => route('admin.data-instrumen.instrumenprodi')],
            ['label' => 'Edit Data Instrumen Prodi', 'url' => '#'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Edit Data Instrumen Prodi
        </h1>

        <div class="mb-3 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
            <form id="instrument-form" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <!-- Unit Kerja Dropdown -->
                    <div class="mb-6">
                        <label for="unit_kerja" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Unit Kerja</label>
                        <select id="unit_kerja" name="unit_kerja_id" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" 
                            required>
                            <option value="">Pilih Jenis Unit Kerja</option>
                        </select>
                    </div>

                    <!-- Kriteria Section -->
                    <div class="border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-200 mb-4">Kriteria</h2>
                        
                        <div id="kriteria-container">
                            <!-- Contoh satu item default, nanti bisa diganti JS dari data API -->
                            <div class="kriteria-item mb-6 p-4 border border-gray-200 rounded-lg">
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label for="kriteria_0" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Kriteria</label>
                                        <select id="kriteria_0" name="kriteria[0][nama_kriteria]" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" 
                                            required>
                                            <option value="">Pilih Kriteria</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Deskripsi Section -->
                                <div class="deskripsi-container mt-4 pl-4 border-l-2 border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-3">Deskripsi</h3>
                                    
                                    <div class="deskripsi-item mb-4 p-3 border border-gray-200 rounded-lg">
                                        <x-form-input id="isi_deskripsi_0_0" name="kriteria[0][deskripsi][0][isi_deskripsi]" 
                                            label="Isi Deskripsi" placeholder="Masukkan isi deskripsi" 
                                            :required="true" maxlength="255" />
                                        
                                        <!-- Unsur Section -->
                                        <div class="unsur-container mt-3 pl-4 border-l-2 border-gray-200">
                                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-200 mb-2">Unsur</h4>
                                            
                                            <div class="unsur-item mb-3 p-2 border border-gray-200 rounded-lg">
                                                <x-form-input id="isi_unsur_0_0_0" name="kriteria[0][deskripsi][0][unsur][0][isi_unsur]" 
                                                    label="Isi Unsur" placeholder="Masukkan isi unsur" 
                                                    :required="true" maxlength="255" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="mt-6 flex gap-3">
                    <x-button type="submit" color="sky" icon="heroicon-o-plus">
                        Simpan
                    </x-button>
                    <x-button color="red" icon="heroicon-o-x-mark" href="{{ route('admin.data-instrumen.instrumenprodi') }}">
                        Batal
                    </x-button>
                </div>
            </form>
        </div>
    </div>
    {{-- modal toast --}}
    <div id="responseModal" class="hidden fixed top-4 end-4 z-50 bg-transparent transition-opacity duration-300">
        <div class="w-full max-w-md p-4 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200" id="modalIcon">
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
    document.addEventListener('DOMContentLoaded', async function () {
        const instrumenId = "{{ $id }}";
        const instrumenUrl = `http://127.0.0.1:5000/api/set-instrumen/${instrumenId}`;
        const kriteriaUrl = `http://127.0.0.1:5000/api/kriteria`;

        try {
            // Fetch data (unchanged)
            const [instrumenRes, kriteriaRes] = await Promise.all([
                fetch(instrumenUrl),
                fetch(kriteriaUrl)
            ]);

            const instrumenData = await instrumenRes.json();
            const kriteriaList = await kriteriaRes.json();

            const data = instrumenData.data;
            const selectedKriteriaId = data.unsur.deskripsi.kriteria.kriteria_id;
            const isiDeskripsi = data.unsur.deskripsi.isi_deskripsi;
            const isiUnsur = data.unsur.isi_unsur;

            // Set unit kerja (unchanged)
            const unitKerjaSelect = document.getElementById('unit_kerja');
            unitKerjaSelect.innerHTML = `
                <option value="${data.jenisunit.jenis_unit_id}" selected>${data.jenisunit.nama_jenis_unit}</option>
            `;

            // Build kriteria form (unchanged)
            const kriteriaContainer = document.getElementById('kriteria-container');
            kriteriaContainer.innerHTML = '';

            const kriteriaIndex = 0;
            const deskripsiIndex = 0;
            const unsurIndex = 0;

            const kriteriaOptions = kriteriaList.map(kriteria => {
                const selected = kriteria.kriteria_id === selectedKriteriaId ? 'selected' : '';
                return `<option value="${kriteria.kriteria_id}" ${selected}>${kriteria.nama_kriteria}</option>`;
            }).join('');

            const kriteriaHtml = `
                <div class="kriteria-item mb-6 p-4 border border-gray-200 rounded-lg">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="kriteria_${kriteriaIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Kriteria</label>
                            <select id="kriteria_${kriteriaIndex}" name="kriteria[${kriteriaIndex}][nama_kriteria]"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                required>
                                <option value="">Pilih Kriteria</option>
                                ${kriteriaOptions}
                            </select>
                        </div>
                    </div>
                    <div class="deskripsi-container mt-4 pl-4 border-l-2 border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-3">Deskripsi</h3>
                        <div class="deskripsi-item mb-4 p-3 border border-gray-200 rounded-lg">
                            <label for="isi_deskripsi_${kriteriaIndex}_${deskripsiIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Isi Deskripsi</label>
                            <input type="text" id="isi_deskripsi_${kriteriaIndex}_${deskripsiIndex}" name="kriteria[${kriteriaIndex}][deskripsi][${deskripsiIndex}][isi_deskripsi]"
                                value="${isiDeskripsi}" required maxlength="255"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                            <div class="unsur-container mt-3 pl-4 border-l-2 border-gray-200">
                                <h4 class="text-md font-medium text-gray-900 dark:text-gray-200 mb-2">Unsur</h4>
                                <div class="unsur-item mb-3 p-2 border border-gray-200 rounded-lg">
                                    <label for="isi_unsur_${kriteriaIndex}_${deskripsiIndex}_${unsurIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Isi Unsur</label>
                                    <input type="text" id="isi_unsur_${kriteriaIndex}_${deskripsiIndex}_${unsurIndex}" name="kriteria[${kriteriaIndex}][deskripsi][${deskripsiIndex}][unsur][${unsurIndex}][isi_unsur]"
                                        value="${isiUnsur}" required maxlength="255"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            kriteriaContainer.insertAdjacentHTML('beforeend', kriteriaHtml);
        } catch (error) {
            showToast('Gagal mengambil data. Silakan coba lagi.', false);
        }
    });

    // Toast function
    function showToast(message, isSuccess = true) {
        const modal = document.getElementById('responseModal');
        const modalMessage = document.getElementById('modalMessage');
        const modalIcon = document.getElementById('modalIcon');

        modalMessage.textContent = message;
        modalIcon.className = isSuccess
            ? 'inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200'
            : 'inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200';
        modal.classList.remove('hidden');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 3000);
    }

    // Close button event listener
    document.getElementById('closeResponseModal').addEventListener('click', () => {
        document.getElementById('responseModal').classList.add('hidden');
    });

    // Form submission
    const form = document.getElementById('instrument-form');
    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        const instrumenId = "{{ $id }}";
        const endpoint = `http://127.0.0.1:5000/api/set-instrumen/${instrumenId}`;

        const jenisUnitId = document.getElementById('unit_kerja').value;
        const isiDeskripsi = document.querySelector('[name="kriteria[0][deskripsi][0][isi_deskripsi]"]').value;
        const isiUnsur = document.querySelector('[name="kriteria[0][deskripsi][0][unsur][0][isi_unsur]"]').value;

        const kriteriaSelect = document.querySelector('[name="kriteria[0][nama_kriteria]"]');
        const namaKriteria = kriteriaSelect.options[kriteriaSelect.selectedIndex].text;

        const payload = {
            jenis_unit_id: parseInt(jenisUnitId),
            aktivitas_id: null,
            unsur: {
                isi_unsur: isiUnsur,
                deskripsi: {
                    isi_deskripsi: isiDeskripsi,
                    kriteria: {
                        nama_kriteria: namaKriteria
                    }
                }
            }
        };

        try {
            const response = await fetch(endpoint, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (response.ok) {
                showToast('Berhasil memperbarui data!', true);
                setTimeout(() => {
                    window.location.href = '{{ route("admin.data-instrumen.instrumenprodi") }}';
                }, 2000);
            } else {
                showToast('Gagal menyimpan: ' + (result.message || 'Unknown error'), false);
            }
        } catch (error) {
            showToast('Terjadi kesalahan saat mengirim data.', false);
        }
    });
    </script>
@endsection