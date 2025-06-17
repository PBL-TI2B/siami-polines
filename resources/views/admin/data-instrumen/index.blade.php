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
            </div>

            <!-- Filter Dropdowns -->
            <div class="flex flex-wrap gap-2">
                <select id="unitKerjaSelect" class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Unit</option>
                </select>
                <select id="periodeSelect" class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Periode</option>
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
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                </div>
                <div class="relative w-full sm:w-auto">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search" id="searchInput" placeholder="Cari" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
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
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="instrumen-table-body">
                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p>Memuat data...</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span id="paginationInfo" class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul id="paginationContainer" class="inline-flex -space-x-px text-sm">
                            <!-- Pagination akan diisi oleh JavaScript -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ==================== GLOBAL VARIABLES ====================
        const API_BASE_URL = 'http://127.0.0.1:5000/api';
        let allData = [];
        let filteredData = [];
        let currentPage = 1;
        let perPage = 5;

        // ==================== DOM ELEMENTS ====================
        const elements = {
            tableBody: document.getElementById('instrumen-table-body'),
            unitKerjaSelect: document.getElementById('unitKerjaSelect'),
            periodeSelect: document.getElementById('periodeSelect'),
            perPageSelect: document.getElementById('perPageSelect'),
            searchInput: document.getElementById('searchInput'),
            paginationInfo: document.getElementById('paginationInfo'),
            paginationContainer: document.getElementById('paginationContainer')
        };

        // ==================== UTILITY FUNCTIONS ====================
        function getTotalActivities(data) {
            let total = 0;
            data.forEach(sasaran => {
                sasaran.indikator_kinerja.forEach(indikator => {
                    total += indikator.aktivitas.length;
                });
            });
            return total;
        }

        function paginateActivities(data, page, perPage) {
            // Flatten all activities with their parent info
            let flatActivities = [];
            data.forEach(sasaran => {
                sasaran.indikator_kinerja.forEach(indikator => {
                    indikator.aktivitas.forEach(aktivitas => {
                        flatActivities.push({
                            sasaran: sasaran,
                            indikator: indikator,
                            aktivitas: aktivitas
                        });
                    });
                });
            });

            // Paginate the flat activities
            const start = (page - 1) * perPage;
            const end = start + perPage;
            const paginatedActivities = flatActivities.slice(start, end);

            // Group back by sasaran and indikator for display
            const groupedData = [];
            const sasaranMap = new Map();

            paginatedActivities.forEach(item => {
                const sasaranId = item.sasaran.sasaran_strategis_id;
                
                if (!sasaranMap.has(sasaranId)) {
                    sasaranMap.set(sasaranId, {
                        ...item.sasaran,
                        indikator_kinerja: []
                    });
                    groupedData.push(sasaranMap.get(sasaranId));
                }

                const sasaranData = sasaranMap.get(sasaranId);
                let indikatorData = sasaranData.indikator_kinerja.find(
                    ind => ind.indikator_kinerja_id === item.indikator.indikator_kinerja_id
                );

                if (!indikatorData) {
                    indikatorData = {
                        ...item.indikator,
                        aktivitas: []
                    };
                    sasaranData.indikator_kinerja.push(indikatorData);
                }

                indikatorData.aktivitas.push(item.aktivitas);
            });

            return groupedData;
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function showError(message) {
            elements.tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-8 text-red-500 dark:text-red-400">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>${message}</p>
                        </div>
                    </td>
                </tr>
            `;
        }

        function showEmpty() {
            elements.tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p>Tidak ada data yang ditemukan</p>
                        </div>
                    </td>
                </tr>
            `;
        }

        // ==================== RENDER FUNCTIONS ====================
        function renderTable(data) {
            if (!data || data.length === 0) {
                showEmpty();
                updatePaginationInfo(0);
                elements.paginationContainer.innerHTML = '';
                return;
            }

            elements.tableBody.innerHTML = '';
            
            // Calculate starting row number based on current page and activities count
            let totalActivitiesBeforeCurrentPage = 0;
            const allActivities = [];
            
            // First, get all activities from filteredData to calculate correct row numbers
            filteredData.forEach(sasaran => {
                sasaran.indikator_kinerja.forEach(indikator => {
                    indikator.aktivitas.forEach(aktivitas => {
                        allActivities.push({
                            sasaran: sasaran,
                            indikator: indikator,
                            aktivitas: aktivitas
                        });
                    });
                });
            });
            
            let currentActivityIndex = (currentPage - 1) * perPage + 1;
            let rowspanCounts = {};

            // Calculate rowspan for each sasaran strategis in current page data
            data.forEach(sasaran => {
                let count = 0;
                sasaran.indikator_kinerja.forEach(indikator => {
                    count += indikator.aktivitas.length;
                });
                rowspanCounts[sasaran.sasaran_strategis_id] = count;
            });

            // Render table rows
            data.forEach(sasaran => {
                let isFirstRowForSasaran = true;
                let sasaranRowspan = rowspanCounts[sasaran.sasaran_strategis_id];

                sasaran.indikator_kinerja.forEach(indikator => {
                    let isFirstRowForIndikator = true;
                    let indikatorRowspan = indikator.aktivitas.length;

                    indikator.aktivitas.forEach(aktivitas => {
                        const row = document.createElement('tr');
                        row.className = 'hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200';

                        const noCell = isFirstRowForSasaran ? 
                            `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 font-medium">${currentActivityIndex}</td>` : '';

                        const sasaranCell = isFirstRowForSasaran ? 
                            `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${sasaran.nama_sasaran}</td>` : '';

                        const indikatorCell = isFirstRowForIndikator ? 
                            `<td rowspan="${indikatorRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${indikator.isi_indikator_kinerja}</td>` : '';

                        const aksiCell = isFirstRowForSasaran ? 
                            `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                                <div class="flex items-center gap-2">
                                    <a href="/admin/data-instrumen/${sasaran.sasaran_strategis_id}/edit" 
                                       class="text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-200 transition-colors duration-200"
                                       title="Edit">
                                        <x-heroicon-o-pencil class="w-5 h-5" />
                                    </a>
                                    <button onclick="confirmDelete('${sasaran.sasaran_strategis_id}')" 
                                            class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors duration-200"
                                            title="Hapus">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
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

                        elements.tableBody.appendChild(row);
                        isFirstRowForSasaran = false;
                        isFirstRowForIndikator = false;
                        currentActivityIndex++;
                    });
                });
            });

            const totalActivities = getTotalActivities(filteredData);
            updatePaginationInfo(totalActivities);
            renderPagination(totalActivities);
        }

        function renderPagination(dataLength) {
            const totalPages = Math.ceil(dataLength / perPage);
            elements.paginationContainer.innerHTML = '';

            if (totalPages <= 1) return;

            // Previous button
            const prevDisabled = currentPage === 1;
            elements.paginationContainer.innerHTML += `
                <li>
                    <button class="flex items-center justify-center px-3 h-8 leading-tight ${
                        prevDisabled ? 'cursor-not-allowed opacity-50' : 'hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200'
                    } text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-l-lg transition-all duration-200"
                    data-page="${currentPage - 1}" ${prevDisabled ? 'disabled' : ''}>
                        <x-heroicon-s-chevron-left class="w-4 h-4 mr-1" />
                    </button>
                </li>
            `;

            // Page numbers
            const startPage = Math.max(1, currentPage - 2);
            const endPage = Math.min(totalPages, currentPage + 2);

            if (startPage > 1) {
                elements.paginationContainer.innerHTML += `
                    <li>
                        <button data-page="1" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 border hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">1</button>
                    </li>
                `;
                if (startPage > 2) {
                    elements.paginationContainer.innerHTML += `
                        <li>
                            <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 border">...</span>
                        </li>
                    `;
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                elements.paginationContainer.innerHTML += `
                    <li>
                        <button data-page="${i}" class="flex items-center justify-center px-3 h-8 leading-tight ${
                            currentPage === i
                                ? 'text-sky-800 bg-sky-50 dark:bg-sky-900 dark:text-sky-200 border-sky-300 dark:border-sky-700 border'
                                : 'text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 border hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200'
                        } transition-all duration-200">${i}</button>
                    </li>
                `;
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    elements.paginationContainer.innerHTML += `
                        <li>
                            <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 border">...</span>
                        </li>
                    `;
                }
                elements.paginationContainer.innerHTML += `
                    <li>
                        <button data-page="${totalPages}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 border hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">${totalPages}</button>
                    </li>
                `;
            }

            // Next button
            const nextDisabled = currentPage === totalPages;
            elements.paginationContainer.innerHTML += `
                <li>
                    <button class="flex items-center justify-center px-3 h-8 leading-tight ${
                        nextDisabled ? 'cursor-not-allowed opacity-50' : 'hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200'
                    } text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg transition-all duration-200"
                    data-page="${currentPage + 1}" ${nextDisabled ? 'disabled' : ''}>
                        <x-heroicon-s-chevron-right class="w-4 h-4 ml-1" />
                    </button>
                </li>
            `;
        }

        function updatePaginationInfo(dataLength) {
            const start = dataLength === 0 ? 0 : (currentPage - 1) * perPage + 1;
            const end = Math.min(currentPage * perPage, dataLength);
            elements.paginationInfo.innerHTML = `
                Menampilkan <strong>${start}</strong> hingga <strong>${end}</strong> dari <strong>${dataLength}</strong> hasil
            `;
        }

        // ==================== DATA FUNCTIONS ====================
        function filterData() {
            const searchTerm = elements.searchInput.value.toLowerCase().trim();
            
            if (!searchTerm) {
                filteredData = allData;
            } else {
                filteredData = allData.filter(sasaran => {
                    return sasaran.nama_sasaran.toLowerCase().includes(searchTerm) ||
                           sasaran.indikator_kinerja.some(indikator => 
                               indikator.isi_indikator_kinerja.toLowerCase().includes(searchTerm) ||
                               indikator.aktivitas.some(aktivitas => 
                                   aktivitas.nama_aktivitas.toLowerCase().includes(searchTerm) ||
                                   aktivitas.satuan.toLowerCase().includes(searchTerm)
                               )
                           );
                });
            }
            
            currentPage = 1;
            const paginatedData = paginateActivities(filteredData, currentPage, perPage);
            renderTable(paginatedData);
        }

        async function fetchData(url, errorMessage) {
            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return await response.json();
            } catch (error) {
                console.error(`Error fetching ${errorMessage}:`, error);
                throw error;
            }
        }

        async function loadInstrumenData() {
            try {
                const data = await fetchData(`${API_BASE_URL}/data-instrumen`, 'instrumen data');
                allData = data;
                filteredData = data;
                const paginatedData = paginateActivities(filteredData, currentPage, perPage);
                renderTable(paginatedData);
            } catch (error) {
                showError('Gagal memuat data instrumen. Silakan coba lagi.');
            }
        }

        async function loadUnitKerja() {
            try {
                const result = await fetchData(`${API_BASE_URL}/unit-kerja`, 'unit kerja data');
                const data = result.data;
                
                data.forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit.unit_kerja_id;
                    option.textContent = unit.nama_unit_kerja;
                    elements.unitKerjaSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Gagal memuat unit kerja:', error);
            }
        }

        async function loadPeriode() {
            try {
                const result = await fetchData(`${API_BASE_URL}/periode-audits`, 'periode data');
                const data = result.data.data;
                
                data.forEach(periode => {
                    const option = document.createElement('option');
                    option.value = periode.periode_id;
                    option.textContent = periode.nama_periode;
                    elements.periodeSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Gagal memuat periode AMI:', error);
            }
        }

        // ==================== EVENT HANDLERS ====================
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                // Implement delete functionality here
                console.log('Delete item with ID:', id);
            }
        }

        // ==================== EVENT LISTENERS ====================
        document.addEventListener('DOMContentLoaded', function() {
            // Load initial data
            loadInstrumenData();
            loadUnitKerja();
            loadPeriode();

            // Pagination click handler
            elements.paginationContainer.addEventListener('click', function(e) {
                if (e.target.matches('[data-page]') && !e.target.disabled) {
                    e.preventDefault();
                    const page = parseInt(e.target.getAttribute('data-page'));
                    const totalActivities = getTotalActivities(filteredData);
                    const totalPages = Math.ceil(totalActivities / perPage);
                    
                    if (page >= 1 && page <= totalPages) {
                        currentPage = page;
                        const paginatedData = paginateActivities(filteredData, currentPage, perPage);
                        renderTable(paginatedData);
                    }
                }
            });

            // Per page change handler
            elements.perPageSelect.addEventListener('change', function() {
                perPage = parseInt(this.value);
                currentPage = 1;
                const paginatedData = paginateActivities(filteredData, currentPage, perPage);
                renderTable(paginatedData);
            });

            // Search handler with debounce
            elements.searchInput.addEventListener('input', debounce(filterData, 300));

            // Filter handlers
            elements.unitKerjaSelect.addEventListener('change', function() {
                // Implement unit kerja filtering
                console.log('Unit kerja selected:', this.value);
            });

            elements.periodeSelect.addEventListener('change', function() {
                // Implement periode filtering
                console.log('Periode selected:', this.value);
            });
        });
    </script>
@endsection