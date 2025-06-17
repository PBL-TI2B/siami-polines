@extends('layouts.app')

@section('title', 'Data Instrumen Prodi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data Instrumen Prodi', 'url' => route('admin.data-instrumen.instrumenprodi')],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Data Instrumen Prodi
        </h1>

        <!-- Table and Pagination -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
            <!-- Table Controls -->
            <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 rounded-t-2xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <form action="#" method="GET">
                        <select name="per_page" id="per-page-select" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25" selected>25</option>
                            <option value="50">50</option>
                        </select>
                    </form>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                </div>
                <div class="relative w-full sm:w-auto">
                    <form id="search-form" method="GET">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" id="search-input" placeholder="Cari" value="" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">No</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Standar</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Deskripsi Area Audit-Sub Butir Standar</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pemeriksaan Pada Unsur</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Jenis Unit Kerja</th>
                        </tr>
                    </thead>
                    <tbody id="instrumen-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span id="pagination-info" class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul class="inline-flex -space-x-px"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- modal toast --}}
    <div id="responseModal" class="hidden fixed top-4 end-4 z-50 bg-transparent transition-opacity duration-300">
        <div class="w-full max-w-md p-4 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200" id="modalIcon">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="sr-only">Ikon Sukses</span>
                </div>
                <div class="ms-3 text-sm font-normal text-gray-500 dark:text-gray-400" id="modalMessage">
                    Action completed successfully.
                </div>
                <button type="button" id="closeResponseModal" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Tutup">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div id="deleteConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Konfirmasi Hapus Response</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-6">
                Apakah Anda yakin menghapus instrumen prodi? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-3">
                <button id="cancelDeleteBtn" type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition-all duration-200">
                    Batal
                </button>
                <button id="confirmDeleteBtn" type="button" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-sky-700 transition-all duration-200">
                    Ya, Hapus Instrumen Prodi
                </button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentInstrumenId = null; // To store the ID of the item to delete
            let perPage = 25; // Default entries per page
            let currentPage = 1; // Default page
            let searchQuery = ''; // Search query
            let totalFilteredItems = 0; // Total items after filtering
            let totalPages = 0; // Total pages

            // Define standard order and create number mapping
            const standardOrder = [
                'Visi, Misi, Tujuan, Strategi',
                'Tata kelola, Tata pamong, dan Kerjasama',
                'Mahasiswa',
                'Sumber Daya Manusia',
                'Keuangan, Sarana, dan Prasarana',
                'Pendidikan / Kurikulum dan Pembelajaran',
                'Penelitian',
                'Pengabdian Kepada Masyarakat',
                'Luaran Tridharma'
            ];
            const standardNumberMap = standardOrder.reduce((map, standard, index) => {
                map[standard] = index + 1; // Map each standard to 1-based index
                return map;
            }, {});

            // Function to show toast modal
            function showToast(message, isSuccess = true) {
                const modal = document.getElementById('responseModal');
                const modalMessage = document.getElementById('modalMessage');
                const modalIcon = document.getElementById('modalIcon');

                modalMessage.textContent = message;
                modalIcon.className = isSuccess
                    ? 'inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200'
                    : 'inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200';

                modal.classList.remove('hidden');
                setTimeout(() => modal.classList.add('hidden'), 3000);
            }

            // Debounce utility for search
            function debounce(func, delay) {
                let timeoutId;
                return function (...args) {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => func.apply(this, args), delay);
                };
            }

            // Function to fetch and render the table based on jenis_unit_id, page, and search
            function renderTable(jenisUnitId = 3, page = 1) {
                currentPage = parseInt(page) || 1;
                const tableBody = document.getElementById('instrumen-table-body');
                const paginationInfo = document.getElementById('pagination-info');
                const pageNumbersContainer = document.querySelector('nav[aria-label="Navigasi Paginasi"] ul');
                tableBody.innerHTML = ''; // Clear the table before rendering

                fetch('http://127.0.0.1:5000/api/set-instrumen')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal mengambil data dari server');
                        }
                        return response.json();
                    })
                    .then(result => {
                        // Filter data based on jenis_unit_id and search query
                        let data = result.data;
                        if (jenisUnitId) {
                            data = data.filter(item => item.jenis_unit_id === parseInt(jenisUnitId));
                        }
                        if (searchQuery) {
                            const searchTerm = searchQuery.toLowerCase();
                            data = data.filter(item =>
                                (item.unsur?.deskripsi?.kriteria?.nama_kriteria || '').toLowerCase().includes(searchTerm) ||
                                (item.unsur?.deskripsi?.isi_deskripsi || '').toLowerCase().includes(searchTerm) ||
                                (item.unsur?.isi_unsur || '').toLowerCase().includes(searchTerm) ||
                                (item.jenisunit?.nama_jenis_unit || '').toLowerCase().includes(searchTerm)
                            );
                        }

                        // If no data after filtering, show a message
                        if (data.length === 0) {
                            tableBody.innerHTML = `
                                <tr>
                                    <td colspan="12" class="px-4 py-3 sm:px-6 text-center text-gray-500">
                                        Tidak ada data untuk unit kerja atau pencarian yang dipilih.
                                    </td>
                                </tr>
                            `;
                            if (paginationInfo) {
                                paginationInfo.innerHTML = `
                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> hasil
                                    </span>`;
                            }
                            pageNumbersContainer.innerHTML = '';
                            return;
                        }

                        // Group data for table rendering
                        const grouped = {};
                        const rowspanStandar = {};
                        const flatGroupedData = [];

                        data.forEach(item => {
                            const standar = item.unsur?.deskripsi?.kriteria?.nama_kriteria || 'Tidak Diketahui';
                            const deskripsi = item.unsur?.deskripsi?.isi_deskripsi || 'Tidak Diketahui';
                            const unsur = item.unsur?.isi_unsur || 'Tidak Diketahui';

                            if (!grouped[standar]) {
                                grouped[standar] = {};
                                rowspanStandar[standar] = 0;
                            }
                            if (!grouped[standar][deskripsi]) {
                                grouped[standar][deskripsi] = {};
                            }
                            if (!grouped[standar][deskripsi][unsur]) {
                                grouped[standar][deskripsi][unsur] = [];
                            }
                            grouped[standar][deskripsi][unsur].push(item);
                            rowspanStandar[standar]++;
                            flatGroupedData.push({ standar, deskripsi, unsur, item });
                        });

                        // Sort flatGroupedData by standardOrder, then by deskripsi and unsur
                        flatGroupedData.sort((a, b) => {
                            const aNumber = standardNumberMap[a.standar] || 999; // Default to 999 for unmapped
                            const bNumber = standardNumberMap[b.standar] || 999;
                            if (aNumber !== bNumber) return aNumber - bNumber; // Sort by standard number
                            // Secondary sort by deskripsi
                            if (a.deskripsi !== b.deskripsi) return a.deskripsi.localeCompare(b.deskripsi);
                            // Tertiary sort by unsur
                            return a.unsur.localeCompare(b.unsur);
                        });

                        // Pagination calculations
                        totalFilteredItems = flatGroupedData.length;
                        totalPages = Math.ceil(totalFilteredItems / perPage);
                        currentPage = Math.min(currentPage, totalPages) || 1;
                        const startIndex = (currentPage - 1) * perPage;
                        const endIndex = Math.min(startIndex + perPage, totalFilteredItems);
                        const paginatedData = flatGroupedData.slice(startIndex, endIndex);

                        // Calculate rowspan for paginated data
                        const rowspanStandarPaginated = {};
                        const rowspanDeskripsi = {};
                        paginatedData.forEach(({ standar, deskripsi }) => {
                            rowspanStandarPaginated[standar] = (rowspanStandarPaginated[standar] || 0) + 1;
                            rowspanDeskripsi[`${standar}-${deskripsi}`] = (rowspanDeskripsi[`${standar}-${deskripsi}`] || 0) + 1;
                        });

                        // Render the table
                        let displayedStandar = new Set();
                        let displayedDeskripsi = new Set();
                        paginatedData.forEach(({ standar, deskripsi, unsur, item }) => {
                            const row = document.createElement('tr');
                            let html = '';

                            if (!displayedStandar.has(standar)) {
                                // Use standardNumberMap for numbering, default to '-' if not found
                                const number = standardNumberMap[standar] || '-';
                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${rowspanStandarPaginated[standar]}">${number}</td>`;
                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${rowspanStandarPaginated[standar]}">${standar}</td>`;
                                displayedStandar.add(standar);
                            }

                            if (!displayedDeskripsi.has(`${standar}-${deskripsi}`)) {
                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${rowspanDeskripsi[`${standar}-${deskripsi}`]}">${deskripsi}</td>`;
                                displayedDeskripsi.add(`${standar}-${deskripsi}`);
                            }

                            html += `
                                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${unsur}</td>
                                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${item.jenisunit?.nama_jenis_unit || 'Tidak Diketahui'}</td>
                                
                            `;
                            row.innerHTML = html;
                            tableBody.appendChild(row);
                        });

                    // Update pagination info
                    const currentStart = totalFilteredItems === 0 ? 0 : startIndex + 1;
                    const currentEnd = endIndex;
                    if (paginationInfo) {
                        paginationInfo.innerHTML = `
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                Menampilkan <strong>${currentStart}</strong> hingga <strong>${currentEnd}</strong> dari <strong>${totalFilteredItems}</strong> entries
                            </span>`;
                    }

                    // Render pagination links
                    pageNumbersContainer.innerHTML = `
                        <li>
                            <a href="#" id="prev-page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-l-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 ${currentPage === 1 ? 'opacity-50 pointer-events-none' : ''}">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </a>
                        </li>`;

                        const pages = [];
                        if (totalPages <= 7) {
                            for (let i = 1; i <= totalPages; i++) pages.push(i);
                        } else {
                            pages.push(1, 2);
                            if (currentPage > 4) pages.push('...');
                            const start = Math.max(3, currentPage - 1);
                            const end = Math.min(totalPages - 2, currentPage + 1);
                            for (let i = start; i <= end; i++) pages.push(i);
                            if (currentPage < totalPages - 3) pages.push('...');
                            pages.push(totalPages - 1, totalPages);
                        }

                        pages.forEach(page => {
                            if (page === '...') {
                                pageNumbersContainer.innerHTML += `
                                    <li>
                                        <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700">...</span>
                                    </li>`;
                            } else {
                                pageNumbersContainer.innerHTML += `
                                    <li>
                                        <a href="#" class="page-link flex items-center justify-center px-3 h-8 leading-tight ${page === currentPage ? 'text-sky-600 bg-sky-50 dark:bg-sky-900 dark:text-sky-200 border-sky-300 dark:border-sky-700' : 'text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700'} border hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200" data-page="${page}">${page}</a>
                                    </li>`;
                            }
                        });

                        pageNumbersContainer.innerHTML += `
                            <li>
                                <a href="#" id="next-page" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 ${currentPage === totalPages || totalPages === 0 ? 'opacity-50 pointer-events-none' : ''}">
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </li>`;
                    })
                    .catch(error => {
                        showToast('Gagal memuat data. Silakan coba lagi.', false);
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="12" class="px-4 py-3 sm:px-6 text-center text-red-500">
                                    Gagal memuat data. Silakan coba again.
                                </td>
                            </tr>
                        `;
                        if (paginationInfo) {
                            paginationInfo.innerHTML = `
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> entri
                                </span>`;
                        }
                        pageNumbersContainer.innerHTML = '';
                    });
            }

            // Event listener for delete buttons
            document.getElementById('instrumen-table-body').addEventListener('click', function (e) {
                const deleteBtn = e.target.closest('.delete-btn');
                if (deleteBtn) {
                    e.preventDefault();
                    currentInstrumenId = deleteBtn.getAttribute('data-id');
                    document.getElementById('deleteConfirmModal').classList.remove('hidden');
                }
            });

            // Event listener for cancel button in delete modal
            document.getElementById('cancelDeleteBtn').addEventListener('click', function () {
                document.getElementById('deleteConfirmModal').classList.add('hidden');
                currentInstrumenId = null;
            });

            // Event listener for confirm delete button
            document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
                document.getElementById('deleteConfirmModal').classList.add('hidden');
                if (currentInstrumenId) {
                    fetch(`http://127.0.0.1:5000/api/set-instrumen/${currentInstrumenId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Gagal menghapus instrumen');
                            }
                            return response.json();
                        })
                        .then(result => {
                            showToast('Instrumen berhasil dihapus!', true);
                            setTimeout(() => {
                                const selectedUnitId = 3;
                                renderTable(selectedUnitId, currentPage);
                            }, 1000); // Re-render with current unit and page
                        })
                        .catch(error => {
                            showToast('Gagal menghapus instrumen. Silakan coba lagi.', false);
                        });
                    currentInstrumenId = null;
                }
            });

            // Event listener for closing toast modal
            document.getElementById('closeResponseModal').addEventListener('click', function () {
                document.getElementById('responseModal').classList.add('hidden');
            });

            // Event listener for pagination
            const pageNumbersContainer = document.querySelector('nav[aria-label="Navigasi Paginasi"] ul');
            if (pageNumbersContainer) {
                pageNumbersContainer.addEventListener('click', function (e) {
                    e.preventDefault();
                    const pageLink = e.target.closest('.page-link');
                    const prevBtn = e.target.closest('#prev-page');
                    const nextBtn = e.target.closest('#next-page');
                    const selectedUnitId = 3;
                    if (pageLink) {
                        const page = parseInt(pageLink.getAttribute('data-page'));
                        renderTable(selectedUnitId, page);
                    } else if (prevBtn && currentPage > 1) {
                        renderTable(selectedUnitId, currentPage - 1);
                    } else if (nextBtn && currentPage < totalPages) {
                        renderTable(selectedUnitId, currentPage + 1);
                    }
                });
            }

            // Event listener for per-page dropdown
            const perPageSelect = document.querySelector('select[name="per_page"]');
            if (perPageSelect) {
                perPageSelect.addEventListener('change', function (e) {
                    e.preventDefault();
                    perPage = parseInt(perPageSelect.value);
                    const selectedUnitId = 3;
                    renderTable(selectedUnitId, 1); // Reset to page 1 on perPage change
                });
            }

            // Event listener for search input
            const searchInput = document.getElementById('search-input');
            if (searchInput) {
                const debouncedSearch = debounce(function () {
                    searchQuery = searchInput.value.trim();
                    const selectedUnitId = 3;
                    renderTable(selectedUnitId, 1); // Reset to page 1 on search
                }, 300);
                searchInput.addEventListener('input', debouncedSearch);
                searchInput.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        searchQuery = searchInput.value.trim();
                        const selectedUnitId = 3;
                        renderTable(selectedUnitId, 1); // Reset to page 1 on search
                    }
                });
            }

            // Initial table render
            renderTable(3, 1);
        });
    </script>
@endsection