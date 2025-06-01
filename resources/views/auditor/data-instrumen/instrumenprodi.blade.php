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
        <div class="flex gap-4 mt-8">
            <x-button id="back-btn" type="button" color="red" icon="heroicon-o-arrow-left">
                Kembali
            </x-button>
            @if (session('status') == 2)
            <x-button id="complete-correction-btn" type="button" color="sky" icon="heroicon-o-check">
                Koreksi Selesai
            </x-button>
            @elseif (session('status') == 7)
            <x-button id="complete-revision-btn" type="button" color="sky" icon="heroicon-o-check">
                Koreksi Revisi Selesai
            </x-button>
            @endif
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Fetch both set-instrumen and responses data
    const auditingId = {{ session('auditing_id') ?? 'null' }}; // Fallback to null if undefined
    const auditStatus = {{ session('status') ?? 1 }}; // Default to 1 if undefined

    if (!auditingId) {
        const tableBody = document.getElementById('instrumen-table-body');
        tableBody.innerHTML = `
            <tr>
                <td colspan="11" class="px-4 py-3 sm:px-6 text-center text-red-500">
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
        fetch(`http://127.0.0.1:5000/api/responses/auditing/${auditingId}`).then(res => {
            if (!res.ok) throw new Error('Gagal mengambil data responses');
            return res.json();
        }).catch(() => ({ data: [] })) // Return empty data array if responses fetch fails
    ])
        .then(([instrumenResult, responseResult]) => {
            const instrumenData = instrumenResult.data || [];
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
                        <td colspan="11" class="px-4 py-3 sm:px-6 text-center text-red-500">
                            Tidak ada data instrumen tersedia.
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

                            // Response columns
                            html += `
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
                    }
                }
                index++;
            }

            // Handle "Kembali" button click
            const backBtn = document.getElementById('back-btn');
            if (backBtn) {
                backBtn.addEventListener('click', function () {
                    window.location.href = "{{ route('auditor.audit.index') }}";
                });
            }

            // Handle "Koreksi Selesai" button click (only if auditStatus is 2)
            if (auditStatus === 2) {
                const completeCorrectionBtn = document.getElementById('complete-correction-btn');
                if (completeCorrectionBtn) {
                    completeCorrectionBtn.addEventListener('click', function () {
                        if (confirm('Apakah Anda yakin ingin menyelesaikan koreksi? Tindakan ini tidak dapat dibatalkan.')) {
                            fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ status: 3 })
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Gagal menyelesaikan koreksi');
                                    }
                                    return response.json();
                                })
                                .then(result => {
                                    alert('Koreksi berhasil diselesaikan!');
                                    completeCorrectionBtn.disabled = true;
                                    completeCorrectionBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                    window.location.href = "{{ route('auditor.audit.index') }}";

                                })
                                .catch(error => {
                                    console.error('Gagal menyelesaikan koreksi:', error);
                                    alert('Gagal menyelesaikan koreksi. Silakan coba lagi.');
                                });
                        }
                    });
                }
            }

            // Handle "Koreksi Revisi Selesai" button click (only if auditStatus is 7)
            if (auditStatus === 7) {
                const completeRevisionBtn = document.getElementById('complete-revision-btn');
                if (completeRevisionBtn) {
                    completeRevisionBtn.addEventListener('click', function () {
                        if (confirm('Apakah Anda yakin ingin menyelesaikan koreksi revisi? Tindakan ini tidak dapat dibatalkan.')) {
                            fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ status: 8 })
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Gagal menyelesaikan koreksi revisi');
                                    }
                                    return response.json();
                                })
                                .then(result => {
                                    alert('Koreksi revisi berhasil diselesaikan!');
                                    completeRevisionBtn.disabled = true;
                                    completeRevisionBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                    window.location.href = "{{ route('auditor.audit.index') }}";
                                })
                                .catch(error => {
                                    console.error('Gagal menyelesaikan koreksi revisi:', error);
                                    alert('Gagal menyelesaikan koreksi revisi. Silakan coba lagi.');
                                });
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Gagal mengambil data instrumen:', error);
            const tableBody = document.getElementById('instrumen-table-body');
            tableBody.innerHTML = `
                <tr>
                    <td colspan="11" class="px-4 py-3 sm:px-6 text-center text-red-500">
                        Gagal memuat data instrumen. Silakan coba lagi.
                    </td>
                </tr>
            `;
        });
});
</script>
@endsection