@extends('layouts.app')

@section('title', 'Dashboard Auditor')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 text-gray-800 sm:px-6 lg:px-8 dark:text-white">
        <h1 class="mb-6 text-2xl font-bold">Hai, Kelompok 3! Selamat Datang di Dashboard Auditor</h1>

        <div class="mb-6">
            <span
                class="inline-block rounded-lg bg-gray-200 px-6 py-3 text-blue-600 shadow dark:bg-[#334155] dark:text-blue-400">Kegiatan
                AMI sedang berlangsung</span>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="md:col-span-2">
                <table class="min-w-full overflow-hidden rounded-lg bg-white dark:bg-slate-800">
                    <thead class="bg-gray-100 text-gray-600 dark:bg-slate-700 dark:text-slate-300">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Unit</th>
                            <th class="px-4 py-3 text-left">Status Auditor</th>
                            <th class="px-4 py-3 text-left">Status Pengisian Auditee</th>
                        </tr>
                    </thead>
                    {{-- ID ditambahkan untuk mempermudah seleksi dengan JavaScript --}}
                    <tbody id="audit-table-body" class="divide-y divide-gray-200 dark:divide-slate-600">
                        {{-- Data akan diisi secara dinamis oleh JavaScript --}}
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-gray-500">
                                Memuat data audit...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-md dark:border-slate-700 dark:bg-slate-800">
                <h2
                    class="border-b border-gray-200 pb-3 text-xl font-bold text-gray-800 dark:border-slate-600 dark:text-white">
                    Informasi Jadwal AMI</h2>

                <div class="divide-y divide-gray-200 dark:divide-slate-600">
                    <div class="py-3">
                        <span class="font-semibold text-gray-600 dark:text-slate-300">Tahun:</span> <span
                            class="font-bold">2025</span>
                    </div>
                    <div class="py-3">
                        <span class="font-semibold text-gray-600 dark:text-slate-300">Periode:</span> <span
                            class="font-bold">04 Jan - 05 Mei</span>
                    </div>
                    <div class="py-3">
                        <span class="font-semibold text-gray-600 dark:text-slate-300">Keterangan:</span> <span
                            class="font-bold">Audit Mutu Internal 2025</span>
                    </div>
                    <div class="py-3">
                        <span class="font-semibold text-gray-600 dark:text-slate-300">Status:</span>
                        <span
                            class="inline-block rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800 dark:bg-blue-500 dark:text-white">
                            Sedang Berjalan
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 dark:border-slate-700 dark:bg-slate-800">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-md font-semibold text-gray-800 dark:text-white">Rekap Capaian Unit: - [ Pilih Unit Kerja
                    Terlebih Dahulu ]</h3>
                <select
                    class="w-28 rounded border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-800 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    <option>Pilih Unit</option>
                </select>
            </div>
            <canvas id="rekapChart" height="100"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const tbody = document.getElementById('audit-table-body');
            if (!tbody) {
                console.error('Element tbody dengan ID "audit-table-body" tidak ditemukan!');
                return;
            }

            // Mapping status dari API ke teks dan warna, sama seperti di dashboard admin
            const statusMap = {
                1: { label: 'Pengisian Instrumen', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
                2: { label: 'Desk Evaluation', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
                3: { label: 'Penjadwalan AL', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
                4: { label: 'Dijadwalkan Tilik', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
                5: { label: 'Pertanyaan Tilik', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
                6: { label: 'Tilik Dijawab', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
                7: { label: 'Laporan Temuan', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
                8: { label: 'Revisi', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
                9: { label: 'Sudah revisi', color: 'bg-yellow-100 text-yellow-600 dark:bg-yellow-800 dark:text-yellow-400' },
                10: { label: 'Closing', color: 'bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-400' },
                11: { label: 'Selesai', color: 'bg-green-100 text-green-600 dark:bg-green-800 dark:text-green-400' }
            };

            try {
                // Fetch data dari API
                const response = await fetch('http://127.0.0.1:5000/api/auditings');
                const data = await response.json();

                // Kosongkan isi tabel sebelum diisi data baru
                tbody.innerHTML = '';

                // Cek jika data kosong atau bukan array
                if (!Array.isArray(data) || data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="4" class="px-4 py-10 text-center text-gray-500">Tidak ada data audit yang tersedia.</td></tr>`;
                    return;
                }

                // Loop setiap item data dan buat baris tabel baru
                data.forEach((item, index) => {
                    const statusInfo = statusMap[item.status] || {
                        label: 'Status Tidak Dikenali',
                        color: 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'
                    };

                    // Buat baris tabel (tr) baru
                    const row = `
                        <tr class="dark:text-white">
                            <td class="px-4 py-3">${index + 1}</td>
                            <td class="px-4 py-3">${item.unit_kerja?.nama_unit_kerja ?? 'N/A'}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-gray-200 px-3 py-1 text-sm dark:bg-gray-600">Belum Diset</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-block rounded-full px-3 py-1 text-center text-sm ${statusInfo.color}">
                                    ${statusInfo.label}
                                </span>
                            </td>
                        </tr>
                    `;

                    // Tambahkan baris baru ke dalam tbody
                    tbody.innerHTML += row;
                });

            } catch (error) {
                console.error('Gagal mengambil data audit:', error);
                tbody.innerHTML = `<tr><td colspan="4" class="px-4 py-10 text-center text-red-500">Gagal memuat data. Silakan coba lagi nanti.</td></tr>`;
            }
        });
    </script>
    
    <script>
        // Fungsi untuk update tema chart
        function updateChartTheme(isDark) {
            const textColor = isDark ? '#cbd5e1' : '#334155';
            const gridColor = isDark ? '#334155' : '#e2e8f0';

            if (window.rekapChart) {
                window.rekapChart.options.scales.x.ticks.color = textColor;
                window.rekapChart.options.scales.y.ticks.color = textColor;
                window.rekapChart.options.scales.x.grid.color = gridColor;
                window.rekapChart.options.scales.y.grid.color = gridColor;
                window.rekapChart.options.plugins.legend.labels.color = textColor;
                window.rekapChart.update();
            }
        }

        // Inisialisasi chart
        const ctx = document.getElementById('rekapChart').getContext('2d');
        window.rekapChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [...Array(11).keys()].map(i => i * 10),
                datasets: [{
                        label: 'Belum Memenuhi',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: 'red'
                    },
                    {
                        label: 'Memenuhi',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: 'green'
                    },
                    {
                        label: 'Melampaui',
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        backgroundColor: 'blue'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#334155'
                        },
                        grid: {
                            color: '#e2e8f0'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#334155'
                        },
                        grid: {
                            color: '#e2e8f0'
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#334155'
                        }
                    }
                }
            }
        });

        // Deteksi perubahan tema
        const observer = new MutationObserver(() => {
            updateChartTheme(document.documentElement.classList.contains('dark'));
        });
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });

        // Inisialisasi tema awal
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            updateChartTheme(true);
        } else {
            document.documentElement.classList.remove('dark');
            updateChartTheme(false);
        }
    </script>
@endsection