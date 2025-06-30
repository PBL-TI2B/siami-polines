@extends('layouts.app')

@section('title', 'Laporan Temuan Audit')

@push('style')
    {{-- Pastikan Flowbite dan komponen lainnya sudah ter-load di layout utama --}}
@endpush

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            ['label' => 'Laporan Temuan'],
        ]" class="mb-6" />

        <div class="mb-6 flex flex-col items-start justify-between gap-y-4 sm:flex-row sm:items-center">
            {{-- Heading --}}
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200">
                    Laporan Temuan Audit
                </h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Berikut adalah laporan semua temuan hasil audit yang ditujukan untuk unit Anda.
                </p>
            </div>

            {{-- Action Button --}}
            <div class="flex-shrink-0">
                <x-button href="{{ route('auditee.laporan-temuan.preview-ptpp', ['auditing' => $audit['auditing_id']]) }}"
                    color="green">
                    <x-heroicon-o-arrow-down-tray class="mr-2 h-5 w-5" />
                    <span>Download PTPP</span>
                </x-button>
            </div>
        </div>


        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            {{-- Kartu Informasi Unit Kerja, Auditor, Auditee --}}
            <div
                class="flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div
                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 dark:bg-sky-900 dark:text-sky-300">
                    <x-heroicon-o-building-office-2 class="h-6 w-6" />
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Unit Kerja/Jurusan/Prodi</h3>
                    <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                        {{ $audit['unit_kerja']['nama_unit_kerja'] ?? '-' }}
                    </p>
                </div>
            </div>
            <div
                class="flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div
                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 dark:bg-sky-900 dark:text-sky-300">
                    <x-heroicon-o-user-group class="h-6 w-6" />
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Auditor</h3>
                    <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                        {{ $audit['auditor1']['nama'] ?? '-' }}
                    </p>
                    <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                        {{ $audit['auditor2']['nama'] ?? '-' }}
                    </p>
                </div>
            </div>
            <div
                class="flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div
                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 dark:bg-sky-900 dark:text-sky-300">
                    <x-heroicon-o-user class="h-6 w-6" />
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Auditee</h3>
                    <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                        {{ $audit['auditee1']['nama'] ?? '-' }}
                    </p>
                    <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">
                        {{ $audit['auditee2']['nama'] ?? '-' }}
                    </p>
                </div>
            </div>
        </div>


        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-gray-200 p-4 dark:border-gray-700">
                {{-- Form Filter --}}
                <form id="filter-form" method="GET" action="#">
                    <div class="flex flex-wrap items-center justify-center gap-4 md:justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                            <select id="perPageSelect" name="per_page"
                                class="w-20 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                            <span class="text-sm text-gray-700 dark:text-gray-300">data</span>
                        </div>

                        <div class="flex flex-wrap items-center justify-center gap-2">
                            <select name="filter-kategori"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 py-2.5 pl-2.5 pr-8 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 sm:w-auto dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                                <option value="" selected>Semua Kategori</option>
                                <option value="NC">NC</option>
                                <option value="AOC">AOC</option>
                                <option value="OFI">OFI</option>
                            </select>
                            <div class="relative w-full sm:w-68">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-500 dark:text-gray-400" />
                                </div>
                                <input type="search" name="search" id="search-input"
                                    placeholder="Cari Kriteria, Standar, Temuan" value=""
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                {{-- Tabel Konten --}}
                <table class="min-w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead
                        class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-700 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">No</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Kriteria</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Standar Nasional</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Uraian Temuan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 text-center sm:px-6 dark:border-gray-700">Kategori</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Akar Penyebab</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 dark:border-gray-700">Saran Perbaikan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- Data tabel akan di-render oleh JavaScript --}}
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 p-4 dark:border-gray-700">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <span id="pagination-info" class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> temuan
                    </span>
                    <nav aria-label="Navigasi Paginasi" id="pagination-nav">
                        <ul class="inline-flex -space-x-px text-sm">
                            <li>
                                <a href="#" id="prev-page"
                                    class="flex h-8 items-center justify-center rounded-l-lg border border-gray-200 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    <span class="sr-only">Sebelumnya</span>
                                    <x-heroicon-o-chevron-left class="h-4 w-4" />
                                </a>
                            </li>
                            {{-- Nomor halaman akan disisipkan di sini oleh JavaScript --}}
                            <div id="page-numbers" class="inline-flex"></div>
                            <li>
                                <a href="#" id="next-page"
                                    class="flex h-8 items-center justify-center rounded-r-lg border border-gray-200 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    <span class="sr-only">Berikutnya</span>
                                    <x-heroicon-o-chevron-right class="h-4 w-4" />
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elemen UI
            const searchInput = document.getElementById('search-input');
            const categoryFilter = document.querySelector('select[name="filter-kategori"]');
            const perPageSelect = document.getElementById('perPageSelect');
            const tableBody = document.querySelector('tbody');
            const paginationInfo = document.getElementById('pagination-info');
            const pageNumbersContainer = document.getElementById('page-numbers');
            const prevPage = document.getElementById('prev-page');
            const nextPage = document.getElementById('next-page');

            // State
            const originalData = @json($laporanTemuan ?? []);
            let filteredData = [...originalData];
            let currentPage = 1;
            let itemsPerPage = parseInt(perPageSelect.value);

            function filterAndRender() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value.toLowerCase();

                filteredData = originalData.filter(temuan => {
                    const matchesSearch = !searchTerm ||
                        ((temuan.kriteria?.nama_kriteria || '').toLowerCase().includes(searchTerm)) ||
                        ((temuan.uraian_temuan || '').toLowerCase().includes(searchTerm)) ||
                        ((temuan.saran_perbaikan || '').toLowerCase().includes(searchTerm)) ||
                        ((temuan.response_tilik?.standar_nasional || '').toLowerCase().includes(searchTerm)) ||
                        ((temuan.response_tilik?.akar_penyebab_penunjang || '').toLowerCase().includes(searchTerm));

                    const matchesCategory = !selectedCategory || (temuan.kategori_temuan || '').toLowerCase() === selectedCategory;
                    return matchesSearch && matchesCategory;
                });

                currentPage = 1;
                render();
            }

            function render() {
                renderTable();
                updatePagination();
            }

            function renderTable() {
                const startIndex = (currentPage - 1) * itemsPerPage;
                const pageData = filteredData.slice(startIndex, startIndex + itemsPerPage);

                tableBody.innerHTML = '';

                if (pageData.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    <p class="text-lg font-medium">Tidak ada data ditemukan</p>
                                    <p class="text-sm">Coba ubah filter atau kata kunci pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>`;
                    return;
                }

                const groupedData = {};
                pageData.forEach(temuan => {
                    const kriteriaId = temuan.kriteria_id;
                    if (!groupedData[kriteriaId]) {
                        groupedData[kriteriaId] = {
                            nama_kriteria: temuan.kriteria?.nama_kriteria || 'Kriteria tidak diketahui',
                            findings: []
                        };
                    }
                    groupedData[kriteriaId].findings.push(temuan);
                });

                let html = '';
                const uniqueKriteriaIdsInFilteredData = [...new Set(filteredData.map(item => item.kriteria_id))];

                Object.keys(groupedData).forEach(kriteriaId => {
                    const group = groupedData[kriteriaId];
                    const groupRowSpan = group.findings.length;

                    // SOLUSI BUG 1: Menggunakan parseInt untuk menyamakan tipe data (string -> number)
                    const globalNo = uniqueKriteriaIdsInFilteredData.indexOf(parseInt(kriteriaId, 10)) + 1;

                    group.findings.forEach((temuan, indexInGroup) => {
                        const kategori = temuan.kategori_temuan || '';
                        const badgeClass = {
                            'NC': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                            'AOC': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                            'OFI': 'bg-sky-100 text-sky-800 dark:bg-sky-900 dark:text-sky-300'
                        }[kategori] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';

                        html += `<tr class="transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700">`;
                        if (indexInGroup === 0) {
                            html += `<td rowspan="${groupRowSpan}" class="border-r border-gray-200 px-4 py-3 text-center align-top sm:px-6 dark:border-gray-700">${globalNo}</td>`;
                            html += `<td rowspan="${groupRowSpan}" class="border-r border-gray-200 px-4 py-3 align-top font-medium text-gray-900 sm:px-6 dark:border-gray-700 dark:text-white">${group.nama_kriteria}</td>`;
                        }
                        html += `<td class="border-r border-gray-200 px-4 py-3 align-middle sm:px-6 dark:border-gray-700">${temuan.response_tilik?.standar_nasional || '-'}</td>`;
                        html += `<td class="border-r border-gray-200 px-4 py-3 align-middle sm:px-6 dark:border-gray-700">${temuan.uraian_temuan || '-'}</td>`;
                        html += `<td class="whitespace-nowrap border-r border-gray-200 px-4 py-3 text-center align-middle sm:px-6 dark:border-gray-700"><span class="rounded-md px-2.5 py-1 text-xs font-medium ${badgeClass}">${kategori || '-'}</span></td>`;
                        html += `<td class="border-r border-gray-200 px-4 py-3 align-middle sm:px-6 dark:border-gray-700">${temuan.response_tilik?.akar_penyebab_penunjang || '-'}</td>`;
                        html += `<td class="px-4 py-3 align-middle sm:px-6 dark:border-gray-700">${temuan.saran_perbaikan || '-'}</td>`;
                        html += '</tr>';
                    });
                });
                tableBody.innerHTML = html;
            }

            function updatePagination() {
                const totalItems = filteredData.length;
                const totalPages = Math.ceil(totalItems / itemsPerPage);
                const startItem = totalItems === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
                const endItem = Math.min(currentPage * itemsPerPage, totalItems);

                paginationInfo.innerHTML = totalItems === 0 ? 'Tidak ada data temuan' :
                    `Menampilkan <strong>${startItem}</strong> hingga <strong>${endItem}</strong> dari <strong>${totalItems}</strong> temuan`;

                pageNumbersContainer.innerHTML = '';

                // SOLUSI BUG 2: Mengubah kondisi dari totalPages > 1 menjadi totalPages > 0
                if (totalPages > 0) {
                    const pages = [];
                    const pageRange = 1;
                    for (let i = 1; i <= totalPages; i++) {
                        if (i === 1 || i === totalPages || (i >= currentPage - pageRange && i <= currentPage + pageRange)) {
                            pages.push(i);
                        }
                    }

                    let lastPage = 0;
                    pages.forEach(page => {
                        if (lastPage !== 0 && page - lastPage > 1) {
                            pageNumbersContainer.innerHTML += `<li><span class="flex h-8 items-center justify-center border border-gray-200 bg-white px-3 leading-tight text-gray-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400">...</span></li>`;
                        }
                        pageNumbersContainer.innerHTML += `
                            <li>
                                <a href="#" data-page="${page}" class="page-link flex h-8 items-center justify-center border border-gray-200 px-3 leading-tight transition-all duration-200 ${
                                    currentPage === page
                                    ? 'bg-sky-50 text-sky-600 dark:bg-gray-700 dark:text-white'
                                    : 'bg-white text-gray-500 hover:bg-gray-50 hover:text-gray-800 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200'
                                }">${page}</a>
                            </li>`;
                        lastPage = page;
                    });
                }

                prevPage.classList.toggle('pointer-events-none', currentPage === 1);
                prevPage.classList.toggle('opacity-50', currentPage === 1);
                nextPage.classList.toggle('pointer-events-none', currentPage === totalPages || totalPages === 0);
                nextPage.classList.toggle('opacity-50', currentPage === totalPages || totalPages === 0);
            }

            // Event Listeners
            searchInput.addEventListener('input', filterAndRender);
            categoryFilter.addEventListener('change', filterAndRender);
            perPageSelect.addEventListener('change', function() {
                itemsPerPage = parseInt(this.value);
                filterAndRender();
            });

            prevPage.addEventListener('click', (e) => {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    render();
                }
            });

            nextPage.addEventListener('click', (e) => {
                e.preventDefault();
                const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    render();
                }
            });

            pageNumbersContainer.addEventListener('click', (e) => {
                e.preventDefault();
                if (e.target.matches('.page-link')) {
                    const page = parseInt(e.target.dataset.page);
                    if (page !== currentPage) {
                        currentPage = page;
                        render();
                    }
                }
            });

            // Initial Render
            filterAndRender();
        });
    </script>
@endpush
