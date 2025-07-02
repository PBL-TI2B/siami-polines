@extends('layouts.app')

@section('title', 'Dashboard Kepala PMPP')

@php
    $user = session('user');
@endphp

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('kepala-pmpp.dashboard.index')]]" />
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200">
                Hai, {{ $user['nama'] ?? 'Kepala' }}! Selamat Datang di Dashboard Kepala PMPP
            </h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Periode Aktif:
                <span id="periodeAktifLabel" class="ml-1 inline-block rounded-full bg-sky-100 px-3 py-1 text-sm font-semibold text-sky-600 dark:bg-sky-800 dark:text-sky-400">
                    Memuat...
                </span>
            </p>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="statsContainer">
        <div class="rounded-2xl border border-sky-200 bg-sky-100 p-6 shadow-sm hover:shadow-md dark:border-sky-600 dark:bg-sky-900">
            <div class="flex items-center space-x-4">
                <div class="rounded-full bg-sky-400 p-3 text-white dark:bg-sky-600">
                    <x-heroicon-o-clock class="h-6 w-6" />
                </div>
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">Audit Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="activeAudits"></p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-green-200 bg-green-100 p-6 shadow-sm hover:shadow-md dark:border-green-600 dark:bg-green-900">
            <div class="flex items-center space-x-4">
                <div class="rounded-full bg-green-500 p-3 text-white dark:bg-green-600">
                    <x-heroicon-o-check-circle class="h-6 w-6" />
                </div>
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">Audit Selesai</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="completedAudits"></p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-yellow-200 bg-yellow-100 p-6 shadow-sm hover:shadow-md dark:border-yellow-600 dark:bg-yellow-900">
            <div class="flex items-center space-x-4">
                <div class="rounded-full bg-yellow-500 p-3 text-white dark:bg-yellow-600">
                    <x-heroicon-o-exclamation-circle class="h-6 w-6" />
                </div>
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">Tindak Lanjut</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="followupAudits"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4 rounded-2xl">
        <div class="w-full md:w-1/3">
            <label for="periodeFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Periode</label>
            <select id="periodeFilter" class="rounded-xl mt-1 block w-full border-gray-300 shadow-sm dark:bg-gray-800 dark:text-white dark:border-gray-600">
                <option value="all">Semua Periode</option>
            </select>
        </div>

        <div class="w-full md:w-2/3">
            <label for="searchInput" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari Nama Unit</label>
            <input type="text" id="searchInput" placeholder="Ketik nama unit..." class="block w-full rounded-xl border-gray-300 shadow-sm dark:bg-gray-800 dark:text-white dark:border-gray-600">
        </div>
    </div>

    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-gray-200">Status Audit Mutu Internal</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Nama Unit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Tanggal Audit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300">Status</th>
                    </tr>
                </thead>
                <tbody id="auditTableBody" class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                    </tbody>
            </table>
        </div>
    </div>

    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-gray-200">Grafik Jumlah Audit per Periode</h3>
        <canvas id="auditChart" class="h-64 w-full"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        const tbody = document.querySelector('#auditTableBody');
        const periodeFilter = document.getElementById('periodeFilter');
        const searchInput = document.getElementById('searchInput');
        let chartInstance;
        let allAuditData = [];

        const statusMap = {
            1: { label: 'Pengisian Instrumen', color: 'bg-blue-100 text-blue-600 dark:bg-blue-800 dark:text-blue-400' },
            2: { label: 'Penjadwalan AL', color: 'bg-blue-100 text-blue-600 dark:bg-blue-800 dark:text-blue-400' },
            3: { label: 'Dijadwalkan AL', color: 'bg-blue-100 text-blue-600 dark:bg-blue-800 dark:text-blue-400' },
            4: { label: 'Desk Evaluation', color: 'bg-blue-100 text-blue-600 dark:bg-blue-800 dark:text-blue-400' },
            5: { label: 'Pertanyaan Tilik', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            6: { label: 'Tilik Dijawab', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            7: { label: 'Laporan Temuan', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
            8: { label: 'Revisi', color: 'bg-orange-100 text-orange-600 dark:bg-orange-800 dark:text-orange-400' },
            9: { label: 'Sudah Revisi', color: 'bg-blue-100 text-blue-600 dark:bg-blue-800 dark:text-blue-400' },
            10: { label: 'Closing', color: 'bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-400' },
            11: { label: 'Selesai', color: 'bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-400' }
        };

        function populatePeriodeFilter(data) {
            const periodesMap = new Map();
            data.forEach(item => {
                if (item.periode && !periodesMap.has(item.periode.periode_id)) {
                    periodesMap.set(item.periode.periode_id, item.periode);
                }
            });

            periodeFilter.innerHTML = `
                <option value="all">Semua Periode</option>
            `;

            periodesMap.forEach(periode => {
                const option = document.createElement('option');
                option.value = periode.periode_id;
                option.textContent = `${periode.nama_periode} (${periode.status})`;
                periodeFilter.appendChild(option);
            });

            const activePeriod = Array.from(periodesMap.values()).find(p => p.status === "Sedang Berjalan");
            if (activePeriod) {
                periodeFilter.value = activePeriod.periode_id;
            } else {
                periodeFilter.value = 'all';
            }
        }

        function renderTableAndStats(filteredData) {
            tbody.innerHTML = '';

            if (!filteredData.length) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center text-gray-500 py-4">Tidak ada data audit.</td></tr>`;
                document.getElementById('activeAudits').textContent = '0';
                document.getElementById('completedAudits').textContent = '0';
                document.getElementById('followupAudits').textContent = '0';
                return;
            }

            filteredData.forEach((item, idx) => {
                const status = statusMap[item.status] || { label: 'Status Tidak Diketahui', color: 'bg-gray-200 text-gray-600 dark:bg-gray-800 dark:text-gray-400' };
                const tanggalAudit = item.jadwal_audit
                    ? new Date(item.jadwal_audit).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
                    : '-';

                tbody.innerHTML += `
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">${idx + 1}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">${item.unit_kerja?.nama_unit_kerja ?? '-'}</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">${tanggalAudit}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold ${status.color}">${status.label}</span>
                        </td>
                    </tr>
                `;
            });

            const activeAudits = filteredData.filter(a => a.status >= 1 && a.status <= 10).length;
            const completedAudits = filteredData.filter(a => a.status === 11).length;
            const followupAudits = filteredData.filter(a => a.status === 8).length;

            document.getElementById('activeAudits').textContent = activeAudits;
            document.getElementById('completedAudits').textContent = completedAudits;
            document.getElementById('followupAudits').textContent = followupAudits;
        }

        function renderChart(data) {
            const periodesMap = new Map();
            data.forEach(item => {
                if (item.periode && !periodesMap.has(item.periode.periode_id)) {
                    periodesMap.set(item.periode.periode_id, item.periode);
                }
            });

            const periods = Array.from(periodesMap.keys()).sort();
            const labels = periods.map(p => periodesMap.get(p)?.nama_periode || `Periode ${p}`);

            const activeData = periods.map(p => data.filter(a => a.periode_id === p && a.status >= 1 && a.status <= 10).length);
            const completedData = periods.map(p => data.filter(a => a.periode_id === p && a.status === 11).length);
            const followupData = periods.map(p => data.filter(a => a.periode_id === p && a.status === 8).length);

            if (chartInstance) chartInstance.destroy();

            chartInstance = new Chart(document.getElementById('auditChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels,
                    datasets: [
                        { label: 'Audit Aktif', data: activeData, backgroundColor: 'rgba(14,165,233,0.6)', borderColor: 'rgba(14,165,233,1)', borderWidth: 1 },
                        { label: 'Audit Selesai', data: completedData, backgroundColor: 'rgba(34,197,94,0.6)', borderColor: 'rgba(34,197,94,1)', borderWidth: 1 },
                        { label: 'Tindak Lanjut', data: followupData, backgroundColor: 'rgba(249,115,22,0.6)', borderColor: 'rgba(249,115,22,1)', borderWidth: 1 }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            // Ensure stepSize and precision are numbers
                            stepSize: 1, 
                            precision: 0,
                            min: 0,
                            title: { display: true, text: 'Jumlah Audit' }
                        }
                    },
                    plugins: { legend: { position: 'top' } }
                }
            });
        }

        function applySearchAndFilter() {
            const val = periodeFilter.value;
            const keyword = searchInput.value.toLowerCase();

            let filtered = [];

            if (val === 'all') {
                filtered = [...allAuditData];
            } else {
                filtered = allAuditData.filter(a => a.periode_id == val);
            }

            if (keyword.trim() !== '') {
                filtered = filtered.filter(a =>
                    a.unit_kerja?.nama_unit_kerja?.toLowerCase().includes(keyword)
                );
            }
            
            // Sort by audit date (newest first) only if jadwal_audit exists
            filtered.sort((a, b) => {
                const dateA = a.jadwal_audit ? new Date(a.jadwal_audit) : new Date(0); // Use epoch for missing dates to place them at the beginning
                const dateB = b.jadwal_audit ? new Date(b.jadwal_audit) : new Date(0);
                return dateB.getTime() - dateA.getTime(); // Descending: terbaru ke terlama
            });

            renderTableAndStats(filtered);
            renderChart(filtered);
        }

        try {
            const response = await fetch('http://127.0.0.1:5000/api/auditings');
            const result = await response.json();

            allAuditData = Array.isArray(result) ? result : (result.data || []);

            populatePeriodeFilter(allAuditData);

            const activePeriod = allAuditData.find(a => a.periode?.status === "Sedang Berjalan");
            document.getElementById('periodeAktifLabel').textContent =
                activePeriod?.periode?.nama_periode || 'Tidak ada periode aktif';

            applySearchAndFilter();

            periodeFilter.addEventListener('change', applySearchAndFilter);
            searchInput.addEventListener('input', applySearchAndFilter);
        } catch (error) {
            tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-red-500">Gagal mengambil data audit.</td></tr>`;
            console.error('Error fetching audit data:', error);
        }
    });
</script>
@endsection