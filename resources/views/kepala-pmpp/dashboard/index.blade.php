@extends('layouts.app')

@section('title', 'Dashboard Kepala PMPP')

@php
    $user = session('user');
@endphp

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <!-- Header -->
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

    <!-- Statistik -->
    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="statsContainer">
        <!-- Audit Aktif -->
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

        <!-- Audit Selesai -->
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

        <!-- Audit Tindak Lanjut -->
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

    <!-- Dropdown Filter -->
    <div class="mb-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <label for="periodeFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pilih Periode</label>
            <select id="periodeFilter" class="mt-1 block w-48 rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:text-white dark:border-gray-600">
                <option value="all">Semua Periode</option>
                <option value="1">Periode 1</option>
                <option value="2">Periode 2</option>
                <option value="3" selected>Periode 3</option>
            </select>
        </div>

        <div class="flex-1">
            <label for="searchInput" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari Nama Unit</label>
            <input type="text" id="searchInput" placeholder="Ketik nama unit..." class="block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:text-white dark:border-gray-600">
        </div>
    </div>

    <!-- Tabel -->
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
                    <!-- Data dari JS -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Grafik -->
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-gray-200">Grafik Jumlah Audit per Periode</h3>
        <canvas id="auditChart" class="h-64 w-full"></canvas>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        const tbody = document.querySelector('#auditTableBody');
        const periodeFilter = document.getElementById('periodeFilter');
        const searchInput = document.getElementById('searchInput');
        let chartInstance;
        let allAuditData = [];

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

        function renderTableAndStats(filteredData) {
            tbody.innerHTML = '';

            if (!filteredData.length) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center text-gray-500 py-4">Tidak ada data audit.</td></tr>`;
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

            document.getElementById('activeAudits').textContent = filteredData.filter(a => a.status !== 11).length;
            document.getElementById('completedAudits').textContent = filteredData.filter(a => a.status === 11).length;
            document.getElementById('followupAudits').textContent = filteredData.filter(a => a.status === 8).length;
        }

        function renderChart(data) {
            const periods = [...new Set(data.map(a => a.periode_id))].sort();
            const labels = periods.map(p => `Periode ${p}`);
            const activeData = periods.map(p => data.filter(a => a.periode_id === p && a.status !== 11).length);
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
                        { label: 'Tindak Lanjut', data: followupData, backgroundColor: 'rgba(253,224,71,0.6)', borderColor: 'rgba(253,224,71,1)', borderWidth: 1 }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
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

            let filtered = val === 'all' ? allAuditData : allAuditData.filter(a => a.periode_id == val);
            if (keyword.trim() !== '') {
                filtered = filtered.filter(a =>
                    a.unit_kerja?.nama_unit_kerja?.toLowerCase().includes(keyword)
                );
            }
        // Tambahkan sorting berdasarkan tanggal audit (terbaru di atas)
        filtered.sort((a, b) => {
            const dateA = new Date(a.jadwal_audit || 0);
            const dateB = new Date(b.jadwal_audit || 0);
            return dateB - dateA; // Descending: terbaru ke terlama
        });

            renderTableAndStats(filtered);
            renderChart(filtered);
        }

        try {
            const response = await fetch('http://127.0.0.1:5000/api/auditings');
            const data = await response.json();
            allAuditData = data;

            const aktif = data.find(a => a.periode_id === 3);
            document.getElementById('periodeAktifLabel').textContent = aktif?.periode?.nama_periode || 'Tidak ditemukan';

            applySearchAndFilter();

            periodeFilter.addEventListener('change', applySearchAndFilter);
            searchInput.addEventListener('input', applySearchAndFilter);
        } catch (error) {
            tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-red-500">Gagal mengambil data audit.</td></tr>`;
            console.error(error);
        }
    });
</script>
@endsection
