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
                        {{ $periode['nama_periode'] ?? 'Tidak Ada' }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        @if ($periode['tanggal_mulai'])
                            {{ \Carbon\Carbon::parse($periode['tanggal_mulai'])->locale('id')->translatedFormat('d F Y') }}
                        @else
                            Tidak Ada
                        @endif
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        @if ($periode['tanggal_berakhir'])
                            {{ \Carbon\Carbon::parse($periode['tanggal_berakhir'])->locale('id')->translatedFormat('d F Y') }}
                        @else
                            Tidak Ada
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
            document.addEventListener('DOMContentLoaded', function() {

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
