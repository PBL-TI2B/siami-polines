@extends('layouts.app')

@section('title', 'Ploting AMI')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => '#'], ['label' => 'Ploting AMI', 'url' => '#']]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Ploting AMI
        </h1>

        <!-- Tombol Aksi -->
        <div class="mb-4 flex flex-wrap items-center gap-2">
            <a href="#"
                class="inline-flex items-center rounded bg-sky-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-sky-900">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Data
            </a>

            <a href="#"
                class="inline-flex items-center rounded bg-sky-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-sky-900">
                <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                </svg>
                Unduh Data
            </a>

            <div class="ml-auto">
                <form method="GET" action="#" id="periodeFilterForm">
                    <select name="periode_id" id="periodeFilter"
                        class="appearance-none rounded-md border border-gray-300 px-4 py-2 pr-10 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        onchange="document.getElementById('periodeFilterForm').submit()">
                        <option value="">Pilih Periode AMI</option>
                        <option value="1">Periode 1</option>
                        <option value="2">Periode 2</option>
                    </select>
                </form>
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden shadow">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit
                        Kerja</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu
                        Audit</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auditee
                        1</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auditee
                        2</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auditor
                        1</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auditor
                        2</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <tr>
                    <td class="px-4 py-4"><input type="checkbox" class="h-4 w-4 rounded border-gray-200 bg-gray-100 text-sky-800">
                    </td>
                    <td class="px-4 py-4">1</td>
                    <td class="px-4 py-4">Unit A</td>
                    <td class="px-4 py-4">01 Januari 2025</td>
                    <td class="px-4 py-4">Auditee Satu</td>
                    <td class="px-4 py-4">Auditee Dua</td>
                    <td class="px-4 py-4">Auditor Satu</td>
                    <td class="px-4 py-4">Auditor Dua</td>
                    <td class="px-4 py-4 text-center">
                        <span
                            class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 inline-flex rounded-full px-2 py-1 text-xs font-semibold">Menunggu</span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <button
                            class="inline-flex items-center px-3 py-1 bg-sky-600 text-white rounded hover:bg-sky-700 text-xs mr-2">
                            Edit
                        </button>
                        <button
                            class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                            Hapus
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-4"><input type="checkbox" class="h-4 w-4 rounded border-gray-200 bg-gray-100 text-sky-800">
                    </td>
                    <td class="px-4 py-4">2</td>
                    <td class="px-4 py-4">Unit B</td>
                    <td class="px-4 py-4">10 Februari 2025</td>
                    <td class="px-4 py-4">Auditee Tiga</td>
                    <td class="px-4 py-4">-</td>
                    <td class="px-4 py-4">Auditor Tiga</td>
                    <td class="px-4 py-4">-</td>
                    <td class="px-4 py-4 text-center">
                        <span
                            class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 inline-flex rounded-full px-2 py-1 text-xs font-semibold">Selesai</span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <button
                            class="inline-flex items-center px-3 py-1 bg-sky-600 text-white rounded hover:bg-sky-700 text-xs mr-2">
                            Edit
                        </button>
                        <button
                            class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                            Hapus
                        </button>
                    </td>
                </tr>
                <!-- Tambahkan baris dummy lain jika perlu -->
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        // Placeholder JS
    </script>
@endpush