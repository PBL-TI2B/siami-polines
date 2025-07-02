@extends('layouts.app')

@section('title', 'Periode Audit')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Toast Notification -->
        @if (session('success'))
            <x-toast id="toast-success" type="success" :message="session('success')" />
        @endif
        @if (session('error'))
            <x-toast id="toast-danger" type="danger" :message="session('error')" />
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
            ['label' => 'Daftar Periode'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Periode Audit
        </h1>

        <!-- Form Section -->
        <div
            class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
            <form action="{{ route('admin.periode-audit.open') }}" method="POST" id="periode-audit-form">
                @csrf
                <div class="mb-6 grid grid-cols-1 gap-6">
                    <x-form-input id="nama_periode" name="nama_periode" label="Nama Periode AMI"
                        placeholder="Masukkan nama periode" :required="true" maxlength="255" />
                </div>
                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <x-form-input id="tanggal_mulai" name="tanggal_mulai" label="Tanggal Mulai" placeholder="dd-mm-yyyy"
                        :required="true" :datepicker="true" />
                    <x-form-input id="tanggal_berakhir" name="tanggal_berakhir" label="Tanggal Berakhir"
                        placeholder="dd-mm-yyyy" :required="true" :datepicker="true" />
                </div>
                <x-button type="submit" color="sky" icon="heroicon-o-plus">
                    Tambah Periode
                </x-button>
            </form>
        </div>

        <!-- Table Section -->
        <x-table :headers="['No', 'Nama Periode AMI', 'Tanggal Mulai', 'Tanggal Berakhir', 'Status', 'Aksi']" :data="$periodeAudits" :perPage="5" :route="route('admin.periode-audit.index')">
            @forelse ($periodeAudits ?? [] as $index => $periode)
                <tr
                    class="border-y border-gray-200 bg-white transition-all duration-200 hover:bg-gray-50 dark:border-gray-500 dark:bg-gray-800 dark:hover:bg-gray-600">
                    <td class="border-r border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700">
                        {{ $periodeAudits->firstItem() + $index }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        {{ $periode['nama_periode'] ?? 'N/A' }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        @if ($periode['tanggal_mulai'])
                            {{ \Carbon\Carbon::parse($periode['tanggal_mulai'])->locale('id')->translatedFormat('d F Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        @if ($periode['tanggal_berakhir'])
                            {{ \Carbon\Carbon::parse($periode['tanggal_berakhir'])->locale('id')->translatedFormat('d F Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="border-r border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700">
                        <span
                            class="{{ $periode['status'] == 'Berakhir' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300' }} inline-flex rounded-full px-2 py-1 text-center text-xs font-semibold leading-5">
                            {{ $periode['status'] ?? 'Tidak Diketahui' }}
                        </span>
                    </td>
                    <x-table-row-actions :actions="[
                        [
                            'label' => 'Tutup',
                            'color' => 'yellow',
                            'icon' => 'heroicon-o-lock-closed',
                            'modalId' => 'close-periode-modal-' . $periode['periode_id'],
                            'condition' => $periode['status'] != 'Berakhir',
                            'dataAttributes' => ['modal-toggle' => 'close-periode-modal-' . $periode['periode_id']],
                        ],
                        [
                            'label' => 'Edit',
                            'color' => 'sky',
                            'icon' => 'heroicon-o-pencil',
                            'href' => route('admin.periode-audit.edit', $periode['periode_id']),
                        ],
                        [
                            'label' => 'Hapus',
                            'color' => 'red',
                            'icon' => 'heroicon-o-trash',
                            'modalId' => 'delete-periode-modal-' . $periode['periode_id'],
                            'dataAttributes' => ['modal-toggle' => 'delete-periode-modal-' . $periode['periode_id']],
                        ],
                    ]" />
                </tr>

                <!-- Modals -->
                @if ($periode['status'] != 'Berakhir')
                    <x-confirmation-modal-periode id="close-periode-modal-{{ $periode['periode_id'] }}"
                        title="Konfirmasi Tutup Periode" :action="route('admin.periode-audit.close', $periode['periode_id'])" method="PUT" type="close"
                        formClass="close-modal-form" :itemName="$periode['nama_periode']" :warningMessage="'Menutup periode ini akan mengakhiri seluruh aktivitas AMI pada periode tersebut dan tidak dapat diubah kembali.'" />
                @endif

                <x-confirmation-modal-periode id="delete-periode-modal-{{ $periode['periode_id'] }}"
                    title="Konfirmasi Hapus Data" :action="route('admin.periode-audit.destroy', $periode['periode_id'])" method="DELETE" type="delete"
                    formClass="delete-modal-form" :itemName="$periode['nama_periode']" :warningMessage="'Menghapus periode ini akan menghapus seluruh riwayat pelaksanaan AMI pada periode tanggal tersebut.'" />
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500 sm:px-6 dark:text-gray-400">
                        Tidak ada data periode audit.
                    </td>
                </tr>
            @endforelse
        </x-table>

        <!-- Dynamic Toast Container -->
        <div id="dynamic-toast-container"></div>
    </div>

    <!-- Scripts -->
    @push('scripts')
        <script>
            // Function to create and show toast with fade animation
            function showToast(type, message) {
                const toastId = 'toast-' + Date.now();
                const container = document.getElementById('dynamic-toast-container');

                if (!container) {
                    return;
                }

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

                // Append to container
                const toast = toastElement.firstElementChild;
                container.appendChild(toast);

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
                // Validasi Form Tambah Periode
                const form = document.getElementById('periode-audit-form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const namaPeriode = document.getElementById('nama_periode').value.trim();
                        const tanggalMulai = document.getElementById('tanggal_mulai').value.trim();
                        const tanggalBerakhir = document.getElementById('tanggal_berakhir').value.trim();

                        // Validasi input kosong
                        if (!namaPeriode || !tanggalMulai || !tanggalBerakhir) {
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
                            showToast('danger', 'Error saat memproses tanggal: ' + error.message);
                        }
                    });
                }

                // Validasi Modal
                function validateModalForm(modalId, formClass) {
                    const modal = document.getElementById(modalId);
                    const form = modal.querySelector(`form.${formClass}`);
                    const input = modal.querySelector(`#confirm_name_${modalId}`);
                    const errorElement = modal.querySelector(`#error_${modalId}`);
                    const expectedValue = form.dataset.expectedName;

                    if (!form || !input || !errorElement) {
                        return;
                    }

                    form.addEventListener('submit', function(e) {
                        e.preventDefault(); // Cegah submit default

                        // Reset pesan error
                        errorElement.classList.add('hidden');
                        errorElement.textContent = '';

                        if (input.value !== expectedValue) {
                            errorElement.classList.remove('hidden');
                            errorElement.textContent = 'Nama periode tidak cocok!';
                            return;
                        }

                        // Jika validasi berhasil, kirim form
                        form.submit();
                    });
                }

                // Terapkan validasi untuk setiap modal
                @forelse ($periodeAudits ?? [] as $periode)
                    @if ($periode['status'] != 'Berakhir')
                        validateModalForm('close-periode-modal-{{ $periode['periode_id'] }}', 'close-modal-form');
                    @endif
                    validateModalForm('delete-periode-modal-{{ $periode['periode_id'] }}', 'delete-modal-form');
                @empty
                @endforelse
            });
        </script>
    @endpush
@endsection
