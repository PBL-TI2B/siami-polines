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
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Keterangan</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Lokasi Bukti Dukung</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Sesuai</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Tidak Sesuai (Minor)</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Tidak Sesuai (Mayor)</th>
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">OFI (Saran Tindak Lanjut)</th>
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
                        {{-- Keterangan --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                            {{ $item['status_instrumen'] ?? '-' }}
                        </td>
                        {{-- Lokasi Bukti Dukung --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                            <a href="{{ $item['response']['lokasi_bukti_dukung'] ?? '-' }}" target="_blank">{{ $item['response']['lokasi_bukti_dukung'] ?? '-' }}</a>
                        </td>
                        {{-- Sesuai --}}
                        <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600 text-center">
                            @if(isset($item['response']['sesuai']))
                            @if($item['response']['sesuai'] == "1")
                            <span class="text-green-600 font-bold">&#10003;</span>
                            @elseif($item['response']['sesuai'] == "0")
                            <span class="text-red-600 font-bold">&#10007;</span>
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
                            <span class="text-green-600 font-bold">&#10003;</span>
                            @elseif($item['response']['minor'] == "0")
                            <span class="text-red-600 font-bold">&#10007;</span>
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
                            <span class="text-green-600 font-bold">&#10003;</span>
                            @elseif($item['response']['mayor'] == "0")
                            <span class="text-red-600 font-bold">&#10007;</span>
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
                            <span class="text-green-600 font-bold">&#10003;</span>
                            @elseif($item['response']['ofi'] == "0")
                            <span class="text-red-600 font-bold">&#10007;</span>
                            @else
                            {{ $item['response']['ofi'] }}
                            @endif
                            @else
                            -
                            @endif
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
        <button class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-gray-300 text-sm font-medium rounded-lg px-4 py-2 flex items-center transition-all duration-200">
            Selesai
        </button>
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
                    <!-- Modal footer -->
                    <div class="flex items-center justify-end space-x-3 rounded-b border-t border-gray-200 p-5 dark:border-gray-700">
                        <button type="button" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-600" data-modal-hide="editResponseModal">
                            Batal
                        </button>
                        <button type="submit" class="rounded-lg bg-sky-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
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
                alert('Data berhasil diperbarui!');
                // Sembunyikan modal menggunakan Flowbite
                const modal = document.getElementById('editResponseModal');
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
                window.location.reload();
            } else {
                alert(`Gagal memperbarui data: ${result.message}`);
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

            document.getElementById('response_id').value = responseId;
            document.getElementById('audit_id').value = auditId;
            document.getElementById('minor_1').checked = minor === "1";
            document.getElementById('mayor_1').checked = mayor === "1";
            document.getElementById('ofi_1').checked = ofi === "1";
            document.getElementById('sesuai_1').checked = sesuai === "1";
        });
    });
    // Tangani submit form
    document.getElementById('editResponseForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const responseId = formData.get('response_id');
        const data = {
            auditing_id: formData.get('audit_id'),
            minor: formData.get('minor') || null,
            mayor: formData.get('mayor') || null,
            ofi: formData.get('ofi') || null,
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
                alert('Data berhasil diperbarui!');
                // Sembunyikan modal menggunakan Flowbite
                const modal = document.getElementById('editResponseModal');
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
                window.location.reload();
            } else {
                alert(`Gagal memperbarui data: ${result.message}`);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan data.');
        }
    });
</script>
@endsection