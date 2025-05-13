@extends('layouts.app')

@section('title', 'Edit Data Instrumen')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data Instrumen', 'url' => route('admin.data-instrumen.index')],
            ['label' => 'Edit Data', 'url' => '#'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Edit Data Instrumen
        </h1>

        <div class="mb-3 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
            <form id="instrument-form" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Sasaran Section -->
                    <div class="border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-200 mb-4">Sasaran</h2>
                        
                        <div id="sasaran-container">
                            <!-- Sasaran akan diisi secara dinamis oleh JavaScript -->
                        </div>
                        
                        <button type="button" id="add-sasaran" class="mt-2 bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium py-1 px-3 rounded">
                            Tambah Sasaran
                        </button>
                    </div>
                </div>
                
                <div class="mt-6 flex gap-3">
                    <x-button type="submit" color="sky" icon="">
                        Simpan
                    </x-button>
                    <x-button color="gray" icon="heroicon-o-x-mark"
                        href="{{ route('admin.data-instrumen.index') }}">
                        Batal
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('instrument-form');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const apiUrl = 'http://127.0.0.1:5000/api/data-instrumen/{{ $sasaran_strategis_id }}';
        let sasaranCounter = 0;

        // Fungsi untuk membuat elemen Sasaran
        function createSasaranItem(sasaranIndex, namaSasaran = '', indikatorKinerja = []) {
            // Escape HTML characters to prevent XSS or rendering issues
            const escapedNamaSasaran = namaSasaran.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
            const sasaranItem = `
                <div class="sasaran-item mb-6 p-4 border border-gray-200 rounded-lg">
                    <button type="button" class="float-right text-red-600 hover:text-red-800 remove-sasaran">×</button>
                    <x-form-input id="nama_sasaran_${sasaranIndex}" name="sasaran[${sasaranIndex}][nama_sasaran]" 
                        label="Nama Sasaran" placeholder="Masukkan nama sasaran" 
                        :required="true" maxlength="255" value="${escapedNamaSasaran}" />
                    
                    <div class="indikator-container mt-4 pl-4 border-l-2 border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-3">Indikator Kinerja</h3>
                        <div class="indikator-items">
                            ${indikatorKinerja.map((indikator, indikatorIndex) => createIndikatorItem(sasaranIndex, indikatorIndex, indikator.isi_indikator_kinerja, indikator.aktivitas)).join('')}
                        </div>
                    </div>
                    
                    <button type="button" class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium py-1 px-3 rounded add-indikator">
                        Tambah Indikator Kinerja
                    </button>
                </div>
            `;
            return sasaranItem;
        }

        // Fungsi untuk membuat elemen Indikator Kinerja
        function createIndikatorItem(sasaranIndex, indikatorIndex, isiIndikator = '', aktivitas = []) {
            const escapedIsiIndikator = isiIndikator.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
            const indikatorItem = `
                <div class="indikator-item mb-4 p-3 border border-gray-200 rounded-lg">
                    <button type="button" class="float-right text-red-600 hover:text-red-800 remove-indikator">×</button>
                    <x-form-input id="isi_indikator_kinerja_${sasaranIndex}_${indikatorIndex}" name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorIndex}][isi_indikator_kinerja]" 
                        label="Isi Indikator Kinerja" placeholder="Masukkan indikator kinerja" 
                        :required="true" maxlength="255" value="${escapedIsiIndikator}" />
                    
                    <div class="aktivitas-container mt-3 pl-4 border-l-2 border-gray-200">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-200 mb-2">Aktivitas</h4>
                        <div class="aktivitas-items">
                            ${aktivitas.map((akt, aktivitasIndex) => createAktivitasItem(sasaranIndex, indikatorIndex, aktivitasIndex, akt.nama_aktivitas, akt.satuan, akt.target)).join('')}
                        </div>
                    </div>
                    
                    <button type="button" class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium py-1 px-3 rounded add-aktivitas">
                        Tambah Aktivitas
                    </button>
                </div>
            `;
            return indikatorItem;
        }

        // Fungsi untuk membuat elemen Aktivitas
        function createAktivitasItem(sasaranIndex, indikatorIndex, aktivitasIndex, namaAktivitas = '', satuan = '', target = '') {
            const escapedNamaAktivitas = namaAktivitas.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
            const escapedSatuan = satuan.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
            const escapedTarget = target.toString().replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
            const aktivitasItem = `
                <div class="aktivitas-item mb-3 p-2 border border-gray-200 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-form-input id="nama_aktivitas_${sasaranIndex}_${indikatorIndex}_${aktivitasIndex}" name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorIndex}][aktivitas][${aktivitasIndex}][nama_aktivitas]" 
                            label="Nama Aktivitas" placeholder="Masukkan nama aktivitas" 
                            :required="true" maxlength="255" value="${escapedNamaAktivitas}" />
                        <x-form-input id="satuan_${sasaranIndex}_${indikatorIndex}_${aktivitasIndex}" name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorIndex}][aktivitas][${aktivitasIndex}][satuan]" 
                            label="Satuan" placeholder="Masukkan satuan" 
                            :required="true" maxlength="50" value="${escapedSatuan}" />
                        <x-form-input id="target_${sasaranIndex}_${indikatorIndex}_${aktivitasIndex}" name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorIndex}][aktivitas][${aktivitasIndex}][target]" 
                            label="Target" placeholder="Masukkan target" 
                            :required="true" value="${escapedTarget}" />
                    </div>
                    <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-aktivitas">
                        Hapus Aktivitas
                    </button>
                </div>
            `;
            return aktivitasItem;
        }

        // Muat data dari API
        async function loadData() {
            try {
                console.log('Fetching data from:', apiUrl);
                const response = await fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                console.log('API Response:', data);

                // Pastikan data adalah array
                if (!Array.isArray(data)) {
                    throw new Error('Expected an array from API');
                }

                const sasaranContainer = document.getElementById('sasaran-container');

                // Kosongkan container
                sasaranContainer.innerHTML = '';

                // Jika data kosong, tambahkan form kosong
                if (data.length === 0) {
                    console.log('Data is empty, adding empty form');
                    sasaranCounter = 0;
                    sasaranContainer.insertAdjacentHTML('beforeend', createSasaranItem(sasaranCounter));
                    return;
                }

                // Isi form dengan data dari API
                data.forEach((sasaran, index) => {
                    console.log(`Processing sasaran ${index}:`, sasaran);
                    if (!sasaran.nama_sasaran || !sasaran.indikator_kinerja) {
                        console.error('Invalid sasaran data:', sasaran);
                        return;
                    }

                    sasaranCounter = index;
                    sasaranContainer.insertAdjacentHTML('beforeend', createSasaranItem(index, sasaran.nama_sasaran, sasaran.indikator_kinerja));
                });

                // Perbarui counter untuk penambahan Sasaran berikutnya
                sasaranCounter = data.length - 1;
            } catch (error) {
                console.error('Error in loadData:', error);
                alert('Terjadi kesalahan saat memuat data: ' + error.message);
            }
        }

        // Panggil fungsi untuk memuat data saat halaman dimuat
        loadData();

        // Penanganan pengiriman form
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Kumpulkan data form
            const sasaranItems = document.querySelectorAll('.sasaran-item');
            const data = [];

            sasaranItems.forEach((sasaranItem, sasaranIndex) => {
                const namaSasaran = sasaranItem.querySelector(`[name="sasaran[${sasaranIndex}][nama_sasaran]"]`).value;
                const indikatorItems = sasaranItem.querySelectorAll('.indikator-item');
                const indikatorKinerja = [];

                indikatorItems.forEach((indikatorItem, indikatorIndex) => {
                    const isiIndikator = indikatorItem.querySelector(`[name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorIndex}][isi_indikator_kinerja]"]`).value;
                    const aktivitasItems = indikatorItem.querySelectorAll('.aktivitas-item');
                    const aktivitas = [];

                    aktivitasItems.forEach((aktivitasItem, aktivitasIndex) => {
                        const namaAktivitas = aktivitasItem.querySelector(`[name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorIndex}][aktivitas][${aktivitasIndex}][nama_aktivitas]"]`).value;
                        const satuan = aktivitasItem.querySelector(`[name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorIndex}][aktivitas][${aktivitasIndex}][satuan]"]`).value;
                        const target = parseInt(aktivitasItem.querySelector(`[name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorIndex}][aktivitas][${aktivitasIndex}][target]"]`).value);

                        aktivitas.push({
                            nama_aktivitas: namaAktivitas,
                            satuan: satuan,
                            target: target
                        });
                    });

                    indikatorKinerja.push({
                        isi_indikator_kinerja: isiIndikator,
                        aktivitas: aktivitas
                    });
                });

                data.push({
                    nama_sasaran: namaSasaran,
                    indikator_kinerja: indikatorKinerja
                });
            });

            // Kirim permintaan API untuk memperbarui data
            try {
                console.log('Submitting data:', data);
                const response = await fetch(apiUrl, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Gagal menyimpan data');
                }

                const result = await response.json();
                alert('Data berhasil diperbarui!');
                window.location.href = '{{ route('admin.data-instrumen.index') }}';
            } catch (error) {
                console.error('Error in form submission:', error);
                alert('Terjadi kesalahan: ' + error.message);
            }
        });

        // Tambah Sasaran
        document.getElementById('add-sasaran').addEventListener('click', function() {
            sasaranCounter++;
            const sasaranItem = createSasaranItem(sasaranCounter);
            document.getElementById('sasaran-container').insertAdjacentHTML('beforeend', sasaranItem);
        });

        // Tambah Indikator Kinerja
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-indikator')) {
                const sasaranItem = e.target.closest('.sasaran-item');
                const sasaranIndex = Array.from(document.querySelectorAll('.sasaran-item')).indexOf(sasaranItem);
                const indikatorContainer = sasaranItem.querySelector('.indikator-items');
                const indikatorCount = indikatorContainer.querySelectorAll('.indikator-item').length;
                
                const indikatorItem = createIndikatorItem(sasaranIndex, indikatorCount);
                indikatorContainer.insertAdjacentHTML('beforeend', indikatorItem);
            }
        });

        // Tambah Aktivitas
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-aktivitas')) {
                const indikatorItem = e.target.closest('.indikator-item');
                const sasaranItem = indikatorItem.closest('.sasaran-item');
                const sasaranIndex = Array.from(document.querySelectorAll('.sasaran-item')).indexOf(sasaranItem);
                const indikatorIndex = Array.from(indikatorItem.parentElement.querySelectorAll('.indikator-item')).indexOf(indikatorItem);
                const aktivitasContainer = indikatorItem.querySelector('.aktivitas-items');
                const aktivitasCount = aktivitasContainer.querySelectorAll('.aktivitas-item').length;
                
                const aktivitasItem = createAktivitasItem(sasaranIndex, indikatorIndex, aktivitasCount);
                aktivitasContainer.insertAdjacentHTML('beforeend', aktivitasItem);
            }
        });

        // Hapus elemen
        document.addEventListener('click', function(e) {
            // Hapus Sasaran
            if (e.target.classList.contains('remove-sasaran')) {
                if (document.querySelectorAll('.sasaran-item').length > 1) {
                    e.target.closest('.sasaran-item').remove();
                } else {
                    alert('Setidaknya harus ada satu sasaran.');
                }
            }
            
            // Hapus Indikator
            if (e.target.classList.contains('remove-indikator')) {
                const indikatorItem = e.target.closest('.indikator-item');
                if (indikatorItem.parentElement.querySelectorAll('.indikator-item').length > 1) {
                    indikatorItem.remove();
                } else {
                    alert('Setidaknya harus ada satu indikator kinerja.');
                }
            }
            
            // Hapus Aktivitas
            if (e.target.classList.contains('remove-aktivitas')) {
                const aktivitasItem = e.target.closest('.aktivitas-item');
                if (aktivitasItem.parentElement.querySelectorAll('.aktivitas-item').length > 1) {
                    aktivitasItem.remove();
                } else {
                    alert('Setidaknya harus ada satu aktivitas.');
                }
            }
        });
    });
</script>
@endpush