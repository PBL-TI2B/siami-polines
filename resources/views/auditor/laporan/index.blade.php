```blade
@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Toast Notification -->
        @if (session('success'))
            <x-toast id="toast-success" type="success" :message="session('success')" />
        @endif

        @if (session('error') || $errors->any())
            <x-toast id="toast-danger" type="danger">
                @if (session('error'))
                    <p>{{ session('error') }}</p>
                @endif
                @if ($errors->any())
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </x-toast>
        @endif

        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
            ['label' => 'Laporan', 'url' => route('auditor.laporan.index')],
        ]" />

        <!-- Heading -->
        <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Laporan
        </h1>

        <!-- Tambah Data Button -->
        <div class="mb-4 flex flex-wrap gap-2">
            <x-button href="{{ route('auditor.laporan.create') }}" color="sky" icon="heroicon-o-plus">
                Tambah Laporan
            </x-button>
        </div>

        <!-- Table Section -->
        <x-table :headers="['No', 'Standar', 'Uraian Temuan', 'Kategori Temuan', 'Saran Perbaikan', 'Status', 'Aksi']" :data="$reports" :perPage="request('entries', 10)" :route="route('auditor.laporan.index')">
            @forelse ($reports as $index => $report)
                <tr
                    class="border-y border-gray-200 bg-white transition-all duration-200 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                    <td class="border-r border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700">
                        {{ $reports->firstItem() + $index }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        {{ $report['standar'] ?? 'N/A' }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        {{ $report['uraian_temuan'] ?? 'N/A' }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        {{ $report['kategori_temuan'] ?? 'N/A' }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        {{ $report['saran_perbaikan'] ?? 'N/A' }}
                    </td>
                    <td
                        class="border-r border-gray-200 px-4 py-4 text-gray-900 sm:px-6 dark:border-gray-700 dark:text-gray-200">
                        {{ $report['status'] ?? 'N/A' }}
                    </td>
                    <x-table-row-actions :actions="[
                        [
                            'label' => '+',
                            'color' => 'sky',
                            'icon' => 'heroicon-o-plus',
                            'href' => !empty($report['id']) ? route('auditor.laporan.edit', $report['id']) : 'javascript:void(0)',
                            'disabled' => empty($report['id']),
                        ],
                    ]" />
                    @if (empty($report['id']))
                        <span class="text-xs text-red-500">Missing report ID: {{ json_encode($report) }}</span>
                    @endif
                </tr>
                @if (!empty($report['id']))
                    <x-confirmation-modal id="delete-report-modal-{{ $report['id'] }}" title="Konfirmasi Hapus Laporan"
                        :action="route('auditor.laporan.destroy', $report['id'])" method="DELETE" type="delete" formClass="delete-modal-form"
                        :itemName="$report['uraian_temuan'] ?? 'Laporan'" :warningMessage="'Menghapus laporan ini akan menghapus seluruh data terkait laporan tersebut.'" />
                @endif
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-4 text-center text-gray-500 sm:px-6 dark:text-gray-400">
                        Tidak ada data laporan.
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>

    <!-- JavaScript untuk Toast -->
    @push('scripts')
        <script>
            // Otomatis tutup toast setelah 5 detik
            document.addEventListener('DOMContentLoaded', function() {
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
            });
        </script>
    @endpush
@endsection
```
