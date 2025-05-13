@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Laporan', 'url' => route('admin.laporan.index')],
    ]" />

    <!-- Heading -->
    <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
        Laporan
    </h1>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Filter controls -->
         

        <x-table id="laporanTable" :headers="[
            '',
            'No',
            'Nama Unit',
            'Tanggal Mulai',
            'Tanggal Berakhir',
            'Status AMI',
            'Aksi',
        ]" :data="$laporan" :perPage="$laporan->perPage()" :route="route('admin.laporan.index')">
            @forelse ($laporan as $index => $item)
                <tr class="bg-white transition-all duration-200 hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-600">
                    <td class="border border-gray-200 px-4 py-4 dark:border-gray-600">
                        <input type="checkbox" class="h-4 w-4 rounded border-gray-200 bg-gray-100 text-sky-800" data-id="{{ $item->id }}">
                    </td>
                    <td class="border border-gray-200 px-4 py-4 dark:border-gray-600">
                        {{ $laporan->firstItem() + $index }}
                    </td>
                    <td class="border border-gray-200 px-4 py-4 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                        {{ $item->nama_unit ?? 'N/A' }}
                    </td>
                    <td class="border border-gray-200 px-4 py-4 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                        {{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d F Y') : 'N/A' }}
                    </td>
                    <td class="border border-gray-200 px-4 py-4 dark:border-gray-600 text-gray-900 dark:text-gray-200">
                        {{ $item->tanggal_berakhir ? \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d F Y') : 'N/A' }}
                    </td>
                    <td class="border border-gray-200 px-4 py-4 dark:border-gray-600">
                        @if($item->status == 'Berakhir')
                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                            Berakhir
                        </span>
                        @else
                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                            {{ $item->status ?? 'Sedang Berjalan' }}
                        </span>
                        @endif
                    </td>
                    <td class="border border-gray-200 px-4 py-4 dark:border-gray-600">
                        <x-table-row-actions :actions="[
                            [
                                'label' => 'Lihat',
                                'color' => 'blue',
                                'icon' => 'heroicon-o-eye',
                                'href' => route('admin.laporan.show', $item->id),
                            ],
                            [
                                'label' => 'Unduh',
                                'color' => 'yellow',
                                'icon' => 'heroicon-o-arrow-down-tray',
                                'href' => route('admin.laporan.download', $item->id),
                            ],
                            [
                                'label' => 'Hapus',
                                'color' => 'red',
                                'icon' => 'heroicon-o-trash',
                                'modalId' => 'delete-laporan-modal-' . $item->id,
                            ],
                        ]" />
                    </td>
                </tr>
                <x-confirmation-modal 
                    id="delete-laporan-modal-{{ $item->id }}" 
                    title="Konfirmasi Hapus Laporan" 
                    :action="route('admin.laporan.destroy', $item->id)" 
                    method="DELETE" 
                    type="delete" 
                    formClass="delete-modal-form"
                    :itemName="$item->nama_unit ?? 'Laporan'" 
                    :warningMessage="'Menghapus laporan ini akan menghapus seluruh data terkait laporan tersebut.'" />
            @empty
                <tr>
                    <td colspan="7" class="border border-gray-200 px-4 py-4 text-center text-gray-500 dark:border-gray-600 dark:text-gray-400">
                        Tidak ada data laporan.
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>
</div>

@endsection {{-- ✅ hanya satu @endsection ini --}}

@push('styles')
<style>
    /* Tambahkan style tambahan di sini jika dibutuhkan */
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.querySelector('thead input[type="checkbox"]');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.row-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        }

        const periodSelect = document.getElementById('periodeFilter');
        if (periodSelect) {
            periodSelect.addEventListener('change', function() {
                const currentUrl = new URL(window.location.href);
                if (this.value) {
                    currentUrl.searchParams.set('periode', this.value);
                } else {
                    currentUrl.searchParams.delete('periode');
                }
                window.location.href = currentUrl.toString();
            });
        }

        document.querySelectorAll('[data-modal-target]').forEach(trigger => {
            trigger.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal-target');
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('hidden');
                }
            });
        });
    });
</script>
@endpush

