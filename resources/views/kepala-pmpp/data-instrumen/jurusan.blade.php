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

        <!-- <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex flex-wrap gap-2">
                <select id="unitKerjaSelectJurusan" class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Unit</option>
                </select>
                <select id="periodeSelectJurusan" class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Periode AMI</option>
                </select>
            </div>
        </div> -->

        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
            <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 rounded-t-2xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <select id="perPageSelectJurusan" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200">
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
                    <input type="search" id="searchInputJurusan" placeholder="Cari" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
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
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="instrumen-table-body-jurusan">
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span id="pagination-info-jurusan" class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan 1 hingga 10 dari 100 hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul id="pagination-buttons-jurusan" class="inline-flex -space-x-px text-sm">
                            {{-- Pagination buttons will be generated by JavaScript --}}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tableBodyJurusan = document.getElementById('instrumen-table-body-jurusan');
            const perPageSelectJurusan = document.getElementById('perPageSelectJurusan');
            const searchInputJurusan = document.getElementById('searchInputJurusan');
            const paginationInfoJurusan = document.getElementById('pagination-info-jurusan');
            const paginationButtonsJurusan = document.getElementById('pagination-buttons-jurusan');
            const unitKerjaSelectJurusan = document.getElementById('unitKerjaSelectJurusan');
            const periodeSelectJurusan = document.getElementById('periodeSelectJurusan');

            let allInstrumenDataJurusanRaw = []; // Data mentah dari API
            let flattenedInstrumenDataJurusan = []; // Data setelah diratakan (flattened) untuk pagination/search
            let perPageJurusan = parseInt(perPageSelectJurusan.value, 10) || 10;
            let currentPageJurusan = 1;
            let searchQueryJurusan = '';
            let selectedUnitKerjaJurusan = null; // Filter ini belum diimplementasikan di API fetch
            let selectedPeriodeJurusan = null; // Filter ini belum diimplementasikan di API fetch

            // === HELPER FUNCTIONS ===
            function debounce(func, delay) {
                let timeoutId;
                return function(...args) {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => func.apply(this, args), delay);
                };
            }

            function showLoadingStateJurusan() {
                tableBodyJurusan.innerHTML = `<tr><td colspan="6" class="text-center p-4"><div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-sky-500 mx-auto"></div><p class="mt-2">Memuat data...</p></td></tr>`;
                paginationInfoJurusan.textContent = 'Memuat...';
                paginationButtonsJurusan.innerHTML = '';
            }

            function showEmptyStateJurusan() {
                tableBodyJurusan.innerHTML = `<tr><td colspan="6" class="px-4 py-3 sm:px-6 text-center text-gray-500">Data tidak ditemukan.</td></tr>`;
                paginationInfoJurusan.textContent = 'Menampilkan 0 hingga 0 dari 0 hasil';
                paginationButtonsJurusan.innerHTML = '';
            }

            function showErrorStateJurusan(message) {
                tableBodyJurusan.innerHTML = `<tr><td colspan="6" class="px-4 py-3 sm:px-6 text-center text-red-500">${message}</td></tr>`;
                paginationInfoJurusan.textContent = '';
                paginationButtonsJurusan.innerHTML = '';
            }

            /**
             * Flattens the nested data structure into a single array of activity rows,
             * with parent sasaran and indikator info attached.
             * This flattened data is then used for pagination and search based on individual activities.
             * Adds `original_sasaran_index` to maintain grouping for rowspan display.
             */
            function flattenInstrumenDataJurusan(data) {
                let flatData = [];
                let sasaranCounter = 0; // To track unique sasaran for the 'No' column logic

                data.forEach(sasaran => {
                    const currentSasaranOriginalIndex = sasaranCounter;
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
                                original_sasaran_index: currentSasaranOriginalIndex // Used for 'No' column grouping
                            });
                        });
                    });
                    sasaranCounter++; // Increment for next unique sasaran
                });
                return flatData;
            }

            /**
             * Filters the flattened data based on search query, then applies pagination.
             */
            function filterAndPaginateInstrumenDataJurusan() {
                let filteredData = flattenedInstrumenDataJurusan;

                // Apply search query filter
                if (searchQueryJurusan) {
                    const searchTerm = searchQueryJurusan.toLowerCase();
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

                // Apply Unit Kerja filter (if selected)
                if (selectedUnitKerjaJurusan && selectedUnitKerjaJurusan !== '') {
                    // This assumes `allInstrumenDataJurusanRaw` might need re-fetching
                    // or `flattenedInstrumenDataJurusan` needs to be derived from a pre-filtered `allInstrumenDataJurusanRaw`.
                    // For now, this filter cannot be applied to `flattenedInstrumenDataJurusan`
                    // unless `unit_kerja_id` is included in each flattened activity item.
                    // If your API supports filtering by unit_kerja_id, it's better to fetch filtered data.
                    console.warn("Filtering by Unit Kerja is not implemented in client-side data for Jurusan. Consider filtering via API or including unit_kerja_id in flattened data.");
                }

                // Apply Periode filter (if selected)
                if (selectedPeriodeJurusan && selectedPeriodeJurusan !== '') {
                    // Similar to Unit Kerja filter, needs API support or `periode_id` in flattened data.
                    console.warn("Filtering by Periode AMI is not implemented in client-side data for Jurusan. Consider filtering via API or including periode_id in flattened data.");
                }


                const totalFilteredItems = filteredData.length;
                const totalPages = Math.ceil(totalFilteredItems / perPageJurusan);
                currentPageJurusan = Math.min(currentPageJurusan, totalPages) || 1;
                currentPageJurusan = Math.max(1, currentPageJurusan); // Ensure current page is at least 1

                const startIndex = (currentPageJurusan - 1) * perPageJurusan;
                const paginatedData = filteredData.slice(startIndex, startIndex + perPageJurusan);

                return {
                    data: paginatedData,
                    totalItems: totalFilteredItems, // Total number of activity rows after filter
                    totalPages: totalPages,
                    startIndex: startIndex // Starting index of the current page for numbering
                };
            }

            /**
             * Renders the table content and updates pagination controls.
             */
            function renderInstrumenTable() {
                const { data: paginatedData, totalItems, totalPages, startIndex } = filterAndPaginateInstrumenDataJurusan();

                tableBodyJurusan.innerHTML = '';
                if (paginatedData.length === 0) {
                    showEmptyStateJurusan();
                    renderPaginationInfoJurusan(0, 0); // Reset info on empty
                    renderPaginationButtonsJurusan(1); // Show only 1 page
                    return;
                }

                let lastSasaranOriginalIndex = null;
                let lastIndikatorId = null;
                let displayNoForSasaran = 0; // This will map to the original Sasaran's index for 'No' column

                // Pre-calculate rowspans for the *current paginated data*
                const paginatedSasaranRowspans = {};
                const paginatedIndikatorRowspans = {};

                paginatedData.forEach(item => {
                    const sasaranKey = item.original_sasaran_index;
                    const indikatorKey = `${sasaranKey}-${item.indikator_id}`;

                    paginatedSasaranRowspans[sasaranKey] = (paginatedSasaranRowspans[sasaranKey] || 0) + 1;
                    paginatedIndikatorRowspans[indikatorKey] = (paginatedIndikatorRowspans[indikatorKey] || 0) + 1;
                });

                // Re-map `original_sasaran_index` to sequential `No` numbers for the current page
                const sasaranDisplayMap = {};
                let currentSasaranDisplayNo = startIndex + 1; // Start 'No' from the true global index + 1
                let seenOriginalSasaranIndexes = new Set();


                paginatedData.forEach(item => {
                    const row = document.createElement('tr');
                    row.className = "transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700";

                    let noCellHtml = '';
                    let sasaranCellHtml = '';
                    let indikatorCellHtml = '';

                    // Logic for 'No' and 'Sasaran Strategis' columns
                    if (item.original_sasaran_index !== lastSasaranOriginalIndex) {
                        lastSasaranOriginalIndex = item.original_sasaran_index;
                        // Determine the rowspan for this Sasaran in the *current paginated view*
                        const sasaranTotalRows = paginatedData.filter(d => d.original_sasaran_index === item.original_sasaran_index).length;

                        noCellHtml = `<td rowspan="${sasaranTotalRows}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${currentSasaranDisplayNo}</td>`;
                        sasaranCellHtml = `<td rowspan="${sasaranTotalRows}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.nama_sasaran}</td>`;
                        currentSasaranDisplayNo++; // Increment for the next *new* Sasaran displayed on this page
                        lastIndikatorId = null; // Reset indikator when sasaran changes
                    }

                    // Logic for 'Indikator Kinerja' column
                    if (item.indikator_id !== lastIndikatorId || item.original_sasaran_index !== lastSasaranOriginalIndex) {
                        // Check if current indikator is different OR if sasaran just changed (forcing new indikator cell)
                        lastIndikatorId = item.indikator_id;
                        // Determine the rowspan for this Indikator within its Sasaran in the *current paginated view*
                        const indikatorTotalRows = paginatedData.filter(d => d.original_sasaran_index === item.original_sasaran_index && d.indikator_id === item.indikator_id).length;
                        indikatorCellHtml = `<td rowspan="${indikatorTotalRows}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.isi_indikator_kinerja}</td>`;
                    }

                    row.innerHTML = `
                        ${noCellHtml}
                        ${sasaranCellHtml}
                        ${indikatorCellHtml}
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.nama_aktivitas}</td>
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.satuan}</td>
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.target}</td>
                    `;
                    tableBodyJurusan.appendChild(row);
                });

                renderPaginationInfoJurusan(startIndex, totalItems);
                renderPaginationButtonsJurusan(totalPages);
            }


            function renderPaginationInfoJurusan(startIndex, totalFilteredItems) {
                const startItem = totalFilteredItems > 0 ? startIndex + 1 : 0;
                const endItem = Math.min(startIndex + perPageJurusan, totalFilteredItems);
                paginationInfoJurusan.innerHTML = `Menampilkan <strong>${startItem}</strong> hingga <strong>${endItem}</strong> dari <strong>${totalFilteredItems}</strong> hasil`;
            }


            function renderPaginationButtonsJurusan(totalPages) {
                paginationButtonsJurusan.innerHTML = '';
                if (totalPages <= 1) return;

                const maxVisibleButtons = 5;
                let startPage;
                let endPage;

                if (totalPages <= maxVisibleButtons) {
                    startPage = 1;
                    endPage = totalPages;
                } else {
                    const sideButtons = Math.floor(maxVisibleButtons / 2);
                    if (currentPageJurusan <= sideButtons) {
                        startPage = 1;
                        endPage = maxVisibleButtons;
                    } else if (currentPageJurusan + sideButtons >= totalPages) {
                        startPage = totalPages - maxVisibleButtons + 1;
                        endPage = totalPages;
                    } else {
                        startPage = currentPageJurusan - sideButtons;
                        endPage = currentPageJurusan + sideButtons;
                    }
                }

                paginationButtonsJurusan.appendChild(createPageButtonJurusan(currentPageJurusan > 1 ? currentPageJurusan - 1 : null, 'Previous', currentPageJurusan === 1));

                for (let i = startPage; i <= endPage; i++) {
                    paginationButtonsJurusan.appendChild(createPageButtonJurusan(i, i, false, i === currentPageJurusan));
                }

                paginationButtonsJurusan.appendChild(createPageButtonJurusan(currentPageJurusan < totalPages ? currentPageJurusan + 1 : null, 'Next', currentPageJurusan === totalPages));
            }

            function createPageButtonJurusan(page, text, isDisabled = false, isActive = false) {
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
            async function fetchAllInstrumenDataJurusan() {
                showLoadingStateJurusan();
                try {
                    const response = await fetch('http://127.0.0.1:5000/api/data-instrumen'); // Your API endpoint
                    if (!response.ok) throw new Error('Gagal mengambil data instrumen');
                    const data = await response.json();
                    allInstrumenDataJurusanRaw = data;
                    flattenedInstrumenDataJurusan = flattenInstrumenDataJurusan(data); // Flatten data once
                    currentPageJurusan = 1; // Reset to first page
                    renderInstrumenTable(); // Initial render
                } catch (error) {
                    console.error('Error fetching instrumen data:', error);
                    showErrorStateJurusan('Tidak dapat terhubung ke server instrumen.');
                }
            }

            // === DROPDOWN DATA FETCHING (for filters) ===
            

            

            // === EVENT LISTENERS ===
            perPageSelectJurusan.addEventListener('change', () => {
                perPageJurusan = parseInt(perPageSelectJurusan.value, 10);
                currentPageJurusan = 1; // Reset to first page
                renderInstrumenTable();
            });

            const debouncedSearchJurusan = debounce(() => {
                searchQueryJurusan = searchInputJurusan.value;
                currentPageJurusan = 1; // Reset to first page
                // When search changes, re-filter the already flattened data and re-render
                renderInstrumenTable();
            }, 300);
            searchInputJurusan.addEventListener('input', debouncedSearchJurusan);

            paginationButtonsJurusan.addEventListener('click', (e) => {
                e.preventDefault();
                const target = e.target.closest('a');
                if (target && target.dataset.page) {
                    const page = parseInt(target.dataset.page);
                    if (!isNaN(page) && page !== currentPageJurusan) {
                        currentPageJurusan = page;
                        renderInstrumenTable();
                    }
                }
            });


            // === INITIALIZATION ===
            fetchAllInstrumenDataJurusan();

        });
    </script>
@endsection