@extends('layouts.app')

@section('title', 'Auditee AMI - Daftar Audit')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        {{-- Komponen Breadcrumb untuk navigasi --}}
        <x-breadcrumb :items="[
            [
                'label' => 'Dashboard',
                'url' => route('auditee.dashboard.index'),
            ],
            [
                'label' => 'Audit',
                'url' => route('auditee.audit.index'),
            ],
        ]" />

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl dark:text-gray-200">
                Audit Mutu Internal (AMI)
            </h1>
        </div>

        {{-- Toast notification --}}
        @if (session('error'))
            <x-toast id="toast-error" type="danger" :message="session('error')" />
        @endif
        @if (session('success'))
            <x-toast id="toast-success" type="success" :message="session('success')" />
        @endif

        <div id="periode-container"
            class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                {{-- Informasi Nama dan Tanggal --}}
                <div class="flex items-center gap-x-3">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-sky-100 text-sky-600 dark:bg-sky-800 dark:text-sky-300">
                        <x-heroicon-o-calendar-days class="h-6 w-6" />
                    </div>
                    <div>
                        <h2 id="periode-name" class="font-bold text-gray-800 dark:text-gray-200">
                            Memuat periode...
                        </h2>
                        <p id="periode-date-range" class="text-sm text-gray-500 dark:text-gray-400">
                            Memuat tanggal...
                        </p>
                    </div>
                </div>
                {{-- Status Periode --}}
                <div class="mt-3 sm:mt-0">
                    <span id="periode-status-badge"
                        class="inline-flex items-center gap-x-1.5 rounded-full px-3 py-1 text-xs font-medium">
                        Memuat status...
                    </span>
                </div>
            </div>
        </div>


        <div class="mb-10">
            <div class="overflow-x-auto rounded-xl bg-white shadow-md dark:bg-gray-800">
                <table id="jadwalAuditTable"
                    class="w-full border-collapse border border-gray-200 text-left text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
                    {{-- THEAD TETAP SAMA --}}
                    <thead
                        class="border-b border-gray-200 bg-gray-100 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">No</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Unit
                                Kerja</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Waktu
                                Audit</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Auditee
                            </th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Auditee
                                2</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Auditor
                                1</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Auditor
                                2</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Status
                            </th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- Pesan loading awal --}}
                        <tr>
                            <td colspan="9"
                                class="border border-gray-200 py-6 text-center text-gray-500 dark:border-gray-700 dark:text-gray-400">
                                <div class="flex items-center justify-center">
                                    <svg class="-ml-1 mr-3 h-5 w-5 animate-spin text-blue-500"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Memuat data audit...
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            // Elemen UI Periode
            const periodeContainer = document.getElementById("periode-container");
            const periodeNameElem = document.getElementById("periode-name");
            const periodeDateRangeElem = document.getElementById("periode-date-range");
            const periodeStatusBadgeElem = document.getElementById("periode-status-badge");

            // Elemen Tabel
            const tableBody = document.getElementById("tableBody");
            const progressDetailBaseUrl =
                "{{ route('auditee.audit.progress-detail', ['auditingId' => 'PLACEHOLDER_ID']) }}";

            // Fungsi untuk memformat tanggal
            const formatDate = (dateString) => {
                if (!dateString) return '';
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            };

            try {
                const response = await fetch("{{ route('auditee.auditings') }}");
                if (!response.ok) {
                    throw new Error(`Gagal mengambil data: ${response.status}`);
                }
                const result = await response.json();

                // Filter data untuk mendapatkan audit dengan status "Sedang Berjalan"
                const activeAudits = result.data.filter(item => {
                    // Filter berdasarkan status periode "Sedang Berjalan"
                    return item.periode?.status === "Sedang Berjalan";
                });

                // Logika untuk menampilkan informasi periode dan data tabel
                if (activeAudits.length === 0) {
                    // Tidak ada periode aktif
                    periodeNameElem.textContent = 'Tidak Ada Periode Aktif';
                    periodeDateRangeElem.textContent =
                        'Saat ini tidak ada jadwal audit yang sedang berlangsung.';
                    periodeStatusBadgeElem.textContent = 'Tidak Aktif';
                    periodeStatusBadgeElem.className =
                        'inline-flex items-center gap-x-1.5 rounded-full px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                    tableBody.innerHTML =
                        `<tr><td colspan="9" class="py-6 text-center text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">Tidak ada data audit untuk periode yang sedang berjalan.</td></tr>`;
                    return;
                }

                // Ada periode aktif, tampilkan informasi
                const activePeriode = activeAudits[0].periode;
                periodeNameElem.textContent = activePeriode.nama_periode;
                periodeDateRangeElem.textContent =
                    `${formatDate(activePeriode.tanggal_mulai)} - ${formatDate(activePeriode.tanggal_berakhir)}`;
                periodeStatusBadgeElem.textContent = 'Sedang Berjalan';
                periodeStatusBadgeElem.className =
                    'inline-flex items-center gap-x-1.5 rounded-full px-3 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-400';

                // Kosongkan tabel dan isi dengan data
                tableBody.innerHTML = "";

                const statusMap = {
                    1: {
                        label: 'Pengisian Instrumen',
                        color: 'bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300'
                    },
                    2: {
                        label: 'Penjadwalan AL',
                        color: 'bg-sky-100 dark:bg-sky-800 text-sky-700 dark:text-sky-300'
                    },
                    3: {
                        label: 'Dijadwalkan AL',
                        color: 'bg-sky-100 dark:bg-sky-800 text-sky-700 dark:text-sky-300'
                    },
                    4: {
                        label: 'Desk Evaluation',
                        color: 'bg-yellow-100 dark:bg-yellow-800 text-yellow-700 dark:text-yellow-300'
                    },
                    5: {
                        label: 'Pertanyaan Tilik',
                        color: 'bg-yellow-100 dark:bg-yellow-800 text-yellow-700 dark:text-yellow-300'
                    },
                    6: {
                        label: 'Tilik Dijawab',
                        color: 'bg-amber-100 dark:bg-amber-800 text-amber-700 dark:text-amber-300'
                    },
                    7: {
                        label: 'Laporan Temuan',
                        color: 'bg-orange-100 dark:bg-orange-800 text-orange-700 dark:text-orange-300'
                    },
                    8: {
                        label: 'Revisi Auditee',
                        color: 'bg-rose-100 dark:bg-rose-800 text-rose-700 dark:text-rose-300'
                    },
                    9: {
                        label: 'Sudah Revisi',
                        color: 'bg-pink-100 dark:bg-pink-800 text-pink-700 dark:text-pink-300'
                    },
                    10: {
                        label: 'Closing',
                        color: 'bg-teal-100 dark:bg-teal-800 text-teal-700 dark:text-teal-300'
                    },
                    11: {
                        label: 'Selesai',
                        color: 'bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300'
                    }
                };

                activeAudits.forEach((item, index) => {
                    const statusInfo = statusMap[parseInt(item.status)] || {
                        label: `Status ${item.status || 'N/A'}`,
                        color: 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300'
                    };
                    const auditingIdForItem = item.auditing_id ?? item.id;
                    const detailUrl = progressDetailBaseUrl.replace('PLACEHOLDER_ID',
                    auditingIdForItem);

                    const rowHTML = `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                        <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">${index + 1}</td>
                        <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${item.unit_kerja?.nama_unit_kerja ?? 'N/A'}</td>
                        <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${formatDate(item.jadwal_audit) || 'Belum diatur'}</td>
                        <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${item.auditee1?.nama ?? 'N/A'}</td>
                        <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${item.auditee2?.nama ?? '-'}</td>
                        <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${item.auditor1?.nama ?? 'N/A'}</td>
                        <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${item.auditor2?.nama ?? '-'}</td>
                        <td class="px-4 py-3 sm:px-6 text-center border border-gray-200 dark:border-gray-700">
                            <span class="${statusInfo.color} inline-flex rounded-full px-3 py-1 text-xs font-semibold leading-tight">${statusInfo.label}</span>
                        </td>
                        <td class="px-4 py-3 sm:px-6 whitespace-nowrap text-center border border-gray-200 dark:border-gray-700">
                            <a href="${detailUrl}" class="text-sm font-medium rounded-lg px-4 py-2 flex items-center justify-center transition-all duration-200 text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600" title="Lihat detail progress audit">
                                Lihat Progress
                            </a>
                        </td>
                    </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', rowHTML);
                });

            } catch (err) {
                console.error("Terjadi kesalahan:", err);
                periodeNameElem.textContent = 'Gagal Memuat Informasi';
                periodeDateRangeElem.textContent = 'Terjadi kesalahan saat menghubungi server.';
                periodeStatusBadgeElem.textContent = 'Error';
                periodeStatusBadgeElem.className =
                    'inline-flex items-center gap-x-1.5 rounded-full px-3 py-1 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-400';
                tableBody.innerHTML =
                    `<tr><td colspan="9" class="py-6 text-center text-red-500 dark:text-red-400 border border-gray-200 dark:border-gray-700">Gagal memuat data audit. ${err.message}</td></tr>`;
            }
        });
    </script>
@endsection
