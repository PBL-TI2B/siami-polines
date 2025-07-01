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
                <!-- <x-button href="#" color="yellow" icon="heroicon-o-document-arrow-up" class="shadow-md hover:shadow-lg transition-all">
                    Import Data
                </x-button> -->
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
                    <span class="text-sm text-gray-700 dark:text-gray-300">sasaran</span> <!-- Ganti dari 'entri' -->
                </div>


                <div class="relative w-full sm:w-auto">
                    <form id="search-form" method="GET">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" id="search-input" placeholder="Cari" value="" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
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
        const perPageSelect = document.getElementById('perPageSelect');
        const info = document.getElementById('pagination-info');
        const searchInput = document.getElementById('search-input');

        let ITEMS_PER_PAGE = parseInt(perPageSelect.value);
        let currentPage = 1;
        let allData = [];
        let flattenedData = [];
        let searchQuery = '';

        perPageSelect.addEventListener('change', function () {
            ITEMS_PER_PAGE = parseInt(this.value);
            currentPage = 1;
            filterAndRender();
        });

        searchInput.addEventListener('input', function () {
            searchQuery = this.value.toLowerCase();
            currentPage = 1;
            filterAndRender();
        });

        fetch('http://127.0.0.1:5000/api/data-instrumen')
            .then(response => response.json())
            .then(data => {
                allData = data;
                flattenedData = flattenData(allData);
                filterAndRender();
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

        function flattenData(data) {
            const result = [];
            data.forEach((sasaran, sIndex) => {
                sasaran.indikator_kinerja.forEach((indikator, iIndex) => {
                    indikator.aktivitas.forEach((aktivitas, aIndex) => {
                        result.push({
                            sasaran,
                            indikator,
                            aktivitas,
                            isFirstSasaran: iIndex === 0 && aIndex === 0,
                            isFirstIndikator: aIndex === 0,
                            sasaranRowspan: sasaran.indikator_kinerja.reduce((sum, ik) => sum + ik.aktivitas.length, 0),
                            indikatorRowspan: indikator.aktivitas.length
                        });
                    });
                });
            });
            return result;
        }

        function renderTable(page, data = flattenedData) {
            tableBody.innerHTML = '';
            const startIndex = (page - 1) * ITEMS_PER_PAGE;
            const endIndex = startIndex + ITEMS_PER_PAGE;
            const dataToShow = data.slice(startIndex, endIndex);
            let rowNumber = startIndex + 1;

            dataToShow.forEach((entry, idx) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200';

                // NOMOR hanya muncul jika isFirstSasaran true, dan rowspan mengikuti rowspan Sasaran Strategis
                const noCell = entry.isFirstSasaran ?
                    `<td rowspan="${entry.sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center align-center">${rowNumber++}</td>` : '';

                const sasaranCell = entry.isFirstSasaran ? 
                    `<td rowspan="${entry.sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${entry.sasaran.nama_sasaran}</td>` : '';

                const indikatorCell = entry.isFirstIndikator ? 
                    `<td rowspan="${entry.indikatorRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${entry.indikator.isi_indikator_kinerja}</td>` : '';

                const aksiCell = entry.isFirstSasaran ?
                    `<td rowspan="${entry.sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                        <div class="flex items-center gap-2">
                            <a href="/admin/data-instrumen/${entry.sasaran.sasaran_strategis_id}/edit" class="text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-200 transition-colors duration-200">
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
                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${entry.aktivitas.nama_aktivitas}</td>
                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${entry.aktivitas.satuan}</td>
                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${entry.aktivitas.target}</td>
                    ${aksiCell}
                `;

                tableBody.appendChild(row);
            });
        }


        function renderPagination(data = flattenedData) {
            paginationContainer.innerHTML = '';
            const pageCount = Math.ceil(data.length / ITEMS_PER_PAGE);
            const start = (currentPage - 1) * ITEMS_PER_PAGE + 1;
            const end = Math.min(currentPage * ITEMS_PER_PAGE, data.length);

            info.innerHTML = `Menampilkan <strong>${start}</strong> hingga <strong>${end}</strong> dari <strong>${data.length}</strong> hasil`;

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
                    filterAndRender();
                });
            }
            paginationContainer.appendChild(prev);

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
                    filterAndRender();
                });
                paginationContainer.appendChild(li);
            }

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
                    filterAndRender();
                });
            }
            paginationContainer.appendChild(next);
        }

        function filterAndRender(jenisUnitId = null) {
            let filtered = flattenedData;

            if (jenisUnitId !== null) {
                filtered = filtered.filter(entry => entry.sasaran.jenis_unit_id === parseInt(jenisUnitId));
            }

            if (searchQuery) {
                const query = searchQuery.toLowerCase();
                filtered = filtered.filter(entry =>
                    entry.sasaran.nama_sasaran.toLowerCase().includes(query) ||
                    entry.indikator.isi_indikator_kinerja.toLowerCase().includes(query) ||
                    entry.aktivitas.nama_aktivitas.toLowerCase().includes(query) ||
                    entry.aktivitas.satuan.toLowerCase().includes(query)
                );
            }

            renderTable(currentPage, filtered);
            renderPagination(filtered);
        }


        // Dropdown Unit Kerja
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

        // Dropdown Periode AMI
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