@extends('layouts.app')

@section('title', 'Auditor AMI')

@section('content')
@php
// Definisikan variabel untuk kartu informasi agar lebih bersih
$status = $auditing->status;
$progressInfo = [
'text' => 'Audit Belum Dimulai',
'color' => 'gray',
'value' => 0,
];

if ($status >= 11) {
$progressInfo = ['text' => 'Selesai', 'color' => 'green', 'value' => 100];
} elseif ($status == 10) {
$progressInfo = ['text' => 'Closing', 'color' => 'green', 'value' => 95];
} elseif ($status == 9) {
$progressInfo = ['text' => 'Sudah Revisi', 'color' => 'sky', 'value' => 90];
} elseif ($status == 8) {
$progressInfo = ['text' => 'Revisi', 'color' => 'yellow', 'value' => 80];
} elseif ($status == 7) {
$progressInfo = ['text' => 'Laporan Temuan', 'color' => 'sky', 'value' => 70];
} elseif ($status == 6) {
$progressInfo = ['text' => 'Tilik Dijawab', 'color' => 'sky', 'value' => 60];
} elseif ($status == 5) {
$progressInfo = ['text' => 'Pertanyaan Tilik', 'color' => 'yellow', 'value' => 50];
} elseif ($status == 4) {
$progressInfo = ['text' => 'Desk Evaluation', 'color' => 'sky', 'value' => 40];
} elseif ($status == 3) {
$progressInfo = ['text' => 'Dijadwalkan AL', 'color' => 'sky', 'value' => 30];
} elseif ($status == 2) {
$progressInfo = ['text' => 'Penjadwalan AL', 'color' => 'sky', 'value' => 20];
} elseif ($status == 1) {
$progressInfo = ['text' => 'Pengisian Instrumen', 'color' => 'sky', 'value' => 10];
}

$periodeStatus = $auditing->periode->status ?? null;
@endphp

<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit'],
    ]" />

    <div class="mb-5">
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-slate-100 sm:text-4xl">
            Progress Audit AMI {{ $auditing->unitKerja->nama_unit_kerja ?? '-' }}
        </h1>
    </div>

    @if($periodeStatus === 'Berakhir')
    <div class="mb-6 p-4 rounded-lg bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200 flex flex-row gap-2">
       <x-heroicon-s-exclamation-triangle class="h-6 w-6"/> <strong>Periode audit telah berakhir.</strong> Anda hanya dapat melihat progress audit, semua aksi telah dinonaktifkan.
    </div>
    @endif

    <div class="flex flex-col gap-8 lg:flex-row">
        <div class="w-full lg:w-2/3">
            <div class="bg-white dark:bg-slate-800/50 shadow-lg rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-700">
                <ol class="ml-5 relative border-l-2 border-slate-200 dark:border-slate-700">
                    @php
                    $instrumenRoute = match ($jenisUnitId) {
                    1 => route('auditor.data-instrumen.instrumenupt',['id' => $auditing->auditing_id]),
                    2 => route('auditor.data-instrumen.instrumenjurusan', ['id' => $auditing->auditing_id]),
                    3 => route('auditor.data-instrumen.instrumenprodi', ['id' => $auditing->auditing_id]),
                    default => '#',
                    };
                    $disabled = $periodeStatus === 'Berakhir' ? 'disabled aria-disabled=true tabindex=-1 style="pointer-events:none;opacity:0.6;"' : '';
                    @endphp

                    <li class="mb-10 ml-10">
                        <span class="absolute -left-5 flex h-10 w-10 items-center justify-center rounded-full ring-8 ring-white dark:ring-slate-800/50 {{ $status >= 3 ? 'bg-green-500' : 'bg-slate-200 dark:bg-slate-600' }}">
                            @if($status >= 3)
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            @else
                            <svg class="h-5 w-5 text-slate-500 dark:text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </span>
                        <h4 class="mb-1 flex items-center text-lg font-semibold text-slate-900 dark:text-white">Jadwalkan Assesmen Lapangan</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Atur tanggal dan waktu untuk pelaksanaan asesmen lapangan dengan auditee.</p>
                        @if($status == 2)
                        <a href="{{ route('auditor.assesmen-lapangan.index',['id' => $auditing->auditing_id]) }}" class="mt-3 inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800" {!! $disabled !!}>
                            Set Jadwal
                            <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        <a href="{{ route('auditor.audit.presensi',['auditing' => $auditing->auditing_id]) }}" class="mt-3 inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800" {!! $disabled !!}>
                            Download Presensi
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                        </a>
                        @endif
                    </li>

                    <li class="mb-10 ml-10">
                        <span class="absolute -left-5 flex h-10 w-10 items-center justify-center rounded-full ring-8 ring-white dark:ring-slate-800/50 {{ $status >= 4 ? 'bg-green-500' : 'bg-slate-200 dark:bg-slate-600' }}">
                            @if($status >= 4)
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            @else
                            <svg class="h-5 w-5 text-slate-500 dark:text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </span>
                        <h4 class="mb-1 text-lg font-semibold text-slate-900 dark:text-white">Koreksi Respon Instrumen</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Periksa dan berikan skor pada jawaban instrumen yang telah diisi oleh auditee.</p>
                        @if($status == 3)
                        <a href="{{ $instrumenRoute }}" class="mt-3 inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800" {!! $disabled !!}>
                            Koreksi Jawaban
                            <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        @elseif($status == 6 || $status == 9)
                        <a href="{{ $instrumenRoute }}" class="mt-3 inline-flex items-center rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 focus:outline-none focus:ring-4 focus:ring-slate-300 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600 dark:focus:ring-slate-800">
                            Lihat Jawaban
                        </a>
                        @endif
                    </li>

                    <li class="mb-10 ml-10">
                        <span class="absolute -left-5 flex h-10 w-10 items-center justify-center rounded-full ring-8 ring-white dark:ring-slate-800/50 {{ $status >= 5 ? 'bg-green-500' : 'bg-slate-200 dark:bg-slate-600' }}">
                            @if($status >= 5)
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            @else
                            <svg class="h-5 w-5 text-slate-500 dark:text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </span>
                        <h4 class="mb-1 text-lg font-semibold text-slate-900 dark:text-white">Daftar Tilik</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Buat pertanyaan verifikasi untuk asesmen lapangan dan periksa jawabannya.</p>
                        @if($status == 4)
                        <a href="{{ route('auditor.daftar-tilik.index', ['auditingId' => $auditing->auditing_id]) }}" class="mt-3 inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800" {!! $disabled !!}>
                            Buat Daftar Tilik
                            <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        @elseif($status == 6 || $status == 9)
                        <a href="{{ route('auditor.daftar-tilik.index', ['auditingId' => $auditing->auditing_id]) }}" class="mt-3 inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800" {!! $disabled !!}>
                            Cek Jawaban Daftar Tilik
                            <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        @endif
                    </li>

                    <li class="mb-10 ml-10">
                        <span class="absolute -left-5 flex h-10 w-10 items-center justify-center rounded-full ring-8 ring-white dark:ring-slate-800/50 {{ $status >= 7 ? 'bg-green-500' : 'bg-slate-200 dark:bg-slate-600' }}">
                            @if($status >= 7)
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            @else
                            <svg class="h-5 w-5 text-slate-500 dark:text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            @endif
                        </span>
                        <h4 class="mb-1 text-lg font-semibold text-slate-900 dark:text-white">Laporan Temuan</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Susun laporan berdasarkan temuan selama proses audit untuk ditinjau oleh auditee.</p>
                        @if($status == 6)
                        <a href="{{ route('auditor.laporan.index', ['auditingId' => $auditing->auditing_id]) }}" class="mt-3 inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800" {!! $disabled !!}>
                            Buat Laporan
                            <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        @endif
                    </li>

                    <li class="ml-10">
                        <span class="absolute -left-5 flex h-10 w-10 items-center justify-center rounded-full ring-8 ring-white dark:ring-slate-800/50 {{ $status >= 10 ? 'bg-green-500' : 'bg-slate-200 dark:bg-slate-600' }}">
                            @if($status >= 10)
                            <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            @else
                            <svg class="h-5 w-5 text-slate-500 dark:text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2H7V7a3 3 0 015.905-.75 1 1 0 001.788-1.15A5.002 5.002 0 0010 2z" />
                            </svg>
                            @endif
                        </span>
                        <h4 class="mb-1 text-lg font-semibold text-slate-900 dark:text-white">Closing Audit</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Selesaikan proses audit setelah semua tahapan disetujui.</p>
                        @if($status == 9)
                        <button type="button" onclick="showCloseConfirmModal()" class="mt-3 inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800 gap-2" {!! $disabled !!}>
                            Closing Proses Audit
                            <x-heroicon-s-key class="h-4 w-4"/>
                        </button>
                        @endif
                    </li>
                </ol>
            </div>
        </div>

        <div class="w-full lg:w-1/3">
            <div class="bg-white dark:bg-slate-800/50 shadow-lg rounded-2xl p-6 border border-slate-200 dark:border-slate-700 sticky top-8">
                <h4 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-4">Status Audit Saat Ini</h4>

                <div class="mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{
                        [
                            'gray' => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200',
                            'sky' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/50 dark:text-sky-300',
                            'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
                            'green' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                        ][$progressInfo['color']]
                    }}">
                        {{ $progressInfo['text'] }}
                    </span>
                </div>

                <div class="w-full bg-slate-200 rounded-full h-2.5 dark:bg-slate-700 mb-2">
                    <div class="bg-{{ $progressInfo['color'] }}-500 h-2.5 rounded-full" style="width: {{ $progressInfo['value'] }}%"></div>
                </div>
                <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-6 text-right">{{ $progressInfo['value'] }}% Selesai</p>

                <div class="mt-4 border-t border-slate-200 dark:border-slate-700 pt-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Progress akan diperbarui secara otomatis setelah Anda menyelesaikan setiap tahapan. Pastikan untuk mengikuti alur yang telah ditentukan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="closeConfirmModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-screen bg-black/50 backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-xl dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-slate-600">
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white">
                    Konfirmasi Closing Audit
                </h3>
                <button type="button" onclick="hideCloseConfirmModal()" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-yellow-400 w-14 h-14" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <p class="mb-5 text-base text-slate-600 dark:text-slate-400">
                    Apakah Anda yakin ingin menyelesaikan proses audit ini?
                    <br>
                    <strong class="text-red-600 dark:text-red-500">Tindakan ini tidak dapat dibatalkan.</strong>
                </p>
            </div>
            <div class="flex justify-center items-center p-4 md:p-5 border-t border-slate-200 rounded-b dark:border-slate-600 gap-4">
                <button id="cancelLockBtn" type="button" class="px-5 py-2.5 text-sm font-medium text-slate-900 focus:outline-none bg-white rounded-lg border border-slate-200 hover:bg-slate-100 hover:text-sky-700 focus:z-10 focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-600 dark:hover:text-white dark:hover:bg-slate-700">Batal</button>
                <button id="confirmLockBtn" type="button" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Ya, Saya Yakin
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Definisikan variabel penting dari PHP ke JS
    const auditingId = {{$auditing -> auditing_id}};
    const apiUpdateUrl = `http://127.0.0.1:5000/api/auditings/${auditingId}`;

    const modalElement = document.getElementById('closeConfirmModal');
    const modalOptions = {
        placement: 'center-center',
        backdrop: 'static',
        backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
        closable: true,
    };
    // Instance modal Flowbite (opsional, jika Anda menggunakan JS Flowbite)
    // const modal = new Modal(modalElement, modalOptions);

    function showCloseConfirmModal() {
        modalElement.classList.remove('hidden');
        modalElement.setAttribute('aria-hidden', 'false');
        document.body.classList.add('overflow-hidden'); // Mencegah scroll di background
    }

    function hideCloseConfirmModal() {
        modalElement.classList.add('hidden');
        modalElement.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('overflow-hidden');
    }

    // Function untuk menampilkan modal respons (sukses/gagal)
    function showResponseModal(message, type = 'success') {
        const iconSuccess = `<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />`;
        const iconError = `<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.008v.008H12v-.008Z" />`;

        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm';
        modal.innerHTML = `
            <div class="relative p-4 w-full max-w-md">
                <div class="relative bg-white rounded-2xl shadow-xl dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 w-14 h-14 ${type === 'success' ? 'text-green-500' : 'text-red-500'}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            ${type === 'success' ? iconSuccess : iconError}
                        </svg>
                        <p class="text-lg text-slate-600 dark:text-slate-300 mb-6">${message}</p>
                        <div class="flex justify-center">
                            <button onclick="this.closest('.fixed').remove(); window.location.reload();" class="px-6 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const confirmLockBtn = document.getElementById('confirmLockBtn');
        const cancelLockBtn = document.getElementById('cancelLockBtn');

        if (cancelLockBtn) {
            cancelLockBtn.addEventListener('click', hideCloseConfirmModal);
        }

        // Listener untuk tombol tutup modal bawaan
        document.querySelectorAll('[data-modal-hide="closeConfirmModal"]').forEach(button => {
            button.addEventListener('click', hideCloseConfirmModal);
        });

        if (confirmLockBtn) {
            confirmLockBtn.addEventListener('click', () => {
                hideCloseConfirmModal();

                // Tampilkan loading spinner jika ada
                confirmLockBtn.disabled = true;
                confirmLockBtn.innerHTML = 'Memproses...';

                fetch(apiUpdateUrl, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Penting untuk keamanan di Laravel
                        },
                        body: JSON.stringify({
                            status: 10
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || 'Gagal menutup audit')
                            });
                        }
                        return response.json();
                    })
                    .then(result => {
                        // Tampilkan modal sukses dan reload halaman setelah ditutup
                        showResponseModal('Proses audit berhasil di-closing!', 'success');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showResponseModal(error.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                    })
                    .finally(() => {
                        // Kembalikan tombol ke state semula
                        confirmLockBtn.disabled = false;
                        confirmLockBtn.innerHTML = 'Ya, Saya Yakin';
                    });
            });
        }
    });
</script>
@endsection
