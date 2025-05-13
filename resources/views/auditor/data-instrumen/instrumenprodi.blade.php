@extends('layouts.app')

@section('title', 'Data Instrumen Prodi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
            ['label' => 'Data Instrumen Prodi', 'url' => route('auditor.data-instrumen.instrumenprodi')],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Data Instrumen Prodi
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
                            {{-- <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Aksi</th> --}}
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
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('http://127.0.0.1:5000/api/set-instrumen') // Ganti URL jika perlu
        .then(response => response.json())
        .then(result => {
            const data = result.data;
            const tableBody = document.getElementById('instrumen-table-body');

            let index = 1;

            const grouped = {};
            const rowspanStandar = {};

            data.forEach(item => {
                const standar = item.unsur.deskripsi.kriteria.nama_kriteria;
                const deskripsi = item.unsur.deskripsi.isi_deskripsi;
                const unsur = item.unsur.isi_unsur;

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

            for (const standar in grouped) {
                let standarDisplayed = false;

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
                            const row = document.createElement('tr');
                            let html = `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${index++}</td>`;

                            if (!standarDisplayed) {
                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForStandar}">${standar}</td>`;
                                standarDisplayed = true;
                            }

                            if (!deskripsiDisplayed) {
                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForDeskripsi}">${deskripsi}</td>`;
                                deskripsiDisplayed = true;
                            }

                            if (!unsurDisplayed) {
                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForUnsur}">${unsur}</td>`;
                                unsurDisplayed = true;
                            }

                            // Kolom lain (kosong diisi "-")
                            for (let i = 0; i < 7; i++) {
                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">-</td>`;
                            }

                            // Kolom aksi
                            // html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">-</td>`;

                            row.innerHTML = html;
                            tableBody.appendChild(row);
                        });
                    }
                }
            }
        })
        .catch(error => {
            console.error('Gagal mengambil data:', error);
            const tableBody = document.getElementById('instrumen-table-body');
            tableBody.innerHTML = `
                <tr>
                    <td colspan="12" class="px-4 py-3 sm:px-6 text-center text-red-500">
                        Gagal memuat data. Silakan coba lagi.
                    </td>
                </tr>
            `;
        });
});
</script>
@endsection