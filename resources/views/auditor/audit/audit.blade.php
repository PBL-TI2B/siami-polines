@extends('layouts.app')

@section('title', 'Auditor AMI')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">

    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit'],
    ]" />
    <div class="overflow-x-auto">
        <h2 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Progress Auditing {{ $auditing->unitKerja->nama_unit_kerja ?? '-' }}
        </h2>
        <div class="flex flex-row gap-5">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8 w-2/3">
                @php
                $status = $auditing->status;
                @endphp
                <ol class="pl-5 relative text-gray-500 border-s border-gray-200 dark:border-gray-700 dark:text-gray-400">
                    {{-- Jadwalkan Assesmen Lapangan --}}
                    <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8
                {{ $status >= 3 ? 'bg-green-200 dark:bg-green-900' : 'bg-gray-100 dark:bg-gray-700' }}
                rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                            @if($status >= 3)
                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                            </svg>
                            @else
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                            </svg>
                            @endif
                        </span>
                        <h3 class="font-medium leading-tight">Jadwalkan Assesmen Lapangan</h3>
                        @if($status == 2)
                        <a href="{{ route('auditor.assesmen-lapangan.index') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Set Jadwal Assesmen Lapangan</a>
                        @endif
                    </li>
                    {{-- Koreksi Respon Instrumen --}}
                    @php
                    $instrumenRoute = match ($jenisUnitId) {
                    1 => route('auditor.data-instrumen.instrumenupt'),
                    2 => route('auditor.data-instrumen.instrumenjurusan', ['id' => $auditing->auditing_id]),
                    3 => route('auditor.data-instrumen.instrumenprodi', ['id' => $auditing->auditing_id]),
                    default => '#', // fallback kalau tidak ditemukan
                    };
                    @endphp
                    <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8
                {{ $status >= 4 ? 'bg-green-200 dark:bg-green-900' : 'bg-gray-100 dark:bg-gray-700' }}
                rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                            @if($status >= 4)
                            {{-- Centang --}}
                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                            </svg>
                            @else
                            {{-- Icon default --}}
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                            </svg>
                            @endif
                        </span>
                        <h3 class="font-medium leading-tight">Koreksi Respon Instrumen</h3>
                        @if($status == 3)
                        {{-- Link ke instrumen sesuai jenis unit --}}
                        <a href="{{ $instrumenRoute }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Koreksi Jawaban Instrumen</a>
                        @elseif($status == 6 || $status == 9)
                        {{-- Link ke instrumen sesuai jenis unit --}}
                        <a href="{{ $instrumenRoute }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Cek Jawaban Instrumen</a>
                        @endif
                    </li>
                    {{-- Daftar Tilik --}}
                    <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8
                {{ $status >= 5 ? 'bg-green-200 dark:bg-green-900' : 'bg-gray-100 dark:bg-gray-700' }}
                rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                            @if($status >= 5)
                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                            </svg>
                            @else
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                            </svg>
                            @endif
                        </span>
                        <h3 class="font-medium leading-tight">Daftar Tilik</h3>
                        @if($status == 4)
                        <a href="{{ route('auditor.daftar-tilik.index') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Buat Pertanyaan Daftar Tilik</a>
                        @elseif($status == 6)
                        <a href="{{ route('auditor.daftar-tilik.index') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Cek Jawaban Daftar Tilik</a>
                        @endif
                    </li>
                    {{-- Laporan Temuan --}}
                    <li class="mb-10 ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8
                {{ $status >= 7 ? 'bg-green-200 dark:bg-green-900' : 'bg-gray-100 dark:bg-gray-700' }}
                rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                            @if($status >= 7)
                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                            </svg>
                            @else
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                            </svg>

                            @endif
                        </span>
                        <h3 class="font-medium leading-tight">Laporan Temuan</h3>
                        @if($status == 6)
                        <a href="{{ route('auditor.laporan.index') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Step details here</a>
                        @endif
                    </li>
                    {{-- Closing Audit --}}
                    <li class="ms-6">
                        <span class="absolute flex items-center justify-center w-8 h-8
                {{ $status >= 10 ? 'bg-green-200 dark:bg-green-900' : 'bg-gray-100 dark:bg-gray-700' }}
                rounded-full -start-4 ring-4 ring-white dark:ring-gray-900">
                            @if($status >= 10)
                            <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                            </svg>
                            @else
                            <svg class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                            </svg>
                            @endif
                        </span>
                        <h3 class="font-medium leading-tight">Closing Audit</h3>
                        @if($status == 9)
                        <a href="javascript:void(0)" onclick="showCloseConfirmModal()" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Closing Proses Audit</a>
                        @endif
                    </li>
                </ol>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-8 flex-1 text-left items-center">
                <div>
                    <p class="font-bold text-2xl dark:text-gray-300 mb-4">
                        Informasi Progress
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Progress akan berubah secara otomatis sesuai dengan tahapan yang telah dilalui dalam proses audit.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Closing Proses Audit -->
<div id="closeConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">

        <!-- Icon tanda seru -->
        <div class="flex justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-yellow-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>
        </div>

        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100 text-center">
            Konfirmasi Closing Proses Audit
        </h3>

        <p class="text-sm text-gray-700 dark:text-gray-300 mb-6 text-center">
            Apakah Anda yakin ingin menyelesaikan (closing) proses audit? <br>
            <strong class="text-red-600">Tindakan ini tidak dapat dibatalkan.</strong>
        </p>

        <div class="flex justify-center gap-3">
            <button id="cancelLockBtn" type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-400 transition-all duration-200">
                Batal
            </button>
            <button id="confirmLockBtn" type="button" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700 transition-all duration-200">
                Ya, Closing Proses Audit
            </button>
        </div>
    </div>
</div>
<script>
    const auditingId = {{ session('auditing_id') ?? 'null' }};
</script>
<script>
    // Modal functions
    function showCloseConfirmModal() {
        const modal = document.getElementById('closeConfirmModal');
        modal.classList.remove('hidden');
    }

    function hideCloseConfirmModal() {
        const modal = document.getElementById('closeConfirmModal');
        modal.classList.add('hidden');
    }

    // Function to show response modal (e.g., for success or error messages)
    function showResponseModal(message, type) {
        const modal = document.createElement('div');
        modal.className = `fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50`;
        modal.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         class="w-12 h-12 ${type === 'success' ? 'text-green-500' : 'text-red-500'}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z'}" />
                    </svg>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300 mb-6 text-center">${message}</p>
                <div class="flex justify-end">
                    <button onclick="this.closest('.fixed').remove()" class="bg-sky-600 text-white px-4 py-2 rounded-md hover:bg-sky-700">
                        OK
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }

    // Event listeners for modal buttons
    document.addEventListener("DOMContentLoaded", function() {
        const confirmLockBtn = document.getElementById('confirmLockBtn');
        const cancelLockBtn = document.getElementById('cancelLockBtn');

        // Cancel button
        cancelLockBtn.addEventListener('click', () => {
            hideCloseConfirmModal();
        });

        // Confirm button
        confirmLockBtn.addEventListener('click', () => {
            hideCloseConfirmModal();
            // Update status to 10
            fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ status: 10 })
            })
                .then(response => {
                    if (!response.ok) throw new Error('Gagal menutup audit');
                    return response.json();
                })
                .then(result => {
                    showResponseModal('Audit berhasil ditutup!', 'success');
                    // Optionally reload the page to reflect the new status
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                })
                .catch(error => {
                    showResponseModal('Gagal menutup audit. Silakan coba lagi.', 'error');
                });
        });

        // Existing table rendering logic
        const tableBody = document.querySelector("#tableBody");
        const namaPeriodeElem = document.querySelector("#namaPeriode");

        try {
            const response = fetch("{{ route('auditor.auditings') }}");
            const result = response.json();

            if (!response.ok || !result.data) {
                throw new Error(result.message || 'Gagal memuat data');
            }

            const data = result.data;

            if (data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="9" class="py-4 text-center text-gray-500">Tidak ada data audit.</td></tr>`;
                namaPeriodeElem.textContent = 'Periode: -';
                return;
            }

            const periodeNama = data[0].periode?.nama_periode ?? 'Tidak diketahui';
            namaPeriodeElem.textContent = `Periode: ${periodeNama}`;

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
