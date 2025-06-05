@extends('layouts.app')

@section('title', 'Daftar Tilik')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('kepala-pmpp.dashboard.index')],
            ['label' => 'Daftar Tilik', 'url' => route('kepala-pmpp.daftar-tilik.index')],
        ]" />

        <!-- Heading -->
        <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Daftar Tilik
        </h1>


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
                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
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
                <table class="min-w-full text-left text-sm text-gray-500 dark:text-gray-400">
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
                            
                        </tr>
                    </thead>
                    <tbody id="tilik-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Baris data akan ditambahkan via JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
<div class="p-4">
    <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
        <span id="pagination-info" class="text-sm text-gray-700 dark:text-gray-300">
            <!-- akan diisi via JS -->
        </span>
        <nav aria-label="Navigasi Paginasi">
            <ul id="pagination-buttons" class="inline-flex -space-x-px text-sm">
                <!-- tombol halaman akan dimuat via JS -->
            </ul>
        </nav>
    </div>
</div>


    <!-- Pass route to JavaScript -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Static mapping for kriteria_id to name
            const kriteriaMap = {
                1: '1. Visi,  Misi, Tujuan, Strategi',
                2: '2. Tata Kelola, Tata Pamong, dan Kerjasama',
                3: '3. Kurikulum dan Pembelajaran',
                4: '4. Penelitian',
                5: '5. Luaran Tridharma',
            };

        const urlParams = new URLSearchParams(window.location.search);
        const perPage = urlParams.get('per_page') || 5;
        const page = parseInt(urlParams.get('page')) || 1;

            fetch(`http://127.0.0.1:5000/api/tilik?per_page=${perPage}&page=${page}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success && Array.isArray(result.data)) {
                const tbody = document.getElementById('tilik-table-body');
                tbody.innerHTML = '';

                result.data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.className = "transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700";

                    const kriteriaName = kriteriaMap[item.kriteria_id] || item.kriteria_id;

                    row.innerHTML =` 
                        <td class="px-4 py-3 sm:px-6">${(page - 1) * perPage + index + 1}</td>
                        <td class="px-4 py-3 sm:px-6">${kriteriaName}</td>
                        <td class="px-4 py-3 sm:px-6">${item.pertanyaan}</td>
                        <td class="px-4 py-3 sm:px-6">${item.indikator ?? '-'}</td>
                        <td class="px-4 py-3 sm:px-6">${item.sumber_data ?? '-'}</td>
                        <td class="px-4 py-3 sm:px-6">${item.metode_perhitungan ?? '-'}</td>
                        <td class="px-4 py-3 sm:px-6">${item.target ?? '-'}</td>
                    `;
                    tbody.appendChild(row);
                });
                renderPagination(result.total, page, perPage);
            } else {
                console.error("Gagal mendapatkan data tilik.");
            }
        })
        .catch(error => {
            console.error("Error fetching tilik data:", error);
        });

        function renderPagination(totalItems, currentPage, perPage) {
            const totalPages = Math.ceil(totalItems / perPage);
            const pagination = document.getElementById("pagination-buttons");
            const info = document.getElementById("pagination-info");
            const visiblePages = 5; // Jumlah tombol halaman yang ditampilkan

            pagination.innerHTML = '';
            info.innerHTML = `Menampilkan <strong>${(currentPage - 1) * perPage + 1}</strong> hingga <strong>${Math.min(currentPage * perPage, totalItems)}</strong> dari <strong>${totalItems}</strong> hasil`;

            // Tombol Previous
            const prevLi = document.createElement('li');
            prevLi.innerHTML = `
                <a href="?per_page=${perPage}&page=${currentPage > 1 ? currentPage - 1 : 1}"
                   class="flex h-8 items-center justify-center border ${currentPage === 1 ? 'border-gray-300 bg-white text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400' : 'border-gray-300 bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200'} px-3 leading-tight transition-all duration-200">
                    Previous
                </a>
            `;
            pagination.appendChild(prevLi);

            // Hitung rentang halaman yang ditampilkan
            let startPage = Math.max(1, currentPage - Math.floor(visiblePages / 2));
            let endPage = Math.min(totalPages, startPage + visiblePages - 1);

            if (endPage - startPage + 1 < visiblePages) {
                startPage = Math.max(1, endPage - visiblePages + 1);
            }

            // Tambahkan tombol halaman
            for (let page = startPage; page <= endPage; page++) {
                const li = document.createElement('li');
                li.innerHTML = `
                    <a href="?per_page=${perPage}&page=${page}"
                    class="flex h-8 items-center justify-center border ${page === currentPage ? 'border-sky-300 bg-sky-50 text-sky-800 dark:border-sky-700 dark:bg-sky-900 dark:text-sky-200' : 'border-gray-300 bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200'} px-3 leading-tight transition-all duration-200">
                        ${page}
                    </a>
                `;
                pagination.appendChild(li);
            }

            // Tombol Next
            const nextLi = document.createElement('li');
            nextLi.innerHTML = `
                <a href="?per_page=${perPage}&page=${currentPage < totalPages ? currentPage + 1 : totalPages}"
                class="flex h-8 items-center justify-center border ${currentPage === totalPages ? 'border-gray-300 bg-white text-gray-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400' : 'border-gray-300 bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200'} px-3 leading-tight transition-all duration-200">
                    Next
                </a>
            `;
            pagination.appendChild(nextLi);
        }

    });
</script>
@endsection