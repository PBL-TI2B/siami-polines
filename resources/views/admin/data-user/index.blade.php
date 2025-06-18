@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <x-toast id="toast-success" type="success" :message="session('success')" />
        @endif

        @if (session('error') || $errors->any())
            <x-toast id="toast-danger" type="danger">
                @if (session('error'))
                    {{ session('error') }}<br>
                @endif
                {{-- Loop through validation errors if they exist --}}
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </x-toast>
        @endif

        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data User', 'url' => route('admin.data-user.index')],
            ['label' => 'Daftar User'],
        ]" />

        <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Daftar User
        </h1>

        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex flex-wrap gap-2">
                <x-button href="{{ route('admin.data-user.create') }}" color="sky" icon="heroicon-o-plus"
                    class="shadow-md hover:shadow-lg transition-all">
                    Tambah Data
                </x-button>
            </div>

            {{-- Filter Dropdowns (Removed) --}}
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
            <div
                class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 rounded-t-2xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <select id="perPageSelect"
                        class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                </div>

                <div class="relative w-full sm:w-auto">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="search" id="search-input" placeholder="Cari..." value=""
                        class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">No
                            </th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Nama
                            </th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">NIP
                            </th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Email
                            </th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Role
                            </th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Unit
                                Kerja</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="user-table-body">
                        </tbody>
                </table>
                <div id="no-data-message" class="hidden text-center py-4 text-gray-500 dark:text-gray-400">
                    Tidak ada data user yang ditemukan.
                </div>
            </div>

            <div class="p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span id="pagination-info" class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>0</strong> hingga <strong>0</strong> dari <strong>0</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul id="pagination" class="inline-flex -space-x-px text-sm">
                            </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal (example, adjust based on your x-confirmation-modal component) --}}
    <x-confirmation-modal id="delete-user-modal" title="Konfirmasi Hapus Data" action="" method="DELETE"
        type="delete" formClass="delete-modal-form" itemName=""
        warningMessage="Menghapus user ini akan menghapus seluruh data terkait user tersebut." />


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const API_BASE_URL = 'http://127.0.0.1:5000/api/data-user';
                // ROLE_API_URL and UNIT_KERJA_API_URL are no longer needed
                // const ROLE_API_URL = 'http://127.0.0.1:5000/api/roles';
                // const UNIT_KERJA_API_URL = 'http://127.0.0.1:5000/api/unit-kerja';

                const tableBody = document.getElementById('user-table-body');
                const paginationContainer = document.getElementById('pagination');
                const perPageSelect = document.getElementById('perPageSelect');
                const info = document.getElementById('pagination-info');
                const searchInput = document.getElementById('search-input');
                // const roleFilterSelect = document.getElementById('roleFilterSelect'); // No longer needed
                // const unitKerjaFilterSelect = document.getElementById('unitKerjaFilterSelect'); // No longer needed
                const noDataMessage = document.getElementById('no-data-message');

                let ITEMS_PER_PAGE = parseInt(perPageSelect.value);
                let currentPage = 1;
                let allUsers = []; // Stores all fetched user data
                let filteredUsers = []; // Stores users after applying filters (only search remains)

                let searchQuery = '';
                // let selectedRoleId = ''; // No longer needed
                // let selectedUnitKerjaId = ''; // No longer needed

                // --- Event Listeners ---
                perPageSelect.addEventListener('change', function() {
                    ITEMS_PER_PAGE = parseInt(this.value);
                    currentPage = 1; // Reset to first page on entries change
                    applyFiltersAndRender();
                });

                searchInput.addEventListener('input', function() {
                    searchQuery = this.value.toLowerCase();
                    currentPage = 1; // Reset to first page on search
                    applyFiltersAndRender();
                });

                // Removed event listeners for role and unit kerja filters
                // roleFilterSelect.addEventListener('change', function() { /* ... */ });
                // unitKerjaFilterSelect.addEventListener('change', function() { /* ... */ });

                // --- Data Fetching Functions ---

                async function fetchUsers() {
                    try {
                        const response = await fetch(API_BASE_URL);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const result = await response.json();
                        allUsers = result.data || []; // Assuming API returns data under 'data' key
                        applyFiltersAndRender(); // Initial render
                    } catch (error) {
                        console.error('Error fetching users:', error);
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="6" class="px-4 py-3 sm:px-6 text-center text-red-500 dark:text-red-400">
                                    Gagal memuat data user. Silakan coba lagi.
                                </td>
                            </tr>
                        `;
                        noDataMessage.classList.add('hidden');
                        info.textContent = 'Menampilkan 0 hingga 0 dari 0 hasil';
                        paginationContainer.innerHTML = '';
                    }
                }

                // Removed fetchRoles and fetchUnitKerjas functions
                // async function fetchRoles() { /* ... */ }
                // async function fetchUnitKerjas() { /* ... */ }

                // --- Filtering and Rendering Logic ---

                function applyFiltersAndRender() {
                    filteredUsers = allUsers.filter(user => {
                        const matchesSearch =
                            (user.nama && user.nama.toLowerCase().includes(searchQuery)) ||
                            (user.email && user.email.toLowerCase().includes(searchQuery)) ||
                            (user.nip && user.nip.toLowerCase().includes(searchQuery)) ||
                            (user.role && user.role.nama_role && user.role.nama_role.toLowerCase().includes(searchQuery)) ||
                            (user.unit_kerja && user.unit_kerja.nama_unit_kerja && user.unit_kerja.nama_unit_kerja.toLowerCase().includes(searchQuery));

                        // Removed role and unit kerja filter conditions
                        // const matchesRole = selectedRoleId ? (user.role && user.role.role_id == selectedRoleId) : true;
                        // const matchesUnitKerja = selectedUnitKerjaId ? (user.unit_kerja && user.unit_kerja.unit_kerja_id == selectedUnitKerjaId) : true;

                        // Only return based on search now
                        return matchesSearch; // && matchesRole && matchesUnitKerja;
                    });

                    renderTable(currentPage, filteredUsers);
                    renderPagination(filteredUsers);
                }


                function renderTable(page, data = []) {
                    tableBody.innerHTML = ''; // Clear existing rows
                    const startIndex = (page - 1) * ITEMS_PER_PAGE;
                    const endIndex = startIndex + ITEMS_PER_PAGE;
                    const dataToShow = data.slice(startIndex, endIndex);

                    if (dataToShow.length === 0) {
                        noDataMessage.classList.remove('hidden');
                        return;
                    } else {
                        noDataMessage.classList.add('hidden');
                    }

                    dataToShow.forEach((user, index) => {
                        const row = document.createElement('tr');
                        row.className =
                            'border-y border-gray-200 bg-white transition-all duration-200 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600';

                        row.innerHTML = `
                            <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                                ${startIndex + index + 1}
                            </td>
                            <td class="px-4 py-4 text-gray-900 sm:px-6 border-r border-gray-200 dark:border-gray-700 dark:text-gray-200">
                                ${user.nama || 'N/A'}
                            </td>
                            <td class="px-4 py-4 text-gray-900 sm:px-6 border-r border-gray-200 dark:border-gray-700 dark:text-gray-200">
                                ${user.nip || 'N/A'}
                            </td>
                            <td class="px-4 py-4 text-gray-900 sm:px-6 border-r border-gray-200 dark:border-gray-700 dark:text-gray-200">
                                ${user.email || 'N/A'}
                            </td>
                            <td class="px-4 py-4 text-gray-900 sm:px-6 border-r border-gray-200 dark:border-gray-700 dark:text-gray-200">
                                ${user.role ? user.role.nama_role : 'N/A'}
                            </td>
                            <td class="px-4 py-4 text-gray-900 sm:px-6 border-r border-gray-200 dark:border-gray-700 dark:text-gray-200">
                                ${user.unit_kerja ? user.unit_kerja.nama_unit_kerja : 'N/A'}
                            </td>
                            <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    <a href="/admin/data-user/${user.user_id}/edit" class="text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-200 transition-colors duration-200" title="Edit">
                                        <x-heroicon-o-pencil class="w-5 h-5" />
                                    </a>
                                    <button type="button" onclick="showDeleteUserModal('${user.user_id}', '${user.nama}')" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors duration-200" title="Hapus">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </div>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                }

                function renderPagination(data = []) {
                    paginationContainer.innerHTML = '';
                    const pageCount = Math.ceil(data.length / ITEMS_PER_PAGE);
                    const startItem = data.length > 0 ? (currentPage - 1) * ITEMS_PER_PAGE + 1 : 0;
                    const endItem = Math.min(currentPage * ITEMS_PER_PAGE, data.length);

                    info.innerHTML = `Menampilkan <strong>${startItem}</strong> hingga <strong>${endItem}</strong> dari <strong>${data.length}</strong> hasil`;

                    if (data.length === 0 || pageCount <= 1) { // Hide pagination if no data or only one page
                        paginationContainer.innerHTML = '';
                        return;
                    }

                    // Previous button
                    const prev = document.createElement('li');
                    prev.innerHTML = `
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight ${
                            currentPage === 1
                                ? 'text-gray-400 bg-white border border-gray-300 cursor-not-allowed opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-600'
                                : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200'
                        } rounded-l-lg transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 14.707a1 1 0 01-1.414 0L6.586 10l4.707-4.707a1 1 0 111.414 1.414L9.414 10l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                        </a>
                    `;
                    if (currentPage > 1) {
                        prev.querySelector('a').addEventListener('click', e => {
                            e.preventDefault();
                            currentPage--;
                            applyFiltersAndRender();
                        });
                    }
                    paginationContainer.appendChild(prev);

                    // Page numbers
                    for (let i = 1; i <= pageCount; i++) {
                        const li = document.createElement('li');
                        li.innerHTML = `
                            <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight ${
                                i === currentPage
                                    ? 'text-sky-800 bg-sky-50 border-sky-300 dark:bg-sky-900 dark:text-sky-200 dark:border-sky-700 border'
                                    : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700 dark:hover:bg-gray-700 dark:hover:text-gray-200'
                            } transition-all duration-200">${i}</a>
                        `;
                        li.querySelector('a').addEventListener('click', e => {
                            e.preventDefault();
                            currentPage = i;
                            applyFiltersAndRender();
                        });
                        paginationContainer.appendChild(li);
                    }

                    // Next button
                    const next = document.createElement('li');
                    next.innerHTML = `
                        <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight ${
                            currentPage === pageCount
                                ? 'text-gray-400 bg-white border border-gray-300 cursor-not-allowed opacity-50 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-600'
                                : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200'
                        } rounded-r-lg transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 5.293a1 1 0 011.414 0L13.414 10l-4.707 4.707a1 1 0 01-1.414-1.414L10.586 10 7.293 6.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </a>
                    `;
                    if (currentPage < pageCount) {
                        next.querySelector('a').addEventListener('click', e => {
                            e.preventDefault();
                            currentPage++;
                            applyFiltersAndRender();
                        });
                    }
                    paginationContainer.appendChild(next);
                }

                // --- Delete Modal Function ---
                window.showDeleteUserModal = function(userId, userName) {
                    const deleteModal = document.getElementById('delete-user-modal');
                    const deleteForm = deleteModal.querySelector('.delete-modal-form');
                    const itemNameSpan = deleteModal.querySelector('#delete-user-modal-item-name');

                    if (itemNameSpan) {
                        itemNameSpan.textContent = userName;
                    } else {
                        deleteModal.querySelector('[data-item-name]').textContent = userName;
                    }
                    deleteForm.action = `/admin/data-user/${userId}`;

                    deleteModal.classList.remove('hidden');
                    deleteModal.setAttribute('aria-hidden', 'false');
                };


                // --- Initial Calls ---
                fetchUsers();
                // Removed initial calls for fetchRoles and fetchUnitKerjas
                // fetchRoles();
                // fetchUnitKerjas();
            });
        </script>
    @endpush
@endsection