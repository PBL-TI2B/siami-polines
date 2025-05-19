@extends('layouts.app')

@section('title', 'Tambah Data Instrumen (Prodi)')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data Instrumen Prodi', 'url' => route('admin.data-instrumen.instrumenprodi')],
            ['label' => 'Tambah Data Instrumen Prodi', 'url' => '#'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Tambah Data Instrumen Prodi
        </h1>

        <div class="mb-3 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
            <form id="instrument-form" method="POST">
                @csrf
                
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
                                                <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-unsur">
                                                    Hapus Unsur
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <button type="button" class="mt-2 bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium py-1 px-3 rounded add-unsur">
                                            Tambah Unsur
                                        </button>
                                    </div>
                                </div>
                                
                                <button type="button" class="mt-2 bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium py-1 px-3 rounded add-deskripsi">
                                    Tambah Deskripsi
                                </button>
                            </div>
                        </div>
                        
                        <button type="button" id="add-kriteria" class="mt-2 bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium py-1 px-3 rounded">
                            Tambah Kriteria
                        </button>
                    </div>
                </div>
                
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
        // =========================== BAGIAN 1: Inisialisasi Dropdown Unit Kerja ===========================
        async function populateUnitKerjaSelect() {
            const selectElement = document.getElementById('unit_kerja');
            try {
                const response = await fetch('http://127.0.0.1:5000/api/jenis-units');
                const result = await response.json();
                const data = result.data;
                selectElement.innerHTML = '<option value="">Pilih Jenis Unit Kerja</option>';
                data.forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit.jenis_unit_id;
                    option.textContent = unit.nama_jenis_unit;
                    selectElement.appendChild(option);
                });
            } catch (error) {
                console.error('Gagal memuat unit kerja:', error);
                selectElement.innerHTML = '<option value="">Gagal memuat unit kerja</option>';
            }
        }

        // Panggil fungsi untuk mengisi dropdown unit kerja
        await populateUnitKerjaSelect();

        // =========================== BAGIAN 2: Inisialisasi Data untuk Dropdown Kriteria ===========================
        let kriteriaData = [];

        try {
            const kriteriaResponse = await fetch('http://127.0.0.1:5000/api/kriteria');
            const kriteriaResult = await kriteriaResponse.json();
            kriteriaData = kriteriaResult.filter(item => item.nama_kriteria.trim() !== '');
            console.log('Kriteria Data:', kriteriaData);
        } catch (error) {
            console.error('Gagal memuat kriteria:', error);
        }

        // Fungsi untuk mengisi dropdown kriteria
        function populateKriteriaSelect(selectElement) {
            selectElement.innerHTML = '<option value="">Pilih Kriteria</option>';
            if (kriteriaData.length === 0) {
                selectElement.innerHTML = '<option value="">Tidak ada kriteria tersedia</option>';
                return;
            }
            kriteriaData.forEach(kriteria => {
                const option = document.createElement('option');
                option.value = kriteria.kriteria_id; // Menggunakan kriteria_id sebagai value
                option.textContent = kriteria.nama_kriteria; // Nama kriteria sebagai teks yang ditampilkan
                selectElement.appendChild(option);
            });
        }

        // Inisialisasi dropdown kriteria awal
        const initialKriteriaSelect = document.getElementById('kriteria_0');
        if (initialKriteriaSelect) {
            populateKriteriaSelect(initialKriteriaSelect);
        }

        // =========================== BAGIAN 3: Fungsionalitas Dinamis Form ===========================
        let kriteriaIndex = 0;

        // Tambah Kriteria (dengan dropdown untuk nama_kriteria)
        document.getElementById('add-kriteria').addEventListener('click', function () {
            kriteriaIndex++;
            const kriteriaContainer = document.getElementById('kriteria-container');
            const newKriteria = document.createElement('div');
            newKriteria.classList.add('kriteria-item', 'mb-6', 'p-4', 'border', 'border-gray-200', 'rounded-lg');
            newKriteria.innerHTML = `
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="kriteria_${kriteriaIndex}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Kriteria</label>
                        <select id="kriteria_${kriteriaIndex}" name="kriteria[${kriteriaIndex}][nama_kriteria]" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" 
                            required>
                            <option value="">Pilih Kriteria</option>
                        </select>
                    </div>
                </div>
                <div class="deskripsi-container mt-4 pl-4 border-l-2 border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-3">Deskripsi</h3>
                    <div class="deskripsi-item mb-4 p-3 border border-gray-200 rounded-lg">
                        <x-form-input id="isi_deskripsi_${kriteriaIndex}_0" name="kriteria[${kriteriaIndex}][deskripsi][0][isi_deskripsi]" 
                            label="Isi Deskripsi" placeholder="Masukkan isi deskripsi" 
                            :required="true" maxlength="255" />
                        <div class="unsur-container mt-3 pl-4 border-l-2 border-gray-200">
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-200 mb-2">Unsur</h4>
                            <div class="unsur-item mb-3 p-2 border border-gray-200 rounded-lg">
                                <x-form-input id="isi_unsur_${kriteriaIndex}_0_0" name="kriteria[${kriteriaIndex}][deskripsi][0][unsur][0][isi_unsur]" 
                                    label="Isi Unsur" placeholder="Masukkan isi unsur" 
                                    :required="true" maxlength="255" />
                                <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-unsur">
                                    Hapus Unsur
                                </button>
                            </div>
                        </div>
                        <button type="button" class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium py-1 px-3 rounded add-unsur">
                            Tambah Unsur
                        </button>
                    </div>
                </div>
                <button type="button" class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium py-1 px-3 rounded add-deskripsi">
                    Tambah Deskripsi
                </button>
                <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-kriteria">
                    Hapus Kriteria
                </button>
            `;
            kriteriaContainer.appendChild(newKriteria);
            populateKriteriaSelect(document.getElementById(`kriteria_${kriteriaIndex}`));
        });

        // Tambah Deskripsi (dengan input teks untuk isi_deskripsi)
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('add-deskripsi')) {
                const deskripsiContainer = e.target.closest('.kriteria-item').querySelector('.deskripsi-container');
                const kriteriaIndex = Array.from(document.querySelectorAll('.kriteria-item')).indexOf(e.target.closest('.kriteria-item'));
                const deskripsiIndex = deskripsiContainer.querySelectorAll('.deskripsi-item').length;
                const newDeskripsi = document.createElement('div');
                newDeskripsi.classList.add('deskripsi-item', 'mb-4', 'p-3', 'border', 'border-gray-200', 'rounded-lg');
                newDeskripsi.innerHTML = `
                    <x-form-input id="isi_deskripsi_${kriteriaIndex}_${deskripsiIndex}" name="kriteria[${kriteriaIndex}][deskripsi][${deskripsiIndex}][isi_deskripsi]" 
                        label="Isi Deskripsi" placeholder="Masukkan isi deskripsi" 
                        :required="true" maxlength="255" />
                    <div class="unsur-container mt-3 pl-4 border-l-2 border-gray-200">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-200 mb-2">Unsur</h4>
                        <div class="unsur-item mb-3 p-2 border border-gray-200 rounded-lg">
                            <x-form-input id="isi_unsur_${kriteriaIndex}_${deskripsiIndex}_0" name="kriteria[${kriteriaIndex}][deskripsi][${deskripsiIndex}][unsur][0][isi_unsur]" 
                                label="Isi Unsur" placeholder="Masukkan isi unsur" 
                                :required="true" maxlength="255" />
                            <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-unsur">
                                Hapus Unsur
                            </button>
                        </div>
                    </div>
                    <button type="button" class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium py-1 px-3 rounded add-unsur">
                        Tambah Unsur
                    </button>
                    <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-deskripsi">
                        Hapus Deskripsi
                    </button>
                `;
                deskripsiContainer.appendChild(newDeskripsi);
            }
        });

        // Tambah Unsur (dengan input teks untuk isi_unsur)
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('add-unsur')) {
                const unsurContainer = e.target.closest('.deskripsi-item').querySelector('.unsur-container');
                const kriteriaIndex = Array.from(document.querySelectorAll('.kriteria-item')).indexOf(e.target.closest('.kriteria-item'));
                const deskripsiIndex = Array.from(e.target.closest('.deskripsi-container').querySelectorAll('.deskripsi-item')).indexOf(e.target.closest('.deskripsi-item'));
                const unsurIndex = unsurContainer.querySelectorAll('.unsur-item').length;
                const newUnsur = document.createElement('div');
                newUnsur.classList.add('unsur-item', 'mb-3', 'p-2', 'border', 'border-gray-200', 'rounded-lg');
                newUnsur.innerHTML = `
                    <x-form-input id="isi_unsur_${kriteriaIndex}_${deskripsiIndex}_${unsurIndex}" name="kriteria[${kriteriaIndex}][deskripsi][${deskripsiIndex}][unsur][${unsurIndex}][isi_unsur]" 
                        label="Isi Unsur" placeholder="Masukkan isi unsur" 
                        :required="true" maxlength="255" />
                    <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-unsur">
                        Hapus Unsur
                    </button>
                `;
                unsurContainer.appendChild(newUnsur);
            }
        });

        // Hapus Kriteria
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-kriteria')) {
                const kriteriaItem = e.target.closest('.kriteria-item');
                if (document.querySelectorAll('.kriteria-item').length > 1) {
                    kriteriaItem.remove();
                } else {
                    alert('Setidaknya satu kriteria harus ada.');
                }
            }
        });

        // Hapus Deskripsi
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-deskripsi')) {
                const deskripsiItem = e.target.closest('.deskripsi-item');
                if (deskripsiItem.closest('.deskripsi-container').querySelectorAll('.deskripsi-item').length > 1) {
                    deskripsiItem.remove();
                } else {
                    alert('Setidaknya satu deskripsi harus ada.');
                }
            }
        });

        // Hapus Unsur
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-unsur')) {
                const unsurItem = e.target.closest('.unsur-item');
                if (unsurItem.closest('.unsur-container').querySelectorAll('.unsur-item').length > 1) {
                    unsurItem.remove();
                } else {
                    alert('Setidaknya satu unsur harus ada.');
                }
            }
        });

        // =========================== BAGIAN 4: Pengiriman Form ===========================
        document.getElementById('instrument-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const unitKerjaId = formData.get('unit_kerja_id') ? parseInt(formData.get('unit_kerja_id')) : null;

            // Validasi unit_kerja_id
            if (!unitKerjaId) {
                alert('Pilih Unit Kerja terlebih dahulu.');
                return;
            }

            const data = { kriteria: [] };

            // Mengumpulkan data dari form
            let isValid = true;
            const errors = [];

            document.querySelectorAll('.kriteria-item').forEach((kriteriaItem, kIndex) => {
                const kriteriaSelect = kriteriaItem.querySelector(`select[name="kriteria[${kIndex}][nama_kriteria]"]`);
                const namaKriteriaId = kriteriaSelect.value; // Ambil kriteria_id dari value
                const kriteriaName = kriteriaData.find(k => k.kriteria_id == namaKriteriaId)?.nama_kriteria || '';

                if (!namaKriteriaId || namaKriteriaId === '') {
                    errors.push(`Pilih Kriteria untuk item ke-${kIndex + 1}.`);
                    isValid = false;
                    return;
                }

                const kriteria = {
                    nama_kriteria: kriteriaName, // Gunakan nama_kriteria dari kriteriaData
                    deskripsi: []
                };

                kriteriaItem.querySelectorAll('.deskripsi-item').forEach((deskripsiItem, dIndex) => {
                    const isiDeskripsi = formData.get(`kriteria[${kIndex}][deskripsi][${dIndex}][isi_deskripsi]`);
                    if (!isiDeskripsi) {
                        errors.push(`Isi Deskripsi untuk item ke-${kIndex + 1}, deskripsi ke-${dIndex + 1} wajib diisi.`);
                        isValid = false;
                        return;
                    }

                    const deskripsi = {
                        isi_deskripsi: isiDeskripsi,
                        unsur: []
                    };

                    deskripsiItem.querySelectorAll('.unsur-item').forEach((unsurItem, uIndex) => {
                        const isiUnsur = formData.get(`kriteria[${kIndex}][deskripsi][${dIndex}][unsur][${uIndex}][isi_unsur]`);
                        if (!isiUnsur) {
                            errors.push(`Isi Unsur untuk item ke-${kIndex + 1}, deskripsi ke-${dIndex + 1}, unsur ke-${uIndex + 1} wajib diisi.`);
                            isValid = false;
                            return;
                        }

                        const unsur = {
                            isi_unsur: isiUnsur,
                            unit_kerja_id: unitKerjaId
                        };
                        deskripsi.unsur.push(unsur);
                    });

                    if (deskripsi.unsur.length === 0) {
                        errors.push(`Setidaknya satu Unsur harus diisi untuk deskripsi ke-${dIndex + 1} pada item ke-${kIndex + 1}.`);
                        isValid = false;
                        return;
                    }

                    kriteria.deskripsi.push(deskripsi);
                });

                if (kriteria.deskripsi.length === 0) {
                    errors.push(`Setidaknya satu Deskripsi harus diisi untuk item ke-${kIndex + 1}.`);
                    isValid = false;
                    return;
                }

                data.kriteria.push(kriteria);
            });

            if (data.kriteria.length === 0) {
                errors.push('Setidaknya satu Kriteria harus diisi.');
                isValid = false;
            }

            // Tampilkan semua error sekaligus
            if (!isValid) {
                alert(errors.join('\n'));
                return;
            }

            // Transformasi data ke format API
            const payload = [];
            data.kriteria.forEach(kriteria => {
                kriteria.deskripsi.forEach(deskripsi => {
                    deskripsi.unsur.forEach(unsur => {
                        payload.push({
                            jenis_unit_id: unsur.unit_kerja_id,
                            aktivitas_id: null, // Secara eksplisit menyertakan aktivitas_id
                            unsur: {
                                isi_unsur: unsur.isi_unsur,
                                deskripsi: {
                                    isi_deskripsi: deskripsi.isi_deskripsi,
                                    kriteria: {
                                        nama_kriteria: kriteria.nama_kriteria
                                    }
                                }
                            }
                        });
                    });
                });
            });

            // Debugging: Log payload sebelum dikirim
            console.log('Payload yang akan dikirim:', payload);

            // Kirim data ke API
            fetch('http://127.0.0.1:5000/api/set-instrumen', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(payload)
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(result => {
                    alert('Data berhasil disimpan!');
                    window.location.href = '{{ route("admin.data-instrumen.instrumenprodi") }}';
                })
                .catch(error => {
                    console.error('Gagal menyimpan data:', error);
                    alert('Gagal menyimpan data. Silakan coba lagi. Periksa konsol untuk detail.');
                });
        });
    });
    </script>
@endsection