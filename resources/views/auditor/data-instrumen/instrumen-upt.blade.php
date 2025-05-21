@extends('layouts.app')

@section('title', 'Instrumen UPT')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => ''], ['label' => 'Instrumen UPT']]" />

        <!-- Heading -->
        <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Instrumen UPT
        </h1>

        <!-- Toolbar -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">


            <!-- Filter Dropdowns -->
            <div class="flex flex-wrap gap-2">
                <select id="unitKerjaSelect"
                    class="w-40 rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    <option selected disabled>Pilih Unit</option>
                </select>
                <select id="periodeSelect"
                    class="w-40 rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    <option selected disabled>Pilih Periode AMI</option>
                </select>
            </div>
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
                            <option value="5" selected>5</option>
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
                                Sasaran Strategis</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Indikator Kinerja</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Aktivitas</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Satuan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Target</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Capaian</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Keterangan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Sesuai</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Lokasi Bukti Dukung</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Tidak
                                Sesuai (Minor)</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Tidak
                                Sesuai (Mayor)</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">OFI
                                (Saran Tindak Lanjut)</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="instrumen-upt-table-body">
                        <!-- Data akan diisi oleh JavaScript -->
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('http://127.0.0.1:5000/api/data-instrumen')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('instrumen-table-body');
                    let rowNumber = 1;
                    let rowspanCounts = {}; // Menyimpan jumlah baris per sasaran

                    // Hitung jumlah baris per sasaran strategis
                    data.forEach(sasaran => {
                        let count = 0;
                        sasaran.indikator_kinerja.forEach(indikator => {
                            count += indikator.aktivitas.length;
                        });
                        rowspanCounts[sasaran.sasaran_strategis_id] = count;
                    });

                    // Loop melalui setiap sasaran strategis
                    data.forEach(sasaran => {
                        let isFirstRowForSasaran = true;
                        let sasaranRowspan = rowspanCounts[sasaran.sasaran_strategis_id];

                        // Loop melalui setiap indikator kinerja
                        sasaran.indikator_kinerja.forEach(indikator => {
                            let isFirstRowForIndikator = true;
                            let indikatorRowspan = indikator.aktivitas.length;

                            // Loop melalui setiap aktivitas
                            indikator.aktivitas.forEach((aktivitas, index) => {
                                const row = document.createElement('tr');
                                row.className =
                                    'hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200';

                                // Nomor hanya ditampilkan di baris pertama sasaran
                                const noCell = isFirstRowForSasaran ?
                                    `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${rowNumber}</td>` :
                                    '';

                                // Sasaran strategis hanya ditampilkan di baris pertama sasaran
                                const sasaranCell = isFirstRowForSasaran ?
                                    `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${sasaran.nama_sasaran}</td>` :
                                    '';

                                // Indikator kinerja hanya ditampilkan di baris pertama indikator
                                const indikatorCell = isFirstRowForIndikator ?
                                    `<td rowspan="${indikatorRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${indikator.isi_indikator_kinerja}</td>` :
                                    '';

                                // Aksi hanya ditampilkan di baris pertama sasaran
                                const aksiCell = isFirstRowForSasaran ?
                                    `<td rowspan="${sasaranRowspan}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                            <div class="flex items-center gap-2">
                                <a href="/admin/data-instrumen/${sasaran.sasaran_strategis_id}/edit" class="text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-200 transition-colors duration-200">
                                    <x-heroicon-o-pencil class="w-5 h-5" />
                                </a>
                                <a href="#" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors duration-200">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </a>
                            </div>
                        </td>` : '';

                                row.innerHTML = `
                        ${noCell}
                        ${sasaranCell}
                        ${indikatorCell}
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${aktivitas.nama_aktivitas}</td>
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${aktivitas.satuan}</td>
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${aktivitas.target}</td>
                        ${aksiCell}
                    `;

                                tableBody.appendChild(row);

                                isFirstRowForSasaran = false;
                                isFirstRowForIndikator = false;
                            });
                        });

                        rowNumber++;
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    const tableBody = document.getElementById('instrumen-table-body');
                    tableBody.innerHTML = `
            <tr>
                <td colspan="14" class="px-4 py-3 sm:px-6 text-center text-red-500">
                    Gagal memuat data. Silakan coba lagi.
                </td>
            </tr>
        `;
                });
        });
        // =========================== BAGIAN 2: Dropdown Unit Kerja ===========================
        fetch('http://127.0.0.1:5000/api/unit-kerja')
            .then(response => response.json())
            .then(result => {
                const data = result.data;
                const select = document.getElementById('unitKerjaSelect');

                data.forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit.unit_kerja_id;
                    option.textContent = unit.nama_unit_kerja;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Gagal memuat unit kerja:', error);
            });
        // =========================== BAGIAN 3: Dropdown Periode ===========================
        fetch('http://127.0.0.1:5000/api/periode-audits')
            .then(response => response.json())
            .then(result => {
                const data = result.data.data;
                const select = document.getElementById('periodeSelect');

                data.forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit.periode_id;
                    option.textContent = unit.nama_periode;
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Gagal memuat periode AMI:', error);
            });
    </script>
@endsection
