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
    <script>
    document.addEventListener('DOMContentLoaded', async function () {
        const instrumenId = "{{ $id }}";
        const instrumenUrl = `http://127.0.0.1:5000/api/set-instrumen/${instrumenId}`;
        const kriteriaUrl = `http://127.0.0.1:5000/api/kriteria`;

        try {
            // Ambil data instrumen & kriteria
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

            // Set Jenis Unit Kerja
            const unitKerjaSelect = document.getElementById('unit_kerja');
            unitKerjaSelect.innerHTML = `
                <option value="${data.jenisunit.jenis_unit_id}" selected>${data.jenisunit.nama_jenis_unit}</option>
            `;

            // Buat form kriteria
            const kriteriaContainer = document.getElementById('kriteria-container');
            kriteriaContainer.innerHTML = ''; // Kosongkan kontainer dummy

            const kriteriaIndex = 0;
            const deskripsiIndex = 0;
            const unsurIndex = 0;

            // Bangun isi dropdown kriteria
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
            console.error('Gagal mengambil data:', error);
        }
    });

    const form = document.getElementById('instrument-form');
    form.addEventListener('submit', async function (event) {
        event.preventDefault(); // Mencegah reload halaman
        console.log('Form submission intercepted');
        const instrumenId = "{{ $id }}"; // pastikan $id dari Blade tersedia
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
        console.log(payload);

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
                alert('Berhasil memperbarui data!');
                console.log(result);
                window.location.href = '{{ route("admin.data-instrumen.instrumenprodi") }}';
            } else {
                alert('Gagal menyimpan: ' + (result.message || 'Unknown error'));
                console.error(result);
            }
        } catch (error) {
            alert('Terjadi kesalahan saat mengirim data.');
            console.error(error);
        }
    });
    </script>
@endsection