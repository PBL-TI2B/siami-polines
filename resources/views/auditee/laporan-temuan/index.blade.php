@extends('layouts.app')

@section('title', 'Laporan Temuan Audit')

@push('style')
    {{-- Pastikan Flowbite dan komponen lainnya sudah ter-load di layout utama --}}
@endpush

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            // ['label' => 'Progress', 'url' => route('auditee.audit.progress-detail')],
            ['label' => 'Laporan Temuan'],
        ]" class="mb-6" />

        <div class="mb-6 flex flex-col items-start justify-between gap-y-4 sm:flex-row sm:items-center">
            {{-- Heading --}}
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200">
                    Laporan Temuan Audit
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Berikut adalah laporan semua temuan hasil audit yang ditujukan untuk unit Anda.
                </p>
            </div>

            {{-- Action Button --}}
            <div class="flex-shrink-0">
                <x-button href="{{ route('auditee.laporan-temuan.download-ptpp', ['auditing' => $audit['auditing_id']]) }}"
                    color="green">
                    <x-heroicon-o-arrow-down-tray class="mr-2 h-5 w-5" />
                    <span>Download PTPP</span>
                </x-button>
            </div>
        </div>


        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            <div
                class="flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div
                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 dark:bg-sky-900 dark:text-sky-300">
                    <x-heroicon-o-building-office-2 class="h-6 w-6" />
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Unit Kerja/Jurusan/Prodi</h3>
                    <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                        {{ $audit['unit_kerja']['nama_unit_kerja'] ?? '-' }}
                    </p>
                </div>
            </div>
            <div
                class="flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div
                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 dark:bg-sky-900 dark:text-sky-300">
                    <x-heroicon-o-user-group class="h-6 w-6" />
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Auditor</h3>
                    <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                        {{ $audit['auditor1']['nama'] ?? '-' }}
                    </p>
                    <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                        {{ $audit['auditor2']['nama'] ?? '-' }}
                    </p>
                </div>
            </div>
            <div
                class="flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div
                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 dark:bg-sky-900 dark:text-sky-300">
                    <x-heroicon-o-user class="h-6 w-6" />
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Auditee</h3>
                    <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                        {{ $audit['auditee1']['nama'] ?? '-' }}
                    </p>
                    <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                        {{ $audit['auditee2']['nama'] ?? '-' }}
                    </p>

                </div>
            </div>
        </div>


        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-gray-200 p-4 dark:border-gray-700">
                <form id="filter-form" method="GET" action="#">
                    <div class="flex flex-wrap items-center justify-center gap-4 md:justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                            <select id="perPageSelect" name="per_page"
                                class="w-20 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <span class="text-sm text-gray-700 dark:text-gray-300">data</span>
                        </div>

                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <select name="status"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 sm:w-auto dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                <option value="">Semua Status</option>
                                <option value="menunggu" selected>Menunggu Tindak Lanjut</option>
                                <option value="diverifikasi">Sudah Diverifikasi</option>
                                <option value="selesai">Selesai</option>
                            </select>
                            <div class="relative w-full sm:w-64">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-500 dark:text-gray-400" />
                                </div>
                                <input type="search" name="search" id="search-input"
                                    placeholder="Cari Standar atau Temuan" value=""
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead
                        class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">No
                            </th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">
                                Standar</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">
                                Uraian Temuan</th>
                            <th scope="col"
                                class="border-r border-gray-200 px-4 py-3 text-center sm:px-6 dark:border-gray-700">Kategori
                            </th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">
                                Tanggal Perbaikan</th>
                            <th scope="col"
                                class="border-r border-gray-200 px-4 py-3 text-center sm:px-6 dark:border-gray-700">Status
                            </th>
                            <th scope="col" class="px-4 py-3 text-center sm:px-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr class="transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td
                                class="border-r border-gray-200 px-4 py-3 text-center align-middle sm:px-6 dark:border-gray-700">
                                1</td>
                            <td
                                class="whitespace-nowrap border-r border-gray-200 px-4 py-3 align-middle font-medium text-gray-900 sm:px-6 dark:border-gray-700 dark:text-white">
                                STD/SPMI/01 - Penerimaan Mahasiswa Baru</td>
                            <td class="border-r border-gray-200 px-4 py-3 align-middle sm:px-6 dark:border-gray-700">
                                Ditemukan bahwa beberapa dokumen persyaratan calon mahasiswa tidak terverifikasi dengan
                                benar sesuai dengan standar yang telah ditetapkan.</td>
                            <td
                                class="whitespace-nowrap border-r border-gray-200 px-4 py-3 text-center align-middle sm:px-6 dark:border-gray-700">
                                <span
                                    class="rounded-md bg-red-100 px-2.5 py-1 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">NC</span>
                            </td>
                            <td class="border-r border-gray-200 px-4 py-3 align-middle sm:px-6 dark:border-gray-700">30 Jun
                                2025</td>
                            <td
                                class="whitespace-nowrap border-r border-gray-200 px-4 py-3 text-center align-middle sm:px-6 dark:border-gray-700">
                                <span
                                    class="inline-flex items-center rounded-full bg-orange-100 px-2.5 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/20 dark:bg-orange-900 dark:text-orange-200">Menunggu
                                    Tindak Lanjut</span>
                            </td>
                            <td class="px-4 py-3 text-center align-middle sm:px-6">
                                <a href="{{ route('auditee.laporan-temuan.tindak-lanjut', ['id' => 1]) }}"
                                    class="flex items-center justify-center rounded-lg bg-sky-800 px-3 py-1.5 text-xs font-medium text-white transition-all duration-200 hover:bg-sky-900 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600">
                                    Tindak Lanjut
                                </a>
                            </td>
                        </tr>
                        <tr class="transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="border-r border-gray-200 px-4 py-3 align-middle sm:px-6 dark:border-gray-700">2</td>
                            <td
                                class="whitespace-nowrap border-r border-gray-200 px-4 py-3 align-middle font-medium text-gray-900 sm:px-6 dark:border-gray-700 dark:text-white">
                                STD/SPMI/05 - Pelaksanaan UAS</td>
                            <td class="border-r border-gray-200 px-4 py-3 align-middle sm:px-6 dark:border-gray-700">Jadwal
                                ujian yang diterbitkan tidak sinkron dengan kalender akademik, menyebabkan kebingungan di
                                kalangan mahasiswa dan dosen.</td>
                            <td
                                class="whitespace-nowrap border-r border-gray-200 px-4 py-3 text-center align-middle sm:px-6 dark:border-gray-700">
                                <span
                                    class="rounded-md bg-yellow-100 px-2.5 py-1 text-xs font-medium text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">AOC</span>
                            </td>
                            <td class="border-r border-gray-200 px-4 py-3 align-middle sm:px-6 dark:border-gray-700">05 Jun
                                2025</td>
                            <td
                                class="whitespace-nowrap border-r border-gray-200 px-4 py-3 text-center align-middle sm:px-6 dark:border-gray-700">
                                <span
                                    class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-900 dark:text-blue-200">Diverifikasi</span>
                            </td>
                            <td class="px-4 py-3 text-center align-middle sm:px-6">
                                <a href="#"
                                    class="flex items-center justify-center rounded-lg bg-gray-200 px-3 py-1.5 text-xs font-medium text-gray-900 transition-all duration-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:focus:ring-gray-600">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                        <tr class="transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="border-r border-gray-200 px-4 py-3 align-middle sm:px-6 dark:border-gray-700">3</td>
                            <td
                                class="whitespace-nowrap border-r border-gray-200 px-4 py-3 align-middle font-medium text-gray-900 sm:px-6 dark:border-gray-700 dark:text-white">
                                STD/SPMI/12 - Sarana & Prasarana</td>
                            <td class="border-r border-gray-200 px-4 py-3 align-middle sm:px-6 dark:border-gray-700">
                                Beberapa peralatan laboratorium ditemukan belum dikalibrasi sesuai jadwal yang seharusnya.
                            </td>
                            <td
                                class="whitespace-nowrap border-r border-gray-200 px-4 py-3 text-center align-middle sm:px-6 dark:border-gray-700">
                                <span
                                    class="rounded-md bg-sky-100 px-2.5 py-1 text-xs font-medium text-sky-800 dark:bg-sky-900 dark:text-sky-300">OFI</span>
                            </td>
                            <td class="border-r border-gray-200 px-4 py-3 align-middle sm:px-6 dark:border-gray-700">25 Apr
                                2025</td>
                            <td
                                class="whitespace-nowrap border-r border-gray-200 px-4 py-3 text-center align-middle sm:px-6 dark:border-gray-700">
                                <span
                                    class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-900 dark:text-green-200">Selesai</span>
                            </td>
                            <td class="px-4 py-3 text-center align-middle sm:px-6">
                                <a href="#"
                                    class="flex items-center justify-center rounded-lg bg-gray-200 px-3 py-1.5 text-xs font-medium text-gray-900 transition-all duration-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:focus:ring-gray-600">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 p-4 dark:border-gray-700">
                <div class="flex flex-col items-center justify-center gap-4 md:flex-row md:justify-between">
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>1</strong> hingga <strong>3</strong> dari <strong>3</strong> data
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul class="inline-flex -space-x-px text-sm">
                            <li>
                                <span
                                    class="ml-0 flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-l-lg border border-gray-300 bg-white leading-tight text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                    <x-heroicon-o-chevron-left class="h-4 w-4" />
                                </span>
                            </li>
                            <li>
                                <span aria-current="page"
                                    class="z-10 flex h-8 w-8 items-center justify-center border border-sky-300 bg-sky-50 leading-tight text-sky-600 dark:border-sky-700 dark:bg-sky-800 dark:text-sky-200">1</span>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 w-8 items-center justify-center border border-gray-300 bg-white leading-tight text-gray-500 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                                    2
                                </a>
                            <li>
                                <span
                                    class="flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-r-lg border border-gray-300 bg-white leading-tight text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                    <x-heroicon-o-chevron-right class="h-4 w-4" />
                                </span>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
