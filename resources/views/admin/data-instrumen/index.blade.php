@extends('layouts.app')

@section('title', 'Instrumen UPT')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[ 
            ['label' => 'Instrumen UPT', 'url' => ''], 
            ['label' => 'List'], 
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-6">
            Instrumen UPT
        </h1>

        <!-- Toolbar -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-2">
                <x-button href="{{ route('admin.data-instrumen.tambah') }}" color="sky" icon="heroicon-o-plus" class="shadow-md hover:shadow-lg transition-all">
                    Tambah Instrumen
                </x-button>

                <x-button href="{{ route('admin.data-instrumen.export') }}" color="sky" icon="heroicon-o-document-arrow-down" class="shadow-md hover:shadow-lg transition-all">
                    Unduh Data
                </x-button>
                <!-- <x-button href="#" color="yellow" icon="heroicon-o-document-arrow-up" class="shadow-md hover:shadow-lg transition-all">
                    Import Data
                </x-button> -->
            </div>

            <!-- Filter Dropdowns -->
            <div class="flex flex-wrap gap-2">
                <select id="unitKerjaSelect" class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Unit</option>
                </select>
            </div>
        </div>

        <!-- Table and Pagination -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
            <!-- Table Controls -->
            <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 rounded-t-2xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <select id="perPageSelect" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                </div>

                <div class="relative w-full sm:w-auto">
                    <form action="#" method="GET">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" placeholder="Cari" value="" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">No</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Sasaran Strategis</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Indikator Kinerja</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Aktivitas</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Satuan</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Target 25</th>
                            <!-- <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Capaian 25</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Keterangan</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Sesuai</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Lokasi Bukti Dukung</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Tidak Sesuai (Minor)</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Tidak Sesuai (Mayor)</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">OFI (Saran Tindak Lanjut)</th> -->
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="instrumen-table-body">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span id="pagination-info" class="text-sm text-gray-700 dark:text-gray-300">
                    Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul id="pagination" class="inline-flex -space-x-px text-sm">
                <!-- Button Prev & Next serta halaman akan diisi dari JavaScript -->
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('instrumen-table-body');
    const paginationContainer = document.getElementById('pagination');
    const itemsPerPage = 10; // Jumlah baris per halaman
    let currentPage = 1;
    let allData = [];

    // Ambil data dari API
    fetch('http://127.0.0.1:5000/api/data-instrumen')
        .then(response => response.json())
        .then(data => {
            allData = data;
            renderTable(currentPage);
            renderPagination();
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            tableBody.innerHTML = `
                <tr>
                    <td colspan="14" class="px-4 py-3 sm:px-6 text-center text-red-500">
                        Gagal memuat data. Silakan coba lagi.
                    </td>
                </tr>
            `;
        });

    // Render Tabel berdasarkan halaman
    function renderTable(page) {
        tableBody.innerHTML = '';
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const slicedData = allData.slice(startIndex, endIndex);

        let rowNumber = startIndex + 1;

        slicedData.forEach(sasaran => {
            let isFirstRowForSasaran = true;
            let sasaranRowspan = 0;

            sasaran.indikator_kinerja.forEach(indikator => {
                sasaranRowspan += indikator.aktivitas.length;
            });

            sasaran.indikator_kinerja.forEach(indikator => {
                let isFirstRowForIndikator = true;
                let indikatorRowspan = indikator.aktivitas.length;

                indikator.aktivitas.forEach(aktivitas => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200';

                    const noCell = isFirstRowForSasaran ?
                        `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${rowNumber}</td>` : '';

                    const sasaranCell = isFirstRowForSasaran ?
                        `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${sasaran.nama_sasaran}</td>` : '';

                    const indikatorCell = isFirstRowForIndikator ?
                        `<td rowspan="${indikatorRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${indikator.isi_indikator_kinerja}</td>` : '';

                    const aksiCell = isFirstRowForSasaran ?
                        `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                            <div class="flex items-center gap-2">
                                <a href="/admin/data-instrumen/${sasaran.sasaran_strategis_id}/edit" class="text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-200 transition-colors duration-200">
                                    <x-heroicon-o-pencil class="w-5 h-5" />
                                </a>
                                <a href="#" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors duration-200">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </a>
                            </div>
                        </td>` : '';

                    row.innerHTML = `
                        ${noCell}
                        ${sasaranCell}
                        ${indikatorCell}
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${aktivitas.nama_aktivitas}</td>
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${aktivitas.satuan}</td>
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${aktivitas.target}</td>
                        ${aksiCell}
                    `;

                    tableBody.appendChild(row);

                    isFirstRowForSasaran = false;
                    isFirstRowForIndikator = false;
                });
            });

            rowNumber++;
        });
    }

    function renderPagination() {
    const pagination = document.getElementById('pagination');
    const info = document.getElementById('pagination-info');
    const pageCount = Math.ceil(allData.length / itemsPerPage);

    pagination.innerHTML = '';

    // Hitung indeks awal dan akhir untuk info
    const start = (currentPage - 1) * itemsPerPage + 1;
    const end = Math.min(currentPage * itemsPerPage, allData.length);

    // Update info tampil data
    info.innerHTML = `Menampilkan <strong>${start}</strong> hingga <strong>${end}</strong> dari <strong>${allData.length}</strong> hasil`;

    // Tombol Previous
    const prev = document.createElement('li');
    prev.innerHTML = `
        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight ${
            currentPage === 1
                ? 'text-gray-400 bg-white border border-gray-300 cursor-not-allowed opacity-50'
                : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700'
        } rounded-l-lg transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L6.586 10l4.707-4.707a1 1 0 111.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
        </a>
    `;
    if (currentPage > 1) {
        prev.querySelector('a').addEventListener('click', e => {
            e.preventDefault();
            currentPage--;
            renderTable(currentPage);
            renderPagination();
        });
    }
    pagination.appendChild(prev);

    // Event listener untuk dropdown jumlah entri
    document.getElementById('perPageSelect').addEventListener('change', function () {
        itemsPerPage = parseInt(this.value);
        currentPage = 1; // Reset ke halaman pertama
        renderTable(currentPage);
        renderPagination();
    });


    // Nomor Halaman
    for (let i = 1; i <= pageCount; i++) {
        const li = document.createElement('li');
        li.innerHTML = `
            <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight ${
                i === currentPage
                    ? 'text-sky-800 bg-sky-50 border-sky-300 dark:bg-sky-900 dark:text-sky-200 dark:border-sky-700 border'
                    : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray-200'
            } transition-all duration-200">${i}</a>
        `;
        li.querySelector('a').addEventListener('click', e => {
            e.preventDefault();
            currentPage = i;
            renderTable(currentPage);
            renderPagination();
        });
        pagination.appendChild(li);
    }

    // Tombol Next
    const next = document.createElement('li');
    next.innerHTML = `
        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight ${
            currentPage === pageCount
                ? 'text-gray-400 bg-white border border-gray-300 cursor-not-allowed opacity-50'
                : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700'
        } rounded-r-lg transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 5.293a1 1 0 011.414 0L13.414 10l-4.707 4.707a1 1 0 01-1.414-1.414L10.586 10 7.293 6.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
        </a>
    `;
    if (currentPage < pageCount) {
        next.querySelector('a').addEventListener('click', e => {
            e.preventDefault();
            currentPage++;
            renderTable(currentPage);
            renderPagination();
        });
    }
    pagination.appendChild(next);
}


    // =================== Dropdown Unit Kerja ===================
    fetch('http://127.0.0.1:5000/api/unit-kerja')
        .then(response => response.json())
        .then(result => {
            const data = result.data;
            const select = document.getElementById('unitKerjaSelect');

            data.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit.unit_kerja_id;
                option.textContent = unit.nama_unit_kerja;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Gagal memuat unit kerja:', error);
        });

    // =================== Dropdown Periode AMI ===================
    fetch('http://127.0.0.1:5000/api/periode-audits')
        .then(response => response.json())
        .then(result => {
            const data = result.data.data;
            const select = document.getElementById('periodeSelect');

            data.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit.periode_id;
                option.textContent = unit.nama_periode;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Gagal memuat periode AMI:', error);
        });
});
</script>

@endsection