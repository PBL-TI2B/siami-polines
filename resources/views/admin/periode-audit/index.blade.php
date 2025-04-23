@extends('layouts.app')

@section('title', 'Periode Audit')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Notifikasi Toast -->
        <div id="toast-success"
            class="z-60 fixed right-5 top-20 mb-4 flex hidden w-full max-w-xs items-center rounded-lg bg-white p-4 text-gray-500 shadow-sm transition-opacity duration-300 dark:bg-gray-800 dark:text-gray-400"
            role="alert">
            <div
                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-500 dark:bg-green-800 dark:text-green-200">
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Ikon Sukses</span>
            </div>
            <div class="ms-3 text-sm font-normal">
                Periode audit berhasil ditambahkan.
            </div>
            <button type="button"
                class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white"
                data-dismiss-target="#toast-success" aria-label="Tutup">
                <span class="sr-only">Tutup</span>
                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        <div id="toast-danger"
            class="z-60 fixed right-5 top-20 mb-4 flex hidden w-full max-w-xs items-center rounded-lg bg-white p-4 text-gray-500 shadow-sm transition-opacity duration-300 dark:bg-gray-800 dark:text-gray-400"
            role="alert">
            <div
                class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-500 dark:bg-red-800 dark:text-red-200">
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                </svg>
                <span class="sr-only">Ikon Error</span>
            </div>
            <div class="ms-3 text-sm font-normal">
                Gagal memproses permintaan.
            </div>
            <button type="button"
                class="-mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white"
                data-dismiss-target="#toast-danger" aria-label="Tutup">
                <span class="sr-only">Tutup</span>
                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <!-- Breadcrumb -->
        <nav class="mb-8 flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-sky-600 dark:text-gray-400 dark:hover:text-white">
                        <x-heroicon-o-home class="mr-2 h-4 w-4" />
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="mx-1 h-3 w-3 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('periode-audit.index') }}"
                            class="ml-1 text-sm font-medium text-gray-700 hover:text-sky-600 dark:text-gray-400 dark:hover:text-white">
                            Periode Audit
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="mx-1 h-3 w-3 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">Daftar Periode</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Judul Halaman -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Periode Audit
        </h1>

        <!-- Bagian Form -->
        <div
            class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
            <form id="periode-audit-form">
                <div class="mb-6 grid grid-cols-1 gap-6">
                    <!-- Input Nama Periode -->
                    <div>
                        <label for="nama_periode" class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-200">
                            Nama Periode AMI
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_periode" name="nama_periode"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-sky-600 dark:focus:ring-sky-600"
                            placeholder="Masukkan nama periode" required maxlength="255">
                    </div>
                </div>
                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Input Tanggal Mulai -->
                    <div>
                        <label for="tanggal_mulai" class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-200">
                            Tanggal Mulai
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-sky-600 dark:focus:ring-sky-600"
                            placeholder="Pilih tanggal mulai" required data-datepicker>
                    </div>
                    <!-- Input Tanggal Berakhir -->
                    <div>
                        <label for="tanggal_berakhir"
                            class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-200">
                            Tanggal Berakhir
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_berakhir" name="tanggal_berakhir"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-sky-600 dark:focus:ring-sky-600"
                            placeholder="Pilih tanggal berakhir" required data-datepicker>
                    </div>
                </div>
                <!-- Tombol Tambah -->
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-sky-800 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-sky-900 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800">
                    <svg class="mr-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Periode
                </button>
            </form>
        </div>

        <!-- Bagian Tabel -->
        <div id="periode-audit-table"
            class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <!-- Table Controls -->
            <div class="border-b border-gray-200 p-4 dark:border-gray-700">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-2">
                        <label for="per_page" class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</label>
                        <select id="per_page" onchange="loadPeriodeAudits(1, this.value)"
                            class="w-18 block rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-sky-600 dark:focus:ring-sky-600">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                    </div>
                    <div class="relative">
                        <input type="text" id="search"
                            oninput="loadPeriodeAudits(1, document.getElementById('per_page').value, this.value)"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-sky-600 dark:focus:ring-sky-600"
                            placeholder="Cari periode...">
                        <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 transform text-gray-400"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead
                        class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="w-4 border-r border-gray-200 p-4 dark:border-gray-700">
                                <input type="checkbox"
                                    class="h-4 w-4 rounded border-gray-200 bg-gray-100 text-sky-800 focus:ring-sky-500 dark:border-gray-500 dark:bg-gray-600 dark:focus:ring-sky-600">
                            </th>
                            <th class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">No</th>
                            <th class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Nama Periode AMI
                            </th>
                            <th class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Tanggal Mulai</th>
                            <th class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Tanggal Berakhir
                            </th>
                            <th class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Status</th>
                            <th class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="periode-audit-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="periode-audit-pagination" class="p-4"></div>
        </div>

        <!-- Modal Konfirmasi Tutup -->
        <div id="close-modal"
            class="fixed inset-0 z-50 flex hidden items-center justify-center overflow-auto bg-gray-500 bg-opacity-75 transition-opacity duration-300">
            <div
                class="relative m-4 w-full max-w-xs rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800 dark:text-gray-200">
                <form id="close-periode-form" class="close-periode-form">
                    <input type="hidden" name="_method" value="PATCH">
                    <div class="mb-4 flex items-center">
                        <div
                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-yellow-100 text-yellow-500 dark:bg-yellow-800 dark:text-yellow-200">
                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a4 4 0 0 0-4 4v1H5a1 1 0 0 0-1 1v7a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8a1 1 0 0 0-1-1h-1V6a4 4 0 0 0-4-4Zm2 5V6a2 2 0 1 0-4 0v1h4Zm-2 6a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                            </svg>
                            <span class="sr-only">Ikon Kunci</span>
                        </div>
                        <h3 class="ms-3 text-sm font-semibold">Tutup Periode Audit</h3>
                    </div>
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        Menutup periode <span id="close-modal-item-name" class="font-semibold"></span> akan mengakhiri
                        seluruh aktivitas AMI pada periode tersebut dan tidak dapat diubah kembali.
                    </p>
                    <div class="mb-4">
                        <label for="close-confirm-name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Masukkan nama periode untuk konfirmasi
                        </label>
                        <input type="text" id="close-confirm-name" name="confirm_name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                            placeholder="Masukkan nama periode">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('close-modal')"
                            class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 hover:bg-gray-200 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded-md bg-yellow-600 px-4 py-2 text-sm font-medium text-white transition-all duration-200 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-600">
                            Tutup
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div id="delete-modal"
            class="fixed inset-0 z-50 flex hidden items-center justify-center overflow-auto bg-gray-500 bg-opacity-75 transition-opacity duration-300">
            <div
                class="relative m-4 w-full max-w-xs rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800 dark:text-gray-200">
                <form id="delete-periode-form" class="delete-periode-form">
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="mb-4 flex items-center">
                        <div
                            class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-500 dark:bg-red-800 dark:text-red-200">
                            <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M6 2a1 1 0 0 0-1 1v1H3a1 1 0 0 0 0 2h1v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2h-2V3a1 1 0 0 0-1-1H6Zm2 4a1 1 0 0 1 1 1v7a1 1 0 1 1-2 0V7a1 1 0 0 1 1-1Zm4 0a1 1 0 0 1 1 1v7a1 1 0 1 1-2 0V7a1 1 0 0 1 1-1Z" />
                            </svg>
                            <span class="sr-only">Ikon Hapus</span>
                        </div>
                        <h3 class="ms-3 text-sm font-semibold">Hapus Periode Audit</h3>
                    </div>
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        Menghapus periode <span id="delete-modal-item-name" class="font-semibold"></span> akan menghapus
                        seluruh riwayat terkait dan tidak dapat dikembalikan.
                    </p>
                    <div class="mb-4">
                        <label for="delete-confirm-name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Masukkan nama periode untuk konfirmasi
                        </label>
                        <input type="text" id="delete-confirm-name" name="confirm_name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                            placeholder="Masukkan nama periode">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('delete-modal')"
                            class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 hover:bg-gray-200 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white transition-all duration-200 hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-600">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Skrip JavaScript -->
    @push('scripts')
        <script>
            // Fungsi untuk menampilkan notifikasi toast
            function showToast(id, message = null) {
                const toast = document.getElementById(id);
                if (message) {
                    toast.querySelector('.ms-3').textContent = message;
                }
                toast.classList.remove('hidden');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 5000);
            }

            // Fungsi untuk memformat tanggal ke format Indonesia
            function formatDate(dateString) {
                if (!dateString) return 'N/A';
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }

            // Fungsi untuk membuka modal
            function openModal(modalId, action, itemName) {
                const modal = document.getElementById(modalId);
                const form = modal.querySelector('form');
                const itemNameElement = modal.querySelector(`#${modalId}-item-name`);
                const confirmInput = modal.querySelector(`#${modalId}-confirm-name`);

                form.action = action;
                itemNameElement.textContent = itemName;
                confirmInput.placeholder = `Masukkan nama ${itemName}`;
                modal.classList.remove('hidden');
                modal.classList.add('opacity-100');
            }

            // Fungsi untuk menutup modal
            function closeModal(modalId) {
                const modal = document.getElementById(modalId);
                const form = modal.querySelector('form');
                const confirmInput = modal.querySelector(`#${modalId}-confirm-name`);
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    form.reset();
                    confirmInput.value = '';
                }, 300); // Sesuaikan dengan durasi transisi
            }

            // Fungsi untuk merender paginasi
            function renderPagination(paginationData) {
                const paginationContainer = document.getElementById('periode-audit-pagination');
                if (!paginationData.total) {
                    paginationContainer.innerHTML = `
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            Tidak ada data untuk ditampilkan.
                        </span>
                    `;
                    return;
                }

                let paginationHtml = `
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <span class="text-sm text-gray-700 dark:text-gray-300">
                            Menampilkan <strong>${paginationData.from}</strong> hingga <strong>${paginationData.to}</strong>
                            dari <strong>${paginationData.total}</strong> hasil
                        </span>
                        <nav aria-label="Navigasi Paginasi">
                            <ul class="inline-flex -space-x-px text-sm">
                                <li>
                                    <button onclick="loadPeriodeAudits(${paginationData.current_page - 1})"
                                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-l-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 ${paginationData.current_page === 1 ? 'cursor-not-allowed opacity-50' : ''}"
                                            ${paginationData.current_page === 1 ? 'disabled' : ''}>
                                        <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>
                                </li>
                `;

                for (let page = 1; page <= paginationData.last_page; page++) {
                    paginationHtml += `
                        <li>
                            <button onclick="loadPeriodeAudits(${page})"
                                    class="flex items-center justify-center px-3 h-8 leading-tight ${page === paginationData.current_page ? 'text-sky-800 bg-sky-50 dark:bg-sky-900 dark:text-sky-200 border-sky-300 dark:border-sky-700' : 'text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200'} border transition-all duration-200">
                                ${page}
                            </button>
                        </li>
                    `;
                }

                paginationHtml += `
                                <li>
                                    <button onclick="loadPeriodeAudits(${paginationData.current_page + 1})"
                                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 ${paginationData.current_page === paginationData.last_page ? 'cursor-not-allowed opacity-50' : ''}"
                                            ${paginationData.current_page === paginationData.last_page ? 'disabled' : ''}>
                                        <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                `;

                paginationContainer.innerHTML = paginationHtml;
            }

            // Fungsi untuk memuat data periode audit dari API
            async function loadPeriodeAudits(page = 1, perPage = 5, search = '') {
                try {
                    // Gunakan window.location.origin untuk base URL
                    const baseUrl = window.location.origin || 'http://127.0.0.1:8000';
                    const endpoint = '/api/periode-audits';
                    const url = new URL(endpoint, baseUrl);
                    url.searchParams.append('page', page);
                    url.searchParams.append('per_page', perPage);
                    if (search) url.searchParams.append('search', search);

                    console.log('Fetching URL:', url.toString()); // Debugging

                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                        },
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const result = await response.json();

                    if (result.status !== 'success') {
                        throw new Error(result.message || 'Gagal memuat data.');
                    }

                    const periodeAudits = result.data.data;
                    const paginationData = result.data;

                    const tbody = document.getElementById('periode-audit-table-body');
                    tbody.innerHTML = '';

                    if (periodeAudits.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="7" class="px-4 py-4 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data periode audit.
                                </td>
                            </tr>
                        `;
                    } else {
                        periodeAudits.forEach((periode, index) => {
                            const row = `
                                <tr class="bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                                    <td class="w-4 p-4 border-r border-gray-200 dark:border-gray-700">
                                        <input type="checkbox" class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                                    </td>
                                    <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                                        ${index + 1 + (paginationData.from - 1)}
                                    </td>
                                    <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                                        ${periode.nama_periode || 'N/A'}
                                    </td>
                                    <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                                        ${formatDate(periode.tanggal_mulai)}
                                    </td>
                                    <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                                        ${formatDate(periode.tanggal_berakhir)}
                                    </td>
                                    <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${periode.status === 'Berakhir' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300'}">
                                            ${periode.status || 'Tidak Diketahui'}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center space-x-2">
                                            ${periode.status !== 'Berakhir' ? `
                                                                                                                                                <button onclick="openModal('close-modal', '/api/periode-audits/${periode.id}/close', '${periode.nama_periode.replace(/'/g, "\\'")}')"
                                                                                                                                                        class="text-sm font-medium rounded-lg px-4 py-2 flex items-center transition-all duration-200 text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-600">
                                                                                                                                                <x-heroicon-o-lock-closed class="w-4 h-4 mr-2" />
                                                                                                                                                    Tutup
                                                                                                                                                </button>
                                                                                                                                            ` : ''}
                                            <a href="/admin/periode-audit/${periode.id}/edit"
                                               class="text-sm font-medium rounded-lg px-4 py-2 flex items-center transition-all duration-200 text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600">
                                                <x-heroicon-o-pencil class="w-4 h-4 mr-2" />
                                                Edit
                                            </a>
                                            <button onclick="openModal('delete-modal', '/api/periode-audits/${periode.id}', '${periode.nama_periode.replace(/'/g, "\\'")}')"
                                                    class="text-sm font-medium rounded-lg px-4 py-2 flex items-center transition-all duration-200 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-600">
                                                <x-heroicon-o-trash class="w-4 h-4 mr-2" />
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tbody.innerHTML += row;
                        });
                    }

                    // Render paginasi
                    renderPagination(paginationData);
                } catch (error) {
                    console.error('Error in loadPeriodeAudits:', error); // Debugging
                    showToast('toast-danger', 'Gagal memuat data: ' + error.message);
                }
            }

            // Fungsi untuk menambah periode
            document.getElementById('periode-audit-form').addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const data = {
                    nama_periode: formData.get('nama_periode'),
                    tanggal_mulai: formData.get('tanggal_mulai'),
                    tanggal_berakhir: formData.get('tanggal_berakhir'),
                    status: 'Sedang Berjalan'
                };

                // Validasi tanggal
                const tanggalMulai = new Date(data.tanggal_mulai.split('-').reverse().join('-'));
                const tanggalBerakhir = new Date(data.tanggal_berakhir.split('-').reverse().join('-'));
                if (tanggalMulai > tanggalBerakhir) {
                    showToast('toast-danger', 'Tanggal mulai tidak boleh lebih besar dari tanggal berakhir.');
                    return;
                }

                try {
                    const baseUrl = window.location.origin || 'http://127.0.0.1:8000';
                    const response = await fetch(`${baseUrl}/api/periode-audits`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(data),
                    });

                    const result = await response.json();

                    if (result.status !== 'success') {
                        throw new Error(result.message || 'Gagal menambah periode.');
                    }

                    showToast('toast-success');
                    this.reset();
                    loadPeriodeAudits();
                } catch (error) {
                    console.error('Error in form submission:', error); // Debugging
                    showToast('toast-danger', 'Gagal menambah periode: ' + error.message);
                }
            });

            // Fungsi untuk menangani submit form modal
            document.querySelectorAll('.close-periode-form, .delete-periode-form').forEach(form => {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const action = this.action;
                    const method = this.querySelector('input[name="_method"]')?.value || 'POST';
                    const confirmName = this.querySelector('input[name="confirm_name"]')?.value;
                    const expectedName = this.querySelector('input[name="confirm_name"]').getAttribute(
                        'placeholder').replace('Masukkan nama ', '');

                    if (confirmName !== expectedName) {
                        showToast('toast-danger', 'Nama periode tidak cocok!');
                        return;
                    }

                    try {
                        const response = await fetch(action, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            },
                        });

                        const result = await response.json();

                        if (result.status !== 'success') {
                            throw new Error(result.message || 'Gagal memproses aksi.');
                        }

                        showToast('toast-success', result.message);
                        closeModal(this.id.replace('-periode-form', '-modal'));
                        loadPeriodeAudits();
                    } catch (error) {
                        console.error('Error in modal form submission:', error); // Debugging
                        showToast('toast-danger', 'Gagal memproses aksi: ' + error.message);
                    }
                });
            });

            // Inisialisasi saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Page loaded, initializing loadPeriodeAudits');
                loadPeriodeAudits();
            });
        </script>
    @endpush
@endsection
