@extends('layouts.app')

@section('title', 'Riwayat Audit')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
            ['label' => 'Riwayat Audit', 'url' => route('auditor.riwayat-audit.index')],
        ]" />

        <!-- Heading -->
        <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Riwayat Audit
        </h1>

        <!-- Info Periode Terpilih & Filter -->
        <div id="periode-info-container" class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <!-- Info Detail -->
                <div class="flex items-center gap-x-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-800 dark:text-blue-300">
                        <x-heroicon-o-archive-box class="h-6 w-6" />
                    </div>
                    <div>
                        <h2 id="periode-info-name" class="font-bold text-gray-800 dark:text-gray-200">
                            Memuat riwayat...
                        </h2>
                        <p id="periode-info-date-range" class="text-sm text-gray-500 dark:text-gray-400">
                           Pilih periode dari daftar untuk melihat detail.
                        </p>
                    </div>
                </div>
                <!-- Dropdown Filter -->
                <div class="w-full sm:w-auto sm:max-w-xs">
                    <label for="periode-select" class="sr-only">Pilih Periode Riwayat</label>
                    <select id="periode-select" class="mr-16 block w-full rounded-xl border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                        <option selected>Memuat periode...</option>
                    </select>
                </div>
            </div>
        </div>


        <!-- Tabel Riwayat Audit -->
        <div class="mb-10">
            <div class="overflow-x-auto rounded-xl bg-white shadow-md dark:bg-gray-800">
                <table id="riwayatAuditTable"
                    class="w-full border-collapse border border-gray-200 text-left text-sm text-gray-500 dark:border-gray-700 dark:text-gray-400">
                    <thead
                        class="border-b border-gray-200 bg-gray-100 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">No</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Unit Kerja</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Waktu Audit</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Auditee</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Auditee 2</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Auditor 1</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Auditor 2</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Status</th>
                            <th scope="col" class="border border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <td colspan="9"
                                class="border border-gray-200 py-6 text-center text-gray-500 dark:border-gray-700 dark:text-gray-400">
                                <div class="flex items-center justify-center">
                                    <svg class="-ml-1 mr-3 h-5 w-5 animate-spin text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memuat riwayat audit...
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
            // Elemen UI
            const periodeSelect = document.getElementById("periode-select");
            const periodeInfoName = document.getElementById("periode-info-name");
            const periodeInfoDateRange = document.getElementById("periode-info-date-range");
            const tableBody = document.getElementById("tableBody");
            const progressDetailBaseUrl = "{{ route('auditor.audit.audit', ['id' => 'PLACEHOLDER_ID']) }}";
            let allAuditsData = [];
            let pastPeriodeMap = new Map();

            // Fungsi Bantuan untuk format tanggal
            const formatDate = (dateString) => {
                if (!dateString) return '';
                return new Date(dateString).toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });
            };

            // Fungsi untuk merender tabel berdasarkan periodeId yang dipilih
            const renderTableForPeriode = (periodeId) => {
                const selectedPeriode = pastPeriodeMap.get(parseInt(periodeId));
                if (selectedPeriode) {
                    periodeInfoName.textContent = selectedPeriode.nama_periode;
                    periodeInfoDateRange.textContent = `Berakhir pada: ${formatDate(selectedPeriode.tanggal_berakhir)}`;
                }

                tableBody.innerHTML = "";
                const filteredAudits = allAuditsData.filter(audit => audit.periode_id == periodeId);

                if (filteredAudits.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="9" class="py-6 text-center text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">Tidak ada data audit untuk periode ini.</td></tr>`;
                    return;
                }

                // PERUBAHAN: Status map disesuaikan dengan halaman progress
                const statusMap = {
                    10: { label: 'Closing', color: 'bg-teal-100 dark:bg-teal-800 text-teal-700 dark:text-teal-300' },
                    11: { label: 'Selesai', color: 'bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300' },
                };

                filteredAudits.forEach((item, index) => {
                    const statusInfo = statusMap[parseInt(item.status)] || {
                        label: `Telah Berakhir`, // Fallback yang lebih baik
                        color: 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300'
                    };
                    const auditingIdForItem = item.auditing_id ?? item.id;
                    const detailUrl = progressDetailBaseUrl.replace('PLACEHOLDER_ID', auditingIdForItem);

                    const rowHTML = `
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-700">${index + 1}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${item.unit_kerja?.nama_unit_kerja ?? 'N/A'}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap border border-gray-200 dark:border-gray-700">${formatDate(item.jadwal_audit) || 'N/A'}</td>
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
            };

            // Logika Utama
            try {
                const response = await fetch("{{ route('auditor.auditings') }}");
                if (!response.ok) throw new Error(`Gagal mengambil data: ${response.status}`);
                const result = await response.json();
                allAuditsData = (result.data || []).filter(item => item.periode?.status === 'Berakhir');

                const now = new Date();
                now.setHours(0, 0, 0, 0);

                allAuditsData.forEach(item => {
                    if (item.periode?.tanggal_berakhir) {
                        const endDate = new Date(item.periode.tanggal_berakhir);
                        if (endDate < now && !pastPeriodeMap.has(item.periode.periode_id)) {
                            pastPeriodeMap.set(item.periode.periode_id, item.periode);
                        }
                    }
                });

                periodeSelect.innerHTML = "";
                if (pastPeriodeMap.size === 0) {
                    periodeSelect.innerHTML = `<option>Tidak ada riwayat</option>`;
                    periodeInfoName.textContent = 'Tidak Ada Riwayat';
                    periodeInfoDateRange.textContent = 'Belum ada periode audit yang selesai.';
                    tableBody.innerHTML = `<tr><td colspan="9" class="py-6 text-center text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-700">Tidak ada riwayat audit yang ditemukan.</td></tr>`;
                    return;
                }

                pastPeriodeMap.forEach(periode => {
                    const option = document.createElement('option');
                    option.value = periode.periode_id;
                    option.textContent = periode.nama_periode;
                    periodeSelect.appendChild(option);
                });

                periodeSelect.addEventListener('change', (e) => {
                    renderTableForPeriode(e.target.value);
                });

                const initialPeriodeId = pastPeriodeMap.keys().next().value;
                if (initialPeriodeId) {
                    renderTableForPeriode(initialPeriodeId);
                }

            } catch (err) {
                console.error("Terjadi kesalahan:", err);
                tableBody.innerHTML = `<tr><td colspan="9" class="py-6 text-center text-red-500 dark:text-red-400 border border-gray-200 dark:border-gray-700">Gagal memuat data riwayat. ${err.message}</td></tr>`;
                periodeInfoName.textContent = 'Gagal Memuat';
                periodeInfoDateRange.textContent = 'Terjadi kesalahan saat mengambil data.';
                periodeSelect.innerHTML = `<option>Error</option>`;
            }
        });
    </script>
@endsection
