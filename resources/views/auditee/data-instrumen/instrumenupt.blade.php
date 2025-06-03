@extends('layouts.app')

@section('title', 'Data Instrumen Unit')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => '/auditee/audit'],
            ['label' => 'Pengisian Instrumen'],
        ]" />

        <h1 class="mb-6 text-2xl font-semibold text-gray-900 dark:text-gray-200">
            Pengisian Instrumen
        </h1>

        {{-- Pesan Informasi Akses Dibatasi (akan selalu tampil jika status bukan 1) --}}
        @if (session('status') != 1)
            <div
                class="relative mb-6 flex items-start gap-3 rounded-lg border border-yellow-400 bg-yellow-100 px-4 py-3 text-yellow-700 dark:border-yellow-600 dark:bg-yellow-800 dark:text-yellow-200">
                <x-heroicon-s-information-circle class="h-6 w-6 flex-shrink-0" />
                <div>
                    <strong class="text-sm font-bold">Informasi!</strong>
                    <span class="block text-sm sm:inline">
                        Halaman ini hanya dapat diakses untuk melihat data. Pengisian dan penguncian jawaban hanya
                        diperbolehkan pada status <b>"Pengisian Instrumen"</b>.
                    </span>
                </div>
            </div>
        @endif

        {{-- Konten Utama Halaman (Tabel dan Kontrol) --}}
        <div id="audit-content">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-600 dark:bg-gray-800">
                <div
                    class="flex flex-col items-center justify-between gap-4 rounded-t-2xl border-b border-gray-200 bg-white p-4 sm:flex-row dark:border-gray-600 dark:bg-gray-800">
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                        <form id="per-page-form" action="#" method="GET">
                            <select name="per_page" id="per-page-select"
                                class="w-18 rounded-lg border border-gray-200 bg-gray-50 p-2 text-sm text-gray-800 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25" selected>25</option>
                                <option value="50">50</option>
                            </select>
                        </form>
                        <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                    </div>
                    <div class="relative w-full sm:w-auto">
                        <form id="search-form" action="#" method="GET">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="search" name="search" id="search-input" placeholder="Cari"
                                class="block w-full rounded-lg border border-gray-200 bg-gray-50 p-2 pl-10 text-sm text-gray-800 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead
                            class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <tr>
                                <th scope="col"
                                    class="w-12 border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">No</th>
                                <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                    Sasaran Strategis</th>
                                <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                    Indikator Kinerja</th>
                                <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                    Aktivitas</th>
                                <th scope="col"
                                    class="w-20 border-r border-gray-200 px-4 py-3 text-center sm:px-6 dark:border-gray-600">
                                    Satuan</th>
                                <th scope="col"
                                    class="w-20 border-r border-gray-200 px-4 py-3 text-center sm:px-6 dark:border-gray-600">
                                    Target</th>
                                <th scope="col"
                                    class="w-24 border-r border-gray-200 px-4 py-3 text-center sm:px-6 dark:border-gray-600">
                                    Capaian</th>
                                <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                    Lokasi Bukti Dukung</th>
                                <th scope="col"
                                    class="w-48 border-r border-gray-200 px-4 py-3 text-center sm:px-6 dark:border-gray-600">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="instr-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                            {{-- Loading Spinner akan ditampilkan di sini saat memuat data --}}
                            <tr>
                                <td colspan="9" class="px-4 py-3 text-center sm:px-6">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <div class="h-6 w-6 animate-spin rounded-full border-4 border-sky-500"></div>
                                        <p class="mt-3 text-gray-700 dark:text-gray-300">Memuat data instrumen...</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-4">
                    <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                        <span id="pagination-info" class="text-sm text-gray-700 dark:text-gray-300">
                            Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> hasil
                        </span>
                        <nav aria-label="Navigasi Paginasi" id="pagination-nav">
                            <ul class="inline-flex -space-x-px text-sm">
                                <li>
                                    <a href="#" id="prev-page"
                                        class="flex h-8 items-center justify-center rounded-l-lg border border-gray-200 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                        <x-heroicon-o-chevron-left class="mr-1 h-4 w-4" />
                                    </a>
                                </li>
                                {{-- Page numbers will be injected here --}}
                                <div id="page-numbers" class="inline-flex"></div>
                                <li>
                                    <a href="#" id="next-page"
                                        class="flex h-8 items-center justify-center rounded-r-lg border border-gray-200 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                        <x-heroicon-o-chevron-right class="ml-1 h-4 w-4" />
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <x-button id="submit-lock-btn" type="submit" color="sky" icon="heroicon-o-lock-closed"
                    class="px-4 py-2 text-sm font-medium">
                    Submit dan Kunci Jawaban
                </x-button>
            </div>
        </div> {{-- End of audit-content --}}
    </div>

    <div id="response-modal"
        class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900/50 transition-opacity duration-300">
        <div class="relative w-full max-w-2xl rounded-lg bg-white p-6 dark:bg-gray-800">
            <button type="button" id="close-modal-btn"
                class="absolute right-4 top-4 text-gray-400 transition-colors duration-200 hover:text-gray-600 dark:hover:text-gray-300">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 id="modal-title" class="mb-6 text-xl font-bold text-gray-900 dark:text-gray-100"></h2>
            <form id="response-form">
                <div class="space-y-6">
                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-600 dark:bg-gray-700">
                        <h3 class="mb-4 text-base font-semibold text-gray-700 dark:text-gray-300">Data Instrumen</h3>
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Sasaran Strategis</dt>
                                <dd id="modal-sasaran" class="mt-1 text-base text-gray-900 dark:text-gray-200"></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Indikator Kinerja</dt>
                                <dd id="modal-indikator" class="mt-1 text-base text-gray-900 dark:text-gray-200"></dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Aktivitas</dt>
                                <dd id="modal-aktivitas" class="mt-1 text-base text-gray-900 dark:text-gray-200"></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Satuan</dt>
                                <dd id="modal-satuan" class="mt-1 text-base text-gray-900 dark:text-gray-200"></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-600 dark:text-gray-400">Target</dt>
                                <dd id="modal-target" class="mt-1 text-base text-gray-900 dark:text-gray-200"></dd>
                            </div>
                        </dl>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="capaian"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Capaian</label>
                            <input type="text" name="capaian" id="capaian"
                                class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                                required>
                            <span id="capaian-error" class="mt-1 hidden text-sm font-medium text-red-600"></span>
                        </div>
                        <div>
                            <label for="lokasi_bukti_dukung"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Bukti
                                Dukung</label>
                            <input type="text" name="lokasi_bukti_dukung" id="lokasi_bukti_dukung"
                                class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <span id="lokasi_bukti_dukung-error"
                                class="mt-1 hidden text-sm font-medium text-red-600"></span>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="set_instrumen_unit_kerja_id" id="set_instrumen_unit_kerja_id">
                <input type="hidden" name="auditing_id" id="auditing_id" value="{{ session('auditing_id') }}">
                <input type="hidden" name="response_id" id="response_id">
                <div class="mt-6 flex justify-end gap-2">
                    <x-button id="cancel-btn" type="button" color="gray" class="px-4 py-2 text-sm font-medium">
                        Batal
                    </x-button>
                    <x-button type="submit" id="submit-btn" color="sky" class="px-4 py-2 text-sm font-medium">
                        Simpan
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mengambil ID auditing dan status audit dari session
            const auditingId = {{ session('auditing_id') }};
            const auditStatus = {{ session('status') ?? 1 }};
            const unitKerjaId = {{ session('unit_kerja_id') }};

            const modal = document.getElementById('response-modal');
            const modalTitle = document.getElementById('modal-title');
            const form = document.getElementById('response-form');
            const submitBtn = document.getElementById('submit-btn');
            const cancelBtn = document.getElementById('cancel-btn');
            const tableBody = document.getElementById('instr-table-body');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const searchInput = document.getElementById('search-input');
            const searchForm = document.getElementById('search-form');
            const paginationInfo = document.getElementById('pagination-info');
            const pageNumbersContainer = document.getElementById('page-numbers');
            const prevPageBtn = document.getElementById('prev-page');
            const nextPageBtn = document.getElementById('next-page');
            const submitLockBtn = document.getElementById('submit-lock-btn');
            const perPageSelect = document.getElementById('per-page-select');

            // Variabel global untuk data dan paginasi
            let allInstrumenData = [];
            let allResponseData = [];
            let currentPage = 1;
            let perPage = 25; // Default perPage diatur ke 25
            let searchQuery = '';
            let totalFilteredItems = 0;
            let totalPages = 0;

            // Fungsi untuk membuka modal
            const openModal = (isEdit, setInstrumenId, response = {}, instrumen = {}) => {
                if (auditStatus !== 1) {
                    showCustomMessage('Pengisian jawaban hanya diperbolehkan pada status Pengisian Instrumen.');
                    return;
                }
                modalTitle.textContent = isEdit ? 'Edit Jawaban Unit' : 'Jawab Instrumen Unit';
                document.getElementById('capaian').value = response.capaian || '';
                document.getElementById('lokasi_bukti_dukung').value = response.lokasi_bukti_dukung || '';
                document.getElementById('set_instrumen_unit_kerja_id').value = setInstrumenId;
                document.getElementById('response_id').value = response.response_id || '';
                document.getElementById('modal-sasaran').textContent = instrumen.sasaran || '-';
                document.getElementById('modal-indikator').textContent = instrumen.indikator || '-';
                document.getElementById('modal-aktivitas').textContent = instrumen.aktivitas || '-';
                document.getElementById('modal-satuan').textContent = instrumen.satuan || '-';
                document.getElementById('modal-target').textContent = instrumen.target || '-';
                document.getElementById('capaian-error').classList.add('hidden');
                document.getElementById('lokasi_bukti_dukung-error').classList.add('hidden');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.querySelector('div').classList.remove('scale-95');
                    modal.classList.remove('opacity-0');
                }, 10);
            };

            // Fungsi untuk menutup modal
            const closeModal = () => {
                modal.classList.add('opacity-0');
                modal.querySelector('div').classList.add('scale-95');
                setTimeout(() => modal.classList.add('hidden'), 300);
            };

            // Fungsi untuk menampilkan pesan kustom
            const showCustomMessage = (message) => {
                const messageBox = document.createElement('div');
                messageBox.className = 'fixed inset-0 bg-gray-900/50 flex items-center justify-center z-[9999]';
                messageBox.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-lg p-8 shadow-xl border border-gray-200 dark:border-gray-600 text-center max-w-sm mx-auto">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Pesan</h3>
                <p class="text-base text-gray-700 dark:text-gray-300 mb-6">${message}</p>
                <button id="close-message-btn-custom" class="w-24 px-6 py-2 bg-sky-800 text-white rounded-lg hover:bg-sky-900 transition-colors duration-200 font-medium">Tutup</button>
            </div>
        `;
                document.body.appendChild(messageBox);
                document.getElementById('close-message-btn-custom').addEventListener('click', () => {
                    document.body.removeChild(messageBox);
                });
            };

            // Fungsi untuk konfirmasi kustom
            const showCustomConfirm = (message, onConfirm) => {
                const confirmBox = document.createElement('div');
                confirmBox.className =
                    'fixed inset-0 bg-gray-900/60 flex items-center justify-center z-[9999] animate-fade-in';
                confirmBox.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-2xl border border-gray-200 dark:border-gray-600 text-center max-w-sm mx-auto relative animate-pop-in">
                <div class="flex justify-center mb-4">
                    <x-heroicon-o-information-circle class="h-16 w-16 text-sky-600 dark:text-sky-700" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Konfirmasi</h3>
                <p class="text-base text-gray-700 dark:text-gray-300 mb-6">${message}</p>
                <div class="flex justify-center gap-4">
                    <button id="confirm-no-btn" class="w-24 px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition-colors duration-200 font-semibold">Tidak</button>
                    <button id="confirm-yes-btn" class="w-24 px-6 py-2 bg-sky-800 text-white rounded-lg hover:bg-sky-900 transition-colors duration-200 font-semibold">Ya</button>
                </div>
            </div>
        `;
                document.body.appendChild(confirmBox);
                document.getElementById('confirm-yes-btn').addEventListener('click', () => {
                    document.body.removeChild(confirmBox);
                    onConfirm(true);
                });
                document.getElementById('confirm-no-btn').addEventListener('click', () => {
                    document.body.removeChild(confirmBox);
                    onConfirm(false);
                });
            };

            // Fungsi untuk memuat semua data dan merender tabel
            const initializeDataAndRenderTable = async () => {
                tableBody.innerHTML = `
            <tr>
                <td colspan="9" class="px-4 py-3 sm:px-6 text-center">
                    <div class="flex flex-col items-center justify-center py-8">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-sky-500"></div>
                        <p class="mt-3 text-gray-700 dark:text-gray-300">Memuat data instrumen...</p>
                    </div>
                </td>
            </tr>
        `;
                try {
                    const [auditingResult, instrumenResult, responseResult] = await Promise.all([
                        fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`).then(res => {
                            if (!res.ok) throw new Error('Gagal mengambil data auditing');
                            return res.json();
                        }),
                        fetch(`http://127.0.0.1:5000/api/set-instrumen`).then(res => res.json()),
                        fetch(`http://127.0.0.1:5000/api/responses/auditing/${auditingId}`)
                        .then(res => res.json())
                        .catch(() => ({
                            data: []
                        }))
                    ]);

                    if (instrumenResult.data) {
                        if (Array.isArray(instrumenResult.data)) {
                            allInstrumenData = instrumenResult.data.filter(item => item.jenis_unit_id ===
                                1);
                        } else if (typeof instrumenResult.data === 'object' && instrumenResult.data !==
                            null) {
                            if (instrumenResult.data.jenis_unit_id === 1) {
                                allInstrumenData = [instrumenResult.data];
                            }
                        }
                    }
                    allResponseData = responseResult.data || [];

                    renderTable(); // Render tabel setelah data dimuat
                } catch (error) {
                    console.error('Gagal memuat data:', error);
                    tableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="px-4 py-3 sm:px-6 text-center text-red-600 dark:text-red-400">
                        Gagal memuat data instrumen. Silakan coba lagi.
                    </td>
                </tr>
            `;
                }
            };

            // Fungsi untuk menghitung rowspan per halaman
            const calculatePageRowspan = (data, startIndex, endIndex) => {
                const rowspanMap = {};
                let currentNumber = 1;
                data.forEach((item, index) => {
                    const sasaran = item.sasaran;
                    const indikator = item.indikator;
                    if (!rowspanMap[sasaran]) {
                        rowspanMap[sasaran] = {
                            count: 0,
                            startIndex: index,
                            number: currentNumber++,
                            indikators: {}
                        };
                    }
                    if (!rowspanMap[sasaran].indikators[indikator]) {
                        rowspanMap[sasaran].indikators[indikator] = {
                            count: 0,
                            startIndex: index
                        };
                    }
                    rowspanMap[sasaran].count += 1;
                    rowspanMap[sasaran].indikators[indikator].count += 1;
                });

                // Sesuaikan rowspan untuk halaman saat ini
                const pageRowspanMap = {};
                data.slice(startIndex, endIndex).forEach((item, index) => {
                    const globalIndex = startIndex + index;
                    const sasaran = item.sasaran;
                    const indikator = item.indikator;

                    if (!pageRowspanMap[sasaran]) {
                        pageRowspanMap[sasaran] = {
                            count: 0,
                            startIndex: globalIndex,
                            number: rowspanMap[sasaran].number,
                            indikators: {}
                        };
                    }
                    if (!pageRowspanMap[sasaran].indikators[indikator]) {
                        pageRowspanMap[sasaran].indikators[indikator] = {
                            count: 0,
                            startIndex: globalIndex
                        };
                    }
                    pageRowspanMap[sasaran].count += 1;
                    pageRowspanMap[sasaran].indikators[indikator].count += 1;
                });

                return pageRowspanMap;
            };

            // Fungsi untuk merender tabel
            const renderTable = (page = 1) => {
                currentPage = page;
                tableBody.innerHTML = ''; // Bersihkan tabel

                let filteredData = allInstrumenData.filter(item => {
                    const searchTerm = searchQuery.toLowerCase();
                    return (
                        (item.aktivitas.indikator_kinerja.sasaran_strategis.nama_sasaran || '')
                        .toLowerCase().includes(searchTerm) ||
                        (item.aktivitas.indikator_kinerja.isi_indikator_kinerja || '').toLowerCase()
                        .includes(searchTerm) ||
                        (item.aktivitas.nama_aktivitas || '').toLowerCase().includes(searchTerm) ||
                        (item.aktivitas.satuan || '').toLowerCase().includes(searchTerm) ||
                        (item.aktivitas.target || '').toLowerCase().includes(searchTerm)
                    );
                });

                // Logika pengelompokan
                const grouped = {};
                filteredData.forEach(item => {
                    const sasaran = item.aktivitas.indikator_kinerja.sasaran_strategis.nama_sasaran;
                    const indikator = item.aktivitas.indikator_kinerja.isi_indikator_kinerja;
                    const aktivitas = item.aktivitas.nama_aktivitas;

                    if (!grouped[sasaran]) {
                        grouped[sasaran] = {};
                    }
                    if (!grouped[sasaran][indikator]) {
                        grouped[sasaran][indikator] = {};
                    }
                    if (!grouped[sasaran][indikator][aktivitas]) {
                        grouped[sasaran][indikator][aktivitas] = [];
                    }
                    grouped[sasaran][indikator][aktivitas].push(item);
                });

                let flatGroupedData = [];
                for (const sasaran in grouped) {
                    for (const indikator in grouped[sasaran]) {
                        for (const aktivitas in grouped[sasaran][indikator]) {
                            grouped[sasaran][indikator][aktivitas].forEach(item => {
                                flatGroupedData.push({
                                    sasaran: sasaran,
                                    indikator: indikator,
                                    aktivitas: aktivitas,
                                    item: item
                                });
                            });
                        }
                    }
                }

                totalFilteredItems = flatGroupedData.length;
                totalPages = Math.ceil(totalFilteredItems / perPage);

                const startIndex = (currentPage - 1) * perPage;
                const endIndex = Math.min(startIndex + perPage, totalFilteredItems);
                const paginatedData = flatGroupedData.slice(startIndex, endIndex);

                // Hitung rowspan untuk halaman saat ini
                const pageRowspanMap = calculatePageRowspan(flatGroupedData, startIndex, endIndex);

                if (paginatedData.length === 0) {
                    tableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="px-4 py-3 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                        Tidak ada data instrumen untuk unit ini.
                    </td>
                </tr>
            `;
                } else {
                    paginatedData.forEach((groupedItem, index) => {
                        const item = groupedItem.item;
                        const response = allResponseData.find(res => res.set_instrumen_unit_kerja_id ===
                            item.set_instrumen_unit_kerja_id) || {};
                        const row = document.createElement('tr');
                        row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';

                        const globalIndex = startIndex + index;
                        const sasaran = groupedItem.sasaran;
                        const indikator = groupedItem.indikator;

                        let html = '';
                        // Kolom No dengan rowspan berdasarkan sasaran
                        if (globalIndex === pageRowspanMap[sasaran].startIndex) {
                            html +=
                                `<td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center" rowspan="${pageRowspanMap[sasaran].count}">${pageRowspanMap[sasaran].number}</td>`;
                        }

                        // Kolom Sasaran Strategis dengan rowspan
                        if (globalIndex === pageRowspanMap[sasaran].startIndex) {
                            html +=
                                `<td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600" rowspan="${pageRowspanMap[sasaran].count}">${sasaran}</td>`;
                        }

                        // Kolom Indikator Kinerja dengan rowspan
                        if (globalIndex === pageRowspanMap[sasaran].indikators[indikator].startIndex) {
                            html +=
                                `<td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600" rowspan="${pageRowspanMap[sasaran].indikators[indikator].count}">${indikator}</td>`;
                        }

                        // Kolom lainnya
                        html += `
                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${groupedItem.aktivitas}</td>
                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center">${item.aktivitas.satuan || '-'}</td>
                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center">${item.aktivitas.target || '-'}</td>
                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center">${response.capaian || '-'}</td>
                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center">${response.lokasi_bukti_dukung || '-'}</td>
                    <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center">
                        ${auditStatus != 1 ? `
                                                <span class="text-gray-500 dark:text-gray-400 text-sm">Jawaban Terkunci</span>
                                            ` : `
                                                <div class="flex items-center justify-center gap-2">
                                                    ${response.response_id ? `
                                    <x-button type="button" color="yellow" icon="heroicon-o-pencil" class="edit-btn text-sm font-medium" data-id="${response.response_id}" data-capaian="${response.capaian || ''}" data-lokasi="${response.lokasi_bukti_dukung || ''}" data-sasaran="${sasaran}" data-indikator="${indikator}" data-aktivitas="${groupedItem.aktivitas}" data-satuan="${item.aktivitas.satuan || ''}" data-target="${item.aktivitas.target || ''}" data-set-instrumen-id="${item.set_instrumen_unit_kerja_id}">
                                        Edit
                                    </x-button>
                                    <x-button type="button" color="red" icon="heroicon-o-trash" class="delete-btn text-sm font-medium" data-id="${response.response_id}">
                                        Hapus
                                    </x-button>
                                ` : `
                                    <x-button type="button" color="sky" icon="heroicon-o-plus" class="add-btn text-sm font-medium" data-id="${item.set_instrumen_unit_kerja_id}" data-sasaran="${sasaran}" data-indikator="${indikator}" data-aktivitas="${groupedItem.aktivitas}" data-satuan="${item.aktivitas.satuan || ''}" data-target="${item.aktivitas.target || ''}">
                                        Jawab
                                    </x-button>
                                `}
                                                </div>
                                            `}
                    </td>
                `;
                        row.innerHTML = html;
                        tableBody.appendChild(row);
                    });
                }

                // Perbarui informasi paginasi
                const currentStart = totalFilteredItems === 0 ? 0 : startIndex + 1;
                const currentEnd = endIndex;
                paginationInfo.innerHTML =
                    `Menampilkan <strong>${currentStart}</strong> hingga <strong>${currentEnd}</strong> dari <strong>${totalFilteredItems}</strong> hasil`;

                // Render tombol paginasi
                pageNumbersContainer.innerHTML = '';
                for (let i = 1; i <= totalPages; i++) {
                    const pageLink = document.createElement('li');
                    pageLink.innerHTML = `
                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-200 transition-all duration-200 ${i === currentPage ? 'text-sky-600 bg-sky-50 dark:bg-gray-700 dark:text-sky-200' : ''}" data-page="${i}">
                    ${i}
                </a>
            `;
                    pageNumbersContainer.appendChild(pageLink);
                }

                // Aktifkan/nonaktifkan tombol prev/next
                prevPageBtn.classList.toggle('opacity-50', currentPage === 1);
                prevPageBtn.classList.toggle('pointer-events-none', currentPage === 1);
                nextPageBtn.classList.toggle('opacity-50', currentPage === totalPages || totalPages === 0);
                nextPageBtn.classList.toggle('pointer-events-none', currentPage === totalPages || totalPages ===
                    0);
            };

            // Inisialisasi status tombol "Submit dan Kunci Jawaban"
            if (auditStatus !== 1) {
                submitLockBtn.disabled = true;
                submitLockBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }

            // Event Listeners
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                searchQuery = searchInput.value.trim();
                renderTable(1); // Reset ke halaman 1 saat pencarian
            });

            perPageSelect.addEventListener('change', function() {
                perPage = parseInt(perPageSelect.value);
                renderTable(1); // Reset ke halaman 1 saat perPage berubah
            });

            pageNumbersContainer.addEventListener('click', function(e) {
                const pageLink = e.target.closest('a[data-page]');
                if (pageLink) {
                    e.preventDefault();
                    const page = parseInt(pageLink.getAttribute('data-page'));
                    renderTable(page);
                }
            });

            prevPageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage > 1) {
                    renderTable(currentPage - 1);
                }
            });

            nextPageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage < totalPages) {
                    renderTable(currentPage + 1);
                }
            });

            tableBody.addEventListener('click', function(e) {
                const addBtn = e.target.closest('.add-btn');
                const editBtn = e.target.closest('.edit-btn');
                const deleteBtn = e.target.closest('.delete-btn');

                if (addBtn) {
                    const setInstrId = addBtn.getAttribute('data-id');
                    const instrumen = {
                        sasaran: addBtn.getAttribute('data-sasaran'),
                        indikator: addBtn.getAttribute('data-indikator'),
                        aktivitas: addBtn.getAttribute('data-aktivitas'),
                        satuan: addBtn.getAttribute('data-satuan'),
                        target: addBtn.getAttribute('data-target'),
                    };
                    openModal(false, setInstrId, {}, instrumen);
                } else if (editBtn) {
                    const response = {
                        response_id: editBtn.getAttribute('data-id'),
                        capaian: editBtn.getAttribute('data-capaian') || '',
                        lokasi_bukti_dukung: editBtn.getAttribute('data-lokasi') || '',
                    };
                    const setInstrId = editBtn.getAttribute('data-set-instrumen-id');
                    const instrumen = {
                        sasaran: editBtn.getAttribute('data-sasaran'),
                        indikator: editBtn.getAttribute('data-indikator'),
                        aktivitas: editBtn.getAttribute('data-aktivitas'),
                        satuan: editBtn.getAttribute('data-satuan'),
                        target: editBtn.getAttribute('data-target'),
                    };
                    openModal(true, setInstrId, response, instrumen);
                } else if (deleteBtn) {
                    e.preventDefault();
                    const responseId = deleteBtn.getAttribute('data-id');
                    if (auditStatus !== 1) {
                        showCustomMessage(
                            'Penghapusan jawaban hanya diperbolehkan pada status Pengisian Instrumen.');
                        return;
                    }
                    showCustomConfirm('Apakah Anda yakin ingin menghapus jawaban ini?', (confirmed) => {
                        if (confirmed) {
                            fetch(`http://127.0.0.1:5000/api/responses/${responseId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => {
                                    if (!response.ok) return response.json().then(err => {
                                        throw err;
                                    });
                                    return response.json();
                                })
                                .then(() => {
                                    showCustomMessage('Jawaban berhasil dihapus!');
                                    initializeDataAndRenderTable();
                                })
                                .catch(error => {
                                    console.error('Gagal menghapus:', error);
                                    showCustomMessage(
                                        'Gagal menghapus jawaban. Silakan coba lagi.');
                                });
                        }
                    });
                }
            });

            closeModalBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const capaian = document.getElementById('capaian');
                const error = document.getElementById('capaian-error');

                if (!capaian.value.trim()) {
                    error.textContent = 'Capaian wajib diisi';
                    error.classList.remove('hidden');
                    return;
                }
                error.classList.add('hidden');

                const formData = new FormData(form);
                const data = {
                    set_instrumen_unit_kerja_id: formData.get('set_instrumen_unit_kerja_id'),
                    auditing_id: formData.get('auditing_id'),
                    capaian: formData.get('capaian'),
                    lokasi_bukti_dukung: formData.get('lokasi_bukti_dukung') || ''
                };

                const isEdit = !!formData.get('response_id');
                const method = isEdit ? 'PUT' : 'POST';
                const endpoint = isEdit ?
                    `http://127.0.0.1:5000/api/responses/${formData.get('response_id')}` :
                    'http://127.0.0.1:5000/api/responses';

                submitBtn.disabled = true;
                submitBtn.innerHTML = `
            <svg class="animate-spin h-4 w-4 mr-2 text-white" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-16 0z"></path>
            </svg>
            Menyimpan...
        `;

                fetch(endpoint, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        if (!response.ok) return response.json().then(err => {
                            throw err;
                        });
                        return response.json();
                    })
                    .then(() => {
                        showCustomMessage(isEdit ? 'Jawaban berhasil diperbarui!' :
                            'Jawaban berhasil disimpan!');
                        closeModal();
                        initializeDataAndRenderTable();
                    })
                    .catch(error => {
                        const errorEl = document.getElementById('capaian-error');
                        if (error.errors) {
                            errorEl.textContent = error.errors.capaian?.join(', ') ||
                                'Terjadi kesalahan';
                            errorEl.classList.remove('hidden');
                        } else {
                            showCustomMessage('Terjadi kesalahan: ' + (error.message ||
                                'Tidak dapat menyimpan jawaban'));
                        }
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Simpan';
                    });
            });

            submitLockBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (auditStatus !== 1) {
                    return;
                }
                showCustomConfirm(
                    'Apakah Anda yakin ingin mengunci jawaban? Tindakan ini tidak dapat dibatalkan.', (
                        confirmed) => {
                        if (confirmed) {
                            fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        status: 2
                                    })
                                })
                                .then(response => {
                                    if (!response.ok) return response.json().then(err => {
                                        throw err;
                                    });
                                    return response.json();
                                })
                                .then(() => {
                                    document.querySelectorAll('#instr-table-body tr').forEach(
                                        row => {
                                            row.lastElementChild.innerHTML =
                                                `<span class="text-gray-500 dark:text-gray-400 text-sm">Jawaban Terkunci</span>`;
                                            row.lastElementChild.classList.add('text-center');
                                        });
                                    submitLockBtn.disabled = true;
                                    submitLockBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                    showCustomMessage('Jawaban berhasil dikunci!');
                                    window.location.href = '/auditee/audit';
                                })
                                .catch(error => {
                                    console.error('Gagal mengunci jawaban:', error);
                                    showCustomMessage('Gagal mengunci jawaban. Silakan coba lagi.');
                                });
                        }
                    });
            });

            // Panggil fungsi inisialisasi
            initializeDataAndRenderTable();
        });
    </script>
@endsection
