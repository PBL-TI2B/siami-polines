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
            <!-- <div class="flex flex-wrap gap-2">
                <x-button href="{{ route('admin.data-instrumen.export') }}" color="sky" icon="heroicon-o-document-arrow-down" class="shadow-md hover:shadow-lg transition-all">
                    Unduh Data
                </x-button>
            </div> -->

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
                    <form action="#" method="GET">
                        <select id="perPageSelect" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200" onchange="this.form.submit()">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>

                    </form>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                </div>
                <div class="relative w-full sm:w-auto">
                    <form action="#" method="GET">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" id="searchInput" placeholder="Cari" value="" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
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
                        Menampilkan <strong>1</strong> hingga <strong>10</strong> dari <strong>0</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul id="pagination-wrapper" class="inline-flex -space-x-px text-sm"></ul>
                    </nav>
                </div>
            </div>

        </div>
    </div>

   <script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.getElementById('instrumen-table-body');
    const unitKerjaSelect = document.getElementById('unitKerjaSelect');
    const periodeSelect = document.getElementById('periodeSelect');
    const searchInput = document.getElementById('searchInput');
    const paginationWrapper = document.getElementById('pagination-wrapper');
    const infoText = document.getElementById('pagination-info');
    const perPageSelect = document.getElementById('perPageSelect');

    let ITEMS_PER_PAGE = parseInt(perPageSelect.value);
    let allData = [];
    let currentPage = 1;

    loadInstrumenData();
    loadUnitKerjaDropdown();
    loadPeriodeDropdown();

    perPageSelect.addEventListener('change', function () {
        ITEMS_PER_PAGE = parseInt(this.value);
        currentPage = 1;
        renderPaginatedTable();
    });

    searchInput.addEventListener('input', function () {
        currentPage = 1;
        renderPaginatedTable();
    });

    function loadInstrumenData() {
        fetch('http://127.0.0.1:5000/api/data-instrumen')
            .then(response => response.json())
            .then(data => {
                allData = data;
                renderPaginatedTable();
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                tableBody.innerHTML = `<tr><td colspan="10" class="text-center text-red-500">Gagal memuat data.</td></tr>`;
            });
    }

    function renderPaginatedTable() {
        tableBody.innerHTML = '';
        const keyword = searchInput.value.toLowerCase();
        const filtered = filterData(allData, keyword);
        const totalItems = filtered.length;
        const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
        const start = (currentPage - 1) * ITEMS_PER_PAGE;
        const paginated = filtered.slice(start, start + ITEMS_PER_PAGE);

        let rowNumber = start + 1;

        paginated.forEach(sasaran => {
            let sasaranRowspan = 0;
            sasaran.indikator_kinerja.forEach(ik => {
                sasaranRowspan += ik.aktivitas.length;
            });

            let isFirstRowForSasaran = true;
            sasaran.indikator_kinerja.forEach(indikator => {
                let indikatorRowspan = indikator.aktivitas.length;
                let isFirstRowForIndikator = true;

                indikator.aktivitas.forEach((aktivitas, idx) => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200';

                    const noCell = isFirstRowForSasaran ? `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6">${rowNumber++}</td>` : '';
                    const sasaranCell = isFirstRowForSasaran ? `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6">${sasaran.nama_sasaran}</td>` : '';
                    const indikatorCell = isFirstRowForIndikator ? `<td rowspan="${indikatorRowspan}" class="px-4 py-3 sm:px-6">${indikator.isi_indikator_kinerja}</td>` : '';

                    row.innerHTML = `
                        ${noCell}
                        ${sasaranCell}
                        ${indikatorCell}
                        <td class="px-4 py-3 sm:px-6">${aktivitas.nama_aktivitas}</td>
                        <td class="px-4 py-3 sm:px-6">${aktivitas.satuan}</td>
                        <td class="px-4 py-3 sm:px-6">${aktivitas.target}</td>
                    `;

                    tableBody.appendChild(row);
                    isFirstRowForSasaran = false;
                    isFirstRowForIndikator = false;
                });
            });
        });

        updatePagination(totalItems);
    }

    function filterData(data, keyword) {
        return data
            .map(sasaran => {
                const indikator_kinerja = sasaran.indikator_kinerja.map(indikator => {
                    const aktivitas = indikator.aktivitas.filter(ak =>
                        sasaran.nama_sasaran.toLowerCase().includes(keyword) ||
                        indikator.isi_indikator_kinerja.toLowerCase().includes(keyword) ||
                        ak.nama_aktivitas.toLowerCase().includes(keyword) ||
                        ak.satuan.toLowerCase().includes(keyword)
                    );
                    return aktivitas.length ? { ...indikator, aktivitas } : null;
                }).filter(i => i !== null);

                return indikator_kinerja.length ? { ...sasaran, indikator_kinerja } : null;
            })
            .filter(s => s !== null);
    }

    function updatePagination(totalItems) {
        const totalPages = Math.ceil(totalItems / ITEMS_PER_PAGE);
        paginationWrapper.innerHTML = '';

        infoText.innerHTML = `Menampilkan <strong>${(currentPage - 1) * ITEMS_PER_PAGE + 1}</strong> 
            hingga <strong>${Math.min(currentPage * ITEMS_PER_PAGE, totalItems)}</strong> 
            dari <strong>${totalItems}</strong> hasil`;

        const createPageButton = (label, page, disabled = false, isActive = false) => {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = "#";
            a.textContent = label;
            a.className = `flex items-center justify-center px-3 h-8 leading-tight border transition-all duration-200 ${
                disabled ? 'opacity-50 cursor-not-allowed' :
                isActive ? 'text-sky-800 bg-sky-50 border-sky-300 dark:bg-sky-900 dark:text-sky-200 dark:border-sky-700' :
                'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray-200'
            }`;

            if (!disabled) {
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentPage = page;
                    renderPaginatedTable();
                });
            }

            li.appendChild(a);
            return li;
        };

        paginationWrapper.appendChild(createPageButton('←', currentPage - 1, currentPage === 1));
        for (let i = 1; i <= totalPages; i++) {
            paginationWrapper.appendChild(createPageButton(i, i, false, i === currentPage));
        }
        paginationWrapper.appendChild(createPageButton('→', currentPage + 1, currentPage === totalPages));
    }

    function loadUnitKerjaDropdown() {
        fetch('http://127.0.0.1:5000/api/unit-kerja')
            .then(response => response.json())
            .then(result => {
                const data = result.data;
                data.forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit.unit_kerja_id;
                    option.textContent = unit.nama_unit_kerja;
                    unitKerjaSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Gagal memuat unit kerja:', error));
    }

    function loadPeriodeDropdown() {
        fetch('http://127.0.0.1:5000/api/periode-audits')
            .then(response => response.json())
            .then(result => {
                const data = result.data.data;
                data.forEach(periode => {
                    const option = document.createElement('option');
                    option.value = periode.periode_id;
                    option.textContent = periode.nama_periode;
                    periodeSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Gagal memuat periode AMI:', error));
    }
});
</script>





@endsection 