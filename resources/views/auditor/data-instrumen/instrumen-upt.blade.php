@extends('layouts.app')

@section('title', 'Instrumen UPT')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
            ['label' => 'Data Instrumen UPT', 'url' => route('auditor.data-instrumen.upt')],
        ]" />

        <!-- Heading -->
        <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Instrumen UPT
        </h1>

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
                                Target 25</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Capaian 25</th>
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
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr class="transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 sm:px-6">1</td>
                            <td class="px-4 py-3 sm:px-6">Meningkatnya kualitas lulusan pendidikan tinggi</td>
                            <td class="px-4 py-3 sm:px-6">Persentase Lulusan S1 dan D4/D3/D2 yang Berhasil Mendapat
                                Pekerjaan, Melanjutkan Studi, atau Menjadi Wirausaha.</td>
                            <td class="px-4 py-3 sm:px-6">Peningkatan dan pengukuran kemampuan bahasa asing mahasiswa</td>
                            <td class="px-4 py-3 sm:px-6">%</td>
                            <td class="px-4 py-3 sm:px-6">80</td>
                            <td class="px-4 py-3 sm:px-6">75</td>
                            <td class="px-4 py-3 sm:px-6">Belum Tercapai</td>
                            <td class="px-4 py-3 sm:px-6">Tidak Sesuai</td>
                            <td class="px-4 py-3 sm:px-6">/bukti/laporan_mahasiswa_2023.pdf</td>
                            <td class="px-4 py-3 sm:px-6">Perbaikan metode pengukuran</td>
                            <td class="px-4 py-3 sm:px-6">-</td>
                            <td class="px-4 py-3 sm:px-6">Revisi dokumen</td>
                            <x-table-row-actions :actions="[
                                ['label' => 'Edit', 'color' => 'sky', 'icon' => 'heroicon-o-pencil', 'href' => '#'],
                                ['label' => 'Hapus', 'color' => 'red', 'icon' => 'heroicon-o-trash', 'href' => '#'],
                            ]" />
                        </tr>
                        <tr class="transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 sm:px-6">2</td>
                            <td class="px-4 py-3 sm:px-6">Meningkatnya tata kelola satuan kerja di lingkungan Ditjen
                                Pendidikan Vokasi</td>
                            <td class="px-4 py-3 sm:px-6">Rata-rata Nilai Kinerja Anggaran atas pelaksanaan RKA-K/L Satker
                                minimal 93</td>
                            <td class="px-4 py-3 sm:px-6">Tata Kelola: Peningkatan kuantitas layanan.</td>
                            <td class="px-4 py-3 sm:px-6">Nilai</td>
                            <td class="px-4 py-3 sm:px-6">93</td>
                            <td class="px-4 py-3 sm:px-6">95</td>
                            <td class="px-4 py-3 sm:px-6">Tercapai</td>
                            <td class="px-4 py-3 sm:px-6">Sesuai</td>
                            <td class="px-4 py-3 sm:px-6">/bukti/laporan_anggaran_2023.pdf</td>
                            <td class="px-4 py-3 sm:px-6">-</td>
                            <td class="px-4 py-3 sm:px-6">-</td>
                            <td class="px-4 py-3 sm:px-6">Lanjutkan monitoring</td>
                            <x-table-row-actions :actions="[
                                ['label' => 'Edit', 'color' => 'sky', 'icon' => 'heroicon-o-pencil', 'href' => '#'],
                                ['label' => 'Hapus', 'color' => 'red', 'icon' => 'heroicon-o-trash', 'href' => '#'],
                            ]" />
                        </tr>
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
@endsection
