@extends('layouts.app')

@section('title', 'Daftar Tilik')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Daftar Tilik', 'url' => route('auditee.daftar-tilik.index')],
        ]" />

        <!-- Heading -->
        <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Daftar Tilik
        </h1>

        <div class="mb-6 flex gap-2">
            {{-- <x-button href="{{ route('auditee.daftar-tilik.create') }}" color="sky" icon="heroicon-o-plus">
                Tambah Pertanyaan
            </x-button> --}}
        </div>

        <!-- Table and Pagination -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <!-- Table Controls -->
            <div
                class="flex flex-col items-center justify-between gap-4 rounded-t-2xl border-b border-gray-200 bg-white p-4 sm:flex-row dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <form action="#" method="GET">
                        <select name="per_page"
                            class="w-18 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                            onchange="this.form.submit()">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </form>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                </div>
                <div class="relative w-full sm:w-auto">
                    <form action="#" method="GET">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" placeholder="Cari" value=""
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table id="tilik-table" class="min-w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead
                        class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">No
                            </th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Kriteria</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Daftar Pertanyaan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Indikator Kinerja Renstra & LKPS</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Sumber Bukti/Bukti</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Metode Perhitungan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Target</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Realisasi</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Standar Nasional / Polines</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Uraian Isian</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Akar Penyebab (Target tidak tercapai)/ Akar Penunjang (Target tercapai)</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Rencana Perbaikan & Tindak Lanjut</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tilik-table-body">
                        <!-- Baris data akan dimasukkan ke sini -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>1</strong> hingga <strong>2</strong> dari <strong>1000</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul class="inline-flex -space-x-px text-sm">
                            <li>
                                <a href="#"
                                    class="flex h-8 cursor-not-allowed items-center justify-center rounded-l-lg border border-gray-300 bg-white px-3 leading-tight text-gray-500 opacity-50 transition-all duration-200 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    <x-heroicon-s-chevron-left class="mr-1 h-4 w-4" />
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center justify-center border border-sky-300 bg-sky-50 px-3 leading-tight text-sky-800 transition-all duration-200 dark:border-sky-700 dark:bg-sky-900 dark:text-sky-200">
                                    1
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center justify-center border border-gray-300 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    2
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center justify-center rounded-r-lg border border-gray-300 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    <x-heroicon-s-chevron-right class="ml-1 h-4 w-4" />
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Pass route to JavaScript -->
    <script>
        window.App = {
            routes: {
                editTilik: '{{ route("auditee.daftar-tilik.edit", ":id") }}'
            }
        };
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", async () => {
        const kriteriaMap = {
            1: '1. Visi,  Misi, Tujuan, Strategi',
            2: '2. Tata Kelola, Tata Pamong, dan Kerjasama',
            3: '3. Kurikulum dan Pembelajaran',
            4: '4. Penelitian',
            5: '5. Luaran Tridharma',
        };

        try {
            const [tilikResponse, responseTilikResponse] = await Promise.all([
                fetch('http://127.0.0.1:5000/api/tilik').then(res => res.json()),
                fetch('http://127.0.0.1:5000/api/response-tilik').then(res => res.json())
            ]);

            const tbody = document.getElementById('tilik-table-body');
            if (!tbody) return console.error("Elemen tbody 'tilik-table-body' tidak ditemukan!");

            tbody.innerHTML = '';

            const responseMap = {};
            if (responseTilikResponse.success && Array.isArray(responseTilikResponse.data)) {
                responseTilikResponse.data.forEach(res => {
                    responseMap[res.tilik_id] = res;
                });
            }

            if (tilikResponse.success && Array.isArray(tilikResponse.data)) {
                tilikResponse.data.forEach((item, index) => {
                    const response = responseMap[item.tilik_id] || {};
                    const kriteriaName = kriteriaMap[item.kriteria_id] || `Kriteria ${item.kriteria_id}`;

                    const row = document.createElement('tr');
                    row.className = "transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700";

                    const getCell = (value) => value ? escapeHtml(value) : '-';

                    row.innerHTML = `
                        <td class="px-4 py-3 sm:px-6">${index + 1}</td>
                        <td class="px-4 py-3 sm:px-6">${kriteriaName}</td>
                        <td class="px-4 py-3 sm:px-6">${getCell(item.pertanyaan)}</td>
                        <td class="px-4 py-3 sm:px-6">${getCell(item.indikator)}</td>
                        <td class="px-4 py-3 sm:px-6">${getCell(item.sumber_data)}</td>
                        <td class="px-4 py-3 sm:px-6">${getCell(item.metode_perhitungan)}</td>
                        <td class="px-4 py-3 sm:px-6">${getCell(item.target)}</td>
                        <td class="px-4 py-3 sm:px-6">${getCell(response.realisasi)}</td>
                        <td class="px-4 py-3 sm:px-6">${getCell(response.standar_nasional)}</td>
                        <td class="px-4 py-3 sm:px-6">${getCell(response.uraian_isian)}</td>
                        <td class="px-4 py-3 sm:px-6">${getCell(response.akar_penyebab_penunjang)}</td>
                        <td class="px-4 py-3 sm:px-6">${getCell(response.rencana_perbaikan_tindak_lanjut)}</td>
                        <td class="px-4 py-3 sm:px-6 text-center">
                            <div class="flex items-center gap-2 justify-center">
                                ${response.realisasi ? `
                                    <a href="/auditee/daftar-tilik/${response.response_tilik_id}/edit" title="Edit Jawaban" class="text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M14 4a2.5 2.5 0 113.536 3.536L6.5 21H3v-3.5L14 4z"/>
                                        </svg>
                                    </a> 
                                    <button data-id="${response.response_tilik_id}" class="delete-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5-4h4m-4 0a2 2 0 00-2 2v1h8V5a2 2 0 00-2-2z"/>
                                        </svg>
                                    </button>
                                    ` : `
                                    <a href="/auditee/daftar-tilik/${item.tilik_id}/create" title="Tambah Jawaban" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </a>`}
                            </div>
                        </td>
                    `;

                    tbody.appendChild(row);
                });
            }

            // Event listener delete
            tbody.addEventListener('click', function (event) {
                const btn = event.target.closest('.delete-btn');
                if (!btn) return;
                const id = btn.dataset.id;
                if (!id) return;

                if (confirm('Apakah Anda yakin ingin menghapus jawaban ini?')) {
                    fetch(`http://127.0.0.1:5000/api/response-tilik/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            alert('Data berhasil dihapus!');
                            location.reload();
                        } else {
                            alert('Gagal menghapus data: ' + (result.message || 'Unknown error'));
                        }
                    })
                    .catch(err => {
                        console.error('Error deleting:', err);
                        alert('Terjadi kesalahan saat menghapus data.');
                    });
                }
            });
        } catch (err) {
            console.error('Gagal memuat data:', err);
        }

        // Escape helper (untuk keamanan)
        function escapeHtml(unsafe) {
            return String(unsafe)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    });
</script>
@endsection