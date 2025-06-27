@extends('layouts.app')

@section('title', 'Dashboard Auditee')

@php
    $user = session('user');
@endphp

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')]]" />
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200">Dashboard</h1>
            <h1 class="py-1 text-2xl font-bold text-gray-900 dark:text-gray-200">
                Hai, {{ $user['nama'] ?? 'Auditee' }}! Selamat Datang di Dashboard Auditee!
            </h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Periode Aktif:
                <div class="inline-flex items-center gap-x-2 rounded-2xl bg-sky-100 px-3 py-1.5 text-xs sm:text-sm dark:bg-sky-800">
                    <x-heroicon-o-calendar-days class="h-4 w-4 shrink-0 text-sky-600 sm:h-5 sm:w-5 dark:text-sky-300" />
                    <span id="dynamicPeriodeName" class="font-semibold text-sky-600 dark:text-sky-300">
                        Memuat periode...
                    </span>
                </div>
            </p>
        </div>
    </div>

    <div class="mb-6" id="statusAmiBox"></div>
    
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Box 1: Status Audit 60% (3 dari 5) -->
<div class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-gray-200">Status Audit Mutu Internal</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Nama Unit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-800" id="auditTableBody">
                        
                        </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-md dark:border-slate-700 dark:bg-slate-800">
            <!-- Box 2: Jadwal AMI 40% (2 dari 5) -->
<div class="lg:col-span-1 rounded-lg border border-gray-200 bg-white p-5 shadow-md dark:border-slate-700 dark:bg-slate-800">
                Informasi Jadwal AMI
            </h2>
            <div class="divide-y divide-gray-200 dark:divide-slate-600" id="infoAmiBox">
                <div class="py-3 text-sm text-gray-600 dark:text-slate-300">
                    Memuat data...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async function () {
        const tbody = document.querySelector('#auditTableBody');
        const dynamicPeriodeNameElem = document.getElementById("dynamicPeriodeName");

        const statusMap = {
            1: { label: 'Pengisian Instrumen', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            2: { label: 'Desk Evaluation', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            3: { label: 'Penjadwalan AL', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            4: { label: 'Dijadwalkan Tilik', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            5: { label: 'Pertanyaan Tilik', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            6: { label: 'Tilik Dijawab', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            7: { label: 'Laporan Temuan', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            8: { label: 'Revisi', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            9: { label: 'Sudah Revisi', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            10: { label: 'Closing', color: 'bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-400' },
            11: { label: 'Selesai', color: 'bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-400' }
        };

        const progressValueMap = {
            1: 10, 2: 20, 3: 25, 4: 35, 5: 50, 6: 60, 7: 75, 8: 80, 9: 85, 10: 90, 11: 100
        };

        const progressColorMap = {
            1: 'bg-blue-500', 2: 'bg-sky-500', 3: 'bg-sky-500', 4: 'bg-yellow-500',
            5: 'bg-yellow-500', 6: 'bg-amber-500', 7: 'bg-amber-600',
            8: 'bg-orange-600', 9: 'bg-orange-700', 10: 'bg-teal-500', 11: 'bg-green-500'
        };

        // --- NEW: Definitions for button styling and URL ---
        // Ensure this route is defined in your web.php for auditee.audit.progress-detail
        const progressDetailBaseUrl = "{{ route('auditee.audit.progress-detail', ['auditingId' => 'PLACEHOLDER_ID']) }}";

        const buttonClasses = "text-sm font-medium rounded-lg px-4 py-2 flex items-center justify-center transition-all duration-200 text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600";
        const disabledButtonClasses = "opacity-50 cursor-not-allowed";
        // --- END NEW ---

        try {
            const response = await fetch('http://127.0.0.1:5000/api/auditings');
            const data = await response.json();

            // Tabel Status
            tbody.innerHTML = '';
            if (!Array.isArray(data) || data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data audit.</td></tr>`;
                // Set dynamic periode name even if no audit data
                if (dynamicPeriodeNameElem) {
                    dynamicPeriodeNameElem.innerText = 'Tidak ada periode aktif';
                }
                return;
            }
            data.sort((a, b) => {
    const dateA = new Date(a.periode?.tanggal_mulai ?? '2020-01-01');
    const dateB = new Date(b.periode?.tanggal_mulai ?? '2020-01-01');
    return dateB - dateA;

});
            data.forEach((item, idx) => {
                const status = item.status ?? 0;
                const statusLabel = statusMap[status]?.label ?? 'Status Tidak Diketahui';
                const statusColor = statusMap[status]?.color ?? 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400';
                const progress = progressValueMap[status] ?? 0;
                const progressBarColor = progressColorMap[status] ?? 'bg-gray-500';

                // --- NEW: Constructing the detail URL and button state ---
                const auditingIdForItem = item.auditing_id; // Get the ID for the current audit item
                let detailUrl = '#'; // Default to a hash if ID is missing
                let buttonSpecificClasses = buttonClasses;
                let buttonClickAttribute = '';

                if (typeof auditingIdForItem !== 'undefined' && auditingIdForItem !== null) {
                    detailUrl = progressDetailBaseUrl.replace('PLACEHOLDER_ID', auditingIdForItem);
                } else {
                    // Apply disabled styles and prevent default click if no ID
                    buttonSpecificClasses += ` ${disabledButtonClasses}`;
                    buttonClickAttribute = 'onclick="return false;" aria-disabled="true"';
                }
                // --- END NEW ---

                tbody.innerHTML += `
                    <tr class="bg-white dark:bg-gray-800">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">${idx + 1}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">${item.unit_kerja?.nama_unit_kerja ?? '-'}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">
                            <div class="w-full h-2 rounded-full bg-gray-200 dark:bg-gray-700">
                                <div class="${progressBarColor} h-2 rounded-full" style="width: ${progress}%"></div>
                            </div>
                            <p class="text-xs mt-1 mb-2 text-gray-600 dark:text-gray-400">${progress}% Selesai</p>
                            <div class="mb-1">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold ${statusColor}">
                                    ${statusLabel}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <a href="${detailUrl}"
                               class="${buttonSpecificClasses}"
                               ${buttonClickAttribute}>
                                Lihat Detail
                            </a>
                            </td>
                    </tr>
                `;
            });

            // Set dynamic period name in the header
            if (dynamicPeriodeNameElem && data[0]?.periode?.nama_periode) {
                dynamicPeriodeNameElem.innerText = data[0].periode.nama_periode;
            } else if (dynamicPeriodeNameElem) {
                dynamicPeriodeNameElem.innerText = 'Tidak ada periode aktif';
            }

            // --- Status Kegiatan Box - Displays Period Dates ---
            const statusBox = document.getElementById('statusAmiBox');
            let periodMessage = '';
            let periodStyle = 'bg-blue-100 text-blue-600 dark:bg-blue-800 dark:text-blue-400'; // Default for ongoing

            if (Array.isArray(data) && data.length > 0 && data[0]?.periode) {
                const periode = data[0].periode;
                const startDateString = periode.tanggal_mulai;
                const endDateString = periode.tanggal_berakhir;

                if (startDateString && endDateString) {
                    const startDate = new Date(startDateString);
                    const endDate = new Date(endDateString);

                    const options = { year: 'numeric', month: 'long', day: 'numeric' };
                    const formattedStartDate = startDate.toLocaleDateString('id-ID', options);
                    const formattedEndDate = endDate.toLocaleDateString('id-ID', options);

                    periodMessage = `Periode AMI Aktif: ${formattedStartDate} - ${formattedEndDate}`;

                    // Determine period status for styling based on current date
                    const today = new Date();
                    today.setHours(0, 0, 0, 0); // Normalize today for comparison
                    startDate.setHours(0,0,0,0); // Normalize start date
                    endDate.setHours(0,0,0,0); // Normalize end date

                    if (today > endDate) {
                        periodStyle = 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-400'; // Completed
                    } else if (today >= startDate && today <= endDate) {
                        periodStyle = 'bg-blue-100 text-blue-600 dark:bg-blue-800 dark:text-blue-400'; // Ongoing
                    } else {
                        periodStyle = 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400'; // Not yet started or other
                    }

                } else {
                    periodMessage = 'Informasi tanggal periode tidak lengkap.';
                    periodStyle = 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400'; // Warning style
                }
            } else {
                periodMessage = 'Informasi periode tidak tersedia.';
                periodStyle = 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400'; // No data style
            }
            statusBox.innerHTML = `<span class="inline-block rounded-lg px-6 py-3 shadow ${periodStyle}">${periodMessage}</span>`;
            // --- END Status Kegiatan Box ---


            // --- INFORMASI JADWAL AMI SECTION ---
            // Now iterates through all 'data' items to display schedule info
            const infoAmiList = data; // Use all data items for this section
            const infoBox = document.getElementById('infoAmiBox');
            let output = '';

            if (infoAmiList.length > 0) {
                infoAmiList.forEach(infoAmi => {
                    const unitName = infoAmi.unit_kerja?.nama_unit_kerja ?? '-';
                    const jadwalAuditDateString = infoAmi.jadwal_audit; // This could be null
                    const today = new Date();
                    today.setHours(0, 0, 0, 0); // Normalize 'today' to start of day for accurate comparison

                    let outputText = `<span class="font-semibold text-gray-600 dark:text-slate-300">Nama Unit:</span>
                                        <span class="font-bold">${unitName}</span>`;

                    if (jadwalAuditDateString) {
                        // Only parse date if jadwalAuditDateString exists
                        const auditDate = new Date(jadwalAuditDateString);
                        auditDate.setHours(0, 0, 0, 0); // Normalize audit date for accurate comparison

                        const tanggalStr = auditDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });

                        if (today < auditDate) {
                            outputText += ` &nbsp;|&nbsp;
                                                <span class="font-semibold text-gray-600 dark:text-slate-300">Tanggal AL:</span>
                                                <span class="font-bold">${tanggalStr}</span>`;
                        } else if (today > auditDate) {
                            outputText += ` &nbsp;|&nbsp;
                                                <span class="font-bold text-red-600 dark:text-red-400">Sudah dilakukan</span>`;
                        } else { // today === auditDate
                            outputText += ` &nbsp;|&nbsp;
                                                <span class="font-semibold text-gray-600 dark:text-slate-300">Tanggal AL:</span>
                                                <span class="font-bold text-green-600 dark:text-green-400">${tanggalStr}</span>`;
                        }
                    } else {
                        // This block will now correctly execute if jadwalAuditDateString is null
                        outputText += ` &nbsp;|&nbsp;
                                            <span class="font-bold text-yellow-600 dark:text-yellow-400">Belum dijadwalkan</span>`;
                    }
                    output += `<div class="py-3">${outputText}</div>`;
                });
                infoBox.innerHTML = output;
            } else {
                infoBox.innerHTML = `
                    <div class="py-3 text-sm text-gray-600 dark:text-slate-300">
                        Belum ada jadwal asesmen lapangan yang tersedia.
                    </div>
                `;
            }
            // --- END INFORMASI JADWAL AMI SECTION ---

        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-red-500">Gagal mengambil data audit. Pastikan server API berjalan.</td></tr>`;
            console.error('Error fetching audit data:', err);
            // Also update period name and status box if fetch fails
            if (dynamicPeriodeNameElem) {
                dynamicPeriodeNameElem.innerText = 'Gagal dimuat';
            }
            const statusBox = document.getElementById('statusAmiBox');
            if (statusBox) {
                statusBox.innerHTML = `<span class="inline-block rounded-lg px-6 py-3 shadow bg-red-100 text-red-600 dark:bg-red-800 dark:text-red-400">Gagal memuat status periode.</span>`;
            }
            const infoBox = document.getElementById('infoAmiBox');
            if (infoBox) {
                infoBox.innerHTML = `<div class="py-3 text-sm text-red-600 dark:text-red-400">Gagal memuat jadwal asesmen.</div>`;
            }
        }
    });
</script>
@endsection