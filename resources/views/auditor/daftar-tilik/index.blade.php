@extends('layouts.app')

@section('title', 'Pertanyaan Daftar Tilik')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditor.audit.index')],
            ['label' => 'Buat Pertanyaan Daftar Tilik'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Pertanyaan Daftar Tilik
        </h1>

        <div class="mb-6 flex gap-2">
            <x-button href="{{ route('auditor.daftar-tilik.create') }}" color="sky" icon="heroicon-o-plus">
                Tambah Pertanyaan
            </x-button>
        </div>

        <!-- Table and Pagination -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <!-- Table Controls -->
            <div
                class="flex flex-col items-center justify-between gap-4 rounded-t-2xl border-b border-gray-200 bg-white p-4 sm:flex-row dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <form action="#" method="GET">
                        <select name="per_page"
                            class="w-18 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                            onchange="this.form.submit()">
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
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" placeholder="Cari" value=""
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-500 dark:text-gray-400">
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
                                Standar Nasional / POLINES</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Uraian Isian</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Akar
                                Penyebab (Target tidak Tercapai)/Akar Penunjang(Target tercapai)</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Rencana Perbaikan & Tindak Lanjut'25</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tilik-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Baris data akan ditambahkan via JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>1</strong> hingga <strong>2</strong> dari <strong>1000</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul class="inline-flex -space-x-px text-sm">
                            <li>
                                <a href="#"
                                    class="flex h-8 cursor-not-allowed items-center justify-center rounded-l-lg border border-gray-300 bg-white px-3 leading-tight text-gray-500 opacity-50 transition-all duration-200 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    <x-heroicon-s-chevron-left class="mr-1 h-4 w-4" />
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center justify-center border border-sky-300 bg-sky-50 px-3 leading-tight text-sky-800 transition-all duration-200 dark:border-sky-700 dark:bg-sky-900 dark:text-sky-200">
                                    1
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center justify-center border border-gray-300 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    2
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center justify-center rounded-r-lg border border-gray-300 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    <x-heroicon-s-chevron-right class="ml-1 h-4 w-4" />
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
                Kunci Pertanyaan
            </x-button>
            @elseif (session('status') == 5)
            <x-button id="complete-revision-btn" type="button" color="sky" icon="heroicon-o-check">
                Selesai Koreksi
            </x-button>
            @endif
        </div>
    </div>

    <!-- Pass route to JavaScript -->
    <script>
        window.App = {
            routes: {
                editTilik: '{{ route("auditor.daftar-tilik.edit", ":id") }}'
            }
        };
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
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

            const auditingId = {{ session('auditing_id') ?? 'null' }};
            const auditStatus = {{ session('status') ?? 'null' }};
            const tbody = document.getElementById('tilik-table-body');
            tbody.innerHTML = ''; // Clear existing rows

            // Fetch tilik data
            fetch('http://127.0.0.1:5000/api/tilik')
                .then(response => response.json())
                .then(tilikResult => {
                    if (!tilikResult.success || !Array.isArray(tilikResult.data)) {
                        console.error("Gagal mendapatkan data tilik.");
                        return;
                    }

                    // Fetch response-tilik data if auditingId is valid
                    const responsePromise = auditingId && auditingId !== 'null'
                        ? fetch(`http://127.0.0.1:5000/api/response-tilik/auditing/${auditingId}`)
                            .then(response => response.json())
                            .catch(error => {
                                console.error("Error fetching response-tilik data:", error);
                                return { success: false, data: [] };
                            })
                        : Promise.resolve({ success: true, data: [] });

                    responsePromise.then(responseResult => {
                        // Create a lookup for response-tilik data by tilik_id
                        const responseMap = {};
                        if (responseResult.success && Array.isArray(responseResult.data)) {
                            responseResult.data.forEach(item => {
                                responseMap[item.tilik_id] = {
                                    response_tilik_id: item.response_tilik_id,
                                    realisasi: item.realisasi ?? '-',
                                    standar_nasional: item.standar_nasional ?? '-',
                                    uraian_isian: item.uraian_isian ?? '-',
                                    akar_penyebab_penunjang: item.akar_penyebab_penunjang ?? '-',
                                    rencana_perbaikan_tindak_lanjut: item.rencana_perbaikan_tindak_lanjut ?? '-'
                                };
                            });
                        }

                        // Render table rows
                        tilikResult.data.forEach((item, index) => {
                            const row = document.createElement('tr');
                            row.className = "transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700";

                            // Resolve kriteria name or fallback to kriteria_id
                            const kriteriaName = kriteriaMap[item.kriteria_id] || item.kriteria_id;

                            // Get response data for this tilik_id, if available
                            const response = responseMap[item.tilik_id] || {
                                response_tilik_id: null,
                                realisasi: '-',
                                standar_nasional: '-',
                                uraian_isian: '-',
                                akar_penyebab_penunjang: '-',
                                rencana_perbaikan_tindak_lanjut: '-'
                            };

                            row.innerHTML = `
                                <td class="px-4 py-3 sm:px-6">${index + 1}</td>
                                <td class="px-4 py-3 sm:px-6">${kriteriaName}</td>
                                <td class="px-4 py-3 sm:px-6">${item.pertanyaan}</td>
                                <td class="px-4 py-3 sm:px-6">${item.indikator ?? '-'}</td>
                                <td class="px-4 py-3 sm:px-6">${item.sumber_data ?? '-'}</td>
                                <td class="px-4 py-3 sm:px-6">${item.metode_perhitungan ?? '-'}</td>
                                <td class="px-4 py-3 sm:px-6">${item.target ?? '-'}</td>
                                <td class="px-4 py-3 sm:px-6">${response.realisasi}</td>
                                <td class="px-4 py-3 sm:px-6">${response.standar_nasional}</td>
                                <td class="px-4 py-3 sm:px-6">${response.uraian_isian}</td>
                                <td class="px-4 py-3 sm:px-6">${response.akar_penyebab_penunjang}</td>
                                <td class="px-4 py-3 sm:px-6">${response.rencana_perbaikan_tindak_lanjut}</td>
                                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">
                                    ${auditStatus !== 3 ? `
                                        <span class="text-gray-500 dark:text-gray-400">Belum sampai proses ini</span>
                                    ` : `
                                        <div class="flex items-center gap-2 justify-center">
                                            <a href="/auditor/daftar-tilik/${item.tilik_id}/edit" class="text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-200 transition-colors duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"></path>
                                                </svg>
                                            </a>
                                            <button data-id="${item.tilik_id}" class="delete-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a2 2 0 00-2 2v1h8V5a2 2 0 00-2-2zm-3 4h6"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    `}
                                </td>
                            `;
                            tbody.appendChild(row);
                        });

                        // Add event listeners for delete buttons
                        document.querySelectorAll('.delete-btn').forEach(button => {
                            button.addEventListener('click', function () {
                                const tilikId = this.getAttribute('data-id');
                                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                                    fetch(`http://127.0.0.1:5000/api/tilik/${tilikId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                    })
                                    .then(response => response.json())
                                    .then(result => {
                                        if (result.success) {
                                            alert('Data berhasil dihapus!');
                                            location.reload();
                                        } else {
                                            alert('Gagal menghapus data: ' + (result.message || 'Unknown error'));
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error deleting tilik data:', error);
                                        alert('Terjadi kesalahan saat menghapus data.');
                                    });
                                }
                            });
                        });

                        const backBtn = document.getElementById('back-btn');
                            if (backBtn) {
                                backBtn.addEventListener('click', function () {
                                    window.location.href = "{{ route('auditor.audit.index') }}";
                                });
                            }

                        // Add event listener for "Kunci Pertanyaan" button (status 3)
                        const completeCorrectionBtn = document.getElementById('complete-correction-btn');
                        if (completeCorrectionBtn && auditingId && auditingId !== 'null' && auditStatus == 3) {
                            completeCorrectionBtn.addEventListener('click', function () {
                                if (confirm('Apakah Anda yakin ingin mengunci pertanyaan?')) {
                                    fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({ status: 4 }),
                                    })
                                    .then(response => response.json())
                                    .then(result => {
                                        if (result.success) {
                                            alert('Pertanyaan berhasil dikunci!');
                                            completeCorrectionBtn.disabled = true;
                                            completeCorrectionBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                            window.location.href = "{{ route('auditor.audit.index') }}";
                                        } else {
                                            alert('Gagal mengunci pertanyaan: ' + (result.message || 'Unknown error'));
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error updating audit status:', error);
                                        alert('Terjadi kesalahan saat mengunci pertanyaan.');
                                    });
                                }
                            });
                        }

                        // Add event listener for "Selesai Koreksi" button (status 5)
                        const completeRevisionBtn = document.getElementById('complete-revision-btn');
                        if (completeRevisionBtn && auditingId && auditingId !== 'null' && auditStatus == 5) {
                            completeRevisionBtn.addEventListener('click', function () {
                                if (confirm('Apakah Anda yakin ingin menyelesaikan koreksi?')) {
                                    fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({ status: 6 }),
                                    })
                                    .then(response => response.json())
                                    .then(result => {
                                        if (result.success) {
                                            alert('Koreksi berhasil diselesaikan!');
                                            completeCorrectionBtn.disabled = true;
                                            completeCorrectionBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                            window.location.href = "{{ route('auditor.audit.index') }}";
                                        } else {
                                            alert('Gagal menyelesaikan koreksi: ' + (result.message || 'Unknown error'));
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error updating audit status:', error);
                                        alert('Terjadi kesalahan saat menyelesaikan koreksi.');
                                    });
                                }
                            });
                        }
                    });
                })
                .catch(error => {
                    console.error("Error fetching tilik data:", error);
                });
        });
    </script>
@endsection