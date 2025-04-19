@extends('layouts.app')

@section('title', 'Periode Audit')

@section('content')
    <div class="max-w-7xl mx-auto p-4 sm:px-6 lg:px-8">
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
            ['label' => 'Beranda', 'url' => route('dashboard')],
            ['label' => 'Periode Audit', 'url' => route('periode-audit.index')],
            ['label' => 'Daftar Periode'],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Periode Audit
        </h1>

        <!-- Form Section -->
        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm mb-8 border border-gray-200 dark:border-gray-700 transition-all duration-200">
            <form action="{{ route('periode-audit.store') }}" method="POST" id="periode-audit-form">
                @csrf
                <div class="grid gap-6 mb-6 grid-cols-1">
                    <!-- Nama Periode -->
                    <x-form-input id="nama_periode" name="nama_periode" label="Nama Periode AMI"
                        placeholder="Masukkan nama periode" :required="true" maxlength="255" />
                </div>
                <div class="grid gap-6 mb-6 grid-cols-1 md:grid-cols-2">
                    <!-- Tanggal Mulai -->
                    <x-form-input id="tanggal_mulai" name="tanggal_mulai" label="Tanggal Mulai"
                        placeholder="Pilih tanggal mulai" :required="true" :datepicker="true" />
                    <!-- Tanggal Berakhir -->
                    <x-form-input id="tanggal_berakhir" name="tanggal_berakhir" label="Tanggal Berakhir"
                        placeholder="Pilih tanggal berakhir" :required="true" :datepicker="true" />
                </div>
                <button type="submit"
                    class="text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center transition-all duration-200">
                    <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                    Tambah Periode
                </button>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">
            <!-- Table Controls -->
            <x-admin.table-controls :route="route('periode-audit.index')" :perPage="5" />

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th scope="col" class="p-4 border-r border-gray-200 dark:border-gray-600">
                                <input type="checkbox"
                                    class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-300 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                            </th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">No
                            </th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Nama
                                Periode AMI</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                                Tanggal Mulai</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                                Tanggal Berakhir</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                                Status</th>
                            <th scope="col" class="px-4 py-3 sm:px-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($periodeAudits ?? [] as $index => $periode)
                            <x-admin.periode-audit-row :periode="$periode" :index="$index" :firstItem="$periodeAudits->firstItem()" />

                            <!-- Modals -->
                            @if ($periode->status != 'Berakhir')
                                <x-admin.confirmation-modal id="close-periode-modal-{{ $periode->periode_id }}"
                                    title="Konfirmasi Tutup Periode" :action="route('periode-audit.close', $periode->periode_id)" method="PATCH" type="close"
                                    :periode="$periode" />
                            @endif

                            <x-admin.confirmation-modal id="delete-periode-modal-{{ $periode->periode_id }}"
                                title="Konfirmasi Hapus Data" :action="route('periode-audit.destroy', $periode->periode_id)" method="DELETE" type="delete"
                                :periode="$periode" />
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-4 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada data periode audit.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <x-pagination :data="$periodeAudits" />
        </div>
    </div>

    <!-- Scripts -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Fungsi untuk menangani toast (sukses dan error)
                const toasts = ['toast-success', 'toast-danger'];
                toasts.forEach(toastId => {
                    const toast = document.getElementById(toastId);
                    if (toast) {
                        // Animasi masuk
                        toast.classList.remove('opacity-0');
                        toast.classList.add('opacity-100');
                        // Otomatis tutup setelah 5 detik
                        setTimeout(() => {
                            toast.classList.remove('opacity-100');
                            toast.classList.add('opacity-0');
                            setTimeout(() => {
                                toast.classList.add('hidden');
                            }, 300); // Sesuaikan dengan durasi transisi
                        }, 5000);
                    }
                });

                // Validasi form di sisi client
                const form = document.getElementById('periode-audit-form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const tanggalMulai = document.getElementById('tanggal_mulai').value;
                        const tanggalBerakhir = document.getElementById('tanggal_berakhir').value;

                        if (tanggalMulai && tanggalBerakhir) {
                            const mulai = new Date(tanggalMulai.split('-').reverse().join('-'));
                            const berakhir = new Date(tanggalBerakhir.split('-').reverse().join('-'));

                            if (mulai > berakhir) {
                                e.preventDefault();
                                alert('Tanggal mulai tidak boleh lebih besar dari tanggal berakhir.');
                            }
                        }
                    });
                }

                // Validasi modal (close dan delete) secara terpusat
                function validateModalForm(formClass, inputSelector, expectedValue, errorMessage) {
                    const forms = document.querySelectorAll(`.${formClass}`);
                    forms.forEach(form => {
                        form.addEventListener('submit', function(e) {
                            const input = form.querySelector(inputSelector);
                            if (input && input.value !== expectedValue) {
                                e.preventDefault();
                                alert(errorMessage);
                            }
                        });
                    });
                }

                // Validasi modal close
                @foreach ($periodeAudits ?? [] as $periode)
                    @if ($periode->status != 'Berakhir')
                        validateModalForm(
                            'close-periode-form',
                            `#confirm_nama_periode_{{ $periode->periode_id }}_close`,
                            `{{ $periode->nama_periode }}`,
                            'Nama periode tidak cocok!'
                        );
                    @endif
                @endforeach

                // Validasi modal delete
                @foreach ($periodeAudits ?? [] as $periode)
                    validateModalForm(
                        'delete-periode-form',
                        `#confirm_nama_periode_{{ $periode->periode_id }}_delete`,
                        `{{ $periode->nama_periode }}`,
                        'Nama periode tidak cocok!'
                    );
                @endforeach
            });
        </script>
    @endpush
@endsection
