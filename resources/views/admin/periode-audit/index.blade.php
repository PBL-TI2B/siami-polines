@extends('layouts.app')

@section('title', 'Periode Audit')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
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
            ['label' => 'Dashboard', 'url' => route('dashboard.index')],
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
                <x-button type="submit" color="sky" icon="heroicon-o-plus">
                    Tambah Periode
                </x-button>
            </form>
        </div>

        <!-- Table Section -->
        <x-table :headers="['', 'No', 'Nama Periode AMI', 'Tanggal Mulai', 'Tanggal Berakhir', 'Status', 'Aksi']" :data="$periodeAudits" :perPage="5" :route="route('periode-audit.index')">
            @forelse ($periodeAudits ?? [] as $index => $periode)
                <tr
                    class="bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                    <td class="w-4 p-4 border-r border-gray-200 dark:border-gray-700">
                        <input type="checkbox"
                            class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
                    </td>
                    <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                        {{ $periodeAudits->firstItem() + $index }}
                    </td>
                    <td
                        class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                        {{ $periode->nama_periode ?? 'N/A' }}
                    </td>
                    <td
                        class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                        @if ($periode->tanggal_mulai)
                            {{ $periode->tanggal_mulai->format('d F Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td
                        class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
                        @if ($periode->tanggal_berakhir)
                            {{ $periode->tanggal_berakhir->format('d F Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
                        <span
                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $periode->status == 'Berakhir' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300' }}">
                            {{ $periode->status ?? 'Tidak Diketahui' }}
                        </span>
                    </td>
                    <x-table-row-actions :actions="[
                        [
                            'label' => 'Tutup',
                            'color' => 'yellow',
                            'icon' => 'heroicon-o-lock-closed',
                            'modalId' => 'close-periode-modal-' . $periode->periode_id,
                            'condition' => $periode->status != 'Berakhir',
                        ],
                        [
                            'label' => 'Edit',
                            'color' => 'sky',
                            'icon' => 'heroicon-o-pencil',
                            'href' => route('periode-audit.edit', $periode->periode_id),
                        ],
                        [
                            'label' => 'Hapus',
                            'color' => 'red',
                            'icon' => 'heroicon-o-trash',
                            'modalId' => 'delete-periode-modal-' . $periode->periode_id,
                        ],
                    ]" />
                </tr>

                <!-- Modals -->
                @if ($periode->status != 'Berakhir')
                    <x-confirmation-modal id="close-periode-modal-{{ $periode->periode_id }}"
                        title="Konfirmasi Tutup Periode" :action="route('periode-audit.close', $periode->periode_id)" method="PATCH" type="close"
                        formClass="close-modal-form" :itemName="$periode->nama_periode" :warningMessage="'Menutup periode ini akan mengakhiri seluruh aktivitas AMI pada periode tersebut dan tidak dapat diubah kembali.'" />
                @endif

                <x-confirmation-modal id="delete-periode-modal-{{ $periode->periode_id }}" title="Konfirmasi Hapus Data"
                    :action="route('periode-audit.destroy', $periode->periode_id)" method="DELETE" type="delete" formClass="delete-modal-form" :itemName="$periode->nama_periode"
                    :warningMessage="'Menghapus periode ini akan menghapus seluruh riwayat pelaksanaan AMI pada periode tanggal tersebut.'" />
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                        Tidak ada data periode audit.
                    </td>
                </tr>
            @endforelse
        </x-table>
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
                        toast.classList.remove('opacity-0');
                        toast.classList.add('opacity-100');
                        setTimeout(() => {
                            toast.classList.remove('opacity-100');
                            toast.classList.add('opacity-0');
                            setTimeout(() => {
                                toast.classList.add('hidden');
                            }, 300);
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
                function validateModalForm(formClass, inputId, expectedValue, errorMessage) {
                    const forms = document.querySelectorAll(`.${formClass}`);
                    forms.forEach(form => {
                        form.addEventListener('submit', function(e) {
                            const input = document.querySelector(inputId);
                            if (input.value !== expectedValue) {
                                e.preventDefault();
                                alert(errorMessage);
                            }
                        });
                    });
                }

                @forelse ($periodeAudits ?? [] as $periode)
                    @if ($periode->status != 'Berakhir')
                        validateModalForm(
                            'close-modal-form',
                            '#confirm_name_close-periode-modal-{{ $periode->periode_id }}',
                            '{{ $periode->nama_periode }}',
                            'Nama periode tidak cocok!'
                        );
                    @endif

                    validateModalForm(
                        'delete-modal-form',
                        '#confirm_name_delete-periode-modal-{{ $periode->periode_id }}',
                        '{{ $periode->nama_periode }}',
                        'Nama periode tidak cocok!'
                    );
                @empty
                    // Tidak ada data untuk validasi
                @endforelse
            });
        </script>
    @endpush
@endsection
