@extends('layouts.app')

@section('title', 'Instrumen Jurusan')

@if (session('user'))
<meta name="user-id" content="{{ session('user')['user_id'] }}">
@endif

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => ''], ['label' => 'Instrumen Jurusan']]" />

    <!-- Heading -->
    <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-gray-200">
        Instrumen {{ $auditing->unitKerja->nama_unit_kerja ?? '-' }}
    </h1>

    <!-- Toolbar -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <!-- Filter Dropdowns (opsional, uncomment jika diperlukan) -->
        {{-- <div class="flex flex-wrap gap-2">
            <select id="unitKerjaSelect"
                class="w-40 rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                <option selected disabled>Pilih Unit</option>
            </select>
            <select id="periodeSelect"
                class="w-40 rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 text-sm text-gray-900 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                <option selected disabled>Pilih Periode AMI</option>
            </select>
        </div> --}}
    </div>

    <!-- Table and Pagination -->
    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <!-- Table Controls -->
        <div class="flex flex-col items-center justify-between gap-4 rounded-t-2xl border-b border-gray-200 bg-white p-4 sm:flex-row dark:border-gray-700 dark:bg-gray-800">
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
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">No</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Sasaran Strategis</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Indikator Kinerja</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Aktivitas</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Satuan</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Target</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Capaian</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Lokasi Bukti Dukung</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Sesuai</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Tidak Sesuai (Minor)</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Tidak Sesuai (Mayor)</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">OFI (Saran Tindak Lanjut)</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Keterangan</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Aksi</th>
                    </tr>
                </thead>
                @php
                // Hitung jumlah baris per sasaran strategis dan indikator kinerja
                $rowspanSasaran = [];
                $rowspanIndikator = [];
                foreach ($instrumenData as $item) {
                $sasaranId = $item['set_instrumen_unit_kerja']['aktivitas']['indikator_kinerja']['sasaran_strategis']['sasaran_strategis_id'] ?? null;
                $indikatorId = $item['set_instrumen_unit_kerja']['aktivitas']['indikator_kinerja']['indikator_kinerja_id'] ?? null;
                if ($sasaranId) {
                if (!isset($rowspanSasaran[$sasaranId])) $rowspanSasaran[$sasaranId] = 0;
                $rowspanSasaran[$sasaranId]++;
                }
                if ($indikatorId) {
                if (!isset($rowspanIndikator[$indikatorId])) $rowspanIndikator[$indikatorId] = 0;
                $rowspanIndikator[$indikatorId]++;
                }
                }
                $printedSasaran = [];
                $printedIndikator = [];
                @endphp
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="instrumen-jurusan-table-body">
                    @forelse ($instrumenData as $index => $item)
                    @php
                    $sasaran = $item['set_instrumen_unit_kerja']['aktivitas']['indikator_kinerja']['sasaran_strategis'] ?? [];
                    $indikator = $item['set_instrumen_unit_kerja']['aktivitas']['indikator_kinerja'] ?? [];
                    $sasaranId = $sasaran['sasaran_strategis_id'] ?? null;
                    $indikatorId = $indikator['indikator_kinerja_id'] ?? null;
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        {{-- No --}}
                        @if (!isset($printedSasaran[$sasaranId]))
                        <td rowspan="{{ $rowspanSasaran[$sasaranId] ?? 1 }}" class="whitespace-nowrap border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600 align-top">{{ $loop->iteration }}</td>
                        @php $printedSasaran[$sasaranId] = true; @endphp
                        @endif

                        {{-- Sasaran Strategis --}}
                        @if (!isset($printedSasaran['label_'.$sasaranId]))
                        <td rowspan="{{ $rowspanSasaran[$sasaranId] ?? 1 }}" class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600 align-top">
                            {{ $sasaran['nama_sasaran'] ?? '-' }}
                        </td>
                        @php $printedSasaran['label_'.$sasaranId] = true; @endphp
                        @endif

                        {{-- Indikator Kinerja --}}
                        @if (!isset($printedIndikator[$indikatorId]))
                        <td rowspan="{{ $rowspanIndikator[$indikatorId] ?? 1 }}" class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600 align-top">
                            {{ $indikator['isi_indikator_kinerja'] ?? '-' }}
                        </td>
                        @php $printedIndikator[$indikatorId] = true; @endphp
                        @endif

                        {{-- Aktivitas --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                            {{ $item['set_instrumen_unit_kerja']['aktivitas']['nama_aktivitas'] ?? '-' }}
                        </td>
                        {{-- Satuan --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                            {{ $item['set_instrumen_unit_kerja']['aktivitas']['satuan'] ?? '-' }}
                        </td>
                        {{-- Target --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                            {{ $item['set_instrumen_unit_kerja']['aktivitas']['target'] ?? '-' }}
                        </td>
                        {{-- Capaian --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                            {{ $item['response']['capaian'] ?? '-' }}
                        </td>
                        {{-- Lokasi Bukti Dukung --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                            <a href="{{ $item['response']['lokasi_bukti_dukung'] ?? '-' }}" target="_blank">{{ $item['response']['lokasi_bukti_dukung'] ?? '-' }}</a>
                        </td>
                        {{-- Sesuai --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600 text-center">
                            @if(isset($item['response']['sesuai']))
                            @if($item['response']['sesuai'] == "1")
                            <span class="text-green-600 font-bold"><x-heroicon-s-check class="h-10 w-10" /></span>
                            @elseif($item['response']['sesuai'] == "0")
                            <span class="text-red-600 font-bold"><x-heroicon-s-x-mark class="h-10 w-10" /></span>
                            @else
                            {{ $item['response']['sesuai'] }}
                            @endif
                            @else
                            -
                            @endif
                        </td>
                        {{-- Minor --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600 text-center">
                            @if(isset($item['response']['minor']))
                            @if($item['response']['minor'] == "1")
                            <span class="text-green-600 font-bold"><x-heroicon-s-check class="h-10 w-10" /></span>
                            @elseif($item['response']['minor'] == "0")
                            <span class="text-red-600 font-bold"><x-heroicon-s-x-mark class="h-10 w-10" /></span>
                            @else
                            {{ $item['response']['minor'] }}
                            @endif
                            @else
                            -
                            @endif
                        </td>
                        {{-- Mayor --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600 text-center">
                            @if(isset($item['response']['mayor']))
                            @if($item['response']['mayor'] == "1")
                            <span class="text-green-600 font-bold"><x-heroicon-s-check class="h-10 w-10" /></span>
                            @elseif($item['response']['mayor'] == "0")
                            <span class="text-red-600 font-bold"><x-heroicon-s-x-mark class="h-10 w-10" /></span>
                            @else
                            {{ $item['response']['mayor'] }}
                            @endif
                            @else
                            -
                            @endif
                        </td>
                        {{-- OFI --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600 text-center">
                            @if(isset($item['response']['ofi']))
                            @if($item['response']['ofi'] == "1")
                            <span class="text-green-600 font-bold"><x-heroicon-s-check class="h-10 w-10" /></span>
                            @elseif($item['response']['ofi'] == "0")
                            <span class="text-red-600 font-bold"><x-heroicon-s-x-mark class="h-10 w-10" /></span>
                            @else
                            {{ $item['response']['ofi'] }}
                            @endif
                            @else
                            -
                            @endif
                        </td>
                        {{-- Keterangan --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                           {{ $item['response']['keterangan'] ?? '' }}
                        </td>
                        {{-- Aksi --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                            <button type="button"
                                class="text-blue-600 hover:text-blue-800 edit-response-btn"
                                data-response-id="{{ $item['response']['response_id'] ?? '' }}"
                                data-minor="{{ $item['response']['minor'] ?? '' }}"
                                data-mayor="{{ $item['response']['mayor'] ?? '' }}"
                                data-ofi="{{ $item['response']['ofi'] ?? '' }}"
                                data-sesuai="{{ $item['response']['sesuai'] ?? '' }}"
                                data-keterangan="{{ $item['response']['keterangan'] ?? '' }}"
                                data-audit-id="{{ $auditing->auditing_id }}"
                                data-modal-target="editResponseModal"
                                data-modal-toggle="editResponseModal">
                                <x-heroicon-s-pencil-square class="h-4 w-4" />
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="14" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                            Tidak ada data yang tersedia untuk audit ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <span class="text-sm text-gray-700 dark:text-gray-300">
                    Menampilkan <strong>1</strong> hingga <strong>{{ count($instrumenData) }}</strong> dari <strong>{{ count($instrumenData) }}</strong> hasil
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
    <div class="pt-5 flex justify-end gap-5">
        @if(isset($auditing) && isset($auditing->auditing_id))
        <a href="{{ route('auditor.audit.audit', ['id' => $auditing->auditing_id]) }}"
            class="text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:ring-gray-300 text-sm font-medium rounded-lg px-4 py-2 flex items-center transition-all duration-200">
            Kembali
        </a>
        @else
        <a href="{{ route('auditor.audit.index') }}"
            class="text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:ring-gray-300 text-sm font-medium rounded-lg px-4 py-2 flex items-center transition-all duration-200">
            Kembali
        </a>
        @endif
      <!-- Tombol Selesai Audit -->
    <button id="btnSelesaiAudit" data-modal-target="confirmModal" data-modal-toggle="confirmModal" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-gray-300 text-sm font-medium rounded-lg px-4 py-2 flex items-center transition-all duration-200">
        Selesai
    </button>

    <!-- Modal Konfirmasi -->
    <div id="confirmModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Konfirmasi Selesai Koreksi 
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="confirmModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Apakah Anda yakin ingin menyelesaikan Koreksi ini?</p>
                    <div class="flex justify-end gap-4">
                        <button data-modal-hide="confirmModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Batal
                        </button>
                        <button id="confirmButton" type="button" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Selesai
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk Edit Respons (Flowbite) -->
    <div id="editResponseModal" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
        <div class="relative max-h-full w-full max-w-md">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow-lg dark:bg-gray-800">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t border-b border-gray-200 p-5 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Respons Instrumen
                    </h3>
                    <button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editResponseModal">
                        <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="editResponseForm" class="p-6 space-y-6">
                    @csrf
                    <input type="hidden" name="response_id" id="response_id">
                    <input type="hidden" name="audit_id" id="audit_id">
                    <div class="flex items-center justify-between">
                        <label for="sesuai_1" class="text-sm font-medium text-gray-900 dark:text-white">Sesuai</label>
                        <div class="flex items-center">
                            <input type="checkbox" name="sesuai" value="1" id="sesuai_1" class="form-checkbox status-checkbox w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                            <label for="sesuai_1" class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">Aktif</label>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <label for="minor_1" class="text-sm font-medium text-gray-900 dark:text-white">Tidak Sesuai (Minor)</label>
                        <div class="flex items-center">
                            <input type="checkbox" name="minor" value="1" id="minor_1" class="form-checkbox status-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                            <label for="minor_1" class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">Aktif</label>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <label for="mayor_1" class="text-sm font-medium text-gray-900 dark:text-white">Tidak Sesuai (Mayor)</label>
                        <div class="flex items-center">
                            <input type="checkbox" name="mayor" value="1" id="mayor_1" class="form-checkbox status-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                            <label for="mayor_1" class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">Aktif</label>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <label for="ofi_1" class="text-sm font-medium text-gray-900 dark:text-white">OFI (Saran Tindak Lanjut)</label>
                        <div class="flex items-center">
                            <input type="checkbox" name="ofi" value="1" id="ofi_1" class="form-checkbox status-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                            <label for="ofi_1" class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">Aktif</label>
                        </div>
                    </div>
                    <div class="flex items-start flex-col">
                        <label for="keterangan" class="text-sm font-medium text-gray-900 dark:text-white">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-text w-full h-24  bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">   </textarea>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center justify-end space-x-3 rounded-b border-t border-gray-200 p-5 dark:border-gray-700">
                        <button type="button" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-600" data-modal-hide="editResponseModal">
                            Batal
                        </button>
                        <button 
                            class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-gray-300 text-sm font-medium rounded-lg px-4 py-2 flex items-center transition-all duration-200">
                            Selesai
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
   // Fungsi untuk menampilkan toast
        function showToast(type, message) {
            const toastId = `toast-${Date.now()}`; // ID unik berdasarkan timestamp
            const toastContainer = document.createElement('div');
            toastContainer.className = 'fixed top-5 right-5 z-50 animate-slide-in-right';
            toastContainer.innerHTML = `
                <div id="${toastId}" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg dark:text-gray-400 dark:bg-gray-800 border ${type === 'success' ? 'border-green-200' : 'border-red-200'}">
                    <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 ${type === 'success' ? 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200' : 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200'} rounded-lg">
                        ${type === 'success' ? `
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                            </svg>
                            <span class="sr-only">Ikon Sukses</span>
                        ` : `
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                            </svg>
                            <span class="sr-only">Ikon Error</span>
                        `}
                    </div>
                    <div class="ms-3 text-sm font-normal text-gray-800 dark:text-gray-200">${message}</div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#${toastId}" onclick="this.closest('.animate-slide-in-right').classList.add('animate-slide-out-right'); setTimeout(() => this.closest('.animate-slide-in-right').remove(), 300);">
                        <span class="sr-only">Tutup</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            `;
            document.body.appendChild(toastContainer);

            // Otomatis menghilangkan toast setelah 5 detik
            setTimeout(() => {
                const toast = document.getElementById(toastId);
                if (toast) {
                    toast.parentElement.classList.add('animate-slide-out-right');
                    setTimeout(() => {
                        toast.parentElement.remove();
                    }, 300);
                }
            }, 2000);
        }

        // Animasi TailwindCSS untuk toast
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes slide-in-right {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slide-out-right {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            .animate-slide-in-right {
                animation: slide-in-right 0.3s ease-out;
            }
            .animate-slide-out-right {
                animation: slide-out-right 0.3s ease-in;
            }
        `;
        document.head.appendChild(style);

        document.getElementById('btnSelesaiAudit').addEventListener('click', function() {
            // Modal konfirmasi akan ditampilkan otomatis melalui data-modal-toggle
        });

        document.getElementById('confirmButton').addEventListener('click', async function() {
            const confirmModal = document.getElementById('confirmModal');
            const auditingId = {{$auditing -> auditing_id}};

            try {
                const response = await fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        status: "4"
                    }),
                });
                const result = await response.json();

                // Sembunyikan modal konfirmasi
                confirmModal.classList.add('hidden');

                if (response.ok) {
                    // Tampilkan toast sukses
                    showToast('success', 'Koreksi instrumen berhasil disimpan.');
                    // Refresh halaman setelah 3 detik untuk memberikan waktu toast terlihat
                    setTimeout(() => {
                        window.location.href = "{{ route('auditor.audit.audit', ['id' => $auditing->auditing_id]) }}";
                    }, 2000);
                } else {
                    // Tampilkan toast error
                    showToast('error', 'Gagal menyimpan koreksi instrumen: ' + (result.message || 'Unknown error'));
                }
            } catch (error) {
                // Sembunyikan modal konfirmasi
                confirmModal.classList.add('hidden');
                // Tampilkan toast error
                showToast('error', 'Terjadi kesalahan saat menyimpan koreksi.');
                console.error(error);
            }
        });
    // Tangani tombol Edit untuk membuka modal
    // Hanya boleh satu checkbox yang aktif
    document.querySelectorAll('.status-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Uncheck semua kecuali yang ini
                document.querySelectorAll('.status-checkbox').forEach(cb => {
                    if (cb !== this) cb.checked = false;
                });
            }
        });
    });

    // Saat submit, jika tidak dicentang, kirim "0"
    document.getElementById('editResponseForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const responseId = formData.get('response_id');
        const data = {
            auditing_id: formData.get('audit_id'),
            sesuai: document.getElementById('sesuai_1').checked ? "1" : "0",
            minor: document.getElementById('minor_1').checked ? "1" : "0",
            mayor: document.getElementById('mayor_1').checked ? "1" : "0",
            ofi: document.getElementById('ofi_1').checked ? "1" : "0",
            keterangan: document.getElementById('keterangan').value,
        };
        try {
            const response = await fetch(`http://127.0.0.1:5000/api/responses/${responseId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (response.ok) {
                // Sembunyikan modal menggunakan Flowbite
                const modal = document.getElementById('editResponseModal');
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
             // Tampilkan toast sukses
                    showToast('success', 'Koreksi instrumen berhasil disimpan.');
                    // Refresh halaman setelah 3 detik untuk memberikan waktu toast terlihat
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    // Tampilkan toast error
                    showToast('error', 'Gagal menyimpan response instrumen: ' + (result.message || 'Unknown error'));
                }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data.');
        }
    });

    // Isi modal saat klik edit
    document.querySelectorAll('.edit-response-btn').forEach(button => {
        button.addEventListener('click', () => {
            const responseId = button.dataset.responseId;
            const auditId = button.dataset.auditId;
            const minor = button.dataset.minor;
            const mayor = button.dataset.mayor;
            const ofi = button.dataset.ofi;
            const sesuai = button.dataset.sesuai;
            const keterangan = button.dataset.keterangan;

            document.getElementById('response_id').value = responseId;
            document.getElementById('audit_id').value = auditId;
            document.getElementById('minor_1').checked = minor === "1";
            document.getElementById('mayor_1').checked = mayor === "1";
            document.getElementById('ofi_1').checked = ofi === "1";
            document.getElementById('sesuai_1').checked = sesuai === "1";
            document.getElementById('keterangan').value = keterangan || '';
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    // Ambil semua baris data dari tbody
    const tableBody = document.querySelector('#instrumen-jurusan-table-body');
    const allRows = Array.from(tableBody.querySelectorAll('tr'));
    let pageSize = parseInt(document.querySelector('select[name="per_page"]').value) || 5;
    let currentPage = 1;
    let filteredRows = allRows;

    // Fungsi untuk merender tabel berdasarkan halaman dan filter
    function renderTable() {
        // Sembunyikan semua baris
        allRows.forEach(row => row.style.display = 'none');

        // Hitung paginasi
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / pageSize);
        if (currentPage > totalPages) currentPage = totalPages || 1;
        const start = (currentPage - 1) * pageSize;
        const end = Math.min(start + pageSize, totalRows);

        // Tampilkan baris sesuai halaman
        filteredRows.slice(start, end).forEach(row => row.style.display = '');

        // Update informasi paginasi
        const pageInfo = document.querySelector('.text-sm.text-gray-700.dark\\:text-gray-300');
        if (pageInfo) {
            pageInfo.innerHTML = `Menampilkan <strong>${start + 1}</strong> hingga <strong>${end}</strong> dari <strong>${totalRows}</strong> hasil`;
        }

        // Update tombol paginasi
        const prevButton = document.querySelector('a[aria-label="Navigasi Paginasi"] li:first-child a');
        const nextButton = document.querySelector('a[aria-label="Navigasi Paginasi"] li:last-child a');
        prevButton.classList.toggle('cursor-not-allowed', currentPage === 1);
        prevButton.classList.toggle('opacity-50', currentPage === 1);
        nextButton.classList.toggle('cursor-not-allowed', currentPage === totalPages || totalPages === 0);
        nextButton.classList.toggle('opacity-50', currentPage === totalPages || totalPages === 0);

        // Update nomor halaman aktif
        const pageLinks = document.querySelectorAll('a[aria-label="Navigasi Paginasi"] li a:not(:first-child):not(:last-child)');
        pageLinks.forEach((link, index) => {
            link.classList.toggle('bg-sky-50', index + 1 === currentPage);
            link.classList.toggle('text-sky-800', index + 1 === currentPage);
            link.classList.toggle('border-sky-300', index + 1 === currentPage);
        });
    }

    // Event listener untuk perubahan jumlah entri per halaman
    document.querySelector('select[name="per_page"]').addEventListener('change', function () {
        pageSize = parseInt(this.value);
        currentPage = 1;
        renderTable();
    });

    // Event listener untuk pencarian
    document.querySelector('input[name="search"]').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();
        filteredRows = allRows.filter(row => row.textContent.toLowerCase().includes(keyword));
        currentPage = 1;
        renderTable();
    });

    // Event listener untuk tombol paginasi
    document.querySelector('a[aria-label="Navigasi Paginasi"] li:first-child a').addEventListener('click', function (e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            renderTable();
        }
    });

    document.querySelector('a[aria-label="Navigasi Paginasi"] li:last-child a').addEventListener('click', function (e) {
        e.preventDefault();
        const totalPages = Math.ceil(filteredRows.length / pageSize);
        if (currentPage < totalPages) {
            currentPage++;
            renderTable();
        }
    });

    // Event listener untuk nomor halaman
    document.querySelectorAll('a[aria-label="Navigasi Paginasi"] li a:not(:first-child):not(:last-child)').forEach((link, index) => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            currentPage = index + 1;
            renderTable();
        });
    });

    // Inisialisasi tabel
    renderTable();
});
</script>
@endsection