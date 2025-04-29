@extends('layouts.app')

@section('title', 'Instrumen UPT')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[ 
            ['label' => 'Instrumen UPT', 'url' => ''], 
            ['label' => 'List'], 
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-6">
            Instrumen UPT
        </h1>

        <!-- Toolbar -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-2">
                <x-button href="#" color="sky" icon="heroicon-o-plus" class="shadow-md hover:shadow-lg transition-all">
                    Tambah Instrumen
                </x-button>
                <x-button href="#" color="sky" icon="heroicon-o-pencil" class="shadow-md hover:shadow-lg transition-all">
                    Edit Instrumen
                </x-button>
                <x-button href="#" color="sky" icon="heroicon-o-document-arrow-down" class="shadow-md hover:shadow-lg transition-all">
                    Unduh Data
                </x-button>
                <x-button href="#" color="yellow" icon="heroicon-o-document-arrow-up" class="shadow-md hover:shadow-lg transition-all">
                    Import Data
                </x-button>
            </div>

            <!-- Filter Dropdowns -->
            <div class="flex flex-wrap gap-2">
                <select class="w-28 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Unit</option>
                    <option value="unit1">Unit 1</option>
                    <option value="unit2">Unit 2</option>
                </select>
                <select class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Periode AMI</option>
                    <option value="periode1">Periode 2023</option>
                    <option value="periode2">Periode 2024</option>
                </select>
            </div>
        </div>

        <!-- Table and Pagination -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
            <!-- Table Controls -->
            <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 rounded-t-2xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <form action="#" method="GET">
                        <select name="per_page" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200" onchange="this.form.submit()">
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
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Sasaran Strategis</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Indikator Kinerja</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                            <td class="px-4 py-3 sm:px-6">1</td>
                            <td class="px-4 py-3 sm:px-6">Meningkatnya kualitas lulusan pendidikan tinggi</td>
                            <td class="px-4 py-3 sm:px-6">Persentase Lulusan S1 dan D4/D3/D2 yang Berhasil Mendapat Pekerjaan, Melanjutkan Studi, atau Menjadi Wirausaha.</td>
                            <td class="px-4 py-3 sm:px-6">Peningkatan dan pengukuran kemampuan bahasa asing mahasiswa</td>
                        </tr>
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                            <td class="px-4 py-3 sm:px-6">2</td>
                            <td class="px-4 py-3 sm:px-6">Meningkatnya tata kelola satuan kerja di lingkungan Ditjen Pendidikan Vokasi</td>
                            <td class="px-4 py-3 sm:px-6">Rata-rata Nilai Kinerja Anggaran atas pelaksanaan RKA-K/L Satker minimal 93</td>
                            <td class="px-4 py-3 sm:px-6">Tata Kelola: Peningkatan kuantitas layanan.</td>
                        </tr>
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
@endsection