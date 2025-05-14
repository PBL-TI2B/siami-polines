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
                    <tbody>
                        <tr class="border-t border-gray-200 dark:border-slate-600">
                            <td class="px-4 py-3 text-gray-600 dark:text-white">1</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-white">Contoh Unit</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-white">Sudah/Belum Di Set</td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-block rounded-full bg-yellow-400 px-3 py-1 text-center text-sm text-black">Belum
                                    diisi</span>
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

        // Toggle tema manual
        function toggleTheme() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
            updateChartTheme(html.classList.contains('dark'));
        }

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
