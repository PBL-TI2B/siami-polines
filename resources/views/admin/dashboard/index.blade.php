@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('admin.dashboard.index')]]" />
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Periode Aktif:
                <span
                    class="ml-1 inline-block rounded-full bg-sky-100 px-3 py-1 text-sm font-semibold text-sky-600 dark:bg-sky-800 dark:text-sky-400">
                    2024/2025 - Semester Genap
                </span>
            </p>
        </div>
    </div>

    <!-- Statistik Audit -->
    <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="statsContainer">
        <!-- Audit Aktif -->
        <div
            class="rounded-2xl border border-sky-200 bg-sky-100 p-6 shadow-sm hover:shadow-md dark:border-sky-600 dark:bg-sky-900">
            <div class="flex items-center space-x-4">
                <div class="rounded-full bg-sky-400 p-3 text-white dark:bg-sky-600">
                    <x-heroicon-o-clock class="text-white-600 dark:text-white-300 h-6 w-6" />
                </div>
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">Audit Aktif</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="activeAudits">0</p>
                </div>
            </div>
        </div>

        <!-- Audit Selesai -->
        <div
            class="rounded-2xl border border-green-200 bg-green-100 p-6 shadow-sm hover:shadow-md dark:border-green-600 dark:bg-green-900">
            <div class="flex items-center space-x-4">
                <div class="rounded-full bg-green-500 p-3 text-white dark:bg-green-600">
                    <x-heroicon-o-check-circle class="text-white-600 dark:text-white-300 h-6 w-6" />
                </div>
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">Audit Selesai</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="completedAudits">0</p>
                </div>
            </div>
        </div>

        <!-- Audit Tindak Lanjut -->
        <div
            class="rounded-2xl border border-yellow-200 bg-yellow-100 p-6 shadow-sm hover:shadow-md dark:border-yellow-600 dark:bg-yellow-900">
            <div class="flex items-center space-x-4">
                <div class="rounded-full bg-yellow-500 p-3 text-white dark:bg-yellow-600">
                    <x-heroicon-o-exclamation-circle class="text-white-600 dark:text-white-300 h-6 w-6" />
                </div>
                <div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">Tindak Lanjut</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" id="followupAudits">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Status AMI -->
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-gray-200">Status Audit Mutu Internal</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            No
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Nama Unit
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">1</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">Unit A</td>
                        <td class="px-6 py-4 text-sm">
                            <span
                                class="inline-block rounded-full bg-red-100 px-3 py-1 text-center text-xs font-semibold text-red-600 dark:bg-red-800 dark:text-red-400">
                                Belum Audit
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <x-button color="sky" icon="heroicon-o-eye">
                                Lihat
                            </x-button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">2</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">Unit B</td>
                        <td class="px-6 py-4 text-sm">
                            <span
                                class="inline-block rounded-full bg-yellow-100 px-3 py-1 text-center text-xs font-semibold text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400">
                                Proses Audit
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <x-button color="sky" icon="heroicon-o-eye">
                                Lihat
                            </x-button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">3</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">Unit C</td>
                        <td class="px-6 py-4 text-sm">
                            <span
                                class="inline-block rounded-full bg-green-100 px-3 py-1 text-center text-xs font-semibold text-green-600 dark:bg-green-800 dark:text-green-400">
                                Selesai Audit
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <x-button color="sky" icon="heroicon-o-eye">
                                Lihat
                            </x-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Grafik Audit -->
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <h3 class="mb-4 text-xl font-bold text-gray-900 dark:text-gray-200">Grafik Jumlah Audit per Periode</h3>
        <canvas id="auditChart" class="h-64 w-full"></canvas>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const tbody = document.querySelector('tbody.divide-y');
        if (!tbody) return;

        // Mapping status angka ke nama status dan warna
        const statusMap = {
            1: {
                label: 'Pengisian Instrumen',
                color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400'
            },
            2: {
                label: 'Desk Evaluation',
                color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400'
            },
            3: {
                label: 'Penjadwalan AL',
                color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400'
            },
            4: {
                label: 'Dijadwalkan Tilik',
                color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400'
            },
            5: {
                label: 'Pertanyaan Tilik',
                color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400'
            },
            6: {
                label: 'Tilik Dijawab',
                color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400'
            },
            7: {
                label: 'Laporan Temuan',
                color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400'
            },
            8: {
                label: 'Revisi',
                color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400'
            },
            9: {
                label: 'Sudah revisi',
                color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400'
            },
            10: {
                label: 'Closing',
                color: 'bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-400'
            },
            11: {
                label: 'Selesai',
                color: 'bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-400'
            }
        };

        try {
            const response = await fetch('http://127.0.0.1:5000/api/auditings');
            const data = await response.json();

            tbody.innerHTML = '';

            if (!Array.isArray(data) || data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Tidak ada data audit.</td></tr>`;
                return;
            }

            data.forEach((item, idx) => {
                const status = statusMap[item.status] || {
                    label: 'Status Tidak Diketahui',
                    color: 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'
                };
                tbody.innerHTML += `
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">${idx + 1}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-200">${item.unit_kerja?.nama_unit_kerja ?? '-'}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-block rounded-full px-3 py-1 text-center text-xs font-semibold ${status.color}">
                            ${status.label}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <button class="inline-flex items-center rounded bg-sky-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-sky-900">
                            Lihat
                        </button>
                    </td>
                </tr>
            `;
            });
        } catch (err) {
            tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-red-500">Gagal mengambil data audit.</td></tr>`;
            console.error(err);
        }
    });
    // Fungsi untuk mengambil data dari API
    async function fetchAuditData() {
        try {
            const response = await fetch('http://127.0.0.1:5000/api/auditings');
            const data = await response.json();

            // Hitung statistik
            const activeAudits = data.filter(audit => audit.periode_id === 3).length;
            const completedAudits = data.filter(audit => audit.status === 9).length;
            const followupAudits = data.filter(audit => audit.status === 8).length;

            // Update statistik di DOM
            document.getElementById('activeAudits').textContent = activeAudits;
            document.getElementById('completedAudits').textContent = completedAudits;
            document.getElementById('followupAudits').textContent = followupAudits;

            // Siapkan data untuk grafik dengan periode tetap (1, 2, 3)
            const periods = [1, 2, 3].map(id => `Periode ${id}`);
            const activeData = [1, 2, 3].map(periodId => data.filter(audit => audit.periode_id === periodId && audit.periode_id === 3).length);
            const completedData = [1, 2, 3].map(periodId => data.filter(audit => audit.periode_id === periodId && audit.status === 9).length);
            const followupData = [1, 2, 3].map(periodId => data.filter(audit => audit.periode_id === periodId && audit.status === 8).length);

            // Buat grafik
            const ctx = document.getElementById('auditChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: periods,
                    datasets: [{
                            label: 'Audit Aktif',
                            data: activeData,
                            backgroundColor: 'rgba(14, 165, 233, 0.6)', // sky
                            borderColor: 'rgba(14, 165, 233, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Audit Selesai',
                            data: completedData,
                            backgroundColor: 'rgba(34, 197, 94, 0.6)', // green
                            borderColor: 'rgba(34, 197, 94, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Tindak Lanjut',
                            data: followupData,
                            backgroundColor: 'rgba(253, 224, 71, 0.6)', // yellow
                            borderColor: 'rgba(253, 224, 71, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Audit'
                            },
                            ticks: {
                                stepSize: 10 // <-- Tambahkan baris ini
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error fetching audit data:', error);
        }
    }

    // Panggil fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', fetchAuditData);
</script>
@endsection