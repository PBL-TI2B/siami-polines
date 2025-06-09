@extends('layouts.app')

@section('title', 'Daftar Tilik')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('kepala-pmpp.dashboard.index')],
            ['label' => 'Daftar Tilik', 'url' => route('kepala-pmpp.daftar-tilik.index')],
        ]" />

        <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Daftar Tilik
        </h1>

        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div
                class="flex flex-col items-center justify-between gap-4 rounded-t-2xl border-b border-gray-200 bg-white p-4 sm:flex-row dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <select name="per_page" id="per-page-select" class="w-18 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                </div>
                <div class="relative w-full sm:w-auto">
                    <form id="search-form" method="GET" onsubmit="return false;">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" id="search-input" placeholder="Cari..."
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">No</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Kriteria</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Daftar Pertanyaan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Indikator Kinerja Renstra & LKPS</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Sumber Bukti/Bukti</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Metode Perhitungan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Target</th>
                        </tr>
                    </thead>
                    <tbody id="tilik-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Rows will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <span id="pagination-info" class="text-sm text-gray-700 dark:text-gray-300"></span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul id="pagination-buttons" class="inline-flex -space-x-px text-sm"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // === KONFIGURASI & VARIABEL ===
    const kriteriaMap = {
        1: '1. Visi, Misi, Tujuan, Strategi',
        2: '2. Tata Kelola, Tata Pamong, dan Kerjasama',
        3: '3. Kurikulum dan Pembelajaran',
        4: '4. Penelitian',
        5: '5. Luaran Tridharma',
    };

    // === DOM ELEMENTS ===
    const tbody = document.getElementById('tilik-table-body');
    const perPageSelect = document.getElementById('per-page-select');
    const searchInput = document.getElementById('search-input');
    const paginationInfo = document.getElementById('pagination-info');
    const paginationButtons = document.getElementById('pagination-buttons');

    // === STATE VARIABLES ===
    let allTilikData = [];
    let perPage = parseInt(perPageSelect.value) || 10;
    let currentPage = 1;
    let searchQuery = '';

    // === FUNGSI-FUNGSI ===

    function debounce(func, delay) {
        let timeoutId;
        return function (...args) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func.apply(this, args), delay);
        };
    }

    async function initializeData() {
        showLoadingState();
        try {
            // PASTIKAN PORT DAN ENDPOINT BENAR (misal: 8000 dan /api/tilik/all)
            const response = await fetch('http://127.0.0.1:5000/api/tilik/all');
            if (!response.ok) throw new Error('Network response was not ok.');
            
            const result = await response.json();
            if (result.success) {
                allTilikData = result.data || [];
                renderTable();
            } else {
                showErrorState(result.message || 'Gagal memuat data.');
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            showErrorState('Tidak dapat terhubung ke server.');
        }
    }

    function renderTable() {
        const filteredData = searchQuery.length > 1
            ? allTilikData.filter(item => {
                const searchTerm = searchQuery.toLowerCase();
                const kriteriaName = kriteriaMap[item.kriteria_id] || '';
                
                return (
                    kriteriaName.toLowerCase().includes(searchTerm) ||
                    (item.pertanyaan || '').toLowerCase().includes(searchTerm) ||
                    (item.indikator || '').toLowerCase().includes(searchTerm) ||
                    (item.sumber_data || '').toLowerCase().includes(searchTerm) ||
                    (item.metode_perhitungan || '').toLowerCase().includes(searchTerm) ||
                    (item.target || '').toLowerCase().includes(searchTerm)
                );
            })
            : allTilikData;

        const totalFilteredItems = filteredData.length;
        const totalPages = Math.ceil(totalFilteredItems / perPage);
        currentPage = Math.min(currentPage, totalPages) || 1;

        const startIndex = (currentPage - 1) * perPage;
        const paginatedData = filteredData.slice(startIndex, startIndex + perPage);

        tbody.innerHTML = '';
        if (paginatedData.length === 0) {
            showEmptyState();
        } else {
            paginatedData.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = "transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700";
                const kriteriaName = kriteriaMap[item.kriteria_id] || item.kriteria_id;
                const nomorUrut = startIndex + index + 1;

                row.innerHTML = `
                    <td class="px-4 py-3 sm:px-6">${nomorUrut}</td>
                    <td class="px-4 py-3 sm:px-6">${kriteriaName}</td>
                    <td class="px-4 py-3 sm:px-6">${item.pertanyaan}</td>
                    <td class="px-4 py-3 sm:px-6">${item.indikator ?? '-'}</td>
                    <td class="px-4 py-3 sm:px-6">${item.sumber_data ?? '-'}</td>
                    <td class="px-4 py-3 sm:px-6">${item.metode_perhitungan ?? '-'}</td>
                    <td class="px-4 py-3 sm:px-6">${item.target ?? '-'}</td>
                `;
                tbody.appendChild(row);
            });
        }

        renderPaginationInfo(startIndex, totalFilteredItems);
        renderPaginationButtons(totalPages);
    }

    function renderPaginationInfo(startIndex, totalFilteredItems) {
        const startItem = totalFilteredItems > 0 ? startIndex + 1 : 0;
        const endItem = Math.min(startIndex + perPage, totalFilteredItems);
        paginationInfo.innerHTML = `Menampilkan <strong>${startItem}</strong> hingga <strong>${endItem}</strong> dari <strong>${totalFilteredItems}</strong> hasil`;
    }

    // ===================================================================
    // === FUNGSI PAGINASI YANG DIPERBARUI ADA DI SINI ===
    // ===================================================================
    function renderPaginationButtons(totalPages) {
        paginationButtons.innerHTML = '';
        if (totalPages <= 1) return;

        const maxVisibleButtons = 5; // Jumlah maksimal tombol nomor halaman yang ditampilkan
        let startPage;
        let endPage;

        if (totalPages <= maxVisibleButtons) {
            // Jika total halaman lebih sedikit atau sama dengan maks, tampilkan semua
            startPage = 1;
            endPage = totalPages;
        } else {
            // Jika total halaman lebih banyak, hitung rentang
            const sideButtons = Math.floor(maxVisibleButtons / 2);
            if (currentPage <= sideButtons) {
                // Kasus: Dekat awal (e.g., current: 1, 2)
                startPage = 1;
                endPage = maxVisibleButtons;
            } else if (currentPage + sideButtons >= totalPages) {
                // Kasus: Dekat akhir (e.g., current: 9, 10 dari 10)
                startPage = totalPages - maxVisibleButtons + 1;
                endPage = totalPages;
            } else {
                // Kasus: Di tengah
                startPage = currentPage - sideButtons;
                endPage = currentPage + sideButtons;
            }
        }

        // Tombol Previous
        paginationButtons.appendChild(createPageButton(currentPage > 1 ? currentPage - 1 : null, 'Previous', currentPage === 1));
        
        // Tombol Nomor Halaman berdasarkan rentang yang dihitung
        for (let i = startPage; i <= endPage; i++) {
            paginationButtons.appendChild(createPageButton(i, i, false, i === currentPage));
        }

        // Tombol Next
        paginationButtons.appendChild(createPageButton(currentPage < totalPages ? currentPage + 1 : null, 'Next', currentPage === totalPages));
    }
    
    function createPageButton(page, text, isDisabled = false, isActive = false) {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = '#';
        a.dataset.page = page;
        
        // Menggunakan textContent agar aman dari injeksi HTML
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
    
    function showLoadingState() {
        tbody.innerHTML = `<tr><td colspan="7" class="text-center p-4"><div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-sky-500 mx-auto"></div><p class="mt-2">Memuat data...</p></td></tr>`;
    }

    function showEmptyState() {
        tbody.innerHTML = `<tr><td colspan="7" class="text-center p-4 text-gray-500">Data tidak ditemukan.</td></tr>`;
    }
    
    function showErrorState(message) {
        tbody.innerHTML = `<tr><td colspan="7" class="text-center p-4 text-red-500">${message}</td></tr>`;
    }

    // === EVENT LISTENERS ===
    perPageSelect.addEventListener('change', () => {
        perPage = parseInt(perPageSelect.value);
        currentPage = 1;
        renderTable();
    });

    const debouncedSearch = debounce(() => {
        searchQuery = searchInput.value;
        currentPage = 1;
        renderTable();
    }, 300);
    searchInput.addEventListener('input', debouncedSearch);

    paginationButtons.addEventListener('click', (e) => {
        e.preventDefault();
        const target = e.target.closest('a');
        if (target && target.dataset.page) {
            const page = parseInt(target.dataset.page);
            if (!isNaN(page) && page !== currentPage) {
                currentPage = page;
                renderTable();
            }
        }
    });

    // === INISIALISASI ===
    initializeData();
});
</script>
@endsection