@extends('layouts.app')

@section('title', 'Auditee AMI')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
        ['label' => 'Audit'],
    ]" />

    <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
        Audit AMI
    </h1>

    <div class="ml-auto">
        <h2 id="namaPeriode" class="text-sm font-medium text-gray-700 dark:text-gray-300">
            <!-- Nama periode akan dimuat via JavaScript -->
        </h2>
    </div>

    <div class="overflow-x-auto">
        <table id="jadwalAuditTable" class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="rounded-lg border-l border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">No</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Unit Kerja</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Waktu Audit</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Auditee</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Auditee 2</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Auditor 1</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Auditor 2</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Status</th>
                    {{-- <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Aksi</th> --}}
                </tr>
            </thead>
            <tbody id="tableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                <tr><td colspan="9" class="text-center py-4 text-gray-500">Memuat data...</td></tr>
            </tbody>
        </table>
        <h2 class="pt-8 mb-8 text-2xl text-gray-900 dark:text-gray-200">
            Progress Auditing Auditee
        </h2>
        @php
            $jenisUnitId = session('jenis_unit_id');
            $instrumenRoute = match ($jenisUnitId) {
                1 => route('auditee.data-instrumen.index'),
                // 2 => route('auditee.data-instrumen.index2'),
                3 => route('auditee.data-instrumen.instrumenprodi'),
                default => '#', // fallback kalau tidak ditemukan
            };
        @endphp

        <x-breadcrumbproses :items="[
            ['label' => 'Respon Instrumen', 'url' => $instrumenRoute],
            ['label' => 'Jadwal Assesmen Lapangan', 'url' => '#'],
            ['label' => 'Response Tilik', 'url' => '#'],
        ]" />
    </div>
<script>
document.addEventListener("DOMContentLoaded", async function () {
    const tableBody = document.querySelector("#tableBody");
    const namaPeriodeElem = document.querySelector("#namaPeriode");

    try {
        const response = await fetch("{{ route('auditee.auditings') }}");
        const result = await response.json();

        if (!response.ok || !result.data) {
            throw new Error(result.message || 'Gagal memuat data');
        }

        const data = result.data;

        // Cek jika data tidak kosong
        if (data.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="9" class="py-4 text-center text-gray-500">Tidak ada data audit.</td></tr>`;
            namaPeriodeElem.textContent = 'Periode: -';
            return;
        }

        // Ambil nama periode dari entri pertama (asumsi semua datanya dari periode yang sama)
        const periodeNama = data[0].periode?.nama_periode ?? 'Tidak diketahui';
        namaPeriodeElem.textContent = `Periode: ${periodeNama}`;

        // Render tabel
        tableBody.innerHTML = "";
        data.forEach((item, index) => {
            const statusClass = item.status === "Selesai"
                ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300'
                : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300';

            const tanggalAudit = item.periode?.tanggal_mulai
                ? new Date(item.periode.tanggal_mulai).toLocaleDateString('id-ID')
                : 'N/A';

            tableBody.innerHTML += `
                <tr>
                    <td class="px-4 py-2">${index + 1}</td>
                    <td class="px-4 py-2">${item.unit_kerja?.nama_unit_kerja ?? 'Belum diatur'}</td>
                    <td class="px-4 py-2">${item.jadwal_audit ?? 'Belum diatur'}</td>
                    <td class="px-4 py-2">${item.auditee1?.nama ?? 'Belum diatur'}</td>
                    <td class="px-4 py-2">${item.auditee2?.nama ?? '-'}</td>
                    <td class="px-4 py-2">${item.auditor1?.nama ?? 'Belum diatur'}</td>
                    <td class="px-4 py-2">${item.auditor2?.nama ?? '-'}</td>
                    <td class="px-4 py-2">
                        <span class="${statusClass} inline-flex rounded-full px-2 py-1 text-xs font-semibold">${item.status}</span>
                    </td>
                </tr>`;
        });

    } catch (err) {
        console.error(err);
        tableBody.innerHTML = `<tr><td colspan="9" class="py-4 text-center text-red-500">Gagal memuat data.</td></tr>`;
        namaPeriodeElem.textContent = 'Periode: Gagal dimuat';
    }
});
</script>
@endsection