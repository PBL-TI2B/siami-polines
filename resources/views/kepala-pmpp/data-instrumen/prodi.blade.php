@extends('layouts.app')

@section('title', 'Data Instrumen Prodi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data Instrumen Prodi', 'url' => route('admin.data-instrumen.instrumenprodi')],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Data Instrumen Prodi
        </h1>
        <!-- Filters and Search -->
        <div class="mb-4 flex justify-between items-center">
            <div class="flex flex-wrap gap-2">
                <select id="jenisUnitSelectProdi" class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Jenis Unit</option>
                </select>
                <select id="periodeSelectProdi" class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Periode AMI</option>
                </select>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
            <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 rounded-t-2xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <select id="perPageSelectProdi" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200">
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
                    <input type="search" id="searchInputProdi" placeholder="Cari" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">No</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Standar</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Deskripsi Area Audit-Sub Butir Standar</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pemeriksaan Pada Unsur</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Jenis Unit Kerja</th>
                            {{-- Additional columns (commented out as in original)
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Ketersediaan Standar dan Dokumen (Ada/Tidak)</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pencapaian Standar SPT PT</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pencapaian Standar SN DIKTI</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Lokal</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Nasional</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Internasional</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Keterangan</th>
                            --}}
                        </tr>
                    </thead>
                    <tbody id="instrumen-table-body-prodi" class="divide-y divide-gray-200 dark:divide-gray-700">
                        </tbody>
                </table>
            </div>

            <div class="p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span id="pagination-info-prodi" class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>1</strong> hingga <strong>10</strong> dari <strong>0</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul id="pagination-buttons-prodi" class="inline-flex -space-x-px text-sm">
                            {{-- Pagination buttons will be generated by JavaScript --}}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // === DOM ELEMENTS ===
    const tableBodyProdi = document.getElementById('instrumen-table-body-prodi');
    const perPageSelectProdi = document.getElementById('perPageSelectProdi');
    const searchInputProdi = document.getElementById('searchInputProdi');
    const paginationInfoProdi = document.getElementById('pagination-info-prodi');
    const paginationButtonsProdi = document.getElementById('pagination-buttons-prodi');
    const jenisUnitSelectProdi = document.getElementById('jenisUnitSelectProdi');
    const periodeSelectProdi = document.getElementById('periodeSelectProdi');

    // === STATE VARIABLES ===
    let allInstrumenDataProdiRaw = []; // Stores the raw fetched data
    let currentFilteredAndGroupedData = {}; // Stores data after filtering, grouped by Standar for pagination
    let perPageProdi = parseInt(perPageSelectProdi.value, 10) || 10;
    let currentPageProdi = 1;
    let searchQueryProdi = '';
    let selectedJenisUnitProdi = '3'; // Default to Prodi (jenis_unit_id = 3)
    let selectedPeriodeProdi = null;

    // === HELPER FUNCTIONS ===
    function debounce(func, delay) {
        let timeoutId;
        return function (...args) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func.apply(this, args), delay);
        };
    }

    function showLoadingStateProdi() {
        tableBodyProdi.innerHTML = `<tr><td colspan="6" class="text-center p-4"><div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-sky-500 mx-auto"></div><p class="mt-2">Memuat data...</p></td></tr>`;
        paginationInfoProdi.textContent = 'Memuat...';
        paginationButtonsProdi.innerHTML = '';
    }

    function showEmptyStateProdi() {
        tableBodyProdi.innerHTML = `<tr><td colspan="6" class="px-4 py-3 sm:px-6 text-center text-gray-500">Data tidak ditemukan.</td></tr>`;
        paginationInfoProdi.textContent = 'Menampilkan 0 hingga 0 dari 0 hasil';
        paginationButtonsProdi.innerHTML = '';
    }

    function showErrorStateProdi(message) {
        tableBodyProdi.innerHTML = `<tr><td colspan="6" class="px-4 py-3 sm:px-6 text-center text-red-500">${message}</td></tr>`;
        paginationInfoProdi.textContent = '';
        paginationButtonsProdi.innerHTML = '';
    }

    /**
     * Filters the raw data based on current search query, selected unit type, and period.
     * Then groups it by 'Standar' (kriteria) for pagination.
     * @returns {Object} An object containing the grouped data and its total count for pagination.
     */
    function filterAndGroupInstrumenDataProdi() {
        let filteredData = allInstrumenDataProdiRaw;

        // Apply Jenis Unit filter
        if (selectedJenisUnitProdi && selectedJenisUnitProdi !== '') {
            filteredData = filteredData.filter(item =>
                item.jenis_unit_id === parseInt(selectedJenisUnitProdi)
            );
        }

        // Apply Periode filter (if you have a 'periode_id' in your set-instrumen data)
        // Currently, the set-instrumen API response doesn't show periode_id directly within its items.
        // If you need to filter by periode, you'll need to ensure the API provides this or filter at the source.
        // For now, it's just a placeholder for the dropdown selection.
        if (selectedPeriodeProdi && selectedPeriodeProdi !== '') {
             // You'll need to adjust this logic based on how `periode_id` is linked in your actual API data.
            // Example: filteredData = filteredData.filter(item => item.periode_audit_id === parseInt(selectedPeriodeProdi));
            console.warn("Filtering by Periode AMI is not fully implemented as 'periode_id' is not directly available in `set-instrumen` API response structure. Implement this when the API supports it.");
        }


        // Apply search query filter
        if (searchQueryProdi) {
            const searchTerm = searchQueryProdi.toLowerCase();
            filteredData = filteredData.filter(item => {
                const standar = item.unsur?.deskripsi?.kriteria?.nama_kriteria || '';
                const deskripsi = item.unsur?.deskripsi?.isi_deskripsi || '';
                const unsur = item.unsur?.isi_unsur || '';
                const jenisUnit = item.jenisunit?.nama_jenis_unit || '';

                return (
                    standar.toLowerCase().includes(searchTerm) ||
                    deskripsi.toLowerCase().includes(searchTerm) ||
                    unsur.toLowerCase().includes(searchTerm) ||
                    jenisUnit.toLowerCase().includes(searchTerm)
                );
            });
        }

        const groupedByStandar = {};
        let uniqueStandarOrder = []; // To maintain the order of standards

        filteredData.forEach(item => {
            const standarKey = item.unsur?.deskripsi?.kriteria?.kriteria_id; // Use kriteria_id as unique key
            if (standarKey) {
                if (!groupedByStandar[standarKey]) {
                    groupedByStandar[standarKey] = {
                        name: item.unsur.deskripsi.kriteria.nama_kriteria,
                        items: [],
                        originalIndex: uniqueStandarOrder.length // Store its original grouping order
                    };
                    uniqueStandarOrder.push(standarKey);
                }
                groupedByStandar[standarKey].items.push(item);
            }
        });

        // Convert the ordered unique keys into an array of grouped objects
        const orderedGroupedData = uniqueStandarOrder.map(key => groupedByStandar[key]);

        return {
            groupedData: orderedGroupedData,
            totalUniqueStandards: orderedGroupedData.length
        };
    }

    /**
     * Renders the table content and updates pagination controls.
     */
    function renderProdiTable() {
        const { groupedData, totalUniqueStandards } = filterAndGroupInstrumenDataProdi();

        const totalPages = Math.ceil(totalUniqueStandards / perPageProdi);
        currentPageProdi = Math.min(currentPageProdi, totalPages) || 1;
        currentPageProdi = Math.max(1, currentPageProdi); // Ensure current page is at least 1

        const startGroupIndex = (currentPageProdi - 1) * perPageProdi;
        const paginatedGroups = groupedData.slice(startGroupIndex, startGroupIndex + perPageProdi);

        tableBodyProdi.innerHTML = '';
        if (paginatedGroups.length === 0) {
            showEmptyStateProdi();
            return;
        }

        let currentDisplayNo = startGroupIndex + 1; // Tracks the sequential 'No' for standards

        paginatedGroups.forEach(standarGroup => {
            let isFirstRowOfStandar = true;

            const totalRowsForCurrentStandarGroup = standarGroup.items.length;

            const groupedByDeskripsiInStandar = {};
            standarGroup.items.forEach(item => {
                const deskripsiKey = item.unsur?.deskripsi?.deskripsi_id || 'no_desc';
                if (!groupedByDeskripsiInStandar[deskripsiKey]) {
                    groupedByDeskripsiInStandar[deskripsiKey] = {
                        name: item.unsur?.deskripsi?.isi_deskripsi || 'Tidak Diketahui',
                        items: []
                    };
                }
                groupedByDeskripsiInStandar[deskripsiKey].items.push(item);
            });

            for (const deskripsiKey in groupedByDeskripsiInStandar) {
                const deskripsiGroup = groupedByDeskripsiInStandar[deskripsiKey];
                let isFirstRowOfDeskripsi = true;
                const totalRowsForCurrentDeskripsiGroup = deskripsiGroup.items.length;

                const groupedByUnsurInDeskripsi = {};
                deskripsiGroup.items.forEach(item => {
                    const unsurKey = item.unsur?.unsur_id || 'no_unsur';
                    if (!groupedByUnsurInDeskripsi[unsurKey]) {
                        groupedByUnsurInDeskripsi[unsurKey] = {
                            name: item.unsur?.isi_unsur || 'Tidak Diketahui',
                            items: []
                        };
                    }
                    groupedByUnsurInDeskripsi[unsurKey].items.push(item);
                });

                for (const unsurKey in groupedByUnsurInDeskripsi) {
                    const unsurGroup = groupedByUnsurInDeskripsi[unsurKey];
                    let isFirstRowOfUnsur = true;
                    const totalRowsForCurrentUnsurGroup = unsurGroup.items.length;

                    unsurGroup.items.forEach(item => {
                        const row = document.createElement('tr');
                        row.className = "transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700";
                        let html = '';

                        // 'No' and 'Standar' columns (rowspan for entire standard group)
                        if (isFirstRowOfStandar) {
                            html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForCurrentStandarGroup}">${currentDisplayNo}</td>`;
                            html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForCurrentStandarGroup}">${standarGroup.name}</td>`;
                            isFirstRowOfStandar = false;
                        }

                        // 'Deskripsi Area Audit-Sub Butir Standar' column (rowspan for entire description group within standard)
                        if (isFirstRowOfDeskripsi) {
                            html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForCurrentDeskripsiGroup}">${deskripsiGroup.name}</td>`;
                            isFirstRowOfDeskripsi = false;
                        }

                        // 'Pemeriksaan Pada Unsur' column (rowspan for entire unsur group within description)
                        if (isFirstRowOfUnsur) {
                            html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForCurrentUnsurGroup}">${unsurGroup.name}</td>`;
                            isFirstRowOfUnsur = false;
                        }

                        // 'Jenis Unit Kerja' column (rendered for each row)
                        html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${item.jenisunit?.nama_jenis_unit || 'Tidak Diketahui'}</td>`;

                        row.innerHTML = html;
                        tableBodyProdi.appendChild(row);
                    });
                }
            }
            currentDisplayNo++; // Increment 'No' for the next distinct standard on the current page
        });

        renderPaginationInfoProdi(startGroupIndex, totalUniqueStandards);
        renderPaginationButtonsProdi(totalPages);
    }

    function renderPaginationInfoProdi(startGroupIndex, totalUniqueStandards) {
        const startItem = totalUniqueStandards > 0 ? startGroupIndex + 1 : 0;
        const endItem = Math.min(startGroupIndex + perPageProdi, totalUniqueStandards);
        paginationInfoProdi.innerHTML = `Menampilkan <strong>${startItem}</strong> hingga <strong>${endItem}</strong> dari <strong>${totalUniqueStandards}</strong> hasil`;
    }

    function renderPaginationButtonsProdi(totalPages) {
        paginationButtonsProdi.innerHTML = '';
        if (totalPages <= 1) return;

        const maxVisibleButtons = 5;
        let startPage;
        let endPage;

        if (totalPages <= maxVisibleButtons) {
            startPage = 1;
            endPage = totalPages;
        } else {
            const sideButtons = Math.floor(maxVisibleButtons / 2);
            if (currentPageProdi <= sideButtons) {
                startPage = 1;
                endPage = maxVisibleButtons;
            } else if (currentPageProdi + sideButtons >= totalPages) {
                startPage = totalPages - maxVisibleButtons + 1;
                endPage = totalPages;
            } else {
                startPage = currentPageProdi - sideButtons;
                endPage = currentPageProdi + sideButtons;
            }
        }

        // Previous Button
        paginationButtonsProdi.appendChild(createPageButtonProdi(currentPageProdi > 1 ? currentPageProdi - 1 : null, 'Previous', currentPageProdi === 1));

        // Page Number Buttons
        for (let i = startPage; i <= endPage; i++) {
            paginationButtonsProdi.appendChild(createPageButtonProdi(i, i, false, i === currentPageProdi));
        }

        // Next Button
        paginationButtonsProdi.appendChild(createPageButtonProdi(currentPageProdi < totalPages ? currentPageProdi + 1 : null, 'Next', currentPageProdi === totalPages));
    }

    function createPageButtonProdi(page, text, isDisabled = false, isActive = false) {
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

    // === DATA FETCHING FUNCTIONS ===
    async function fetchAllInstrumenDataProdi() {
        showLoadingStateProdi();
        try {
            const response = await fetch('http://127.0.0.1:5000/api/set-instrumen');
            if (!response.ok) throw new Error('Gagal mengambil data instrumen');
            const result = await response.json();
            allInstrumenDataProdiRaw = result.data || [];
            currentPageProdi = 1; // Reset to first page
            renderProdiTable(); // Re-render table with new data and filters
        } catch (error) {
            console.error('Error fetching instrumen data:', error);
            showErrorStateProdi('Tidak dapat terhubung ke server instrumen.');
        }
    }

    async function fetchJenisUnit() {
        try {
            const response = await fetch('http://127.0.0.1:5000/api/jenis-units');
            const result = await response.json();
            const data = result.data;
            // Add a default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Semua Jenis Unit';
            jenisUnitSelectProdi.appendChild(defaultOption);

            data.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit.jenis_unit_id;
                option.textContent = unit.nama_jenis_unit;
                jenisUnitSelectProdi.appendChild(option);
            });
            // Set default selection to jenis_unit_id = 3 (Prodi)
            jenisUnitSelectProdi.value = selectedJenisUnitProdi;
        } catch (error) {
            console.error('Gagal memuat jenis unit:', error);
        }
    }

    async function fetchPeriodeAudit() {
        try {
            const response = await fetch('http://127.0.0.1:5000/api/periode-audits');
            const result = await response.json();
            const data = result.data.data; // Assuming .data.data as per previous
            // Add a default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Semua Periode';
            periodeSelectProdi.appendChild(defaultOption);

            data.forEach(periode => {
                const option = document.createElement('option');
                option.value = periode.periode_id;
                option.textContent = periode.nama_periode;
                periodeSelectProdi.appendChild(option);
            });
        } catch (error) {
            console.error('Gagal memuat periode AMI:', error);
        }
    }

    // === EVENT LISTENERS ===
    perPageSelectProdi.addEventListener('change', () => {
        perPageProdi = parseInt(perPageSelectProdi.value, 10);
        currentPageProdi = 1; // Reset to first page
        renderProdiTable();
    });

    const debouncedSearchProdi = debounce(() => {
        searchQueryProdi = searchInputProdi.value;
        currentPageProdi = 1; // Reset to first page
        renderProdiTable(); // Re-render with new search query
    }, 300);
    searchInputProdi.addEventListener('input', debouncedSearchProdi);

    paginationButtonsProdi.addEventListener('click', (e) => {
        e.preventDefault();
        const target = e.target.closest('a');
        if (target && target.dataset.page) {
            const page = parseInt(target.dataset.page);
            if (!isNaN(page) && page !== currentPageProdi) {
                currentPageProdi = page;
                renderProdiTable();
            }
        }
    });

    jenisUnitSelectProdi.addEventListener('change', () => {
        selectedJenisUnitProdi = jenisUnitSelectProdi.value;
        currentPageProdi = 1; // Reset to first page
        renderProdiTable(); // Re-render with new filter
    });

    periodeSelectProdi.addEventListener('change', () => {
        selectedPeriodeProdi = periodeSelectProdi.value;
        currentPageProdi = 1; // Reset to first page
        renderProdiTable(); // Re-render with new filter
    });

    // Event listener for delete button (copied from original, ensure route exists)
    document.getElementById('instrumen-table-body-prodi').addEventListener('click', function (e) {
        const deleteBtn = e.target.closest('.delete-btn');
        if (deleteBtn) {
            e.preventDefault();
            const setInstrumenId = deleteBtn.getAttribute('data-id');

            if (confirm('Apakah Anda yakin ingin menghapus instrumen ini?')) {
                fetch(`http://127.0.0.1:5000/api/set-instrumen/${setInstrumenId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal menghapus instrumen');
                        }
                        return response.json();
                    })
                    .then(result => {
                        alert('Instrumen berhasil dihapus!');
                        // Assuming this is a SPA, re-fetch data or remove row
                        fetchAllInstrumenDataProdi();
                        // For a full page reload if not SPA:
                        // window.location.href = '/admin/data-instrumen/prodi';
                    })
                    .catch(error => {
                        console.error('Gagal menghapus instrumen:', error);
                        alert('Gagal menghapus instrumen. Silakan coba lagi.');
                    });
            }
        }
    });

    // === INITIALIZATION ===
    fetchJenisUnit();
    fetchPeriodeAudit();
    fetchAllInstrumenDataProdi(); // Initial data fetch and render

});
</script>
@endsection