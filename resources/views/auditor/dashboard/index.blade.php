@extends('layouts.app')

@section('title', 'Dashboard Auditor')

@php
    $user = session('user');
@endphp

@section('content')
<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <div class="mb-8">
       <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')]]" />
        <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
            Selamat Datang, {{ $user['nama'] ?? 'Auditor' }}!
        </h1>
        <p class="mt-1 text-lg text-gray-600 dark:text-gray-400">
            Anda berada di Dashboard Auditor. Berikut adalah ringkasan aktivitas AMI Anda.
        </p>
    </div>

    <div class="mb-8" id="statusAmiBox">
        <div role="status" class="flex animate-pulse items-center rounded-lg bg-gray-100 p-4 shadow-sm dark:bg-gray-700">
            <svg class="h-8 w-8 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
            </svg>
            <div class="ms-4 h-6 w-full rounded-full bg-gray-300 dark:bg-gray-600"></div>
            <span class="sr-only">Memuat...</span>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 lg:col-span-2">
            <h3 class="mb-5 text-xl font-bold text-gray-900 dark:text-white">Status Audit Unit Kerja</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Unit Kerja</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Progres</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Status Terkini</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800" id="auditTableBody">
                        </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="mb-5 text-xl font-bold text-gray-900 dark:text-white">
                Jadwal Asesmen Lapangan
            </h3>
            <div id="infoAmiBox">
                 </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async function () {
        // Elements
        const auditTableBody = document.getElementById('auditTableBody');
        const statusAmiBox = document.getElementById('statusAmiBox');
        const infoAmiBox = document.getElementById('infoAmiBox');

        // Data Maps
        const statusMap = {
            1: { label: 'Pengisian Instrumen', color: 'bg-sky-100 text-sky-800 dark:bg-sky-900 dark:text-sky-300' },
            2: { label: 'Desk Evaluation', color: 'bg-sky-100 text-sky-800 dark:bg-sky-900 dark:text-sky-300' },
            3: { label: 'Penjadwalan AL', color: 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-300' },
            4: { label: 'Dijadwalkan Tilik', color: 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300' },
            5: { label: 'Pertanyaan Tilik', color: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' },
            6: { label: 'Tilik Dijawab', color: 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300' },
            7: { label: 'Laporan Temuan', color: 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300' },
            8: { label: 'Revisi', color: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' },
            9: { label: 'Sudah Revisi', color: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' },
            10: { label: 'Closing', color: 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-300' },
            11: { label: 'Selesai', color: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' }
        };
        const progressValueMap = { 1: 10, 2: 20, 3: 25, 4: 35, 5: 50, 6: 60, 7: 75, 8: 80, 9: 85, 10: 90, 11: 100 };

        // URL and Button Config
        const progressDetailBaseUrl = "{{ route('auditor.audit.audit', ['id' => 'PLACEHOLDER_ID']) }}";

        // Helper function to format dates
        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
        };

        // REFACTOR: Render functions for each component
        const renderAlert = (data) => {
            let alertContent = '';
            let periodMessage = 'Informasi periode tidak tersedia.';
            // Default gray style
            let icon = `<svg class="flex-shrink-0 w-5 h-5 text-gray-800 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>`;
            let classes = 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
            
            if (Array.isArray(data) && data.length > 0 && data[0]?.periode) {
                const { tanggal_mulai, tanggal_berakhir, nama_periode } = data[0].periode;
                if(tanggal_mulai && tanggal_berakhir) {
                    const startDate = new Date(tanggal_mulai);
                    const endDate = new Date(tanggal_berakhir);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    periodMessage = `<strong>${nama_periode}:</strong> Berlangsung dari ${formatDate(tanggal_mulai)} hingga ${formatDate(tanggal_berakhir)}.`;
                    
                    if (today > endDate) {
                        // Completed
                        icon = `<svg class="flex-shrink-0 w-5 h-5 text-green-800 dark:text-green-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>`;
                        classes = 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-300';
                        periodMessage = `<strong>${nama_periode}:</strong> Telah berakhir pada ${formatDate(tanggal_berakhir)}.`;
                    } else if (today >= startDate && today <= endDate) {
                        // Ongoing
                        icon = `<svg class="flex-shrink-0 w-5 h-5 text-sky-800 dark:text-sky-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>`;
                        classes = 'bg-sky-100 text-sky-800 dark:bg-sky-800 dark:text-sky-300';
                    }
                }
            }
            alertContent = `<div class="flex items-center p-4 text-sm rounded-lg shadow-sm ${classes}" role="alert">
                ${icon}
                <span class="sr-only">Info</span>
                <div class="ms-3 font-medium">${periodMessage}</div>
            </div>`;
            statusAmiBox.innerHTML = alertContent;
        };

        const renderTable = (data) => {
            if (!Array.isArray(data) || data.length === 0) {
                auditTableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" /></svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">Tidak ada data audit</h3><p class="mt-1 text-sm text-gray-500">Saat ini belum ada data audit yang perlu ditangani.</p>
                </td></tr>`;
                return;
            }

            let tableRows = '';
            data.forEach(item => {
                const status = item.status ?? 0;
                const statusInfo = statusMap[status] || { label: 'Unknown', color: 'bg-gray-100 text-gray-800' };
                const progress = progressValueMap[status] ?? 0;
                const auditingId = item.auditing_id;
                const detailUrl = auditingId ? progressDetailBaseUrl.replace('PLACEHOLDER_ID', auditingId) : '#';
                const isButtonDisabled = !auditingId;

                tableRows += `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">${item.unit_kerja?.nama_unit_kerja ?? 'N/A'}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Periode: ${item.periode?.nama_periode ?? 'N/A'}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-600">
                                    <div class="bg-sky-600 h-2.5 rounded-full" style="width: ${progress}%" data-tooltip-target="tooltip-progress-${item.auditing_id}"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 ml-3">${progress}%</span>
                            </div>
                            <div id="tooltip-progress-${item.auditing_id}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Progres ${progress}%
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center text-xs font-medium px-2.5 py-0.5 rounded-full ${statusInfo.color}">${statusInfo.label}</span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <a href="${detailUrl}" ${isButtonDisabled ? 'aria-disabled="true"' : ''} class="inline-flex items-center justify-center text-white bg-sky-700 hover:bg-sky-800 focus:ring-4 focus:ring-sky-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-sky-600 dark:hover:bg-sky-700 focus:outline-none dark:focus:ring-sky-800 ${isButtonDisabled ? 'opacity-50 cursor-not-allowed' : ''}">
                                Detail
                                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/></svg>
                            </a>
                        </td>
                    </tr>
                `;
            });
            auditTableBody.innerHTML = tableRows;
        };

        const renderTimeline = (data) => {
            if (!Array.isArray(data) || data.length === 0) {
                 infoAmiBox.innerHTML = `<div class="text-center text-gray-500 dark:text-gray-400 py-8"><p>Belum ada jadwal asesmen lapangan.</p></div>`;
                 return;
            }

            let timelineItems = '';
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            // Filter and sort items that have a schedule date or are unscheduled
            const scheduledItems = data
                .filter(item => item.jadwal_audit)
                .sort((a, b) => new Date(a.jadwal_audit) - new Date(b.jadwal_audit));

            const unscheduledItems = data.filter(item => !item.jadwal_audit);
            const allItems = [...scheduledItems, ...unscheduledItems];

            if(allItems.length === 0) {
                 infoAmiBox.innerHTML = `<div class="text-center text-gray-500 dark:text-gray-400 py-8"><p>Belum ada jadwal asesmen lapangan.</p></div>`;
                 return;
            }

            allItems.forEach(item => {
                let timeStatus = '';
                let iconClass = 'bg-gray-200 dark:bg-gray-600';
                let iconSvg = `<svg class="w-3 h-3 text-gray-600 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4Z M0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/></svg>`;

                if (item.jadwal_audit) {
                    const auditDate = new Date(item.jadwal_audit);
                    auditDate.setHours(0, 0, 0, 0);
                    
                    if (auditDate < today) {
                        timeStatus = `<time class="text-sm font-normal leading-none text-gray-500 dark:text-gray-400">Selesai - ${formatDate(item.jadwal_audit)}</time>`;
                        iconClass = 'bg-green-200 dark:bg-green-900'; // Green for completed
                        iconSvg = `<svg class="w-3 h-3 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/></svg>`;
                    } else if (auditDate.getTime() === today.getTime()) {
                        timeStatus = `<time class="text-sm font-semibold leading-none text-sky-700 dark:text-sky-400">Hari Ini - ${formatDate(item.jadwal_audit)}</time>`;
                        iconClass = 'bg-sky-200 dark:bg-sky-900 ring-8 ring-white dark:ring-gray-800'; // sky for today
                    } else {
                        timeStatus = `<time class="text-sm font-normal leading-none text-gray-500 dark:text-gray-400">${formatDate(item.jadwal_audit)}</time>`;
                    }
                } else {
                    timeStatus = `<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Belum Dijadwalkan</span>`;
                }
                
                timelineItems += `
                    <li class="mb-6 ms-6">            
                        <span class="absolute flex items-center justify-center w-6 h-6 rounded-full -start-3 ${iconClass}">
                           ${iconSvg}
                        </span>
                        <h4 class="flex items-center mb-1 text-base font-semibold text-gray-900 dark:text-white">${item.unit_kerja?.nama_unit_kerja ?? 'N/A'}</h4>
                        ${timeStatus}
                    </li>
                `;
            });

            infoAmiBox.innerHTML = `<ol class="relative border-s border-gray-200 dark:border-gray-600">${timelineItems}</ol>`;
        };

        const renderError = (error) => {
             console.error('Error fetching audit data:', error);
             const errorMessage = `<tr><td colspan="4" class="px-6 py-4 text-center text-red-500 dark:text-red-400">Gagal mengambil data. Pastikan server API berjalan.</td></tr>`;
             auditTableBody.innerHTML = errorMessage;
             statusAmiBox.innerHTML = `<div class="flex items-center p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                <span class="sr-only">Error</span>
                <div>Gagal memuat status periode.</div>
            </div>`;
             infoAmiBox.innerHTML = `<div class="text-center text-red-500 dark:text-red-400 py-8"><p>Gagal memuat jadwal asesmen.</p></div>`;
        };

        // Main execution
        (async () => {
            try {
                const response = await fetch('http://127.0.0.1:5000/api/auditings');
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const data = await response.json();

                renderAlert(data);
                renderTable(data);
                renderTimeline(data);
                
                // Re-initialize Flowbite components for dynamically added content
                if (window.initFlowbite) {
                    window.initFlowbite();
                }

            } catch (error) {
                renderError(error);
            }
        })();
    });
</script>
@endsection