@extends('layouts.app')

@section('title', 'Edit Periode Audit')

@section('content')
    <div class="container mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Toast Notification -->
        @if (session('success'))
            <x-toast id="toast-success" type="success" :message="session('success')" />
        @endif

        @if ($errors->any())
            <x-toast id="toast-danger" type="danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </x-toast>
        @endif

        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Periode Audit', 'url' => route('admin.periode-audit.index')],
            ['label' => 'Edit Periode'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Edit Periode Audit
        </h1>

        <!-- Form Section -->
        <div
            class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
            <form action="{{ route('admin.periode-audit.update', $periodeAudit['periode_id']) }}" method="POST"
                id="periode-audit-form">
                @csrf
                @method('PUT')
                <div class="mb-6 grid grid-cols-1 gap-6">
                    <!-- Nama Periode -->
                    <x-form-input id="nama_periode" name="nama_periode" label="Nama Periode AMI"
                        placeholder="Masukkan nama periode" :value="old('nama_periode', $periodeAudit['nama_periode'])" :required="true" maxlength="255" />
                </div>
                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Tanggal Mulai -->
                    <x-form-input id="tanggal_mulai" name="tanggal_mulai" label="Tanggal Mulai" placeholder="dd-mm-yyyy"
                        :value="old('tanggal_mulai', $periodeAudit['tanggal_mulai'])" :required="true" :datepicker="true" />
                    <!-- Tanggal Berakhir -->
                    <x-form-input id="tanggal_berakhir" name="tanggal_berakhir" label="Tanggal Berakhir"
                        placeholder="dd-mm-yyyy" :value="old('tanggal_berakhir', $periodeAudit['tanggal_berakhir'])" :required="true" :datepicker="true" />
                </div>

                <div class="mb-6 grid grid-cols-1 gap-6">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                            Status Periode
                        </label>
                        <select id="status" name="status" required
                            class="bg-gray-50 dark:bg-gray-700 border {{ $errors->has('status') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} text-gray-900 dark:text-gray-200 dark:placeholder-gray-400 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 transition-all duration-200">
                            <option value="">Pilih Status</option>
                            <option value="Sedang Berjalan"
                                {{ old('status', $periodeAudit['status'] ?? '') == 'Sedang Berjalan' ? 'selected' : '' }}>
                                Sedang Berjalan
                            </option>
                            <option value="Berakhir"
                                {{ old('status', $periodeAudit['status'] ?? '') == 'Berakhir' ? 'selected' : '' }}>
                                Berakhir
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Buttons -->
                <div class="flex space-x-3">
                    <x-button type="submit" color="sky" icon="heroicon-o-check">
                        Simpan Perubahan
                    </x-button>
                    <x-button type="button" color="gray" icon="heroicon-o-x-mark"
                        href="{{ route('admin.periode-audit.index') }}">
                        Batal
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script untuk mengatur toast dan validasi -->
    @push('scripts')
        <script>
            // Function to create and show toast with fade animation
            function showToast(type, message) {
                const toastId = 'toast-' + Date.now();

                // Create toast element with CSS animation classes
                const toastElement = document.createElement('div');
                toastElement.innerHTML = `
                    <div id="${toastId}"
                        class="fixed top-20 right-5 flex items-start sm:items-center w-auto max-w-xs sm:max-w-sm md:max-w-md lg:max-w-md p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 z-60 animate-fade-in"
                        role="alert">
                        <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 ${type === 'success' ? 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200' : (type === 'warning' ? 'text-yellow-500 bg-yellow-100 dark:bg-yellow-800 dark:text-yellow-200' : 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200')} rounded-lg">
                            ${type === 'success' ?
                                '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>' :
                                (type === 'warning' ?
                                    '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>' :
                                    '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>'
                                )
                            }
                            <span class="sr-only">Ikon ${type === 'success' ? 'Sukses' : (type === 'warning' ? 'Peringatan' : 'Error')}</span>
                        </div>
                        <div class="flex-1 min-w-0 ms-3 text-sm font-normal break-words">
                            ${message}
                        </div>
                        <button type="button"
                            class="ms-3 flex-shrink-0 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors duration-200"
                            onclick="closeToast('${toastId}')" aria-label="Tutup">
                            <span class="sr-only">Tutup</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                `;

                // Append to body
                const toast = toastElement.firstElementChild;
                document.body.appendChild(toast);

                // Auto close after 5 seconds
                setTimeout(() => {
                    closeToast(toastId);
                }, 5000);
            }

            // Function to close toast with CSS fade animation
            function closeToast(toastId) {
                const toast = document.getElementById(toastId);
                if (toast) {
                    toast.classList.remove('animate-fade-in');
                    toast.classList.add('animate-fade-out');
                    setTimeout(() => {
                        toast.remove();
                    }, 400);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Validasi form di sisi client
                const form = document.getElementById('periode-audit-form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const namaPeriode = document.getElementById('nama_periode').value.trim();
                        const tanggalMulai = document.getElementById('tanggal_mulai').value.trim();
                        const tanggalBerakhir = document.getElementById('tanggal_berakhir').value.trim();
                        const status = document.getElementById('status').value;

                        // Validasi input kosong
                        if (!namaPeriode || !tanggalMulai || !tanggalBerakhir || !status) {
                            e.preventDefault();
                            showToast('danger', 'Semua kolom wajib diisi!');
                            return;
                        }

                        // Validasi format tanggal (dd-mm-yyyy)
                        const dateRegex = /^(\d{2})-(\d{2})-(\d{4})$/;
                        if (!dateRegex.test(tanggalMulai) || !dateRegex.test(tanggalBerakhir)) {
                            e.preventDefault();
                            showToast('danger', 'Format tanggal harus dd-mm-yyyy!');
                            return;
                        }

                        // Validasi tanggal mulai <= tanggal berakhir
                        try {
                            const mulai = new Date(tanggalMulai.split('-').reverse().join('-'));
                            const berakhir = new Date(tanggalBerakhir.split('-').reverse().join('-'));

                            if (isNaN(mulai) || isNaN(berakhir)) {
                                e.preventDefault();
                                showToast('danger', 'Tanggal tidak valid!');
                                return;
                            }

                            if (mulai > berakhir) {
                                e.preventDefault();
                                showToast('warning',
                                    'Tanggal mulai tidak boleh lebih besar dari tanggal berakhir.');
                                return;
                            }

                        } catch (error) {
                            e.preventDefault();
                            showToast('danger', 'Kesalahan saat memproses tanggal: ' + error.message);
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
