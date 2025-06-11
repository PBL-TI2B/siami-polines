@extends('layouts.app')

@section('title', 'Data Instrumen Prodi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditor.audit.index')],
            ['label' => 'Response Instrumen'],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Lihat Response Instrumen
        </h1>

        <!-- Table and Pagination -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
            <!-- Table Controls -->
            <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 rounded-t-2xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <form action="#" method="GET">
                        <select name="per_page" id="per-page-select" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                        </select>
                    </form>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
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
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Standar</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Deskripsi Area Audit-Sub Butir Standar</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pemeriksaan Pada Unsur</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Ketersediaan Standar dan Dokumen (Ada/Tidak)</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pencapaian Standar SPT PT</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pencapaian Standar SN DIKTI</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Lokal</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Nasional</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Internasional</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="instrumen-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span id="pagination-info" class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi" id="pagination-nav">
                        <ul class="inline-flex -space-x-px text-sm">
                            <li>
                                <a href="#" id="prev-page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-l-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">
                                    <x-heroicon-s-chevron-left class="w-4 h-4 mr-1" />
                                </a>
                            </li>
                            <div id="page-numbers" class="inline-flex"></div>
                            <li>
                                <a href="#" id="next-page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">
                                    <x-heroicon-s-chevron-right class="w-4 h-4 ml-1" />
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="flex gap-4 mt-8">
            <x-button id="back-btn" type="button" color="red" icon="heroicon-o-arrow-left">
                Kembali
            </x-button>
            @if (session('status') == 3)
            <x-button id="complete-correction-btn" type="button" color="sky" icon="heroicon-o-check">
                Koreksi Selesai
            </x-button>
            @elseif (session('status') == 8)
            <x-button id="complete-revision-btn" type="button" color="sky" icon="heroicon-o-check">
                Koreksi Revisi Selesai
            </x-button>
            @endif
        </div>
    </div>
    <!-- Modal Konfirmasi -->
    <div id="correctionConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 id="confirmModalTitle" class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100"></h3>
            <p id="confirmModalMessage" class="text-sm text-gray-700 dark:text-gray-300 mb-6"></p>
            <div class="flex justify-end gap-3">
                <button id="cancelLockBtn" type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition-all duration-200">
                    Batal
                </button>
                <button id="confirmLockBtn" type="button" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700 transition-all duration-200">
                    Ya
                </button>
            </div>
        </div>
    </div>
    <!-- Modal Alert -->
    <div id="alertModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 id="alertModalTitle" class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100"></h3>
            <p id="alertModalMessage" class="text-sm text-gray-700 dark:text-gray-300 mb-6"></p>
            <div class="flex justify-end">
                <button id="alertOkBtn" type="button" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700 transition-all duration-200">
                    OK
                </button>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // DOM elements
    const auditingId = {{ session('auditing_id') ?? 'null' }};
    const auditStatus = {{ session('status') ?? 1 }};
    const tableBody = document.getElementById('instrumen-table-body');
    const perPageSelect = document.querySelector('select[name="per_page"]');
    const searchInput = document.getElementById('search-input');
    const paginationInfo = document.getElementById('pagination-info');
    const pageNumbersContainer = document.querySelector('nav[aria-label="Navigasi Paginasi"] ul');
    const backBtn = document.getElementById('back-btn');

    // Pagination and filtering variables
    let instrumenData = [];
    let responseData = [];
    let perPage = parseInt(perPageSelect?.value) || 25;
    let currentPage = 1;
    let searchQuery = '';
    let totalFilteredItems = 0;
    let totalPages = 0;

    // Define standard order for numbering
    const standardOrder = [
        'Visi, Misi, Tujuan, Strategi',
        'Tata kelola, Tata pamong, dan Kerjasama',
        'Mahasiswa',
        'Sumber Daya Manusia',
        'Keuangan, Sarana, dan Prasarana',
        'Pendidikan / Kurikulum dan Pembelajaran',
        'Penelitian',
        'Pengabdian Kepada Masyarakat',
        'Luaran Tridharma'
    ];
    const standardNumberMap = {};
    standardOrder.forEach((nama, index) => {
        standardNumberMap[nama] = index + 1;
    });

    // Debounce utility for search
    function debounce(func, delay) {
        let timeoutId;
        return function (...args) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func.apply(this, args), delay);
        };
    }

    // Helper function to render checklist
    const renderChecklist = (value) => {
        return value === '1' ? `
            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        ` : '-';
    };

    // Initialize and render table
    async function initializeDataAndRenderTable() {
        tableBody.innerHTML = `
            <tr>
                <td colspan="11" class="px-4 py-3 sm:px-6 text-center">
                    <div class="flex flex-col items-center justify-center py-8">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-sky-500"></div>
                        <p class="mt-3 text-gray-700 dark:text-gray-300">Memuat data instrumen...</p>
                    </div>
                </td>
            </tr>`;

        if (!auditingId) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="11" class="px-4 py-3 sm:px-6 text-center text-red-500">
                        ID auditing tidak tersedia. Silakan coba lagi.
                    </td>
                </tr>`;
            return;
        }

        try {
            const [instrumenResult, responseResult] = await Promise.all([
                fetch('http://127.0.0.1:5000/api/set-instrumen').then(res => {
                    if (!res.ok) throw new Error('Gagal mengambil data set-instrumen');
                    return res.json();
                }),
                fetch(`http://127.0.0.1:5000/api/responses/auditing/${auditingId}`).then(res => {
                    if (!res.ok) throw new Error('Gagal mengambil data responses');
                    return res.json();
                }).catch(() => ({ data: [] }))
            ]);

            instrumenData = (instrumenResult.data || []).filter(item => item.jenis_unit_id === 3);
            responseData = responseResult.data || [];
            renderTable(1);
        } catch (error) {
            console.error('Gagal mengambil data instrumen:', error);
            tableBody.innerHTML = `
                <tr>
                    <td colspan="11" class="px-4 py-3 sm:px-6 text-center text-red-500">
                        Gagal memuat data instrumen. Silakan coba lagi.
                    </td>
                </tr>`;
        }
    }

    function renderTable(page = 1) {
        currentPage = parseInt(page) || 1;
        tableBody.innerHTML = '';

        // Filter data based on search query
        let filteredData = instrumenData.filter(item => {
            const searchTerm = searchQuery.toLowerCase();
            const response = responseData.find(res => res.set_instrumen_unit_kerja_id === item.set_instrumen_unit_kerja_id) || {};
            return (
                (item?.unsur?.deskripsi?.kriteria?.nama_kriteria || '').toLowerCase().includes(searchTerm) ||
                (item?.unsur?.deskripsi?.isi_deskripsi || '').toLowerCase().includes(searchTerm) ||
                (item?.unsur?.isi_unsur || '').toLowerCase().includes(searchTerm) ||
                (response?.ketersediaan_standar_dan_dokumen || '').toLowerCase().includes(searchTerm) ||
                (response?.keterangan || '').toLowerCase().includes(searchTerm)
            );
        });

        // Group filtered data and track unique standar
        const grouped = {};
        const flatGroupedData = [];
        const rowspanStandar = {};
        const rowspanDeskripsi = {};
        filteredData.forEach(item => {
            const standar = item?.unsur?.deskripsi?.kriteria?.nama_kriteria || 'Tidak Diketahui';
            const deskripsi = item?.unsur?.deskripsi?.isi_deskripsi || 'Tidak Diketahui';
            const unsur = item?.unsur?.isi_unsur || 'Tidak Diketahui';

            if (!grouped[standar]) {
                grouped[standar] = {};
                rowspanStandar[standar] = 0;
            }
            if (!grouped[standar][deskripsi]) {
                grouped[standar][deskripsi] = {};
                rowspanDeskripsi[`${standar}-${deskripsi}`] = 0;
            }
            if (!grouped[standar][deskripsi][unsur]) {
                grouped[standar][deskripsi][unsur] = [];
            }
            grouped[standar][deskripsi][unsur].push(item);
            flatGroupedData.push({ standar, deskripsi, unsur, item });
            rowspanStandar[standar]++;
            rowspanDeskripsi[`${standar}-${deskripsi}`]++;
        });

        // Pagination calculations
        totalFilteredItems = flatGroupedData.length;
        totalPages = Math.ceil(totalFilteredItems / perPage);
        currentPage = Math.min(currentPage, totalPages) || 1;

        const startIndex = (currentPage - 1) * perPage;
        const endIndex = Math.min(startIndex + perPage, totalFilteredItems);
        const paginatedData = flatGroupedData.slice(startIndex, endIndex);

        // Recalculate rowspan for paginated data
        const paginatedRowspanStandar = {};
        const paginatedRowspanDeskripsi = {};
        paginatedData.forEach(({ standar, deskripsi }) => {
            paginatedRowspanStandar[standar] = (paginatedRowspanStandar[standar] || 0) + 1;
            paginatedRowspanDeskripsi[`${standar}-${deskripsi}`] = (paginatedRowspanDeskripsi[`${standar}-${deskripsi}`] || 0) + 1;
        });

        if (!paginatedData.length) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="11" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        Tidak ada data instrumen tersedia untuk Prodi.
                    </td>
                </tr>`;
            if (paginationInfo) {
                paginationInfo.innerHTML = `
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> hasil
                    </span>`;
            }
            renderPagination();
            return;
        }

        // Create response map for quick lookup
        const responseMap = {};
        responseData.forEach(response => {
            responseMap[response.set_instrumen_unit_kerja_id] = response;
        });

        // Render table rows
        let displayedStandar = new Set();
        let displayedDeskripsi = new Set();
        paginatedData.forEach(({ standar, deskripsi, unsur, item }) => {
            const response = responseMap[item.set_instrumen_unit_kerja_id] || {};
            const row = document.createElement('tr');
            let html = '';

            if (!displayedStandar.has(standar)) {
                const standarNumber = standardNumberMap[standar] || '-';
                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${paginatedRowspanStandar[standar]}">${standarNumber}</td>`;
                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${paginatedRowspanStandar[standar]}">${standar}</td>`;
                displayedStandar.add(standar);
            }

            if (!displayedDeskripsi.has(`${standar}-${deskripsi}`)) {
                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${paginatedRowspanDeskripsi[`${standar}-${deskripsi}`]}">${deskripsi}</td>`;
                displayedDeskripsi.add(`${standar}-${deskripsi}`);
            }

            html += `
                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${unsur}</td>
                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${response.ketersediaan_standar_dan_dokumen || '-'}</td>
                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.spt_pt)}</td>
                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.sn_dikti)}</td>
                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.lokal)}</td>
                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.nasional)}</td>
                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.internasional)}</td>
                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${response.keterangan || '-'}</td>
            `;

            row.innerHTML = html;
            tableBody.appendChild(row);
        });

        // Update pagination info
        const currentStart = totalFilteredItems === 0 ? 0 : startIndex + 1;
        const currentEnd = endIndex;
        if (paginationInfo) {
            paginationInfo.innerHTML = `
                <span class="text-sm text-gray-700 dark:text-gray-300">
                    Menampilkan <strong>${currentStart}</strong> hingga <strong>${currentEnd}</strong> dari <strong>${totalFilteredItems}</strong> hasil
                </span>`;
        }

        renderPagination();
    }

    function renderPagination() {
        pageNumbersContainer.innerHTML = `
            <li>
                <a href="#" id="prev-page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-l-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 ${currentPage === 1 ? 'opacity-50 pointer-events-none' : ''}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            </li>`;

        const pages = [];
        if (totalPages <= 7) {
            for (let i = 1; i <= totalPages; i++) pages.push(i);
        } else {
            pages.push(1, 2);
            if (currentPage > 4) pages.push('...');
            const start = Math.max(3, currentPage - 1);
            const end = Math.min(totalPages - 2, currentPage + 1);
            for (let i = start; i <= end; i++) pages.push(i);
            if (currentPage < totalPages - 3) pages.push('...');
            pages.push(totalPages - 1, totalPages);
        }

        pages.forEach(page => {
            if (page === '...') {
                pageNumbersContainer.innerHTML += `
                    <li>
                        <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700">...</span>
                    </li>`;
            } else {
                pageNumbersContainer.innerHTML += `
                    <li>
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight ${page === currentPage ? 'text-sky-600 bg-sky-50 dark:bg-sky-900 dark:text-sky-200 border-sky-300 dark:border-sky-700' : 'text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700'} border hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200" data-page="${page}">${page}</a>
                    </li>`;
            }
        });

        pageNumbersContainer.innerHTML += `
            <li>
                <a href="#" id="next-page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 ${currentPage === totalPages || totalPages === 0 ? 'opacity-50 pointer-events-none' : ''}">
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </li>`;
    }

    // Event listeners
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function (e) {
            e.preventDefault();
            perPage = parseInt(perPageSelect.value);
            renderTable(1);
        });
    }

    if (searchInput) {
        const debouncedSearch = debounce(function () {
            searchQuery = searchInput.value.trim();
            renderTable(1);
        }, 300);

        searchInput.addEventListener('input', debouncedSearch);

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchQuery = searchInput.value.trim();
                renderTable(1);
            }
        });
    }

    if (pageNumbersContainer) {
        pageNumbersContainer.addEventListener('click', function (e) {
            e.preventDefault();
            const pageLink = e.target.closest('a[data-page]');
            const prevBtn = e.target.closest('#prev-page');
            const nextBtn = e.target.closest('#next-page');
            if (pageLink) {
                renderTable(parseInt(pageLink.getAttribute('data-page')));
            } else if (prevBtn && currentPage > 1) {
                renderTable(currentPage - 1);
            } else if (nextBtn && currentPage < totalPages) {
                renderTable(currentPage + 1);
            }
        });
    }

    if (backBtn) {
        backBtn.addEventListener('click', function () {
            window.history.back();
        });
    }

    // Helper function to show confirmation modal
    function showConfirmModal(title, message, onConfirm) {
        const modal = document.getElementById('correctionConfirmModal');
        const titleElement = document.getElementById('confirmModalTitle');
        const messageElement = document.getElementById('confirmModalMessage');
        const cancelBtn = document.getElementById('cancelLockBtn');
        const confirmBtn = document.getElementById('confirmLockBtn');

        titleElement.textContent = title;
        messageElement.textContent = message;
        modal.classList.remove('hidden');

        const newCancelBtn = cancelBtn.cloneNode(true);
        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
        const newConfirmBtn = confirmBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

        newCancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        newConfirmBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            onConfirm();
        });
    }

    // Helper function to show alert modal
    function showAlertModal(title, message, isSuccess) {
        const modal = document.getElementById('alertModal');
        const titleElement = document.getElementById('alertModalTitle');
        const messageElement = document.getElementById('alertModalMessage');
        const okBtn = document.getElementById('alertOkBtn');

        titleElement.textContent = title;
        messageElement.textContent = message;
        okBtn.classList.toggle('bg-green-600', isSuccess);
        okBtn.classList.toggle('bg-red-600', !isSuccess);
        okBtn.classList.toggle('hover:bg-green-700', isSuccess);
        okBtn.classList.toggle('hover:bg-red-700', !isSuccess);
        modal.classList.remove('hidden');

        const newOkBtn = okBtn.cloneNode(true);
        okBtn.parentNode.replaceChild(newOkBtn, okBtn);

        newOkBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    }

    // Helper function to handle API call and modal feedback
    function handleCompletion(auditingId, status, successMessage, button, successUrl) {
        fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ status })
        })
            .then(response => {
                if (!response.ok) throw new Error('Gagal menyelesaikan proses');
                return response.json();
            })
            .then(result => {
                showAlertModal('Sukses', successMessage, true);
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');
                setTimeout(() => {
                    window.location.href = successUrl;
                }, 1000);
            })
            .catch(error => {
                console.error('Gagal menyelesaikan proses:', error);
                showAlertModal('Error', 'Gagal menyelesaikan proses. Silakan coba lagi.', false);
            });
    }

    // Handle correction and revision buttons
    if (auditStatus === 3) {
        const completeCorrectionBtn = document.getElementById('complete-correction-btn');
        if (completeCorrectionBtn) {
            completeCorrectionBtn.addEventListener('click', function () {
                showConfirmModal(
                    'Konfirmasi Kunci Jawaban',
                    'Apakah Anda yakin sudah mengoreksi seluruh jawaban? Tindakan ini tidak dapat dibatalkan.',
                    () => {
                        handleCompletion(
                            auditingId,
                            4,
                            'Koreksi berhasil diselesaikan!',
                            completeCorrectionBtn,
                            "{{ route('auditor.audit.index') }}"
                        );
                    }
                );
            });
        }
    }

    if (auditStatus === 8) {
        const completeRevisionBtn = document.getElementById('complete-revision-btn');
        if (completeRevisionBtn) {
            completeRevisionBtn.addEventListener('click', function () {
                showConfirmModal(
                    'Konfirmasi Kunci Revisi',
                    'Apakah Anda yakin ingin menyelesaikan koreksi revisi? Tindakan ini tidak dapat dibatalkan.',
                    () => {
                        handleCompletion(
                            auditingId,
                            9,
                            'Koreksi revisi berhasil diselesaikan!',
                            completeRevisionBtn,
                            "{{ route('auditor.audit.index') }}"
                        );
                    }
                );
            });
        }
    }

    // Initialize data
    initializeDataAndRenderTable();
});
</script>
@endsection