@extends('layouts.app') {{-- Pastikan ini sesuai dengan nama layout utama Anda --}}

@section('title', 'Auditee AMI - Daftar Audit')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        {{-- Komponen Breadcrumb untuk navigasi --}}
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')], /* Pastikan route 'auditee.dashboard.index' valid */
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],      /* Pastikan route 'auditee.audit.index' valid */
        ]" />

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl dark:text-gray-200">
                Audit Mutu Internal (AMI)
            </h1>
        </div>

        {{-- Tampilan periode audit aktif --}}
        <div class="mb-4 flex">
            <div id="periodeDisplayContainer" class="flex items-center gap-x-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Periode:</span>
                <div class="inline-flex items-center gap-x-2 rounded-2xl bg-sky-100 px-3 py-1.5 text-xs sm:text-sm dark:bg-sky-800">
                    <x-heroicon-o-calendar-days class="h-4 w-4 shrink-0 text-sky-600 sm:h-5 sm:w-5 dark:text-sky-300" />
                    <span id="dynamicPeriodeName" class="font-semibold text-sky-600 dark:text-sky-300">
                        Memuat periode...
                    </span>
                </div>
            </div>
        </div>

        {{-- Menampilkan pesan error dari session (jika ada) --}}
        @if (session('error'))
            <div class="mb-6 rounded-md bg-red-100 p-4 dark:bg-red-900/30">
                <div class="flex">
                    <div class="shrink-0">
                        <x-heroicon-s-x-circle class="h-5 w-5 text-red-500 dark:text-red-400" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="mb-10">
            <div class="overflow-x-auto rounded-lg bg-white shadow-md dark:bg-gray-800">
                {{-- Modifikasi di sini: tambahkan kelas border, border-collapse, dan warna border --}}
                <table id="jadwalAuditTable" class="w-full text-left text-sm text-gray-500 dark:text-gray-400 border-collapse border border-gray-200 dark:border-gray-700">
                    <thead class="border-b border-gray-200 bg-gray-100 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200">
                        <tr>
                            {{-- Modifikasi di sini: tambahkan kelas border dan warna border pada setiap th --}}
                            <th scope="col" class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">No</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">Unit Kerja</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">Waktu Audit</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">Auditee</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">Auditee 2</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">Auditor 1</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">Auditor 2</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">Status</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- Pesan loading awal, akan diganti oleh JavaScript --}}
                        <tr>
                            <td colspan="9" class="py-6 text-center text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-center">
                                    <svg class="-ml-1 mr-3 h-5 w-5 animate-spin text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
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
            const tableBody = document.getElementById("tableBody");
            const dynamicPeriodeNameElem = document.getElementById("dynamicPeriodeName");

            const progressDetailBaseUrl = "{{ route('auditee.audit.progress-detail', ['auditingId' => 'PLACEHOLDER_ID']) }}";

            try {
                const response = await fetch("{{ route('auditee.auditings') }}");

                if (!response.ok) {
                    let errorBody = "Tidak ada detail tambahan dari server.";
                    try { errorBody = await response.text(); } catch (e) { /* Abaikan jika parsing error body gagal */ }
                    throw new Error(`HTTP error! Status: ${response.status}. Pesan Server: ${errorBody}`);
                }
                const result = await response.json();

                if (!result.data || !Array.isArray(result.data) || result.data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="9" class="py-6 text-center text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">${'Tidak ada data audit untuk periode ini.'}</td></tr>`; // Tambahkan border juga di sini
                    dynamicPeriodeNameElem.textContent = 'Belum ada periode';
                    return;
                }

                const audits = result.data;
                const periodeNama = audits[0].periode?.nama_periode ?? 'Tidak Diketahui';
                dynamicPeriodeNameElem.textContent = periodeNama;
                tableBody.innerHTML = "";

                const statusMap = {
                    1: { label: 'Pengisian Instrumen', color: 'bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300' },
                    2: { label: 'Desk Evaluation', color: 'bg-sky-100 dark:bg-sky-800 text-sky-700 dark:text-sky-300' },
                    3: { label: 'Penjadwalan AL', color: 'bg-sky-100 dark:bg-sky-800 text-sky-700 dark:text-sky-300' },
                    4: { label: 'Dijadwalkan AL', color: 'bg-yellow-100 dark:bg-yellow-800 text-yellow-700 dark:text-yellow-300' },
                    5: { label: 'Pertanyaan Tilik', color: 'bg-yellow-100 dark:bg-yellow-800 text-yellow-700 dark:text-yellow-300' },
                    6: { label: 'Tilik Dijawab', color: 'bg-amber-100 dark:bg-amber-800 text-amber-700 dark:text-amber-300' },
                    7: { label: 'Laporan Temuan', color: 'bg-orange-100 dark:bg-orange-800 text-orange-700 dark:text-orange-300' },
                    8: { label: 'Revisi Auditee', color: 'bg-rose-100 dark:bg-rose-800 text-rose-700 dark:text-rose-300' },
                    9: { label: 'Sudah Revisi', color: 'bg-pink-100 dark:bg-pink-800 text-pink-700 dark:text-pink-300' },
                    10: { label: 'Closing', color: 'bg-teal-100 dark:bg-teal-800 text-teal-700 dark:text-teal-300' },
                    11: { label: 'Selesai', color: 'bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300' }
                };

                audits.forEach((item, index) => {
                    const statusAudit = parseInt(item.status);
                    const statusInfo = statusMap[statusAudit] || {
                        label: `Status ${item.status || 'N/A'}`,
                        color: 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300'
                    };

                    const waktuAuditFormatted = item.jadwal_audit
                        ? new Date(item.jadwal_audit).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })
                        : 'Belum diatur';

                    const unitKerjaNama = item.unit_kerja?.nama_unit_kerja ?? 'N/A';
                    const auditingIdForItem = item.auditing_id ?? item.id;

                    let detailUrl = '#';
                    if (typeof auditingIdForItem !== 'undefined' && auditingIdForItem !== null) {
                        detailUrl = progressDetailBaseUrl.replace('PLACEHOLDER_ID', auditingIdForItem);
                    }

                    const buttonClasses = "text-sm font-medium rounded-lg px-4 py-2 flex items-center justify-center transition-all duration-200 text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600";
                    const disabledButtonClasses = "opacity-50 cursor-not-allowed";

                    // Modifikasi di sini: tambahkan kelas border dan warna border pada setiap td
                    const rowHTML = `
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">${index + 1}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${unitKerjaNama}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${waktuAuditFormatted}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${item.auditee1?.nama ?? 'N/A'}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${item.auditee2?.nama ?? '-'}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${item.auditor1?.nama ?? 'N/A'}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${item.auditor2?.nama ?? '-'}</td>
                            <td class="px-4 py-3 sm:px-6 text-center border border-gray-200 dark:border-gray-700">
                                <span class="${statusInfo.color} inline-flex rounded-full px-3 py-1 text-xs font-semibold leading-tight">
                                    ${statusInfo.label}
                                </span>
                            </td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap text-center border border-gray-200 dark:border-gray-700">
                                <a href="${detailUrl}"
                                   class="${buttonClasses} ${(typeof auditingIdForItem === 'undefined' || auditingIdForItem === null) ? disabledButtonClasses : ''}"
                                   ${(typeof auditingIdForItem === 'undefined' || auditingIdForItem === null) ? 'onclick="return false;" aria-disabled="true"' : ''}>
                                    Lihat Progress
                                </a>
                            </td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', rowHTML);
                });

            } catch (err) {
                console.error("Terjadi kesalahan saat memuat atau memproses data audit:", err);
                // Tambahkan border juga di sini
                tableBody.innerHTML = `<tr><td colspan="9" class="py-6 text-center text-red-500 dark:text-red-400 border border-gray-200 dark:border-gray-700">Gagal memuat data audit. ${err.message}</td></tr>`;
                dynamicPeriodeNameElem.textContent = 'Gagal dimuat';
            }
        });
    </script>
@endsection
