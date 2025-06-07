@extends('layouts.app')

@section('title', 'Data Instrumen Prodi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            ['label' => 'Response Instrumen'],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Response Instrumen Prodi
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
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Aksi</th>
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
            <x-button id="submit-lock-btn" type="submit" color="sky" icon="heroicon-o-plus">
                Submit dan Kunci Jawaban
            </x-button>
        </div>
    </div>

    <!-- Modal Tambah Response -->
    <div id="tambahResponseModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <button id="closeTambahResponseModal" type="button" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 text-2xl font-bold">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Form Response</h2>

            <form id="modalInstrumenForm">
                @csrf
                <input type="hidden" name="auditing_id" value="{{ session('auditing_id') }}">
                <input type="hidden" name="set_instrumen_unit_kerja_id" id="modal_set_instrumen_unit_kerja_id">
                <input type="hidden" name="response_id" id="modal_response_id">

                <!-- Ketersediaan -->
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ketersediaan Standar dan Dokumen</span>
                    <label class="inline-flex items-center mt-1">
                        <input type="radio" name="ketersediaan_standar_dan_dokumen" value="Ada" class="form-radio text-sky-600">
                        <span class="ml-2 dark:text-gray-300">Ada</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" name="ketersediaan_standar_dan_dokumen" value="Tidak" class="form-radio text-red-600">
                        <span class="ml-2 dark:text-gray-300">Tidak</span>
                    </label>
                </div>

                <!-- Aspek -->
                @php
                    $aspects = [
                        'spt_pt' => 'Pencapaian Standar SPT PT',
                        'sn_dikti' => 'Pencapaian Standar SN DIKTI',
                        'lokal' => 'Daya Saing Lokal',
                        'nasional' => 'Daya Saing Nasional',
                        'internasional' => 'Daya Saing Internasional'
                    ];
                @endphp
                @foreach ($aspects as $name => $label)
                    <div class="mb-4">
                        <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                        <label class="inline-flex items-center mt-1">
                            <input type="radio" name="{{ $name }}" value="1" class="form-radio text-sky-600">
                            <span class="ml-2 dark:text-gray-300">Ada</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" name="{{ $name }}" value="0" class="form-radio text-red-600">
                            <span class="ml-2 dark:text-gray-300">Tidak</span>
                        </label>
                    </div>
                @endforeach

                <!-- Keterangan -->
                <div class="mb-4">
                    <label for="modal_keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                    <textarea name="keterangan" id="modal_keterangan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600" placeholder="Masukkan Keterangan..."></textarea>
                </div>

                <!-- Tombol -->
                <div class="mt-3 flex gap-3">
                    <button type="submit" class="bg-sky-600 text-white px-4 py-2 rounded hover:bg-sky-700">Simpan</button>
                    <button type="button" id="clearModalForm" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Clear</button>
                    <button type="button" id="closeModalBtn" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Batal</button>
                </div>

                <div id="modalResponseMessage" class="mt-4 hidden text-sm"></div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Kunci -->
    <div id="lockConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Konfirmasi Kunci Jawaban</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-6">
                Apakah Anda yakin ingin mengunci jawaban? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-3">
                <button id="cancelLockBtn" type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition-all duration-200">
                    Batal
                </button>
                <button id="confirmLockBtn" type="button" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700 transition-all duration-200">
                    Ya, Kunci Jawaban
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Notifikasi -->
    <div id="notifModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 id="notifTitle" class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100"></h3>
            <p id="notifMessage" class="text-sm text-gray-700 dark:text-gray-300 mb-6"></p>
            <div class="flex justify-end">
                <button id="closeNotifBtn" type="button" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700 transition-all duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- modal toast --}}
    <div id="responseModal" class="hidden fixed top-4 end-4 z-50 bg-transparent transition-opacity duration-300">
        <div class="w-full max-w-md p-4 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200" id="modalIcon">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="sr-only">Ikon Sukses</span>
                </div>
                <div class="ms-3 text-sm font-normal text-gray-500 dark:text-gray-400" id="modalMessage">
                    Action completed successfully.
                </div>
                <button type="button" id="closeResponseModal" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Tutup">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div id="deleteConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Konfirmasi Hapus Response</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-6">
                Apakah Anda yakin menghapus response? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-3">
                <button id="cancelDeleteBtn" type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition-all duration-200">
                    Batal
                </button>
                <button id="confirmDeleteBtn" type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-sky-700 transition-all duration-200">
                    Ya, Hapus Response
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const auditingId = {{ session('auditing_id') ?? 'null' }};
            const auditStatus = {{ session('status') ?? 1 }};

            // DOM elements
            const tableBody = document.getElementById('instrumen-table-body');
            const perPageSelect = document.querySelector('select[name="per_page"]');
            const searchForm = document.getElementById('search-form');
            const searchInput = document.getElementById('search-input');
            const paginationInfo = document.getElementById('pagination-info');
            const pageNumbersContainer = document.querySelector('nav[aria-label="Navigasi Paginasi"] ul');
            const submitLockBtn = document.getElementById('submit-lock-btn');
            const backBtn = document.getElementById('back-btn');
            const lockConfirmModal = document.getElementById('lockConfirmModal');
            const notifModal = document.getElementById('notifModal');
            const notifTitle = document.getElementById('notifTitle');
            const notifMessage = document.getElementById('notifMessage');
            const closeNotifBtn = document.getElementById('closeNotifBtn');
            const cancelLockBtn = document.getElementById('cancelLockBtn');
            const confirmLockBtn = document.getElementById('confirmLockBtn');
            const tambahResponseModal = document.getElementById('tambahResponseModal');
            const closeTambahResponseModal = document.getElementById('closeTambahResponseModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const clearModalForm = document.getElementById('clearModalForm');
            const form = document.getElementById('modalInstrumenForm');
            const messageDiv = document.getElementById('modalResponseMessage');
            const responseModal = document.getElementById('responseModal');
            const modalIcon = document.getElementById('modalIcon');
            const modalMessage = document.getElementById('modalMessage');
            const closeResponseModal = document.getElementById('closeResponseModal');
            const deleteConfirmModal = document.getElementById('deleteConfirmModal');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            // Pagination and filtering variables
            let instrumenData = [];
            let responseData = [];
            let perPage = parseInt(perPageSelect?.value) || 25;
            let currentPage = 1;
            let searchQuery = '';
            let totalFilteredItems = 0;
            let totalPages = 0;

            // Define the fixed standard order
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

            // Create a mapping of nama_kriteria to number (1-based index)
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

            // Modal handling
            const showModal = modal => modal.classList.remove('hidden');
            const hideModal = modal => modal.classList.add('hidden');

            const showResponseModal = (message, type = 'success') => {
                modalMessage.textContent = message;
                modalIcon.className = `inline-flex items-center justify-center shrink-0 w-8 h-8 ${type === 'success' ? 'text-green-600 bg-green-100 dark:bg-green-800 dark:text-green-200' : 'text-red-600 bg-red-100 dark:bg-red-800 dark:text-red-200'} rounded-lg`;
                modalIcon.innerHTML = type === 'success' ?
                    `<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="sr-only">Ikon Sukses</span>` :
                    `<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                    </svg>
                    <span class="sr-only">Ikon Error</span>`;
                showModal(responseModal);
                setTimeout(() => hideModal(responseModal), 2000);
            };

            const showNotif = (title, message) => {
                notifTitle.textContent = title;
                notifMessage.textContent = message;
                showModal(notifModal);
            };

            // Render checklist icons
            function renderChecklist(value) {
                if (value === '1') {
                    return `<svg class="w-5 h-5 text-green-600 dark:text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>`;
                } else if (value === '0') {
                    return `<svg class="w-5 h-5 text-red-600 dark:text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>`;
                }
                return '-';
            }

            // Initialize and render table
            async function initializeDataAndRenderTable() {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="9" class="px-4 py-3 sm:px-6 text-center">
                            <div class="flex flex-col items-center justify-center py-8">
                                <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-sky-500"></div>
                                <p class="mt-3 text-gray-700 dark:text-gray-300">Memuat data instrumen...</p>
                            </div>
                        </td>
                    </tr>`;

                if (!auditingId) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="12" cols="px-4 py-3 sm:px-6 text-center text-center text-red-600">
                                <span class="text-red-500 dark:text-red-400">ID auditing tidak tersedia. Silakan coba lagi.</span>
                            </td>
                        </tr>`;
                    return;
                }

                try {
                    const [instrumenResult, responseResult] = await Promise.all([
                        fetch('http://127.0.0.1:5000/api/set-instrumen').then(res => {
                            if (!res.ok) throw new Error('Gagal mengambil data set-instrumen.');
                            return res.json();
                        }),
                        fetch(`http://127.0.0.1:5000/api/responses/auditing/${auditingId}`).then(res => {
                            if (!res.ok) throw new Error('Gagal mengambil data responses.');
                            return res.json();
                        }).catch(() => ({ data: [] }))
                    ]);

                    instrumenData = (instrumenResult?.data || []).filter(item => item.jenis_unit_id === 3);
                    responseData = responseResult?.data || [];
                    renderTable(1);
                } catch (err) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="12" class="px-4 py-4 sm:px-6 text-center text-red-600">
                                <span class="text-red-500 dark:text-red-400">Gagal memuat data: ${err.message}</span>
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
                    const response = responseData.find(res => res.set_instrumen_unit_kerja_id === item.set_data_id) || {};
                    return (
                        (item?.unsur?.deskripsi?.kriteria?.nama_kriteria || '').toLowerCase().includes(searchTerm) ||
                        (item?.unsur?.deskripsi?.isi_deskripsi || '').toLowerCase().includes(searchTerm) ||
                        (item?.unsur?.isi_unsur || '').toLowerCase().includes(searchTerm) ||
                        (response?.ketersediaan_standar_dan_dokumen || '').toLowerCase().includes(searchTerm) ||
                        (response?.keterangan || '').toLowerCase().includes(searchTerm)
                    );
                });

                // Group data and track unique standar
                const grouped = {};
                const flatGroupedData = [];
                const uniqueStandar = new Set();
                filteredData.forEach(item => {
                    const standar = item?.unsur?.deskripsi?.kriteria?.nama_kriteria || 'Tidak Diketahui';
                    const deskripsi = item?.unsur?.deskripsi?.isi_deskripsi || '';
                    const unsur = item?.unsur?.isi_unsur || 'Tidak Diketahui';

                    if (!grouped[standar]) grouped[standar] = {};
                    if (!grouped[standar][deskripsi]) grouped[standar][deskripsi] = {};
                    if (!grouped[standar][deskripsi][unsur]) grouped[standar][deskripsi][unsur] = [];
                    grouped[standar][deskripsi][unsur].push(item);
                    flatGroupedData.push({ standar, deskripsi, unsur, item });
                    uniqueStandar.add(standar);
                });

                // Pagination calculations
                totalFilteredItems = flatGroupedData.length;
                totalPages = Math.ceil(totalFilteredItems / perPage);
                currentPage = Math.min(currentPage, totalPages) || 1;

                const startIndex = (currentPage - 1) * perPage;
                const endIndex = Math.min(startIndex + perPage, totalFilteredItems);
                const paginatedData = flatGroupedData.slice(startIndex, endIndex);

                // Calculate rowspan for paginated data
                const rowspanStandar = {};
                const rowspanDeskripsi = {};
                paginatedData.forEach(({ standar, deskripsi }) => {
                    rowspanStandar[standar] = (rowspanStandar[standar] || 0) + 1;
                    rowspanDeskripsi[`${standar}-${deskripsi}`] = (rowspanDeskripsi[`${standar}-${deskripsi}`] || 0) + 1;
                });

                if (!paginatedData.length) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="12" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data instrumen tersedia untuk Prodi.
                            </td>
                        </tr>`;
                    if (paginationInfo) {
                        paginationInfo.innerHTML = `
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> hasil
                            </span>`;
                    }
                    return;
                }

                let displayedStandar = new Set();
                let displayedDeskripsi = new Set();

                paginatedData.forEach(({ standar, deskripsi, unsur, item }) => {
                    const response = responseData.find(res => res.set_instrumen_unit_kerja_id === item.set_instrumen_unit_kerja_id) || {};
                    const row = document.createElement('tr');
                    let html = '';

                    if (!displayedStandar.has(standar)) {
                        const standarNumber = standardNumberMap[standar] || '-';
                        html += `<td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${rowspanStandar[standar]}">${standarNumber}</td>`;
                        html += `<td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${rowspanStandar[standar]}">${standar}</td>`;
                        displayedStandar.add(standar);
                    }

                    if (!displayedDeskripsi.has(`${standar}-${deskripsi}`)) {
                        html += `<td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${rowspanDeskripsi[`${standar}-${deskripsi}`]}">${deskripsi}</td>`;
                        displayedDeskripsi.add(`${standar}-${deskripsi}`);
                    }

                    html += `
                        <td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600">${unsur}</td>
                        <td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600">${response.ketersediaan_standar_dan_dokumen || '-'}</td>
                        <td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.spt_pt)}</td>
                        <td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.sn_dikti)}</td>
                        <td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.lokal)}</td>
                        <td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.nasional)}</td>
                        <td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.internasional)}</td>
                        <td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600">${response.keterangan || '-'}</td>
                        <td class="px-6 py-4 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">
                            ${!(auditStatus == 1 || auditStatus == 8) ?
                                `<span class="text-gray-500 dark:text-gray-400">Jawaban Terkunci</span>` :
                                `<div class="flex items-center gap-2 justify-center">
                                    ${response.response_id ?
                                        `<button type="button" class="edit-response-btn text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-200" data-id="${response.response_id}" data-set-id="${item.set_instrumen_unit_kerja_id}" title="Edit Response">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M14 4a2.5 2.5 0 113.536 3.536L6.5 21H3v-3.5L14 4z"/>
                                            </svg>
                                        </button>
                                        <button data-id="${response.response_id}" class="delete-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5-4h4m-4 0a2 2 0 00-2 2v1h8V5a2 2 0 00-2-2z"/>
                                            </svg>
                                        </button>` :
                                        `<button type="button" class="tambah-response-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200" data-set-id="${item.set_instrumen_unit_kerja_id}" title="Tambah Response">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </button>`
                                    }
                                </div>`
                            }
                        </td>`;

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

                // Render pagination links
                pageNumbersContainer.innerHTML = `
                    <li>
                        <a href="#" id="prev-page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-l-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 ${currentPage === 1 ? 'opacity-50 pointer-events-none' : ''}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    </li>`;

                // Condensed pagination
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

            closeResponseModal.addEventListener('click', () => hideModal(responseModal));
            closeNotifBtn.addEventListener('click', () => hideModal(notifModal));
            cancelLockBtn.addEventListener('click', () => hideModal(lockConfirmModal));
            closeTambahResponseModal.addEventListener('click', () => hideModal(tambahResponseModal));
            closeModalBtn.addEventListener('click', () => hideModal(tambahResponseModal));
            clearModalForm.addEventListener('click', () => {
                form.reset();
                messageDiv.classList.add('hidden');
            });

            let lockAction = null;
            if (submitLockBtn) {
                if (auditStatus != 1 && auditStatus != 8) {
                    submitLockBtn.disabled = true;
                    submitLockBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    submitLockBtn.addEventListener('click', e => {
                        e.preventDefault();
                        showModal(lockConfirmModal);
                        lockAction = () => {
                            const totalInstrumen = instrumenData.length;
                            const totalResponse = responseData.length;

                            if (totalResponse < totalInstrumen) {
                                showResponseModal('Anda harus mengisi semua data instrumen response sebelum mengunci jawaban.', 'error');
                                return;
                            }

                            const newStatus = auditStatus === 1 ? 2 : (auditStatus === 8 ? 9 : null);
                            if (newStatus === null) {
                                showResponseModal('Status audit tidak valid untuk dikunci.', 'error');
                                return;
                            }

                            fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                                method: 'PUT',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ status: newStatus })
                            })
                                .then(response => {
                                    if (!response.ok) throw new Error('Gagal mengunci jawaban');
                                    return response.json();
                                })
                                .then(result => {
                                    tableBody.querySelectorAll('tr').forEach(row => {
                                        const actionCell = row.lastElementChild;
                                        actionCell.innerHTML = `<span class="text-gray-500 dark:text-gray-400">Jawaban Terkunci</span>`;
                                        actionCell.classList.add('text-center');
                                    });
                                    submitLockBtn.disabled = true;
                                    submitLockBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                    showResponseModal('Jawaban berhasil dikunci!', 'success');
                                    window.location.href = "{{ route('auditee.audit.index') }}";
                                })
                                .catch(error => {
                                    showResponseModal('Gagal mengunci jawaban. Silakan coba lagi.', 'error');
                                });
                        };
                    });
                    confirmLockBtn.addEventListener('click', () => {
                        hideModal(lockConfirmModal);
                        if (typeof lockAction === 'function') lockAction();
                    });
                }
            }

            let deleteAction = null;
            tableBody.addEventListener('click', e => {
                const deleteBtn = e.target.closest('.delete-btn');
                const addBtn = e.target.closest('.tambah-response-btn');
                const editBtn = e.target.closest('.edit-response-btn');

                if (deleteBtn) {
                    e.preventDefault();
                    const responseId = deleteBtn.getAttribute('data-id');
                    showModal(deleteConfirmModal);
                    deleteAction = () => {
                        fetch(`http://127.0.0.1:5000/api/responses/${responseId}`, {
                            method: 'DELETE',
                            headers: { 'Content-Type': 'application/json' }
                        })
                            .then(response => {
                                if (!response.ok) throw new Error('Gagal menghapus response');
                                return response.json();
                            })
                            .then(result => {
                                hideModal(deleteConfirmModal);
                                showResponseModal('Response berhasil dihapus!', 'success');
                                setTimeout(() => initializeDataAndRenderTable(), 2000);
                            })
                            .catch(error => {
                                hideModal(deleteConfirmModal);
                                showResponseModal(`Gagal menghapus response: ${error.message}`, 'error');
                            });
                    };
                }

                if (addBtn) {
                    e.preventDefault();
                    const setId = addBtn.getAttribute('data-set-id');
                    openModal(setId);
                }

                if (editBtn) {
                    e.preventDefault();
                    const responseId = editBtn.getAttribute('data-id');
                    const setId = editBtn.getAttribute('data-set-id');
                    fetch(`http://127.0.0.1:5000/api/responses/${responseId}`)
                        .then(res => {
                            if (!res.ok) throw new Error('Gagal memuat data response');
                            return res.json();
                        })
                        .then(data => openModal(setId, data.data))
                        .catch(err => {
                            showResponseModal('Gagal memuat data response', 'error');
                        });
                }
            });

            cancelDeleteBtn.addEventListener('click', () => {
                hideModal(deleteConfirmModal);
                deleteAction = null;
            });

            confirmDeleteBtn.addEventListener('click', () => {
                if (typeof deleteAction === 'function') {
                    deleteAction();
                }
            });

            function openModal(setInstrumenId, response = null) {
                form.reset();
                messageDiv.classList.add('hidden');
                document.getElementById('modal_set_instrumen_unit_kerja_id').value = setInstrumenId;

                if (response) {
                    form.setAttribute('data-mode', 'edit');
                    document.getElementById('modal_response_id').value = response.response_id;
                    document.querySelectorAll('[name="ketersediaan_standar_dan_dokumen"]').forEach(r => {
                        r.checked = r.value === response.ketersediaan_standar_dan_dokumen;
                    });
                    ['spt_pt', 'sn_dikti', 'lokal', 'nasional', 'internasional'].forEach(field => {
                        document.querySelectorAll(`[name="${field}"]`).forEach(r => {
                            r.checked = r.value === String(response[field]);
                        });
                    });
                    document.getElementById('modal_keterangan').value = response.keterangan || '';
                } else {
                    form.setAttribute('data-mode', 'tambah');
                    document.getElementById('modal_response_id').value = '';
                }
                showModal(tambahResponseModal);
            }

            form.addEventListener('submit', e => {
                e.preventDefault();
                const mode = form.getAttribute('data-mode');
                const formData = new FormData(form);
                const payload = Object.fromEntries(formData.entries());
                if (!payload.keterangan || payload.keterangan.trim() === '') {
                    payload.keterangan = null;
                }
                const url = mode === 'edit'
                    ? `http://127.0.0.1:5000/api/responses/${payload.response_id}`
                    : 'http://127.0.0.1:5000/api/responses';
                const method = mode === 'edit' ? 'PUT' : 'POST';

                fetch(url, {
                    method,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                })
                    .then(res => {
                        if (!res.ok) {
                            return res.json().then(err => {
                                throw new Error(err.message || 'Gagal menyimpan response');
                            });
                        }
                        return res.json();
                    })
                    .then(result => {
                        hideModal(tambahResponseModal);
                        showResponseModal(`Response berhasil ${mode === 'edit' ? 'diperbarui' : 'ditambahkan'}!`, 'success');
                        setTimeout(() => initializeDataAndRenderTable(), 2000);
                    })
                    .catch(err => {
                        showResponseModal(`Gagal menyimpan response: ${err.message}`, 'error');
                    });
            });

            backBtn.addEventListener('click', () => window.history.back());

            // Initialize data
            initializeDataAndRenderTable();
        });
    </script>
@endsection