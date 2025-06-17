@extends('layouts.app')

@section('title', 'Auditor AMI')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit'],
    ]" />

    <!-- Heading -->
    <h2 class="mb-8 text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
        Progress Auditing {{ $auditing->unitKerja->nama_unit_kerja ?? '-' }}
    </h2>

    <!-- Main Content -->
    <div class="flex flex-col gap-6 lg:flex-row">
        <!-- Progress Timeline -->
        <div class="w-full lg:w-2/3">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 border border-gray-200 dark:border-gray-700">
                @php
                    $status = $auditing->status;
                @endphp
                <ol class="relative border-l-4 border-gray-200 dark:border-gray-700 pl-8">
                    <!-- Jadwalkan Assesmen Lapangan -->
                    <li class="mb-8">
                        <span class="absolute flex items-center justify-center w-10 h-10 rounded-full -left-5 ring-4 ring-white dark:ring-gray-900 {{ $status >= 3 ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-600' }}">
                            @if($status >= 3)
                                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                    <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                </svg>
                            @endif
                        </span>
                        <h3 class="ml-6 text-lg font-semibold text-gray-900 dark:text-white">Jadwalkan Assesmen Lapangan</h3>
                        @if($status == 2)
                            <a href="{{ route('auditor.assesmen-lapangan.index') }}" class="ml-6 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">Set Jadwal Assesmen Lapangan</a>
                        @endif
                    </li>
                    <!-- Koreksi Respon Instrumen -->
                    @php
                        $instrumenRoute = match ($jenisUnitId) {
                            1 => route('auditor.data-instrumen.instrumenupt'),
                            2 => route('auditor.data-instrumen.instrumenjurusan', ['id' => $auditing->auditing_id]),
                            3 => route('auditor.data-instrumen.instrumenprodi', ['id' => $auditing->auditing_id]),
                            default => '#',
                        };
                    @endphp
                    <li class="mb-8">
                        <span class="absolute flex items-center justify-center w-10 h-10 rounded-full -left-5 ring-4 ring-white dark:ring-gray-900 {{ $status >= 4 ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-600' }}">
                            @if($status >= 4)
                                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                    <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z" />
                                </svg>
                            @endif
                        </span>
                        <h3 class="ml-6 text-lg font-semibold text-gray-900 dark:text-white">Koreksi Respon Instrumen</h3>
                        @if($status == 3)
                            <a href="{{ $instrumenRoute }}" class="ml-6 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">Koreksi Jawaban Instrumen</a>
                        @elseif($status == 6 || $status == 9)
                            <a href="{{ $instrumenRoute }}" class="ml-6 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">Cek Jawaban Instrumen</a>
                        @endif
                    </li>
                    <!-- Daftar Tilik -->
                    <li class="mb-8">
                        <span class="absolute flex items-center justify-center w-10 h-10 rounded-full -left-5 ring-4 ring-white dark:ring-gray-900 {{ $status >= 5 ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-600' }}">
                            @if($status >= 5)
                                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                    <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                </svg>
                            @endif
                        </span>
                        <h3 class="ml-6 text-lg font-semibold text-gray-900 dark:text-white">Daftar Tilik</h3>
                        @if($status == 4)
                            <a href="{{ route('auditor.daftar-tilik.index', ['auditingId' => $auditing->auditing_id]) }}" class="ml-6 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">Buat Pertanyaan Daftar Tilik</a>
                        @elseif($status == 6)
                            <a href="{{ route('auditor.daftar-tilik.index', ['auditingId' => $auditing->auditing_id]) }}" class="ml-6 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">Cek Jawaban Daftar Tilik</a>
                        @endif
                    </li>
                    <!-- Laporan Temuan -->
                    <li class="mb-8">
                        <span class="absolute flex items-center justify-center w-10 h-10 rounded-full -left-5 ring-4 ring-white dark:ring-gray-900 {{ $status >= 7 ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-600' }}">
                            @if($status >= 7)
                                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                    <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                </svg>
                            @endif
                        </span>
                        <h3 class="ml-6 text-lg font-semibold text-gray-900 dark:text-white">Laporan Temuan</h3>
                        @if($status == 6)
                            <a href="{{ route('auditor.laporan.index', ['auditingId' => $auditing->auditing_id]) }}" class="ml-6 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">Buat Laporan Temuan</a>
                        @endif
                    </li>
                    <!-- Closing Audit -->
                    <li>
                        <span class="absolute flex items-center justify-center w-10 h-10 rounded-full -left-5 ring-4 ring-white dark:ring-gray-900 {{ $status >= 10 ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-600' }}">
                            @if($status >= 10)
                                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                    <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2ZM7 2h4v3H7V2Zm5.7 8.289-3.975 3.857a1 1 0 0 1-1.393 0L5.3 12.182a1.002 1.002 0 1 1 1.4-1.436l1.328 1.289 3.28-3.181a1 1 0 1 1 1.392 1.435Z" />
                                </svg>
                            @endif
                        </span>
                        <h3 class="ml-6 text-lg font-semibold text-gray-900 dark:text-white">Closing Audit</h3>
                        @if($status == 9)
                            <a href="javascript:void(0)" onclick="showCloseConfirmModal()" class="ml-6 text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">Closing Proses Audit</a>
                        @endif
                    </li>
                </ol>
            </div>
        </div>

        <!-- Progress Information -->
        <div class="w-full lg:w-1/3">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 border border-gray-200 dark:border-gray-700">
                <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Informasi Progress</h4>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Progress akan berubah secara otomatis sesuai dengan tahapan yang telah dilalui dalam proses audit.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Closing Proses Audit (Flowbite) -->
<div id="closeConfirmModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Konfirmasi Closing Proses Audit</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="closeConfirmModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-6 text-center">
                <svg class="mx-auto mb-4 w-12 h-12 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    Apakah Anda yakin ingin menyelesaikan (closing) proses audit? <br>
                    <strong class="text-red-600 dark:text-red-400">Tindakan ini tidak dapat dibatalkan.</strong>
                </p>
            </div>
            <!-- Modal Footer -->
            <div class="flex justify-center gap-4 p-4 border-t dark:border-gray-600">
                <button id="cancelLockBtn" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="closeConfirmModal">
                    Batal
                </button>
                <button id="confirmLockBtn" type="button" class="px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800">
                    Ya, Closing Proses Audit
                </button>
            </div>
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
        modal.setAttribute('aria-hidden', 'false');
    }

    function hideCloseConfirmModal() {
        const modal = document.getElementById('closeConfirmModal');
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
    }

    // Function to show response modal
    function showResponseModal(message, type) {
        const modal = document.createElement('div');
        modal.className = `fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50`;
        modal.innerHTML = `
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 w-12 h-12 ${type === 'success' ? 'text-green-500' : 'text-red-500'}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="${type === 'success' ? 'M5 13l4 4L19 7' : 'M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z'}" />
                        </svg>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">${message}</p>
                        <div class="flex justify-center">
                            <button onclick="this.closest('.fixed').remove()" class="px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800">
                                OK
                            </button>
                        </div>
                    </div>
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
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                })
                .catch(error => {
                    showResponseModal('Gagal menutup audit. Silakan coba lagi.', 'error');
                });
        });

        // Remove table rendering logic as it's not relevant to this template
    });
</script>
@endsection