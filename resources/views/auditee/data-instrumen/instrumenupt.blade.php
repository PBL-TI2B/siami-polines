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
            Pengisian Instrumen Unit
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
                                <th scope="col"
                                    class="min-w-[300px] border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                    Sasaran Strategis</th>
                                <th scope="col"
                                    class="min-w-[300px] border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                    Indikator Kinerja</th>
                                <th scope="col"
                                    class="min-w-[250px] border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
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
                                <th scope="col"
                                    class="min-w-[250px] border-r border-gray-200 px-4 py-3 text-center sm:px-6 dark:border-gray-600">
                                    Link Bukti Dukung</th>
                                <th scope="col"
                                    class="min-w-[250px] border-r border-gray-200 px-4 py-3 text-center sm:px-6 dark:border-gray-600">
                                    Keterangan</th>
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
        <div class="relative max-h-[85vh] w-full max-w-2xl overflow-y-auto rounded-lg bg-white p-6 pb-6 dark:bg-gray-800">
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
                                placeholder="Masukkan nilai capaian (contoh: 85)" required>
                            <span id="capaian-error" class="mt-1 hidden text-sm font-medium text-red-600"></span>
                        </div>
                        <div>
                            <label for="lokasi_bukti_dukung"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Link Bukti
                                Dukung</label>
                            <input type="text" name="lokasi_bukti_dukung" id="lokasi_bukti_dukung"
                                class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                                placeholder="Masukkan URL bukti dukung (contoh: https://example.com/bukti)">
                            <span id="lokasi_bukti_dukung-error"
                                class="mt-1 hidden text-sm font-medium text-red-600"></span>
                        </div>
                        <div>
                            <label for="keterangan"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                            <textarea name="keterangan" id="keterangan"
                                class="block w-full rounded-lg border border-gray-300 px-3 py-2.5 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                                rows="4" placeholder="Masukkan keterangan tambahan (opsional)"></textarea>
                            <span id="keterangan-error" class="mt-1 hidden text-sm font-medium text-red-600"></span>
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
            let auditStatus = {{ session('status') ?? 1 }};
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
            let perPage = 25;
            let searchQuery = '';
            let totalFilteredItems = 0;
            let totalPages = 0;

            // Fungsi untuk membuka modal
            const openModal = (isEdit, setInstrumenId, response = {}, instrumen = {}) => {
                if (auditStatus !== 1) {
                    showCustomMessage('Pengisian jawaban hanya diperbolehkan pada status Pengisian Instrumen.');
                    return;
                }
                modalTitle.textContent = isEdit ? 'Edit Jawaban Instrumen' : 'Jawab Instrumen Unit';
                document.getElementById('capaian').value = response.capaian || '';
                document.getElementById('lokasi_bukti_dukung').value = response.lokasi_bukti_dukung || '';
                document.getElementById('keterangan').value = response.keterangan || '';
                document.getElementById('set_instrumen_unit_kerja_id').value =
                    setInstrumenId; // set_instrumen_unit_kerja_id dari data tabel
                document.getElementById('response_id').value = response.response_id || '';
                document.getElementById('modal-sasaran').textContent = instrumen.sasaran || '-';
                document.getElementById('modal-indikator').textContent = instrumen.indikator || '-';
                document.getElementById('modal-aktivitas').textContent = instrumen.aktivitas || '-';
                document.getElementById('modal-satuan').textContent = instrumen.satuan || '-';
                document.getElementById('modal-target').textContent = instrumen.target || '-';
                document.getElementById('capaian-error').classList.add('hidden');
                document.getElementById('lokasi_bukti_dukung-error').classList.add('hidden');
                document.getElementById('keterangan-error').classList.add('hidden');
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
                        <svg class="h-16 w-16 text-sky-600 dark:text-sky-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
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

            const initializeDataAndRenderTable = async () => {
                tableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="px-4 py-3 sm:px-6 text-center">
                        <div class="flex flex-col items-center justify-center py-8">
                            <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-sky-500"></div>
                            <p class="mt-3 text-gray-700 dark:text-gray-300">Memuat data instrumen...</p>
                        </div>
                    </td>
                </tr>`;
                try {
                    // auditingId sudah ada dari session
                    // set_instrumen_unit_kerja_id didapat saat membuka modal dari atribut data tombol
                    const [instrumenResult, responseResult] = await Promise.all([
                        fetch(`http://127.0.0.1:5000/api/set-instrumen`).then(res => res
                            .json()), // Untuk data instrumen umum
                        fetch(
                            `http://127.0.0.1:5000/api/responses/auditing/${auditingId}`
                        ) // Untuk response yang sudah ada
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
                    renderTable();
                } catch (error) {
                    console.error('Gagal memuat data:', error);
                    tableBody.innerHTML = `
                    <tr>
                        <td colspan="9" class="px-4 py-3 sm:px-6 text-center text-red-600 dark:text-red-400">
                            Gagal memuat data instrumen. Silakan coba lagi.
                        </td>
                    </tr>`;
                }
            };

            const calculatePageRowspan = (data, startIndex, endIndex) => {
                const rowspanMap = {};
                let currentNumber = 1; // Nomor urut global untuk sasaran

                // Hitung rowspan dan nomor urut global berdasarkan data yang sudah difilter (flatGroupedData)
                const globalRowspanMap = {};
                let globalCurrentNumber = 1;
                data.forEach((gItem, index) => {
                    const sasaran = gItem.sasaran;
                    const indikator = gItem.indikator;

                    if (!globalRowspanMap[sasaran]) {
                        globalRowspanMap[sasaran] = {
                            count: 0,
                            startIndex: -1,
                            number: globalCurrentNumber++,
                            indikators: {}
                        };
                    }
                    if (globalRowspanMap[sasaran].startIndex === -1) globalRowspanMap[sasaran]
                        .startIndex = index;
                    globalRowspanMap[sasaran].count++;

                    if (!globalRowspanMap[sasaran].indikators[indikator]) {
                        globalRowspanMap[sasaran].indikators[indikator] = {
                            count: 0,
                            startIndex: -1
                        };
                    }
                    if (globalRowspanMap[sasaran].indikators[indikator].startIndex === -1)
                        globalRowspanMap[sasaran].indikators[indikator].startIndex = index;
                    globalRowspanMap[sasaran].indikators[indikator].count++;
                });


                const pageRowspanMap = {};
                data.slice(startIndex, endIndex).forEach((groupedItem, localIndex) => {
                    const globalIndex = startIndex + localIndex;
                    const sasaran = groupedItem.sasaran;
                    const indikator = groupedItem.indikator;

                    if (!pageRowspanMap[sasaran]) {
                        pageRowspanMap[sasaran] = {
                            count: 0,
                            // Tentukan apakah ini baris pertama untuk sasaran ini DI HALAMAN SAAT INI
                            // dan apakah index globalnya cocok dengan startIndex global untuk sasaran ini
                            isFirstSasaranRowOnPage: globalIndex === globalRowspanMap[sasaran]
                                .startIndex,
                            number: globalRowspanMap[sasaran].number, // Ambil nomor dari map global
                            indikators: {}
                        };
                    }
                    // Hitung berapa banyak baris sasaran ini yang ada di halaman saat ini
                    for (let i = startIndex; i < endIndex; i++) {
                        if (data[i].sasaran === sasaran) {
                            pageRowspanMap[sasaran].count++;
                        }
                    }


                    if (!pageRowspanMap[sasaran].indikators[indikator]) {
                        pageRowspanMap[sasaran].indikators[indikator] = {
                            count: 0,
                            isFirstIndikatorRowOnPage: globalIndex === globalRowspanMap[sasaran]
                                .indikators[indikator].startIndex
                        };
                    }
                    for (let i = startIndex; i < endIndex; i++) {
                        if (data[i].sasaran === sasaran && data[i].indikator === indikator) {
                            pageRowspanMap[sasaran].indikators[indikator].count++;
                        }
                    }
                });
                // Untuk memastikan count di pageRowspanMap adalah jumlah aktual di halaman itu
                for (const sasaranKey in pageRowspanMap) {
                    pageRowspanMap[sasaranKey].count = data.slice(startIndex, endIndex).filter(it => it
                        .sasaran === sasaranKey).length;
                    for (const indikatorKey in pageRowspanMap[sasaranKey].indikators) {
                        pageRowspanMap[sasaranKey].indikators[indikatorKey].count = data.slice(startIndex,
                            endIndex).filter(it => it.sasaran === sasaranKey && it.indikator ===
                            indikatorKey).length;
                    }
                }


                return {
                    pageRowspanMap,
                    globalRowspanMap
                };
            };


            const renderTable = (page = 1) => {
                currentPage = page;
                tableBody.innerHTML = '';

                let filteredData = allInstrumenData.filter(item => {
                    const searchTerm = searchQuery.toLowerCase();
                    return (
                        (item.aktivitas.indikator_kinerja.sasaran_strategis.nama_sasaran || '').toLowerCase().includes(searchTerm) ||
                        (item.aktivitas.indikator_kinerja.isi_indikator_kinerja || '').toLowerCase().includes(searchTerm) ||
                        (item.aktivitas.nama_aktivitas || '').toLowerCase().includes(searchTerm) ||
                        (item.aktivitas.satuan || '').toLowerCase().includes(searchTerm) ||
                        (item.aktivitas.target || '').toLowerCase().includes(searchTerm) ||
                        (allResponseData.find(res => res.set_instrumen_unit_kerja_id === item.set_instrumen_unit_kerja_id)?.capaian || '').toLowerCase().includes(searchTerm) ||
                        (allResponseData.find(res => res.set_instrumen_unit_kerja_id === item.set_instrumen_unit_kerja_id)?.lokasi_bukti_dukung || '').toLowerCase().includes(searchTerm) ||
                        (allResponseData.find(res => res.set_instrumen_unit_kerja_id === item.set_instrumen_unit_kerja_id)?.keterangan || '').toLowerCase().includes(searchTerm)
                    );
                });

                const grouped = {};
                filteredData.forEach(item => {
                    const sasaran = item.aktivitas.indikator_kinerja.sasaran_strategis.nama_sasaran;
                    const indikator = item.aktivitas.indikator_kinerja.isi_indikator_kinerja;
                    const aktivitas = item.aktivitas.nama_aktivitas;

                    if (!grouped[sasaran]) grouped[sasaran] = {};
                    if (!grouped[sasaran][indikator]) grouped[sasaran][indikator] = {};
                    if (!grouped[sasaran][indikator][aktivitas]) grouped[sasaran][indikator][
                        aktivitas
                    ] = [];
                    grouped[sasaran][indikator][aktivitas].push(item);
                });

                let flatGroupedData = [];
                for (const sasaran in grouped) {
                    for (const indikator in grouped[sasaran]) {
                        for (const aktivitas in grouped[sasaran][indikator]) {
                            grouped[sasaran][indikator][aktivitas].forEach(item => {
                                flatGroupedData.push({
                                    sasaran,
                                    indikator,
                                    aktivitas,
                                    item
                                });
                            });
                        }
                    }
                }

                totalFilteredItems = flatGroupedData.length;
                totalPages = Math.ceil(totalFilteredItems / perPage);
                currentPage = Math.min(page, totalPages) || 1; // Pastikan halaman saat ini valid


                const startIndex = (currentPage - 1) * perPage;
                const endIndex = Math.min(startIndex + perPage, totalFilteredItems);
                const paginatedData = flatGroupedData.slice(startIndex, endIndex);

                const {
                    pageRowspanMap,
                    globalRowspanMap
                } = calculatePageRowspan(flatGroupedData, startIndex, endIndex);

                if (paginatedData.length === 0) {
                    tableBody.innerHTML =
                        `<tr><td colspan="9" class="px-4 py-3 sm:px-6 text-center text-gray-500 dark:text-gray-400">Tidak ada data instrumen untuk Unit ini.</td></tr>`;
                } else {
                    let
                        firstRowFlags = {}; // Untuk melacak apakah TD sudah dirender untuk sasaran/indikator tertentu di halaman ini

                    paginatedData.forEach((groupedItem, localIndex) => {
                        const item = groupedItem.item;
                        const response = allResponseData.find(res => res.set_instrumen_unit_kerja_id ===
                            item.set_instrumen_unit_kerja_id) || {};
                        const row = document.createElement('tr');
                        row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';

                        const globalIndex = startIndex + localIndex;
                        const sasaran = groupedItem.sasaran;
                        const indikator = groupedItem.indikator;

                        let html = '';

                        // Kolom No & Sasaran Strategis (rowspan berdasarkan sasaran)
                        if (!firstRowFlags[sasaran]) {
                            const sasaranInfo = globalRowspanMap[sasaran];
                            if (sasaranInfo) {
                                html +=
                                    `<td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center" rowspan="${pageRowspanMap[sasaran]?.count || 1}">${sasaranInfo.number}</td>`;
                                html +=
                                    `<td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600" rowspan="${pageRowspanMap[sasaran]?.count || 1}">${sasaran}</td>`;
                                firstRowFlags[sasaran] = true;
                                firstRowFlags[`${sasaran}-${indikator}`] =
                                    false; // Reset flag indikator saat sasaran baru
                            }
                        }

                        // Kolom Indikator Kinerja (rowspan berdasarkan indikator dalam sasaran)
                        if (!firstRowFlags[`${sasaran}-${indikator}`]) {
                            const indikatorInfo = globalRowspanMap[sasaran]?.indikators[indikator];
                            if (indikatorInfo) {
                                html +=
                                    `<td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600" rowspan="${pageRowspanMap[sasaran]?.indikators[indikator]?.count || 1}">${indikator}</td>`;
                                firstRowFlags[`${sasaran}-${indikator}`] = true;
                            }
                        }


                        html += `
                            <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${groupedItem.aktivitas}</td>
                            <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center">${item.aktivitas.satuan || '-'}</td>
                            <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center">${item.aktivitas.target || '-'}</td>
                            <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center">${response.capaian || '-'}</td>
                            <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center">
                                ${response.lokasi_bukti_dukung ? `<a href="${response.lokasi_bukti_dukung}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline break-all">${response.lokasi_bukti_dukung}</a>` : '-'}
                            </td>
                            <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center">${response.keterangan || '-'}</td>
                            <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 text-center">
                                ${auditStatus != 1 ? `<span class="text-gray-500 dark:text-gray-400 text-sm">Jawaban Terkunci</span>` : `
                                                        <div class="flex items-center justify-center gap-2">
                                                            ${response.response_id ? `
                                            <button type="button" class="edit-btn text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-600 rounded-lg px-3 py-1.5 flex items-center" data-id="${response.response_id}" data-capaian="${response.capaian || ''}" data-lokasi="${response.lokasi_bukti_dukung || ''}" data-sasaran="${sasaran}" data-indikator="${indikator}" data-aktivitas="${groupedItem.aktivitas}" data-satuan="${item.aktivitas.satuan || ''}" data-target="${item.aktivitas.target || ''}" data-set-instrumen-id="${item.set_instrumen_unit_kerja_id}">
                                                <svg class="w-3 h-3 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                                Edit
                                            </button>
                                            <button type="button" class="delete-btn text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-600 rounded-lg px-3 py-1.5 flex items-center" data-id="${response.response_id}">
                                                 <svg class="w-3 h-3 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12.56 0c1.153 0 2.243.096 3.222.261m3.222.261L12 5.291M12 5.291A2.25 2.25 0 0112.75 3h-1.5A2.25 2.25 0 019 5.291m0 0a2.25 2.25 0 001.969.923c1.153 0 2.243-.096 3.222-.261m3.222.261M15 5.291L15 3H9v2.291" /></svg>
                                                Hapus
                                            </button>
                                        ` : `
                                            <button type="button" class="add-btn text-sm font-medium text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600 rounded-lg px-3 py-1.5 flex items-center" data-id="${item.set_instrumen_unit_kerja_id}" data-sasaran="${sasaran}" data-indikator="${indikator}" data-aktivitas="${groupedItem.aktivitas}" data-satuan="${item.aktivitas.satuan || ''}" data-target="${item.aktivitas.target || ''}">
                                                <svg class="w-3 h-3 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                                Jawab
                                            </button>
                                        `}
                                                        </div>
                                                    `}
                            </td>
                        `;
                        row.innerHTML = html;
                        tableBody.appendChild(row);
                    });
                }

                const currentStart = totalFilteredItems === 0 ? 0 : startIndex + 1;
                const currentEnd = endIndex;
                paginationInfo.innerHTML =
                    `Menampilkan <strong>${currentStart}</strong> hingga <strong>${currentEnd}</strong> dari <strong>${totalFilteredItems}</strong> hasil`;

                pageNumbersContainer.innerHTML = '';
                for (let i = 1; i <= totalPages; i++) {
                    const pageLink = document.createElement('li');
                    pageLink.innerHTML =
                        `<a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-200 transition-all duration-200 ${i === currentPage ? 'text-sky-600 bg-sky-50 dark:bg-gray-700 dark:text-sky-200' : ''}" data-page="${i}">${i}</a>`;
                    pageNumbersContainer.appendChild(pageLink);
                }

                prevPageBtn.classList.toggle('opacity-50', currentPage === 1);
                prevPageBtn.classList.toggle('pointer-events-none', currentPage === 1);
                nextPageBtn.classList.toggle('opacity-50', currentPage === totalPages || totalPages === 0);
                nextPageBtn.classList.toggle('pointer-events-none', currentPage === totalPages || totalPages ===
                    0);
            };

            if (auditStatus !== 1) {
                submitLockBtn.disabled = true;
                submitLockBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }

            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                searchQuery = searchInput.value.trim();
                renderTable(1);
            });

            perPageSelect.addEventListener('change', function() {
                perPage = parseInt(perPageSelect.value);
                renderTable(1);
            });

            pageNumbersContainer.addEventListener('click', function(e) {
                const pageLink = e.target.closest('a[data-page]');
                if (pageLink) {
                    e.preventDefault();
                    renderTable(parseInt(pageLink.getAttribute('data-page')));
                }
            });

            prevPageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage > 1) renderTable(currentPage - 1);
            });

            nextPageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentPage < totalPages) renderTable(currentPage + 1);
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
                const capaianInput = document.getElementById('capaian');
                const capaianError = document.getElementById('capaian-error');
                const keteranganInput = document.getElementById('keterangan'); // Tambahan
                const keteranganError = document.getElementById('keterangan-error'); // Tambahan

                if (!capaianInput.value.trim()) {
                    capaianError.textContent = 'Capaian wajib diisi';
                    capaianError.classList.remove('hidden');
                    return;
                }
                capaianError.classList.add('hidden');

                const formData = new FormData(form);
                const dataToSave = {
                    set_instrumen_unit_kerja_id: formData.get('set_instrumen_unit_kerja_id'),
                    auditing_id: formData.get('auditing_id'),
                    capaian: formData.get('capaian'),
                    lokasi_bukti_dukung: formData.get('lokasi_bukti_dukung') || '',
                    keterangan: formData.get('keterangan') || '' // Tambahan untuk keterangan
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
        Menyimpan...`;

                fetch(endpoint, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(dataToSave)
                    })
                    .then(response => {
                        if (!response.ok) return response.json().then(err => {
                            throw err;
                        });
                        return response.json();
                    })
                    .then(savedResponseData => {
                        showCustomMessage(isEdit ? 'Jawaban berhasil diperbarui!' :
                            'Jawaban berhasil disimpan!');
                        closeModal();

                        const currentAuditingId = parseInt(document.getElementById('auditing_id')
                            .value);
                        const currentSetInstrumenUnitKerjaId = parseInt(document.getElementById(
                            'set_instrumen_unit_kerja_id').value);

                        let actualResponseId;
                        if (isEdit) {
                            actualResponseId = parseInt(formData.get('response_id'));
                        } else {
                            actualResponseId = savedResponseData.data ? (savedResponseData.data.id ||
                                savedResponseData.data.response_id) : savedResponseData.id;
                            if (!actualResponseId && savedResponseData.response_id) {
                                actualResponseId = savedResponseData.response_id;
                            }
                        }

                        if (!actualResponseId) {
                            console.error(
                                'Error: Gagal mendapatkan response_id setelah menyimpan/memperbarui jawaban utama. Respons:',
                                savedResponseData);
                            showCustomMessage(
                                'Gagal mendapatkan ID jawaban untuk status instrumen. Silakan cek konsol.'
                            );
                            initializeDataAndRenderTable();
                            return;
                        }

                        const instrumentResponsePayload = {
                            auditing_id: currentAuditingId,
                            set_instrumen_unit_kerja_id: currentSetInstrumenUnitKerjaId,
                            response_id: actualResponseId,
                            status_instrumen: "Baru Ditambahkan"
                        };

                        return fetch('http://127.0.0.1:5000/api/instrumen-response', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify(instrumentResponsePayload)
                            })
                            .then(instrResp => {
                                if (!instrResp.ok) {
                                    return instrResp.json().then(err => {
                                        console.error(
                                            'Gagal mengirim data ke /api/instrumen-response:',
                                            err);
                                        throw new Error(
                                            `Gagal mengirim status instrumen: ${(err.message || JSON.stringify(err))}`
                                        );
                                    });
                                }
                                return instrResp.json();
                            })
                            .then(instrResponseData => {
                                console.log(
                                    'Status instrumen berhasil dikirim ke /api/instrumen-response:',
                                    instrResponseData);
                                initializeDataAndRenderTable();
                            })
                            .catch(instrError => {
                                console.error('Error saat mengirim status instrumen:', instrError);
                                showCustomMessage(
                                    'Jawaban utama disimpan, namun terjadi kesalahan saat mengirim status instrumen tambahan.'
                                );
                                initializeDataAndRenderTable();
                            });
                    })
                    .catch(error => {
                        const errorEl = document.getElementById('capaian-error');
                        const keteranganErrorEl = document.getElementById(
                            'keterangan-error'); // Tambahan
                        if (error.errors) {
                            if (error.errors.capaian) {
                                errorEl.textContent = error.errors.capaian.join(', ');
                                errorEl.classList.remove('hidden');
                            }
                            if (error.errors.keterangan) { // Tambahan untuk validasi keterangan
                                keteranganErrorEl.textContent = error.errors.keterangan.join(', ');
                                keteranganErrorEl.classList.remove('hidden');
                            }
                        } else {
                            showCustomMessage('Terjadi kesalahan: ' + (error.message ||
                                'Tidak dapat menyimpan jawaban'));
                        }
                        initializeDataAndRenderTable();
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Simpan';
                    });
            });

            submitLockBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (auditStatus !== 1) { // Pemeriksaan status yang ketat
                    showCustomMessage(
                        'Penguncian jawaban hanya diperbolehkan pada status "Pengisian Instrumen".',
                        'error');
                    return;
                }
                showCustomConfirm(
                    'Apakah Anda yakin ingin mengunci jawaban? Tindakan ini tidak dapat dibatalkan.', (
                        confirmed) => {
                        if (confirmed) {
                            const originalButtonHtml = submitLockBtn
                                .innerHTML; // Simpan HTML asli tombol
                            submitLockBtn.disabled = true;
                            submitLockBtn.innerHTML = `
                                <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Mengunci...
                            `;

                            fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        status: 2
                                    }) // Mengunci, status menjadi 2
                                })
                                .then(response => {
                                    if (!response.ok) return response.json().then(err => {
                                        throw err;
                                    });
                                    return response.json();
                                })
                                .then(() => {
                                    auditStatus =
                                        2; // Update status di client-side untuk konsistensi UI langsung
                                    showCustomMessage('Jawaban berhasil dikunci!', 'success');
                                    // Update UI secara langsung
                                    renderTable(
                                        currentPage); // Re-render tabel dengan status terkunci
                                    submitLockBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                    submitLockBtn.innerHTML =
                                        originalButtonHtml; // Kembalikan HTML asli setelah proses (meski sudah disabled)

                                    // Update pesan informasi di atas
                                    const infoMessageDiv = document.querySelector(
                                        '.border-yellow-400');
                                    if (infoMessageDiv && infoMessageDiv.querySelector(
                                            'span.block')) {
                                        infoMessageDiv.querySelector('span.block').innerHTML =
                                            'Halaman ini hanya dapat diakses untuk melihat data. Jawaban telah dikunci.';
                                    }


                                    setTimeout(() => {
                                        window.location.href =
                                            `/auditee/audit/detail/${auditingId}`; // Redirect ke halaman detail auditing setelah 2 detik
                                    }, 2000); // Delay 2 detik agar user sempat baca pesan
                                })
                                .catch(error => {
                                    console.error('Gagal mengunci jawaban:', error);
                                    showCustomMessage(
                                        `Gagal mengunci jawaban: ${error.message || 'Silakan coba lagi.'}`,
                                        'error');
                                    submitLockBtn.disabled = false; // Aktifkan kembali jika gagal
                                    submitLockBtn.innerHTML =
                                        originalButtonHtml; // Kembalikan HTML/teks asli tombol
                                });
                        }
                    });
            });

            // Panggil fungsi inisialisasi
            initializeDataAndRenderTable();
        });
    </script>
@endsection
