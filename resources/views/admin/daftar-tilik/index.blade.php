@extends('layouts.app')

@section('title', 'Daftar Tilik')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Daftar Tilik', 'url' => route('admin.daftar-tilik.index')],
        ]" />

        <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Daftar Tilik
        </h1>

        <div class="mb-6 flex gap-2">
            <x-button href="{{ route('admin.daftar-tilik.create') }}" color="sky" icon="heroicon-o-plus">
                Tambah Pertanyaan
            </x-button>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div
                class="flex flex-col items-center justify-between gap-4 rounded-t-2xl border-b border-gray-200 bg-white p-4 sm:flex-row dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <select name="per_page" id="per-page-select" class="w-18 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                </div>
                <div class="relative w-full sm:w-auto">
                    <form id="search-form" method="GET" onsubmit="return false;">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" id="search-input" placeholder="Cari..."
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">No</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Kriteria</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Daftar Pertanyaan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Indikator Kinerja Renstra & LKPS</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Sumber Bukti/Bukti</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Metode Perhitungan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Target</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tilik-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                        </tbody>
                </table>
            </div>

            <div class="p-4">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <span id="pagination-info" class="text-sm text-gray-700 dark:text-gray-300"></span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul id="pagination-buttons" class="inline-flex -space-x-px text-sm"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

<script>
    window.App = {
        routes: {
            editTilik: '{{ route("admin.daftar-tilik.edit", ":id") }}'
        }
    };
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // === KONFIGURASI & VARIABEL ===
    const kriteriaMap = {
        1: '1. Visi, Misi, Tujuan, Strategi',
        2: '2. Tata Kelola, Tata Pamong, dan Kerjasama',
        3: '3. Mahasiswa',
        4: '4. Sumber Daya Manusia',
        5: '5. Keuangan, Sarana, dan Prasarana',
        6: '6. Pendidikan / Kurikulum dan Pembelajaran',
        7: '7. Penelitian',
        8: '8. Pengabdian Kepada Masyarakat',
        9: '9. Luaran Tridharma',
    };

    // === DOM ELEMENTS ===
    const tbody = document.getElementById('tilik-table-body');
    const perPageSelect = document.getElementById('per-page-select');
    const searchInput = document.getElementById('search-input');
    const paginationInfo = document.getElementById('pagination-info');
    const paginationButtons = document.getElementById('pagination-buttons');

    // === STATE VARIABLES ===
    let allTilikData = [];
    let perPage = parseInt(perPageSelect.value) || 10;
    let currentPage = 1;
    let searchQuery = '';

    // === FUNGSI-FUNGSI ===

    function debounce(func, delay) {
        let timeoutId;
        return function (...args) {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func.apply(this, args), delay);
        };
    }

    async function initializeData() {
    showLoadingState();
    try {
        // Mengambil data tilik dan data kriteria secara paralel
        const [tilikResponse, kriteriaResponse] = await Promise.all([
            fetch('http://127.0.0.1:5000/api/tilik/all'), 
            fetch('http://127.0.0.1:5000/api/kriteria')  
        ]);

        if (!tilikResponse.ok) throw new Error('Gagal mengambil data tilik');
        if (!kriteriaResponse.ok) throw new Error('Gagal mengambil data kriteria');
        
        const tilikResult = await tilikResponse.json();
        const kriteriaResult = await kriteriaResponse.json();

        // membangun kriteriaMap secara dinamis
        if (Array.isArray(kriteriaResult)) { 
             kriteriaResult.forEach(item => {
                kriteriaMap[item.kriteria_id] = item.nama_kriteria; 
            });
        } else if (kriteriaResult.success && Array.isArray(kriteriaResult.data)) { // Jika API dibungkus objek
            kriteriaResult.data.forEach(item => {
                kriteriaMap[item.kriteria_id] = item.nama_kriteria;
            });
        }

        if (tilikResult.success) {
            allTilikData = tilikResult.data || [];
            renderTable();
        } else {
            showErrorState(tilikResult.message || 'Gagal memuat data tilik.');
        }

    } catch (error) {
        console.error('Error fetching data:', error);
        showErrorState('Tidak dapat terhubung ke server.');
    }
}

    function renderTable() {
        const filteredData = searchQuery.length > 1
            ? allTilikData.filter(item => {
                const searchTerm = searchQuery.toLowerCase();
                const kriteriaName = kriteriaMap[item.kriteria_id] || '';
                
                return (
                    kriteriaName.toLowerCase().includes(searchTerm) ||
                    (item.pertanyaan || '').toLowerCase().includes(searchTerm) ||
                    (item.indikator || '').toLowerCase().includes(searchTerm) ||
                    (item.sumber_data || '').toLowerCase().includes(searchTerm) ||
                    (item.metode_perhitungan || '').toLowerCase().includes(searchTerm) ||
                    (item.target || '').toLowerCase().includes(searchTerm)
                );
            })
            : allTilikData;

        const totalFilteredItems = filteredData.length;
        const totalPages = Math.ceil(totalFilteredItems / perPage);
        currentPage = Math.min(currentPage, totalPages) || 1;

        const startIndex = (currentPage - 1) * perPage;
        const paginatedData = filteredData.slice(startIndex, startIndex + perPage);

        tbody.innerHTML = '';
        if (paginatedData.length === 0) {
            showEmptyState();
        } else {
            paginatedData.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = "transition-all duration-200 hover:bg-gray-100 dark:hover:bg-gray-700";
                const kriteriaName = kriteriaMap[item.kriteria_id] || item.kriteria_id;
                const nomorUrut = startIndex + index + 1;
                const editUrl = window.App.routes.editTilik.replace(':id', item.tilik_id);

                row.innerHTML = `
                    <td class="px-4 py-3 sm:px-6">${nomorUrut}</td>
                    <td class="px-4 py-3 sm:px-6">${kriteriaName}</td>
                    <td class="px-4 py-3 sm:px-6">${item.pertanyaan}</td>
                    <td class="px-4 py-3 sm:px-6">${item.indikator ?? '-'}</td>
                    <td class="px-4 py-3 sm:px-6">${item.sumber_data ?? '-'}</td>
                    <td class="px-4 py-3 sm:px-6">${item.metode_perhitungan ?? '-'}</td>
                    <td class="px-4 py-3 sm:px-6">${item.target ?? '-'}</td>
                    <td class="px-4 py-3 sm:px-6 border-gray-200 dark:border-gray-600 text-center">
                        <div class="flex items-center gap-2 justify-center">
                            <a href="${editUrl}" class="text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-200 transition-colors duration-200" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"></path></svg>
                            </a>
                            <button data-id="${item.tilik_id}" class="delete-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors duration-200" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a2 2 0 00-2 2v1h8V5a2 2 0 00-2-2zm-3 4h6"></path></svg>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        renderPaginationInfo(startIndex, totalFilteredItems);
        renderPaginationButtons(totalPages);
        addDeleteButtonListeners(); // Tambahkan event listener setelah tombol dibuat
    }

    function renderPaginationInfo(startIndex, totalFilteredItems) {
        const startItem = totalFilteredItems > 0 ? startIndex + 1 : 0;
        const endItem = Math.min(startIndex + perPage, totalFilteredItems);
        paginationInfo.innerHTML = `Menampilkan <strong>${startItem}</strong> hingga <strong>${endItem}</strong> dari <strong>${totalFilteredItems}</strong> hasil`;
    }
    
    function renderPaginationButtons(totalPages) {
        paginationButtons.innerHTML = '';
        if (totalPages <= 1) return;

        const maxVisibleButtons = 5;
        let startPage, endPage;

        if (totalPages <= maxVisibleButtons) {
            startPage = 1;
            endPage = totalPages;
        } else {
            const sideButtons = Math.floor(maxVisibleButtons / 2);
            if (currentPage <= sideButtons) {
                startPage = 1;
                endPage = maxVisibleButtons;
            } else if (currentPage + sideButtons >= totalPages) {
                startPage = totalPages - maxVisibleButtons + 1;
                endPage = totalPages;
            } else {
                startPage = currentPage - sideButtons;
                endPage = currentPage + sideButtons;
            }
        }

        paginationButtons.appendChild(createPageButton(currentPage > 1 ? currentPage - 1 : null, 'Previous', currentPage === 1));
        
        for (let i = startPage; i <= endPage; i++) {
            paginationButtons.appendChild(createPageButton(i, i, false, i === currentPage));
        }

        paginationButtons.appendChild(createPageButton(currentPage < totalPages ? currentPage + 1 : null, 'Next', currentPage === totalPages));
    }
    
    function createPageButton(page, text, isDisabled = false, isActive = false) {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = '#';
        a.dataset.page = page;
        a.textContent = text;
        
        let classes = "flex h-8 items-center justify-center border px-3 leading-tight transition-all duration-200 ";
        if (isDisabled) {
            classes += "border-gray-300 bg-white text-gray-500 cursor-not-allowed opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400";
        } else if (isActive) {
            classes += "border-sky-300 bg-sky-50 text-sky-800 z-10 dark:border-sky-700 dark:bg-sky-900 dark:text-sky-200";
        } else {
            classes += "border-gray-300 bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200";
        }
        a.className = classes;
        
        li.appendChild(a);
        return li;
    }
    
    function showLoadingState() {
        const colCount = document.querySelector('thead tr').childElementCount;
        tbody.innerHTML = `<tr><td colspan="${colCount}" class="text-center p-4"><div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-sky-500 mx-auto"></div><p class="mt-2">Memuat data...</p></td></tr>`;
    }

    function showEmptyState() {
        const colCount = document.querySelector('thead tr').childElementCount;
        tbody.innerHTML = `<tr><td colspan="${colCount}" class="text-center p-4 text-gray-500">Data tidak ditemukan.</td></tr>`;
    }
    
    function showErrorState(message) {
        const colCount = document.querySelector('thead tr').childElementCount;
        tbody.innerHTML = `<tr><td colspan="${colCount}" class="text-center p-4 text-red-500">${message}</td></tr>`;
    }

    // === EVENT LISTENERS ===
    perPageSelect.addEventListener('change', () => {
        perPage = parseInt(perPageSelect.value);
        currentPage = 1;
        renderTable();
    });

    const debouncedSearch = debounce(() => {
        searchQuery = searchInput.value;
        currentPage = 1;
        renderTable();
    }, 300);
    searchInput.addEventListener('input', debouncedSearch);

    paginationButtons.addEventListener('click', (e) => {
        e.preventDefault();
        const target = e.target.closest('a');
        if (target && target.dataset.page) {
            const page = parseInt(target.dataset.page);
            if (!isNaN(page) && page !== currentPage) {
                currentPage = page;
                renderTable();
            }
        }
    });

    function addDeleteButtonListeners() {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const tilikId = this.getAttribute('data-id');
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    // PASTIKAN PORT DI SINI JUGA BENAR
                    fetch(`http://127.0.0.1:5000/api/tilik/${tilikId}`, {
                        method: 'DELETE',
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            alert('Data berhasil dihapus!');
                            initializeData(); // Muat ulang semua data dari awal
                        } else {
                            alert('Gagal menghapus data: ' + (result.message || 'Error tidak diketahui'));
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting data:', error);
                        alert('Terjadi kesalahan saat menghubungi server untuk menghapus data.');
                    });
                }
            });
        });
    }

    // === INISIALISASI ===
    initializeData();
});
</script>
@endsection