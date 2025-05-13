@extends('layouts.app')

@section('title', 'Daftar Tilik')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
            ['label' => 'Daftar Tilik', 'url' => route('auditor.daftar-tilik.index')],
        ]" />

        <!-- Heading -->
        <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Daftar Tilik
        </h1>

        <div class="mb-6 flex gap-2">
            <x-button href="{{ route('auditor.daftar-tilik.create') }}" color="sky" icon="heroicon-o-plus">
                Tambah Pertanyaan
            </x-button>

            <x-button href="{{ route('unit-kerja.create', ['type' => 'upt']) }}" color="sky" icon="heroicon-o-plus">
                Edit Pertanyaan
            </x-button>
            <x-button type="submit" color="sky" icon="heroicon-o-document-arrow-down">
                Unduh Data
            </x-button>
            <x-button type="submit" color="yellow" icon="heroicon-o-document-arrow-up">
                Import Data
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
                                Standar Nasional POLINES</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Uraian Isian</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Akar
                                Penyebab (Target tidak Tercapai)/Akar Penunjang(Target tercapai)</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Rencana Perbaikan & Tindak Lanjut'25</th>

                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr class="transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 sm:px-6">1</td>
                            <td class="px-4 py-3 sm:px-6">1</td>
                            <td class="px-4 py-3 sm:px-6">Apakah visi yang mencerminkan visi perguruan tinggi dan memayungi
                                visi keilmuan terkait keunikan program studi serta didukung data implementasi yang konsisten
                            </td>
                            <td class="px-4 py-3 sm:px-6">
                                <li>LAM Emba</li>
                                <li>LAM Infokom</li>
                                <li>LAM Teknik</li>
                            </td>
                        </tr>
                        <tr class="transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 sm:px-6">2</td>
                            <td class="px-4 py-3 sm:px-6">1</td>
                            <td class="px-4 py-3 sm:px-6">Apakah misi, tujuan, dan strategi yang searah dan strategi
                                perguruan tinggi serta mendukung pengembangan program studi dengan data implementasi yang
                                konsisten </td>
                            <td class="px-4 py-3 sm:px-6">
                                <li>LAM Emba</li>
                                <li>LAM Infokom</li>
                                <li>LAM Teknik</li>
                            </td>
                        </tr>
                        <tr class="transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 sm:px-6">3</td>
                            <td class="px-4 py-3 sm:px-6">2</td>
                            <td class="px-4 py-3 sm:px-6">
                                <li>1. Apakah sudah ada struktur organisasi yg jelas untuk UPPS ?</li>
                                <li>2. Apakah sudah ada tupoksi yang jelas dari Unit Pengelola Program Studi?</li>
                                <li>3. Apakah sudah ada pedoman ataupun kode etik bagi UPPS ?</li>
                            </td>
                            <td class="px-4 py-3 sm:px-6">Unit Pengelola Program Studi mendeskripsikan proses, struktur dan
                                tradisi dalam menjalankan tugas dan menggunakan wewenangnya untuk mengemban misi, mewujudkan
                                visi dan mencapai tujuan serta sasaran strategisnya yang didukung perilaku etis dan
                                berintegritas para pengelola, tenaga kependidikan, mahasiswa dan mitra Unit Pengelola
                                Program Studi.</td>
                            <td class="px-4 py-3 sm:px-6">Statuta dan SOTK SK UPPS dan Tupoksi</td>
                        </tr>
                        <tr class="transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 sm:px-6">4</td>
                            <td class="px-4 py-3 sm:px-6">2</td>
                            <td class="px-4 py-3 sm:px-6">
                                <li>1. Apakah sudah ada pedoman jelas pembuatan laporan kinerja UPPS?</li>
                                <li>2. Apakah kinerja UPPS memenuhi kriteria 5 pilar sistim tata pamong?</li>
                            </td>
                            <td class="px-4 py-3 sm:px-6">Unit Pengelola Program Studi mendeskripsikan peran, tanggung
                                jawab, wewenang dan proses pengambilan keputusan untuk pencapaian efektivitas organisasi
                                berdasarkan visi, misi, tujuan dan strategi serta menggunakan lima pilar sistem tata pamong,
                                yang mencakup: kredibel, transparan, akuntabel, bertanggung jawab dan adil.</td>
                            <td class="px-4 py-3 sm:px-6">Lakin UPPS</td>
                        </tr>
                        <tr class="transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 sm:px-6">5</td>
                            <td class="px-4 py-3 sm:px-6">2</td>
                            <td class="px-4 py-3 sm:px-6">
                                <li>1. Bagaimanakah program kerja UPPS ?</li>
                                <li>2. Apakah ada tindak lanjut dari hasil survey kepuasan pelanggan?</li>
                                <li>3. Apakah Unit Pengelola Program Studi secara periodik melakukan survey kepuasan
                                    pelanggan?</li>
                            </td>
                            <td class="px-4 py-3 sm:px-6">Unit Pengelola Program Studi mendeskripsikan peran, tanggung
                                jawab, wewenang dan proses pengambilan keputusan untuk pencapaian efektivitas organisasi
                                berdasarkan visi, misi, tujuan dan strategi serta menggunakan lima pilar sistem tata pamong,
                                yang mencakup: kredibel, transparan, akuntabel, bertanggung jawab dan adil.</td>
                            <td class="px-4 py-3 sm:px-6">Renop UPPS</td>
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
