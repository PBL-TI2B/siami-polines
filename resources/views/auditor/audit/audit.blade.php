@extends('layouts.app')

@section('title', 'Auditee AMI')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">

    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit'],
    ]" />
    <div class="overflow-x-auto">
        <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Progress Auditing Auditee
        </h2>
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8">
            <ol class="pl-5 relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">
                <li class="mb-10 ms-6">
                    <span class="absolute flex items-center justify-center w-8 h-8 bg-green-200 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-green-900">
                        <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                        </svg>
                    </span>
                    <h3 class="font-medium leading-tight">Koreksi Respon Instrumen</h3>
                    @php
                    $jenisUnitId = session('jenis_unit_id');
                    $instrumenRoute = match ($jenisUnitId) {
                    1 => route('auditor.data-instrumen.instrumenupt'),
                    2 => route('auditor.data-instrumen.instrumenjurusan'),
                    3 => route('auditor.data-instrumen.instrumenprodi'),
                    default => '#', // fallback kalau tidak ditemukan
                    };
                    @endphp
                    <a href="{{ $instrumenRoute }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Step details here</a>
                </li>
                <li class="mb-10 ms-6">
                    <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                        <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                            <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                        </svg>
                    </span>
                    <h3 class="font-medium leading-tight">Jadwalkan Assesmen Lapangan</h3>
                    <a href="{{ route('auditor.assesmen-lapangan.index') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Step details here</a>
                </li>
                <li class="mb-10 ms-6">
                    <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                        <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                        </svg>
                    </span>
                    <h3 class="font-medium leading-tight">Daftar Tilik</h3>
                    <a href="{{ route('auditor.daftar-tilik.index') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Step details here</a>
                </li>
                <li class="mb-10 ms-6">
                    <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                        <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                        </svg>
                    </span>
                    <h3 class="font-medium leading-tight">Laporan Temuan</h3>
                    <a href="{{ route('auditor.laporan.index') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Step details here</a>
                </li>
                <li class="ms-6">
                    <span class="absolute flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full -start-4 ring-4 ring-white dark:ring-gray-900 dark:bg-gray-700">
                        <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                            <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                        </svg>
                    </span>
                    <h3 class="font-medium leading-tight">Closing Audit</h3>
                    <!-- <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Step details here</a> -->
                </li>
            </ol>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", async function() {
        const tableBody = document.querySelector("#tableBody");
        const namaPeriodeElem = document.querySelector("#namaPeriode");

        try {
            const response = await fetch("{{ route('auditor.auditings') }}");
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
                const statusClass = item.status === "Selesai" ?
                    'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' :
                    'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300';

                const tanggalAudit = item.periode?.tanggal_mulai ?
                    new Date(item.periode.tanggal_mulai).toLocaleDateString('id-ID') :
                    'N/A';

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