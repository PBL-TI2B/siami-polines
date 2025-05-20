@extends('layouts.app')

@section('title', 'Tambah Data Instrumen')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data Instrumen', 'url' => route('admin.data-instrumen.index')],
            ['label' => 'Tambah Data', 'url' => '#'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Tambah Data Instrumen
        </h1>

        <div class="mb-3 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
            <form id="instrument-form" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Sasaran Section -->
                    <div class="border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-200 mb-4">Sasaran</h2>
                        
                        <div id="sasaran-container">
                            <div class="sasaran-item mb-3 p-4 border border-gray-200 rounded-lg">
                                <x-form-input id="nama_sasaran" name="sasaran[0][nama_sasaran]" 
                                    label="Nama Sasaran" placeholder="Masukkan nama sasaran" 
                                    :required="true" maxlength="255" />
                                
                                <!-- Indikator Kinerja Section -->
                                <div class="indikator-container mt-4 pl-4  border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-3">Indikator Kinerja</h3>
                                    
                                    <div class="indikator-item mb-4 p-3 border border-gray-200 rounded-lg">
                                        <x-form-input id="isi_indikator_kinerja" name="sasaran[0][indikator_kinerja][0][isi_indikator_kinerja]" 
                                            label="Isi Indikator Kinerja" placeholder="Masukkan indikator kinerja" 
                                            :required="true" maxlength="255" />
                                        
                                        <!-- Aktivitas Section -->
                                        <div class="aktivitas-container mt-3 pl-4 border-gray-200">
                                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-200 mb-2">Aktivitas</h4>
                                            
                                            <div class="aktivitas-item mb-3 p-2 border border-gray-200 rounded-lg">
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <x-form-input id="nama_aktivitas" name="sasaran[0][indikator_kinerja][0][aktivitas][0][nama_aktivitas]" 
                                                        label="Nama Aktivitas" placeholder="Masukkan nama aktivitas" 
                                                        :required="true" maxlength="255" />
                                                    <x-form-input id="satuan" name="sasaran[0][indikator_kinerja][0][aktivitas][0][satuan]" 
                                                        label="Satuan" placeholder="Masukkan satuan" 
                                                        :required="true" maxlength="50" />
                                                    <x-form-input id="target" name="sasaran[0][indikator_kinerja][0][aktivitas][0][target]" 
                                                        label="Target" placeholder="Masukkan target" 
                                                        :required="true" />
                                                </div>
                                                <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-aktivitas">
                                                    Hapus Aktivitas
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <button type="button" class="mt-2 bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium py-1 px-3 rounded">
                                            Tambah Aktivitas
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class=" bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium py-1 px-3 rounded">
                                    Tambah Indikator Kinerja
                                </button>
                            </div>
                        </div>
                        
                        <button type="button" id="add-sasaran" class=" bg-blue-100 hover:bg-blue-200 text-blue-800 text-sm font-medium py-1 px-3 rounded">
                            Tambah Sasaran
                        </button>
                    </div>
                </div>
                
                <div class="mt-6 flex gap-3 justify-end">
                    <x-button type="submit" color="sky" icon="heroicon-o-plus">
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

        // Form submission handler
        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Collect form data
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

            // Send API request
            try {
                const response = await fetch('http://127.0.0.1:5000/api/data-instrumen', {
                    method: 'POST',
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
                alert('Data berhasil disimpan!');
                window.location.href = '{{ route('admin.data-instrumen.index') }}';
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            }
        });

        // Add Sasaran
        let sasaranCounter = 0;
        document.getElementById('add-sasaran').addEventListener('click', function() {
            sasaranCounter++;
            const sasaranItem = `
                <div class="sasaran-item mb-6 p-4 border border-gray-200 rounded-lg">
                    <button type="button" class="float-right text-red-600 hover:text-red-800 remove-sasaran">×</button>
                    <x-form-input id="nama_sasaran_${sasaranCounter}" name="sasaran[${sasaranCounter}][nama_sasaran]" 
                        label="Nama Sasaran" placeholder="Masukkan nama sasaran" 
                        :required="true" maxlength="255" />
                    
                    <div class="indikator-container mt-4 pl-4 border-l-2 border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200 mb-3">Indikator Kinerja</h3>
                        
                        <div class="indikator-item mb-4 p-3 border border-gray-200 rounded-lg">
                            <button type="button" class="float-right text-red-600 hover:text-red-800 remove-indikator">×</button>
                            <x-form-input id="isi_indikator_kinerja_${sasaranCounter}_0" name="sasaran[${sasaranCounter}][indikator_kinerja][0][isi_indikator_kinerja]" 
                                label="Isi Indikator Kinerja" placeholder="Masukkan indikator kinerja" 
                                :required="true" maxlength="255" />
                            
                            <div class="aktivitas-container mt-3 pl-4 border-l-2 border-gray-200">
                                <h4 class="text-md font-medium text-gray-900 dark:text-gray-200 mb-2">Aktivitas</h4>
                                
                                <div class="aktivitas-item mb-3 p-2 border border-gray-200 rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <x-form-input id="nama_aktivitas_${sasaranCounter}_0_0" name="sasaran[${sasaranCounter}][indikator_kinerja][0][aktivitas][0][nama_aktivitas]" 
                                            label="Nama Aktivitas" placeholder="Masukkan nama aktivitas" 
                                            :required="true" maxlength="255" />
                                        <x-form-input id="satuan_${sasaranCounter}_0_0" name="sasaran[${sasaranCounter}][indikator_kinerja][0][aktivitas][0][satuan]" 
                                            label="Satuan" placeholder="Masukkan satuan" 
                                            :required="true" maxlength="50" />
                                        <x-form-input id="target_${sasaranCounter}_0_0" name="sasaran[${sasaranCounter}][indikator_kinerja][0][aktivitas][0][target]" 
                                            label="Target" placeholder="Masukkan target" 
                                            :required="true" />
                                    </div>
                                    <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-aktivitas">
                                        Hapus Aktivitas
                                    </button>
                                </div>
                            </div>
                            
                            <button type="button" class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium py-1 px-3 rounded add-aktivitas">
                                Tambah Aktivitas
                            </button>
                        </div>
                    </div>
                    
                    <button type="button" class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium py-1 px-3 rounded add-indikator">
                        Tambah Indikator Kinerja
                    </button>
                </div>
            `;
            document.getElementById('sasaran-container').insertAdjacentHTML('beforeend', sasaranItem);
        });

        // Add Indikator Kinerja
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-indikator')) {
                const sasaranItem = e.target.closest('.sasaran-item');
                const sasaranIndex = Array.from(document.querySelectorAll('.sasaran-item')).indexOf(sasaranItem);
                const indikatorContainer = sasaranItem.querySelector('.indikator-container');
                const indikatorCount = indikatorContainer.querySelectorAll('.indikator-item').length;
                
                const indikatorItem = `
                    <div class="indikator-item mb-4 p-3 border border-gray-200 rounded-lg">
                        <button type="button" class="float-right text-red-600 hover:text-red-800 remove-indikator">×</button>
                        <x-form-input id="isi_indikator_kinerja_${sasaranIndex}_${indikatorCount}" name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorCount}][isi_indikator_kinerja]" 
                            label="Isi Indikator Kinerja" placeholder="Masukkan indikator kinerja" 
                            :required="true" maxlength="255" />
                        
                        <div class="aktivitas-container mt-3 pl-4 border-l-2 border-gray-200">
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-200 mb-2">Aktivitas</h4>
                            
                            <div class="aktivitas-item mb-3 p-2 border border-gray-200 rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <x-form-input id="nama_aktivitas_${sasaranIndex}_${indikatorCount}_0" name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorCount}][aktivitas][0][nama_aktivitas]" 
                                        label="Nama Aktivitas" placeholder="Masukkan nama aktivitas" 
                                        :required="true" maxlength="255" />
                                    <x-form-input id="satuan_${sasaranIndex}_${indikatorCount}_0" name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorCount}][aktivitas][0][satuan]" 
                                        label="Satuan" placeholder="Masukkan satuan" 
                                        :required="true" maxlength="50" />
                                    <x-form-input id="target_${sasaranIndex}_${indikatorCount}_0" name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorCount}][aktivitas][0][target]" 
                                        label="Target" placeholder="Masukkan target" 
                                        :required="true"  />
                                </div>
                                <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-aktivitas">
                                    Hapus Aktivitas
                                </button>
                            </div>
                        </div>
                        
                        <button type="button" class="mt-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium py-1 px-3 rounded add-aktivitas">
                            Tambah Aktivitas
                        </button>
                    </div>
                `;
                indikatorContainer.insertAdjacentHTML('beforeend', indikatorItem);
            }
        });

        // Add Aktivitas
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-aktivitas')) {
                const indikatorItem = e.target.closest('.indikator-item');
                const sasaranItem = indikatorItem.closest('.sasaran-item');
                const sasaranIndex = Array.from(document.querySelectorAll('.sasaran-item')).indexOf(sasaranItem);
                const indikatorIndex = Array.from(indikatorItem.parentElement.querySelectorAll('.indikator-item')).indexOf(indikatorItem);
                const aktivitasContainer = indikatorItem.querySelector('.aktivitas-container');
                const aktivitasCount = aktivitasContainer.querySelectorAll('.aktivitas-item').length;
                
                const aktivitasItem = `
                    <div class="aktivitas-item mb-3 p-2 border border-gray-200 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <x-form-input id="nama_aktivitas_${sasaranIndex}_${indikatorIndex}_${aktivitasCount}" name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorIndex}][aktivitas][${aktivitasCount}][nama_aktivitas]" 
                                label="Nama Aktivitas" placeholder="Masukkan nama aktivitas" 
                                :required="true" maxlength="255" />
                            <x-form-input id="satuan_${sasaranIndex}_${indikatorIndex}_${aktivitasCount}" name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorIndex}][aktivitas][${aktivitasCount}][satuan]" 
                                label="Satuan" placeholder="Masukkan satuan" 
                                :required="true" maxlength="50" />
                            <x-form-input id="target_${sasaranIndex}_${indikatorIndex}_${aktivitasCount}" name="sasaran[${sasaranIndex}][indikator_kinerja][${indikatorIndex}][aktivitas][${aktivitasCount}][target]" 
                                label="Target" placeholder="Masukkan target" 
                                :required="true" />
                        </div>
                        <button type="button" class="mt-2 bg-red-100 text-red-600 hover:text-red-800 text-sm font-medium py-1 px-3 rounded remove-aktivitas">
                            Hapus Aktivitas
                        </button>
                    </div>
                `;
                aktivitasContainer.insertAdjacentHTML('beforeend', aktivitasItem);
            }
        });

        // Remove elements
        document.addEventListener('click', function(e) {
            // Remove Sasaran
            if (e.target.classList.contains('remove-sasaran')) {
                if (document.querySelectorAll('.sasaran-item').length > 1) {
                    e.target.closest('.sasaran-item').remove();
                } else {
                    alert('Setidaknya harus ada satu sasaran.');
                }
            }
            
            // Remove Indikator
            if (e.target.classList.contains('remove-indikator')) {
                const indikatorItem = e.target.closest('.indikator-item');
                if (indikatorItem.parentElement.querySelectorAll('.indikator-item').length > 1) {
                    indikatorItem.remove();
                } else {
                    alert('Setidaknya harus ada satu indikator kinerja.');
                }
            }
            
            // Remove Aktivitas
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