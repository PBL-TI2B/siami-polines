@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Laporan', 'url' => route('admin.laporan.index')],
    ]" />


<!-- Heading -->
<h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
    Laporan
</h1>

<div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <!-- Filter controls -->
    <div class="p-4 flex justify-between items-center border-b">
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-600">Show</span>
            <select class="form-select rounded-md border-gray-300 text-sm">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="text-sm text-gray-600">entries</span>
        </div>

        <div class="flex items-center">
            <div class="mr-4">
                <select class="form-select rounded-md border-gray-300 text-sm">
                    <option value="">Pilih Periode Ami</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
            <div class="relative">
                <input type="text" placeholder="Search" class="form-input rounded-md border-gray-300 pl-10 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

     <!-- Table and Pagination -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                <tr>
                    <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                        <div class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                        No
                    </th>
                    <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                        Nama Unit
                    </th>
                    <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                        Tanggal Mulai
                    </th>
                    <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                        Tanggal Berakhir
                    </th>
                    <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                        Status AMI
                    </th>
                    <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        1
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        Teknik Elektro
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        1 Januari 2024
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        1 Mei 2024
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-md bg-green-100 text-green-800">
                            Berakhir
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 text-xs text-white bg-blue-600 rounded-md flex items-center justify-center">
                                @svg('heroicon-o-eye', 'h-4 w-4 mr-1')
                                Lihat
                            </button>
                            <button class="px-3 py-1 text-xs text-white bg-yellow-500 rounded-md flex items-center justify-center">
                                 @svg('heroicon-o-arrow-down-tray', 'h-4 w-4 mr-1')
                                 Unduh
                            </button>
                            <button class="px-3 py-1 text-xs text-white bg-red-500 rounded-md flex items-center justify-center">
                                @svg('heroicon-o-trash', 'h-4 w-4 mr-1')
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        2
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        Teknologi Rekayasa Komputer
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        4 Januari 2025
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        5 Mei 2025
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-md bg-blue-100 text-blue-800">
                            Sedang Berjalan
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div class="flex space-x-2">
                            <button class="px-3 py-1 text-xs text-white bg-blue-600 rounded-md flex items-center justify-center">
                                @svg('heroicon-o-eye', 'h-4 w-4 mr-1')
                                Lihat
                            </button>
                            <button class="px-3 py-1 text-xs text-white bg-yellow-500 rounded-md flex items-center justify-center">
                                @svg('heroicon-o-arrow-down-tray', 'h-4 w-4 mr-1')
                                Unduh
                            </button>
                            <button class="px-3 py-1 text-xs text-white bg-red-500 rounded-md flex items-center justify-center">
                                @svg('heroicon-o-trash', 'h-4 w-4 mr-1')
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 bg-white border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Showing 1 to 5 of 5 results
            </div>
        </div>
    </div>
</div>


</div>
@endsection

@push('styles')

<style>
    /* Additional custom styles if needed */
</style>

@endpush

@push('scripts')

<script>
    // Additional scripts if needed
</script>

@endpush
