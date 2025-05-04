@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard.index')],
            ['label' => 'Laporan', 'url' => route('laporan.index')],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Laporan
        </h1>

        <!-- Filter dan Search -->
        <div class="flex justify-between items-center mb-4">
            <div class="ml-auto">
                <select id="periodeFilter"
                    class="border border-gray-300 rounded-md px-4 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                    <option value="">Pilih Periode AMI</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
            <input type="text" placeholder="Search" class="border rounded px-3 py-1.5 w-64 ml-4" />
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">No</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Nama Unit</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Tanggal Mulai</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Tanggal Berakhir</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Status AMI</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600 dark:text-gray-300">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <td class="px-4 py-2">1</td>
                        <td class="px-4 py-2">Teknik Elektro</td>
                        <td class="px-4 py-2">1 Januari 2024</td>
                        <td class="px-4 py-2">1 Mei 2024</td>
                        <td class="px-4 py-2">
                            <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded-full">Berakhir</span>
                        </td>
                        <td class="px-4 py-2 space-x-1">
                            <a href="#" class="px-2 py-1 bg-blue-500 text-white rounded text-xs">Lihat</a>
                            <a href="#" class="px-2 py-1 bg-yellow-500 text-white rounded text-xs">Unduh</a>
                            <a href="#" class="px-2 py-1 bg-red-500 text-white rounded text-xs">Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">2</td>
                        <td class="px-4 py-2">Teknologi Rekayasa Komputer</td>
                        <td class="px-4 py-2">4 Januari 2025</td>
                        <td class="px-4 py-2">5 Mei 2025</td>
                        <td class="px-4 py-2">
                            <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2 py-1 rounded-full">Sedang Berjalan</span>
                        </td>
                        <td class="px-4 py-2 space-x-1">
                            <a href="#" class="px-2 py-1 bg-blue-500 text-white rounded text-xs">Lihat</a>
                            <a href="#" class="px-2 py-1 bg-yellow-500 text-white rounded text-xs">Unduh</a>
                            <a href="#" class="px-2 py-1 bg-red-500 text-white rounded text-xs">Hapus</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
