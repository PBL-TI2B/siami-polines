@extends('layouts.app')

@section('title', 'Response Daftar Tilik')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditor.audit.index')],
            ['label' => 'Response Daftar Tilik'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Response Daftar Tilik
        </h1>

        <!-- Table and Pagination -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <!-- Table Controls -->
            <div
                class="flex flex-col items-center justify-between gap-4 rounded-t-2xl border-b border-gray-200 bg-white p-4 sm:flex-row dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <form action="#" method="GET">
                        <select name="per_page" id="per-page-select"
                            class="w-18 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
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
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" id="search-input" placeholder="Cari" value=""
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table id="tilik-table" class="min-w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead
                        class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">No
                            </th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Kriteria</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Daftar Pertanyaan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Indikator Kinerja Renstra & LKPS</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Sumber Bukti/Bukti</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Metode Perhitungan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Target</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Realisasi</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Standar Nasional / Polines</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Uraian Isian</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Akar
                                Penyebab (Target tidak tercapai)/ Akar Penunjang (Target tercapai)</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Rencana Perbaikan & Tindak Lanjut</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tilik-table-body">
                        <!-- Baris data akan dimasukkan ke sini -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <span id="pagination-info" class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi" id="pagination-nav">
                        <ul class="inline-flex -space-x-px text-sm">
                            <li>
                                <a href="#" id="prev-page"
                                    class="flex h-8 items-center justify-center rounded-l-lg border border-gray-300 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    <x-heroicon-s-chevron-left class="mr-1 h-4 w-4" />
                                </a>
                            </li>
                            <div id="page-numbers" class="inline-flex"></div>
                            <li>
                                <a href="#" id="next-page"
                                    class="flex h-8 items-center justify-center rounded-r-lg border border-gray-300 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    <x-heroicon-s-chevron-right class="ml-1 h-4 w-4" />
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="mt-8 flex gap-4">
            <x-button id="back-btn" type="button" color="red" icon="heroicon-o-arrow-left">
                Kembali
            </x-button>
            @if (session('status') == 5)
                <x-button id="lock-btn" type="button" color="sky" icon="heroicon-o-lock-closed">
                    Kunci Jawaban
                </x-button>
            @endif
        </div>
    </div>

    <!-- Modal Hapus -->
    <div id="deleteConfirmModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900/50">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Konfirmasi Hapus Response</h3>
            <p class="mb-6 text-sm text-gray-700 dark:text-gray-300">
                Apakah Anda yakin menghapus response daftar tilik? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-3">
                <button id="cancelDeleteBtn" type="button"
                    class="rounded-md bg-gray-300 px-4 py-2 text-gray-800 transition-all duration-200 hover:bg-gray-400">
                    Batal
                </button>
                <button id="confirmDeleteBtn" type="button"
                    class="rounded-md bg-red-600 px-4 py-2 text-white transition-all duration-200 hover:bg-red-700">
                    Ya, Hapus Response
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Kunci -->
    <div id="lockConfirmModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900/50">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">Konfirmasi Kunci Jawaban</h3>
            <p class="mb-6 text-sm text-gray-700 dark:text-gray-300">
                Apakah Anda yakin ingin mengunci jawaban daftar tilik? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-3">
                <button id="cancelLockBtn" type="button"
                    class="rounded-md bg-gray-300 px-4 py-2 text-gray-800 transition-all duration-200 hover:bg-gray-400">
                    Batal
                </button>
                <button id="confirmLockBtn" type="button"
                    class="rounded-md bg-sky-600 px-4 py-2 text-white transition-all duration-200 hover:bg-sky-700">
                    Ya, Kunci Jawaban Daftar Tilik
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Toast -->
    <div id="responseModal" class="fixed end-4 top-4 z-50 hidden bg-transparent transition-opacity duration-300">
        <div class="w-full max-w-md rounded-lg bg-white p-4 shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div id="modalIcon" class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg">
                    <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="sr-only">Ikon Sukses</span>
                </div>
                <div class="ms-3 text-sm font-normal text-gray-500 dark:text-gray-400" id="modalMessage">
                    Action completed successfully.
                </div>
                <button type="button" id="closeResponseModal"
                    class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white"
                    aria-label="Tutup">
                    <span class="sr-only">Tutup</span>
                    <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Pass route to JavaScript -->
    <script>
        window.App = {
            routes: {
                editTilik: '{{ route('auditee.daftar-tilik.edit', ':id') }}',
                createTilik: '{{ route('auditee.daftar-tilik.create', ':id') }}'
            }
        };
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Static mapping for kriteria_id to name
            const kriteriaMap = {
                1: '1. Visi, Misi, Tujuan, Strategi',
                2: '2. Tata kelola, Tata pamong, dan Kerjasama',
                3: '3. Mahasiswa',
                4: '4. Sumber Daya Manusia',
                5: '5. Keuangan, Sarana, dan Prasarana',
                6: '6. Pendidikan / Kurikulum dan Pembelajaran',
                7: '7. Penelitian',
                8: '8. Pengabdian Kepada Masyarakat',
                9: '9. Luaran Tridharma',
            };

            // DOM elements
            const auditingId = {{ $auditingId ?? 'null' }};
            let auditStatus = {{ $status ?? 'null' }};
            const tbody = document.getElementById('tilik-table-body');
            const perPageSelect = document.getElementById('per-page-select');
            const searchInput = document.getElementById('search-input');
            const paginationInfo = document.getElementById('pagination-info');
            const pageNumbersContainer = document.querySelector('#pagination-nav ul');
            const backBtn = document.getElementById('back-btn');
            const deleteModal = document.getElementById('deleteConfirmModal');
            const lockModal = document.getElementById('lockConfirmModal');
            const responseModal = document.getElementById('responseModal');
            const modalIcon = document.getElementById('modalIcon');
            const modalMessage = document.getElementById('modalMessage');
            const closeResponseModal = document.getElementById('closeResponseModal');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const cancelLockBtn = document.getElementById('cancelLockBtn');
            const confirmLockBtn = document.getElementById('confirmLockBtn');

            // Pagination and filtering variables
            let tilikData = [];
            let responseData = [];
            let perPage = parseInt(perPageSelect?.value) || 25;
            let currentPage = 1;
            let searchQuery = '';
            let totalFilteredItems = 0;
            let totalPages = 0;
            let currentResponseTilikId = null;

            // Debounce utility for search
            function debounce(func, delay) {
                let timeoutId;
                return function(...args) {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => func.apply(this, args), delay);
                };
            }

            // Function to show modal
            const showModal = (modal) => {
                modal.classList.remove('hidden');
            };

            // Function to hide modal
            const hideModal = (modal) => {
                modal.classList.add('hidden');
            };

            // Function to show toast modal
            const showToast = (message, isSuccess = true) => {
                modalMessage.textContent = message;
                modalIcon.classList.remove('bg-green-100', 'text-green-500', 'bg-red-100', 'text-red-500');
                modalIcon.innerHTML = isSuccess ?
                    `<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Ikon Sukses</span>` :
                    /NewLine/
                `<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                </svg>
                <span class="sr-only">Ikon Error</span>`;
                modalIcon.classList.add(isSuccess ? 'bg-green-100' : 'bg-red-100', isSuccess ?
                    'text-green-500' : 'text-red-500');
                showModal(responseModal);
                setTimeout(() => hideModal(responseModal), 3000);
            };

            // Escape HTML to prevent XSS
            function escapeHtml(unsafe) {
                return String(unsafe)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // Initialize and render table
            async function initializeDataAndRenderTable() {
                tbody.innerHTML = `
                <tr>
                    <td colspan="13" class="px-4 py-3 sm:px-6 text-center">
                        <div class="flex flex-col items-center justify-center py-8">
                            <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-sky-500"></div>
                            <p class="mt-3 text-gray-700 dark:text-gray-300">Memuat data tilik...</p>
                        </div>
                    </td>
                </tr>`;

                if (!auditingId) {
                    tbody.innerHTML = `
                    <tr>
                        <td colspan="13" class="px-4 py-3 sm:px-6 text-center text-red-500">
                            ID auditing tidak tersedia. Silakan coba lagi.
                        </td>
                    </tr>`;
                    return;
                }

                try {
                    const [tilikResult, responseResult] = await Promise.all([
                        fetch('http://127.0.0.1:5000/api/tilik/all').then(res => {
                            if (!res.ok) throw new Error('Gagal mengambil data tilik');
                            return res.json();
                        }),
                        fetch(`http://127.0.0.1:5000/api/response-tilik/auditing/${auditingId}`).then(
                            res => {
                                if (!res.ok) throw new Error('Gagal mengambil data response-tilik');
                                return res.json();
                            }).catch(() => ({
                            data: []
                        }))
                    ]);

                    tilikData = tilikResult.data || [];
                    responseData = responseResult.data || [];
                    renderTable(1);
                } catch (error) {
                    console.error('Gagal memuat data:', error);
                    tbody.innerHTML = `
                    <tr>
                        <td colspan="13" class="px-4 py-3 sm:px-6 text-center text-red-500">
                            Gagal memuat data tilik. Silakan coba lagi.
                        </td>
                    </tr>`;
                }
            }

            function renderTable(page = 1) {
                currentPage = parseInt(page) || 1;
                tbody.innerHTML = '';

                // Filter data based on search query
                let filteredData = tilikData.filter(item => {
                    const searchTerm = searchQuery.toLowerCase();
                    const response = responseData.find(res => res.tilik_id === item.tilik_id) || {};
                    const kriteriaName = kriteriaMap[item.kriteria_id] || item.kriteria_id || '';
                    return (
                        kriteriaName.toLowerCase().includes(searchTerm) ||
                        (item.pertanyaan || '').toLowerCase().includes(searchTerm) ||
                        (item.indikator || '').toLowerCase().includes(searchTerm) ||
                        (item.sumber_data || '').toLowerCase().includes(searchTerm) ||
                        (item.metode_perhitungan || '').toLowerCase().includes(searchTerm) ||
                        (item.target || '').toLowerCase().includes(searchTerm) ||
                        (response.realisasi || '').toLowerCase().includes(searchTerm) ||
                        (response.standar_nasional || '').toLowerCase().includes(searchTerm) ||
                        (response.uraian_isian || '').toLowerCase().includes(searchTerm) ||
                        (response.akar_penyebab_penunjang || '').toLowerCase().includes(searchTerm) ||
                        (response.rencana_perbaikan_tindak_lanjut || '').toLowerCase().includes(
                            searchTerm)
                    );
                });

                // Pagination calculations
                totalFilteredItems = filteredData.length;
                totalPages = Math.ceil(totalFilteredItems / perPage);
                currentPage = Math.min(currentPage, totalPages) || 1;

                const startIndex = (currentPage - 1) * perPage;
                const endIndex = Math.min(startIndex + perPage, totalFilteredItems);
                const paginatedData = filteredData.slice(startIndex, endIndex);

                if (!paginatedData.length) {
                    tbody.innerHTML = `
                    <tr>
                        <td colspan="13" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada data tilik tersedia.
                        </td>
                    </tr>`;
                    paginationInfo.innerHTML = `
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> hasil
                    </span>`;
                    renderPagination();
                    return;
                }

                // Create response map for quick lookup
                const responseMap = {};
                responseData.forEach(response => {
                    responseMap[response.tilik_id] = {
                        response_tilik_id: response.response_tilik_id,
                        realisasi: response.realisasi ?? '-',
                        standar_nasional: response.standar_nasional ?? '-',
                        uraian_isian: response.uraian_isian ?? '-',
                        akar_penyebab_penunjang: response.akar_penyebab_penunjang ?? '-',
                        rencana_perbaikan_tindak_lanjut: response.rencana_perbaikan_tindak_lanjut ?? '-'
                    };
                });

                // Render table rows
                paginatedData.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.className = "transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700";
                    const kriteriaName = kriteriaMap[item.kriteria_id] || item.kriteria_id || '-';
                    const response = responseMap[item.tilik_id] || {
                        response_tilik_id: null,
                        realisasi: '-',
                        standar_nasional: '-',
                        uraian_isian: '-',
                        akar_penyebab_penunjang: '-',
                        rencana_perbaikan_tindak_lanjut: '-'
                    };

                    row.innerHTML = `
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${startIndex + index + 1}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${escapeHtml(kriteriaName)}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${escapeHtml(item.pertanyaan || '-')}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${escapeHtml(item.indikator || '-')}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${escapeHtml(item.sumber_data || '-')}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${escapeHtml(item.metode_perhitungan || '-')}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${escapeHtml(item.target || '-')}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${escapeHtml(response.realisasi)}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${escapeHtml(response.standar_nasional)}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${escapeHtml(response.uraian_isian)}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${escapeHtml(response.akar_penyebab_penunjang)}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${escapeHtml(response.rencana_perbaikan_tindak_lanjut)}</td>
                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">
                        ${auditStatus !== 5 ? `
                                <span class="text-gray-500 dark:text-gray-400">Jawaban dikunci</span>
                            ` : `
                                <div class="flex items-center gap-2 justify-center">
                                    ${response.realisasi !== '-' ? `
                                    <a href="/auditee/audit/daftar-tilik/${response.response_tilik_id}/edit" title="Edit Jawaban" class="text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M14 4a2.5 2.5 0 113.536 3.536L6.5 21H3v-3.5L14 4z"/>
                                        </svg>
                                    </a>
                                    <button data-id="${response.response_tilik_id}" class="delete-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5-4h4m-4 0a2 2 0 00-2 2v1h8V5a2 2 0 00-2-2z"/>
                                        </svg>
                                    </button>
                                ` : `
                                    <a href="/auditee/audit/daftar-tilik/${item.tilik_id}/create" title="Tambah Jawaban" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </a>
                                `}
                                </div>
                            `}
                    </td>
                `;
                    tbody.appendChild(row);
                });

                // Update pagination info
                const currentStart = totalFilteredItems === 0 ? 0 : startIndex + 1;
                const currentEnd = endIndex;
                paginationInfo.innerHTML = `
                <span class="text-sm text-gray-700 dark:text-gray-300">
                    Menampilkan <strong>${currentStart}</strong> hingga <strong>${currentEnd}</strong> dari <strong>${totalFilteredItems}</strong> hasil
                </span>`;

                renderPagination();

                // Add event listeners for delete buttons
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        currentResponseTilikId = this.getAttribute('data-id');
                        showModal(deleteModal);
                    });
                });
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
                perPageSelect.addEventListener('change', function(e) {
                    e.preventDefault();
                    perPage = parseInt(perPageSelect.value);
                    renderTable(1);
                });
            }

            if (searchInput) {
                const debouncedSearch = debounce(function() {
                    searchQuery = searchInput.value.trim();
                    renderTable(1);
                }, 300);

                searchInput.addEventListener('input', debouncedSearch);

                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchQuery = searchInput.value.trim();
                        renderTable(1);
                    }
                });
            }

            if (pageNumbersContainer) {
                pageNumbersContainer.addEventListener('click', function(e) {
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
                backBtn.addEventListener('click', function() {
                    window.history.back();
                });
            }

            // Handle delete modal actions
            cancelDeleteBtn.addEventListener('click', () => {
                hideModal(deleteModal);
                currentResponseTilikId = null;
            });

            confirmDeleteBtn.addEventListener('click', () => {
                if (currentResponseTilikId) {
                    fetch(`http://127.0.0.1:5000/api/response-tilik/${currentResponseTilikId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(response => response.json())
                        .then(result => {
                            hideModal(deleteModal);
                            if (result.success) {
                                showToast('Hapus response berhasil', true);
                                initializeDataAndRenderTable(); // Refresh table
                            } else {
                                showToast('Gagal menghapus response: ' + (result.message ||
                                    'Unknown error'), false);
                            }
                            currentResponseTilikId = null;
                        })
                        .catch(error => {
                            console.error('Error deleting response:', error);
                            hideModal(deleteModal);
                            showToast('Gagal menghapus response.', false);
                            currentResponseTilikId = null;
                        });
                }
            });

            // Handle lock modal actions
            const lockBtn = document.getElementById('lock-btn');
            if (lockBtn && auditingId && auditingId !== 'null') {
                lockBtn.addEventListener('click', function() {
                    showModal(lockModal);
                });

                cancelLockBtn.addEventListener('click', () => {
                    hideModal(lockModal);
                });

                confirmLockBtn.addEventListener('click', () => {
                    lockBtn.disabled = true;
                    fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                status: '6'
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                            return response.json();
                        })
                        .then(result => {
                            hideModal(lockModal);
                            if (result.success || result.message ===
                                'Data auditing berhasil diperbarui') {
                                showToast('Jawaban berhasil dikunci', true);
                                lockBtn.disabled = true;
                                auditStatus = 6;
                                initializeDataAndRenderTable(); // Refresh table
                                setTimeout(() => {
                                    window.location.href = "{{ route('auditee.audit.index') }}";
                                }, 3000);
                            } else {
                                lockBtn.disabled = false;
                                showToast('Gagal mengunci jawaban: ' + (result.message ||
                                    'Unknown error'), false);
                            }
                        })
                        .catch(error => {
                            console.error('Error locking responses:', error);
                            hideModal(lockModal);
                            lockBtn.disabled = false;
                            showToast('Gagal mengunci jawaban.', false);
                        });
                });
            }

            // Close toast modal
            closeResponseModal.addEventListener('click', () => {
                hideModal(responseModal);
            });

            // Initialize data
            initializeDataAndRenderTable();
        });
    </script>
@endsection
