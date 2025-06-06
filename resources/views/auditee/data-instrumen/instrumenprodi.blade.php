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
                        <select name="per_page" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200" onchange="this.form.submit()">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </form>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                </div>
                <div class="relative w-full sm:w-auto">
                    <form action="#" method="GET">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" placeholder="Cari" value="" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
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
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>1</strong> hingga <strong>2</strong> dari <strong>1000</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul class="inline-flex -space-x-px text-sm">
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
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 border hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">
                                    2
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
        <div>
            <x-button id="submit-lock-btn" type="submit" color="sky" icon="heroicon-o-plus" class="mt-8">
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch both set-instrumen and responses data
        const auditingId = {{ session('auditing_id') ?? 'null' }}; // Fallback to null if undefined
        const auditStatus = {{ session('status') ?? 1 }}; // Get audit status, default to 1 if undefined

        // Check if auditingId is valid
        if (!auditingId) {
            const tableBody = document.getElementById('instrumen-table-body');
            tableBody.innerHTML = `
                <tr>
                    <td colspan="12" class="px-4 py-3 sm:px-6 text-center text-red-500">
                        ID auditing tidak tersedia. Silakan coba lagi.
                    </td>
                </tr>
            `;
            return;
        }

        Promise.all([
            fetch('http://127.0.0.1:5000/api/set-instrumen').then(res => {
                if (!res.ok) throw new Error('Gagal mengambil data set-instrumen');
                return res.json();
            }),
            fetch(`http://127.0.0.1:5000/api/responses/auditing/${auditingId}`)
                .then(res => {
                    if (!res.ok) throw new Error('Gagal mengambil data responses');
                    return res.json();
                })
                .catch(() => ({ data: [] })) // Return empty data array if responses fetch fails
        ])
            .then(([instrumenResult, responseResult]) => {
                const instrumenData = (instrumenResult.data || []).filter(item => item.jenis_unit_id === 3);
                const responseData = responseResult.data || [];

                // Create a map of responses by set_instrumen_unit_kerja_id
                const responseMap = {};
                responseData.forEach(response => {
                    responseMap[response.set_instrumen_unit_kerja_id] = response;
                });

                const tableBody = document.getElementById('instrumen-table-body');
                let index = 1; // Nomor urut berdasarkan standar

                // If no instrumen data, show empty message
                if (!instrumenData.length) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="12" class="px-4 py-3 sm:px-6 text-center text-red-500">
                                Tidak ada data instrumen tersedia untuk Prodi.
                            </td>
                        </tr>
                    `;
                    return;
                }

                const grouped = {};
                const rowspanStandar = {};

                // Group instrumen data
                instrumenData.forEach(item => {
                    const standar = item.unsur?.deskripsi?.kriteria?.nama_kriteria || 'Tidak Diketahui';
                    const deskripsi = item.unsur?.deskripsi?.isi_deskripsi || 'Tidak Diketahui';
                    const unsur = item.unsur?.isi_unsur || 'Tidak Diketahui';

                    if (!grouped[standar]) {
                        grouped[standar] = {};
                        rowspanStandar[standar] = 0;
                    }
                    if (!grouped[standar][deskripsi]) {
                        grouped[standar][deskripsi] = {};
                    }
                    if (!grouped[standar][deskripsi][unsur]) {
                        grouped[standar][deskripsi][unsur] = [];
                    }

                    grouped[standar][deskripsi][unsur].push(item);
                    rowspanStandar[standar]++;
                });

                // Helper function to render checklist
                const renderChecklist = (value) => {
                    return value === '1' ? `
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    ` : '-';
                };

                // Iterate through grouped data
                for (const standar in grouped) {
                    let standarDisplayed = false;
                    let nomorDisplayed = false;

                    const totalRowsForStandar = Object.values(grouped[standar])
                        .map(desc => Object.values(desc).reduce((sum, arr) => sum + arr.length, 0))
                        .reduce((a, b) => a + b, 0);

                    for (const deskripsi in grouped[standar]) {
                        let deskripsiDisplayed = false;
                        const totalRowsForDeskripsi = Object.values(grouped[standar][deskripsi])
                            .reduce((sum, arr) => sum + arr.length, 0);

                        for (const unsur in grouped[standar][deskripsi]) {
                            let unsurDisplayed = false;
                            const items = grouped[standar][deskripsi][unsur];
                            const totalRowsForUnsur = items.length;

                            items.forEach(item => {
                                const response = responseMap[item.set_instrumen_unit_kerja_id] || {};
                                const row = document.createElement('tr');
                                let html = '';

                                // Kolom No
                                if (!nomorDisplayed) {
                                    html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForStandar}">${index}</td>`;
                                    nomorDisplayed = true;
                                }

                                // Kolom Standar
                                if (!standarDisplayed) {
                                    html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForStandar}">${standar}</td>`;
                                    standarDisplayed = true;
                                }

                                // Kolom Deskripsi
                                if (!deskripsiDisplayed) {
                                    html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForDeskripsi}">${deskripsi}</td>`;
                                    deskripsiDisplayed = true;
                                }

                                // Kolom Unsur
                                if (!unsurDisplayed) {
                                    html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForUnsur}">${unsur}</td>`;
                                    unsurDisplayed = true;
                                }

                                // Response columns with checklist
                                html += `
                                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${response.ketersediaan_standar_dan_dokumen || '-'}</td>
                                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.spt_pt)}</td>
                                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.sn_dikti)}</td>
                                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.lokal)}</td>
                                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.nasional)}</td>
                                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.internasional)}</td>
                                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${response.keterangan || '-'}</td>
                                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">
                                        ${!(auditStatus == 1 || auditStatus == 7) ? `
                                            <span class="text-gray-500 dark:text-gray-400">Jawaban Terkunci</span>
                                        ` : `
                                            <div class="flex items-center gap-2 justify-center">
                                            ${response.response_id ? `
                                                <button type="button" class="edit-response-btn text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-200"
                                                    data-id="${response.response_id}" data-set-id="${item.set_instrumen_unit_kerja_id}" title="Edit Response">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M14 4a2.5 2.5 0 113.536 3.536L6.5 21H3v-3.5L14 4z"/>
                                                        </svg>
                                                </button>
                                                <button data-id="${response.response_id}" class="delete-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5-4h4m-4 0a2 2 0 00-2 2v1h8V5a2 2 0 00-2-2z"/>
                                                        </svg>
                                                </button>
                                            ` : `
                                                <button type="button" class="tambah-response-btn text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200"
                                                    data-set-id="${item.set_instrumen_unit_kerja_id}" title="Tambah Response">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                        </svg>
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
                    }
                }
                index++;
            });

            // Handle "Submit dan Kunci Jawaban" button click
            const submitLockBtn = document.getElementById('submit-lock-btn');
            const lockConfirmModal = document.getElementById('lockConfirmModal');
            const notifModal = document.getElementById('notifModal');
            const notifTitle = document.getElementById('notifTitle');
            const notifMessage = document.getElementById('notifMessage');
            const closeNotifBtn = document.getElementById('closeNotifBtn');
            const cancelLockBtn = document.getElementById('cancelLockBtn');
            const confirmLockBtn = document.getElementById('confirmLockBtn');

            function showModal(modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            function hideModal(modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            function showNotif(title, message) {
                notifTitle.textContent = title;
                notifMessage.textContent = message;
                showModal(notifModal);
            }
            closeNotifBtn.addEventListener('click', () => hideModal(notifModal));
            if (cancelLockBtn) cancelLockBtn.addEventListener('click', () => hideModal(lockConfirmModal));

            let lockAction = null;

            if (submitLockBtn) {
                if (auditStatus != 1 && auditStatus != 7) {
                    submitLockBtn.disabled = true;
                    submitLockBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    submitLockBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        showModal(lockConfirmModal);
                        lockAction = () => {
                            // Ambil jumlah instrumen dan response dari variabel yang sudah ada
                            const totalInstrumen = document.querySelectorAll('#instrumen-table-body tr').length;
                            // Hitung response yang sudah diisi (misal: response_id ada di setiap baris)
                            const totalResponse = Array.from(document.querySelectorAll('#instrumen-table-body tr')).filter(row => {
                                // Cek jika ada tombol edit (berarti sudah ada response)
                                return row.querySelector('.edit-response-btn');
                            }).length;

                            if (totalResponse < totalInstrumen) {
                                showNotif('Peringatan', 'Anda harus mengisi semua data instrumen response sebelum mengunci jawaban.');
                                return;
                            }

                            let newStatus = auditStatus === 1 ? 2 : (auditStatus === 7 ? 8 : null);
                            if (newStatus === null) {
                                showNotif('Gagal', 'Status audit tidak valid untuk dikunci.');
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
                                    // Update all "Aksi" columns to "Jawaban Terkunci"
                                    const rows = document.querySelectorAll('#instrumen-table-body tr');
                                    rows.forEach(row => {
                                        const actionCell = row.lastElementChild;
                                        actionCell.innerHTML = `<span class="text-gray-500 dark:text-gray-400">Jawaban Terkunci</span>`;
                                        actionCell.classList.add('text-center');
                                    });
                                    submitLockBtn.disabled = true;
                                    submitLockBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                    showNotif('Berhasil', 'Jawaban berhasil dikunci!');
                                })
                                .catch(error => {
                                    console.error('Gagal mengunci jawaban:', error);
                                    showNotif('Gagal', 'Gagal mengunci jawaban. Silakan coba lagi.');
                                });
                        };
                    });
                    if (confirmLockBtn) {
                        confirmLockBtn.addEventListener('click', function () {
                            hideModal(lockConfirmModal);
                            if (typeof lockAction === 'function') lockAction();
                        });
                    }
                }
            }

        // Event listener for delete response buttons
        document.getElementById('instrumen-table-body').addEventListener('click', function (e) {
            const deleteBtn = e.target.closest('.delete-btn');
            if (deleteBtn) {
                e.preventDefault();
                const responseId = deleteBtn.getAttribute('data-id');

                if (confirm('Apakah Anda yakin ingin menghapus response ini?')) {
                    fetch(`http://127.0.0.1:5000/api/responses/${responseId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Gagal menghapus response');
                            }
                            return response.json();
                        })
                        .then(result => {
                            alert('Response berhasil dihapus!');
                            window.location.reload(); // Refresh to update table
                        })
                        .catch(error => {
                            console.error('Gagal menghapus response:', error);
                            alert('Gagal menghapus response. Silakan coba lagi.');
                        });
                }
            }
        });

        // Modal Tambah Response
        const tambahResponseModal = document.getElementById('tambahResponseModal');
        const closeTambahResponseModal = document.getElementById('closeTambahResponseModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const clearModalForm = document.getElementById('clearModalForm');
        const form = document.getElementById('modalInstrumenForm');
        const messageDiv = document.getElementById('modalResponseMessage');

        // 🔓 Open Modal Function
        function openModal(setInstrumenId, response = null) {
            form.reset(); // Kosongkan form dulu
            messageDiv.classList.add('hidden');
            document.getElementById('modal_set_instrumen_unit_kerja_id').value = setInstrumenId;

            if (response) {
                // Mode Edit
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
                // Mode Tambah
                form.setAttribute('data-mode', 'tambah');
                document.getElementById('modal_response_id').value = '';
            }

            tambahResponseModal.classList.remove('hidden');
            tambahResponseModal.classList.add('flex');
        }

        // 🔒 Close Modal
        function closeModal() {
            tambahResponseModal.classList.add('hidden');
            tambahResponseModal.classList.remove('flex');
        }

        closeTambahResponseModal.addEventListener('click', closeModal);
        closeModalBtn.addEventListener('click', closeModal);
        clearModalForm.addEventListener('click', () => form.reset());

        // 🎯 Table Action Handler (Tambah/Edit)
        document.getElementById('instrumen-table-body').addEventListener('click', function (e) {
            const addBtn = e.target.closest('.tambah-response-btn');
            const editBtn = e.target.closest('.edit-response-btn');

            if (addBtn) {
                e.preventDefault();
                const setId = addBtn.getAttribute('data-set-id');
                openModal(setId, null);
            }

            if (editBtn) {
                e.preventDefault();
                const responseId = editBtn.getAttribute('data-id');
                const setId = editBtn.getAttribute('data-set-id');

                fetch(`http://127.0.0.1:5000/api/responses/${responseId}`)
                    .then(res => res.json())
                    .then(data => openModal(setId, data.data)) // <-- gunakan data.data
                    .catch(err => {
                        alert('Gagal memuat data response');
                        console.error(err);
                    });
            }
        });

        // ✅ Submit Handler
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const mode = form.getAttribute('data-mode');
            const formData = new FormData(form);
            const payload = Object.fromEntries(formData.entries());

            // Pastikan response_id ada saat edit
            if (mode === 'edit' && !payload.response_id) {
                messageDiv.classList.remove('hidden', 'text-green-500');
                messageDiv.classList.add('text-red-500');
                messageDiv.textContent = 'Gagal: response_id tidak ditemukan.';
                return;
            }

            const url = mode === 'edit'
                ? `http://127.0.0.1:5000/api/responses/${payload.response_id}`
                : 'http://127.0.0.1:5000/api/responses';

            const method = mode === 'edit' ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
                .then(res => {
                    if (!res.ok) throw new Error('Gagal menyimpan data');
                    return res.json();
                })
                .then(result => {
                    messageDiv.classList.remove('hidden', 'text-red-500');
                    messageDiv.classList.add('text-green-500');
                    messageDiv.textContent = 'Response berhasil disimpan!';

                    // Ambil response terbaru dari result.data (atau result, tergantung API Anda)
                    const response = result.data || result;

                    // Temukan baris tabel yang sesuai dengan set_instrumen_unit_kerja_id
                    const rows = document.querySelectorAll('#instrumen-table-body tr');
                    rows.forEach(row => {
                        // Cek apakah tombol edit/tambah pada baris ini punya data-set-id yang sama
                        const editBtn = row.querySelector('.edit-response-btn');
                        const tambahBtn = row.querySelector('.tambah-response-btn');
                        const setId = editBtn?.getAttribute('data-set-id') || tambahBtn?.getAttribute('data-set-id');
                        if (setId == response.set_instrumen_unit_kerja_id) {
                            // Update kolom-kolom response pada baris ini
                            const cells = row.querySelectorAll('td');
                            // Kolom ke-5 dst: ketersediaan, spt_pt, sn_dikti, lokal, nasional, internasional, keterangan
                            cells[4].textContent = response.ketersediaan_standar_dan_dokumen || '-';
                            cells[5].innerHTML = response.spt_pt == 1 ? `<svg class="w-5 h-5 text-green-600 dark:text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>` : '-';
                            cells[6].innerHTML = response.sn_dikti == 1 ? `<svg class="w-5 h-5 text-green-600 dark:text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>` : '-';
                            cells[7].innerHTML = response.lokal == 1 ? `<svg class="w-5 h-5 text-green-600 dark:text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>` : '-';
                            cells[8].innerHTML = response.nasional == 1 ? `<svg class="w-5 h-5 text-green-600 dark:text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>` : '-';
                            cells[9].innerHTML = response.internasional == 1 ? `<svg class="w-5 h-5 text-green-600 dark:text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>` : '-';
                            cells[10].textContent = response.keterangan || '-';

                            // Update tombol aksi menjadi tombol edit & delete
                            cells[11].innerHTML = `
                                <div class="flex items-center gap-2 justify-center">
                                    <button type="button" class="edit-response-btn text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-200"
                                        data-id="${response.response_id}" data-set-id="${response.set_instrumen_unit_kerja_id}" title="Edit Response">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M14 4a2.5 2.5 0 113.536 3.536L6.5 21H3v-3.5L14 4z"/>
                                        </svg>
                                    </button>
                                    <button data-id="${response.response_id}" class="delete-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5-4h4m-4 0a2 2 0 00-2 2v1h8V5a2 2 0 00-2-2z"/>
                                        </svg>
                                    </button>
                                </div>
                            `;
                        }
                    });

                    // Tutup modal setelah update
                    tambahResponseModal.classList.add('hidden');
                    tambahResponseModal.classList.remove('flex');
                })
                .catch(err => {
                    messageDiv.classList.remove('hidden', 'text-green-500');
                    messageDiv.classList.add('text-red-500');
                    messageDiv.textContent = 'Gagal menyimpan response.';
                });
        });

        // Clear modal form
        document.getElementById('clearModalForm').addEventListener('click', function () {
            document.getElementById('modalInstrumenForm').reset();
            document.getElementById('modalResponseMessage').classList.add('hidden');
        });

        document.getElementById('closeModalBtn').addEventListener('click', function () {
            tambahResponseModal.classList.add('hidden');
            tambahResponseModal.classList.remove('flex');
        });
    });
    </script>
@endsection