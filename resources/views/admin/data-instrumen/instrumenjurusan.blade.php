@extends('layouts.app')

@section('title', 'Instrumen Jurusan')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Instrumen Jurusan', 'url' => ''],
        ['label' => 'List'],
    ]" />

    <!-- Heading -->
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-6">
        Instrumen Jurusan
    </h1>

    <!-- Toolbar -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-2">
            <x-button href="{{ route('admin.data-instrumen.tambah') }}" color="sky" icon="heroicon-o-plus" class="shadow-md hover:shadow-lg transition-all">
                Tambah Instrumen
            </x-button>
            <x-button href="{{ route('admin.data-instrumen.export') }}" color="sky" icon="heroicon-o-document-arrow-down" class="shadow-md hover:shadow-lg transition-all">
                Unduh Data
            </x-button>
        </div>
    </div>

    <!-- Table and Pagination -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
        <!-- Table Controls -->
        <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 rounded-t-2xl border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                <form action="#" method="GET">
                    <select id="perPageSelect" name="per_page" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </form>
                <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
            </div>
            <div class="relative w-full sm:w-auto">
                <form action="#" method="GET">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search" name="search" placeholder="Cari" value="" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                    <tr>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">No</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Sasaran Strategis</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Indikator Kinerja</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Aktivitas</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Satuan</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Target 25</th>
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="instrumen-table-body">
                    <!-- Data akan diisi oleh JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <span id="pagination-info" class="text-sm text-gray-700 dark:text-gray-300">
                    <!-- Info paginasi akan diisi JS -->
                </span>
                <nav aria-label="Navigasi Paginasi">
                    <ul class="inline-flex -space-x-px text-sm">
                        <li>
                            <a id="prevPageBtn" href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-l-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">
                                <x-heroicon-s-chevron-left class="w-4 h-4 mr-1" />
                            </a>
                        </li>
                        <li>
                            <span id="currentPage" class="flex items-center justify-center px-3 h-8 leading-tight text-sky-800 bg-sky-50 dark:bg-sky-900 dark:text-sky-200 border-sky-300 dark:border-sky-700 border transition-all duration-200"></span>
                        </li>
                        <li>
                            <a id="nextPageBtn" href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">
                                <x-heroicon-s-chevron-right class="w-4 h-4 ml-1" />
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
let allData = [];
let currentPage = 1;
let perPage = 5;

// Helper: flatten all aktivitas
function getFlatAktivitas(data) {
    let flat = [];
    data.forEach(sasaran => {
        sasaran.indikator_kinerja.forEach(indikator => {
            indikator.aktivitas.forEach(aktivitas => {
                flat.push({
                    sasaran,
                    indikator,
                    aktivitas
                });
            });
        });
    });
    return flat;
}

// Render Table & Pagination
function renderTable(page = 1) {
    const tableBody = document.getElementById('instrumen-table-body');
    tableBody.innerHTML = '';

    const flatAktivitas = getFlatAktivitas(allData);
    const totalData = flatAktivitas.length;
    const totalPages = Math.ceil(totalData / perPage);

    // Pagination logic
    const start = (page - 1) * perPage;
    const end = Math.min(start + perPage, totalData);
    const pageAktivitas = flatAktivitas.slice(start, end);

    // Buat mapping urutan nomor untuk setiap sasaran_strategis_id di seluruh data
    let sasaranOrder = {};
    let order = 1;
    allData.forEach(sasaran => {
        sasaranOrder[sasaran.sasaran_strategis_id] = order++;
    });

    // Hitung rowspan pada halaman ini
    let sasaranCount = {};
    pageAktivitas.forEach(item => {
        const sid = item.sasaran.sasaran_strategis_id;
        sasaranCount[sid] = (sasaranCount[sid] || 0) + 1;
    });

    let renderedSasaran = {};

    pageAktivitas.forEach((item, idx) => {
        const sid = item.sasaran.sasaran_strategis_id;
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200';

        // Nomor mengikuti urutan sasaran strategis (bukan urutan aktivitas)
        let noCell = '';
        if (!renderedSasaran[sid]) {
            noCell = `<td rowspan="${sasaranCount[sid]}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${sasaranOrder[sid]}</td>`;
            renderedSasaran[sid] = true;
        }

        // Sasaran Strategis (rowspan)
        let sasaranCell = '';
        if (noCell) {
            sasaranCell = `<td rowspan="${sasaranCount[sid]}" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.sasaran.nama_sasaran}</td>`;
        }

        row.innerHTML = `
            ${noCell}
            ${sasaranCell}
            <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.indikator.isi_indikator_kinerja}</td>
            <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.aktivitas.nama_aktivitas}</td>
            <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.aktivitas.satuan}</td>
            <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">${item.aktivitas.target}</td>
            <!-- aksiCell jika ada -->
        `;
        tableBody.appendChild(row);
    });

    // Update pagination info
    const info = document.getElementById('pagination-info');
    if (totalData === 0) {
        info.innerHTML = 'Tidak ada data.';
    } else {
        info.innerHTML = `Menampilkan <strong>${totalData === 0 ? 0 : start + 1}</strong> hingga <strong>${end}</strong> dari <strong>${totalData}</strong> hasil`;
    }

    // Update current page
    document.getElementById('currentPage').textContent = `${page} / ${totalPages}`;

    // Enable/disable prev/next button
    document.getElementById('prevPageBtn').classList.toggle('cursor-not-allowed', page === 1);
    document.getElementById('prevPageBtn').classList.toggle('opacity-50', page === 1);
    document.getElementById('nextPageBtn').classList.toggle('cursor-not-allowed', page === totalPages || totalPages === 0);
    document.getElementById('nextPageBtn').classList.toggle('opacity-50', page === totalPages || totalPages === 0);
}

// Fetch data and setup events
document.addEventListener('DOMContentLoaded', function() {
    fetch('http://127.0.0.1:5000/api/data-instrumen')
        .then(response => response.json())
        .then(data => {
            allData = data;
            renderTable(currentPage);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            document.getElementById('instrumen-table-body').innerHTML = `
                <tr>
                    <td colspan="14" class="px-4 py-3 sm:px-6 text-center text-red-500">
                        Gagal memuat data. Silakan coba lagi.
                    </td>
                </tr>
            `;
        });

    // Per-page select event
    document.getElementById('perPageSelect').addEventListener('change', function(e) {
        perPage = parseInt(e.target.value);
        currentPage = 1;
        renderTable(currentPage);
    });

    // Pagination button events
    document.getElementById('prevPageBtn').addEventListener('click', function(e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            renderTable(currentPage);
        }
    });
    document.getElementById('nextPageBtn').addEventListener('click', function(e) {
        e.preventDefault();
        const flatAktivitas = getFlatAktivitas(allData);
        const totalPages = Math.ceil(flatAktivitas.length / perPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderTable(currentPage);
        }
    });

    // Dropdown Unit Kerja
    fetch('http://127.0.0.1:5000/api/unit-kerja')
        .then(response => response.json())
        .then(result => {
            const data = result.data;
            const select = document.getElementById('unitKerjaSelect');
            data.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit.unit_kerja_id;
                option.textContent = unit.nama_unit_kerja;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Gagal memuat unit kerja:', error);
        });

    // Dropdown Periode
    fetch('http://127.0.0.1:5000/api/periode-audits')
        .then(response => response.json())
        .then(result => {
            const data = result.data.data;
            const select = document.getElementById('periodeSelect');
            data.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit.periode_id;
                option.textContent = unit.nama_periode;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Gagal memuat periode AMI:', error);
        });
});
</script>
@endsection