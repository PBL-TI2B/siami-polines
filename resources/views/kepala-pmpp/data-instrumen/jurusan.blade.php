@extends('layouts.app')

@section('title', 'Instrumen Jurusan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Instrumen Jurusan', 'url' => ''],
            ['label' => 'List'],
        ]" />

        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-6">
            Instrumen Jurusan
        </h1>

        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex flex-wrap gap-2">
                <select id="unitKerjaSelect" class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Unit</option>
                </select>
                <select id="periodeSelect" class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Periode AMI</option>
                </select>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
            <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 rounded-t-2xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <select id="perPageSelectInstrumen" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
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
                    <input type="search" id="searchInputInstrumen" placeholder="Cari" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
                </div>
            </div>

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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="instrumen-table-body">
                        </tbody>
                </table>
            </div>

            <div class="p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span id="pagination-info-instrumen" class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan 1 hingga 10 dari 100 hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul id="pagination-buttons-instrumen" class="inline-flex -space-x-px text-sm">
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-l-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 cursor-not-allowed opacity-50">
                                    <x-heroicon-s-chevron-left class="w-4 h-4 mr-1" />
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-sky-800 bg-sky-50 dark:bg-sky-900 dark:text-sky-200 border-sky-300 dark:border-sky-700 border transition-all duration-200">
                                    1
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">
                                    <x-heroicon-s-chevron-right class="w-4 h-4 ml-1" />
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableBodyInstrumen = document.getElementById('instrumen-table-body');
            const perPageSelectInstrumen = document.getElementById('perPageSelectInstrumen');
            const searchInputInstrumen = document.getElementById('searchInputInstrumen');
            const paginationInfoInstrumen = document.getElementById('pagination-info-instrumen');
            const paginationButtonsInstrumen = document.getElementById('pagination-buttons-instrumen');
            const unitKerjaSelect = document.getElementById('unitKerjaSelect');
            const periodeSelect = document.getElementById('periodeSelect');

            let allInstrumenDataRaw = []; // Data mentah dari API
            let processedInstrumenData = []; // Data setelah diratakan (flattened) untuk pagination/search
            let perPageInstrumen = parseInt(perPageSelectInstrumen.value, 10) || 10;
            let currentPageInstrumen = 1;
            let searchQueryInstrumen = '';
            let selectedUnitKerja = null;
            let selectedPeriode = null;

            function debounce(func, delay) {
                let timeoutId;
                return function(...args) {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => func.apply(this, args), delay);
                };
            }

            function processRawData(data) {
                let flatData = [];
                let overallIndex = 0; // To keep track of the global index for each unique 'No' (Sasaran Strategis)

                data.forEach(sasaran => {
                    const sasaranIndex = overallIndex; // Capture the index for this sasaran

                    sasaran.indikator_kinerja.forEach(indikator => {
                        indikator.aktivitas.forEach(aktivitas => {
                            flatData.push({
                                sasaran_id: sasaran.sasaran_strategis_id,
                                nama_sasaran: sasaran.nama_sasaran,
                                indikator_id: indikator.indikator_kinerja_id,
                                isi_indikator_kinerja: indikator.isi_indikator_kinerja,
                                aktivitas_id: aktivitas.aktivitas_id,
                                nama_aktivitas: aktivitas.nama_aktivitas,
                                satuan: aktivitas.satuan,
                                target: aktivitas.target,
                                original_sasaran_index: sasaranIndex // Mark which original sasaran it belongs to
                            });
                        });
                    });
                    overallIndex++; // Increment for the next unique sasaran
                });
                return flatData;
            }

            function filterAndPaginateInstrumenData() {
                let filteredData = processedInstrumenData;

                // Filter berdasarkan search query
                if (searchQueryInstrumen) {
                    const searchTerm = searchQueryInstrumen.toLowerCase();
                    filteredData = filteredData.filter(item => {
                        return (
                            (item.nama_sasaran || '').toLowerCase().includes(searchTerm) ||
                            (item.isi_indikator_kinerja || '').toLowerCase().includes(searchTerm) ||
                            (item.nama_aktivitas || '').toLowerCase().includes(searchTerm) ||
                            (item.satuan || '').toLowerCase().includes(searchTerm) ||
                            (item.target || '').toLowerCase().includes(searchTerm)
                        );
                    });
                }

                // Filtering by unique sasaran_id for pagination (each sasaran_id counts as 1 for 'No' column)
                // We need to group by original_sasaran_index to effectively paginate by the "No" column
                const uniqueSasaranGroups = [];
                let currentSasaranGroup = null;

                filteredData.forEach(item => {
                    if (!currentSasaranGroup || currentSasaranGroup.original_sasaran_index !== item.original_sasaran_index) {
                        currentSasaranGroup = {
                            original_sasaran_index: item.original_sasaran_index,
                            items: []
                        };
                        uniqueSasaranGroups.push(currentSasaranGroup);
                    }
                    currentSasaranGroup.items.push(item);
                });

                const totalSasaranGroups = uniqueSasaranGroups.length;
                const totalPages = Math.ceil(totalSasaranGroups / perPageInstrumen);
                currentPageInstrumen = Math.min(currentPageInstrumen, totalPages) || 1;

                const startGroupIndex = (currentPageInstrumen - 1) * perPageInstrumen;
                const paginatedSasaranGroups = uniqueSasaranGroups.slice(startGroupIndex, startGroupIndex + perPageInstrumen);

                let finalPaginatedData = [];
                paginatedSasaranGroups.forEach(group => {
                    finalPaginatedData = finalPaginatedData.concat(group.items);
                });

                return {
                    data: finalPaginatedData,
                    totalItems: totalSasaranGroups, // This is the count of unique "No" entries
                    totalPages: totalPages,
                    startIndex: startGroupIndex // This is the start index for the groups
                };
            }


            function renderInstrumenTable() {
                const { data: paginatedData, totalItems, totalPages, startIndex } = filterAndPaginateInstrumenData();

                tableBodyInstrumen.innerHTML = '';
                if (paginatedData.length === 0) {
                    showEmptyStateInstrumen();
                    renderPaginationInfoInstrumen(0, 0, 0, 0); // Reset info on empty
                    renderPaginationButtonsInstrumen(1); // Show only 1 page
                    return;
                }

                let currentSasaranId = null;
                let sasaranRowspan = 0;
                let currentIndikatorId = null;
                let indikatorRowspan = 0;
                let rowNumberDisplay = startIndex + 1; // Actual number for the "No" column

                let rowIndexInCurrentSasaranGroup = 0; // Tracks rows within the current SASARAN group

                paginatedData.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200';

                    let noCellHtml = '';
                    let sasaranCellHtml = '';
                    let indikatorCellHtml = '';

                    // Calculate rowspan for the current sasaran group
                    if (item.sasaran_id !== currentSasaranId) {
                        currentSasaranId = item.sasaran_id;
                        // Find how many rows this sasaran_id spans in the *current filtered and paginated view*
                        sasaranRowspan = paginatedData.filter(d => d.sasaran_id === item.sasaran_id).length;
                        noCellHtml = `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${rowNumberDisplay}</td>`;
                        sasaranCellHtml = `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.nama_sasaran}</td>`;
                        rowNumberDisplay++; // Increment 'No' only for new sasaran groups
                        currentIndikatorId = null; // Reset indikator for new sasaran
                    }

                    // Calculate rowspan for the current indikator group within the sasaran
                    if (item.indikator_id !== currentIndikatorId) {
                        currentIndikatorId = item.indikator_id;
                        // Find how many rows this indikator_id spans within the current sasaran_id in the *current filtered and paginated view*
                        indikatorRowspan = paginatedData.filter(d => d.sasaran_id === item.sasaran_id && d.indikator_id === item.indikator_id).length;
                        indikatorCellHtml = `<td rowspan="${indikatorRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.isi_indikator_kinerja}</td>`;
                    }

                    row.innerHTML = `
                        ${noCellHtml}
                        ${sasaranCellHtml}
                        ${indikatorCellHtml}
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.nama_aktivitas}</td>
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.satuan}</td>
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.target}</td>
                    `;
                    tableBodyInstrumen.appendChild(row);
                });

                renderPaginationInfoInstrumen(startIndex, paginatedData.length, totalItems, totalPages);
                renderPaginationButtonsInstrumen(totalPages);
            }


            function renderPaginationInfoInstrumen(startGroupIndex, currentDisplayedItems, totalUniqueGroups, totalPages) {
                const startNum = totalUniqueGroups > 0 ? startGroupIndex + 1 : 0;
                const endNum = Math.min(startGroupIndex + perPageInstrumen, totalUniqueGroups);
                paginationInfoInstrumen.innerHTML = `Menampilkan <strong>${startNum}</strong> hingga <strong>${endNum}</strong> dari <strong>${totalUniqueGroups}</strong> hasil`;
            }


            function renderPaginationButtonsInstrumen(totalPages) {
                paginationButtonsInstrumen.innerHTML = '';
                if (totalPages <= 1) return;

                const maxVisibleButtons = 5;
                let startPage;
                let endPage;

                if (totalPages <= maxVisibleButtons) {
                    startPage = 1;
                    endPage = totalPages;
                } else {
                    const sideButtons = Math.floor(maxVisibleButtons / 2);
                    if (currentPageInstrumen <= sideButtons) {
                        startPage = 1;
                        endPage = maxVisibleButtons;
                    } else if (currentPageInstrumen + sideButtons >= totalPages) {
                        startPage = totalPages - maxVisibleButtons + 1;
                        endPage = totalPages;
                    } else {
                        startPage = currentPageInstrumen - sideButtons;
                        endPage = currentPageInstrumen + sideButtons;
                    }
                }

                paginationButtonsInstrumen.appendChild(createPageButtonInstrumen(currentPageInstrumen > 1 ? currentPageInstrumen - 1 : null, 'Previous', currentPageInstrumen === 1));

                for (let i = startPage; i <= endPage; i++) {
                    paginationButtonsInstrumen.appendChild(createPageButtonInstrumen(i, i, false, i === currentPageInstrumen));
                }

                paginationButtonsInstrumen.appendChild(createPageButtonInstrumen(currentPageInstrumen < totalPages ? currentPageInstrumen + 1 : null, 'Next', currentPageInstrumen === totalPages));
            }

            function createPageButtonInstrumen(page, text, isDisabled = false, isActive = false) {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = '#';
                a.dataset.page = page;
                a.textContent = text;

                let classes = "flex h-8 items-center justify-center border px-3 leading-tight transition-all duration-200 ";
                if (isDisabled) {
                    classes += "border-gray-300 bg-white text-gray-500 cursor-not-allowed opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400";
                } else if (isActive) {
                    classes += "border-sky-300 bg-sky-50 text-sky-800 z-10 dark:border-sky-700 dark:bg-sky-900 dark:text-sky-200";
                } else {
                    classes += "border-gray-300 bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200";
                }
                a.className = classes;

                li.appendChild(a);
                return li;
            }

            function showLoadingStateInstrumen() {
                tableBodyInstrumen.innerHTML = `<tr><td colspan="6" class="text-center p-4"><div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-sky-500 mx-auto"></div><p class="mt-2">Memuat data...</p></td></tr>`;
            }

            function showEmptyStateInstrumen() {
                tableBodyInstrumen.innerHTML = `<tr><td colspan="6" class="text-center p-4 text-gray-500">Data tidak ditemukan.</td></tr>`;
            }

            function showErrorStateInstrumen(message) {
                tableBodyInstrumen.innerHTML = `<tr><td colspan="6" class="text-center p-4 text-red-500">${message}</td></tr>`;
            }

            async function fetchInstrumenData() {
                showLoadingStateInstrumen();
                try {
                    const response = await fetch('http://127.0.0.1:5000/api/data-instrumen');
                    if (!response.ok) throw new Error('Gagal mengambil data instrumen');
                    const data = await response.json();
                    allInstrumenDataRaw = data;
                    processedInstrumenData = processRawData(data); // Flatten and process data once
                    currentPageInstrumen = 1; // Reset to first page
                    renderInstrumenTable();
                } catch (error) {
                    console.error('Error fetching instrumen data:', error);
                    showErrorStateInstrumen('Tidak dapat terhubung ke server instrumen.');
                }
            }

            // =========================== BAGIAN Filter Dropdown ===========================
            async function fetchUnitKerja() {
                try {
                    const response = await fetch('http://127.0.0.1:5000/api/unit-kerja');
                    const result = await response.json();
                    const data = result.data;
                    data.forEach(unit => {
                        const option = document.createElement('option');
                        option.value = unit.unit_kerja_id;
                        option.textContent = unit.nama_unit_kerja;
                        unitKerjaSelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Gagal memuat unit kerja:', error);
                }
            }

            async function fetchPeriodeAudit() {
                try {
                    const response = await fetch('http://127.0.0.1:5000/api/periode-audits');
                    const result = await response.json();
                    const data = result.data.data;
                    data.forEach(periode => {
                        const option = document.createElement('option');
                        option.value = periode.periode_id;
                        option.textContent = periode.nama_periode;
                        periodeSelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Gagal memuat periode AMI:', error);
                }
            }

            // =========================== EVENT LISTENERS ===========================
            perPageSelectInstrumen.addEventListener('change', () => {
                perPageInstrumen = parseInt(perPageSelectInstrumen.value, 10);
                currentPageInstrumen = 1;
                renderInstrumenTable();
            });

            const debouncedSearchInstrumen = debounce(() => {
                searchQueryInstrumen = searchInputInstrumen.value;
                fetchInstrumenData(); // Refetch or re-process all data to apply search
            }, 300);
            searchInputInstrumen.addEventListener('input', debouncedSearchInstrumen);

            paginationButtonsInstrumen.addEventListener('click', (e) => {
                e.preventDefault();
                const target = e.target.closest('a');
                if (target && target.dataset.page) {
                    const page = parseInt(target.dataset.page);
                    if (!isNaN(page) && page !== currentPageInstrumen) {
                        currentPageInstrumen = page;
                        renderInstrumenTable();
                    }
                }
            });

            // Handle filter changes (implement filtering logic if needed based on selected values)
            unitKerjaSelect.addEventListener('change', (event) => {
                selectedUnitKerja = event.target.value;
                // Implement filtering logic here or trigger a data refetch
                console.log('Selected Unit Kerja:', selectedUnitKerja);
            });

            periodeSelect.addEventListener('change', (event) => {
                selectedPeriode = event.target.value;
                // Implement filtering logic here or trigger a data refetch
                console.log('Selected Periode AMI:', selectedPeriode);
            });


            // === INISIALISASI ===
            fetchInstrumenData();
            fetchUnitKerja();
            fetchPeriodeAudit();
        });
    </script>
@endsection