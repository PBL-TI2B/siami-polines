@extends('layouts.app')

@section('title', 'Auditee AMI - Progress Audit: ' . ($audit['unit_kerja']['nama_unit_kerja'] ?? 'Detail'))

@section('content')
    {{-- Toast notification --}}
    @if (session('error'))
        <x-toast id="toast-error" type="danger" :message="session('error')" />
    @endif
    @if (session('success'))
        <x-toast id="toast-success" type="success" :message="session('success')" />
    @endif

    @php
        // Definisikan variabel untuk kartu informasi dan stepper
        $status = isset($audit['status']) ? (int) $audit['status'] : 0;

        $statusMap = [
            0 => ['text' => 'Audit Belum Dimulai', 'color' => 'gray', 'value' => 0, 'progressBg' => 'bg-gray-500'],
            1 => ['text' => 'Pengisian Instrumen', 'color' => 'blue', 'value' => 10, 'progressBg' => 'bg-blue-500'],
            2 => ['text' => 'Menunggu Jadwal Asesmen', 'color' => 'sky', 'value' => 20, 'progressBg' => 'bg-sky-500'],
            3 => ['text' => 'Jadwal Asesmen Diterbitkan', 'color' => 'sky', 'value' => 25, 'progressBg' => 'bg-sky-500'],
            4 => ['text' => 'Desk Evaluation oleh Auditor', 'color' => 'yellow', 'value' => 35, 'progressBg' => 'bg-yellow-500'],
            5 => ['text' => 'Menunggu Jawaban Daftar Tilik', 'color' => 'yellow', 'value' => 50, 'progressBg' => 'bg-yellow-500'],
            6 => ['text' => 'Daftar Tilik Telah Dijawab', 'color' => 'amber', 'value' => 60, 'progressBg' => 'bg-amber-500'],
            7 => ['text' => 'Menunggu Laporan Temuan', 'color' => 'amber', 'value' => 75, 'progressBg' => 'bg-amber-600'],
            8 => ['text' => 'Revisi Diperlukan', 'color' => 'orange', 'value' => 80, 'progressBg' => 'bg-orange-600'],
            9 => ['text' => 'Revisi Telah Dikirim', 'color' => 'orange', 'value' => 85, 'progressBg' => 'bg-orange-700'],
            10 => ['text' => 'Proses Closing oleh Auditor', 'color' => 'teal', 'value' => 90, 'progressBg' => 'bg-teal-500'],
            11 => ['text' => 'Selesai', 'color' => 'green', 'value' => 100, 'progressBg' => 'bg-green-500'],
        ];

        $progressInfo = $statusMap[$status] ?? $statusMap[0];

    @endphp

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            [
                'label' =>
                    'Progress: ' . ($audit['unit_kerja']['nama_unit_kerja'] ?? ($audit['auditing_id'] ?? 'Detail')),
            ],
        ]" />

        <div class="mb-6">
            <h1 class="mb-6 text-3xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-slate-100">
                Progress Audit: {{ $audit['unit_kerja']['nama_unit_kerja'] ?? 'Detail Audit' }}
            </h1>
        </div>
        <div class="mb-4 flex items-center gap-x-2">
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Periode:</span>
            <div
                class="inline-flex items-center gap-x-2 rounded-full bg-sky-100 px-3 py-1.5 text-xs sm:text-sm dark:bg-sky-900/50">
                <x-heroicon-o-calendar-days class="h-4 w-4 shrink-0 text-sky-600 sm:h-5 sm:w-5 dark:text-sky-300" />
                <span class="font-semibold text-sky-700 dark:text-sky-300">
                    {{ $audit['periode']['nama_periode'] ?? 'Tidak Diketahui' }}
                </span>
            </div>
        </div>


        <div class="flex flex-col gap-8 lg:flex-row">
            {{-- Konten Utama (Stepper) --}}
            <div class="w-full lg:w-2/3">
                <div
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg sm:p-8 dark:border-slate-700 dark:bg-slate-800/50">
                    <ol class="relative ml-5 border-l-2 border-slate-200 dark:border-slate-700">

                        {{-- Langkah 1: Jawab Instrumen --}}
                        <li class="mb-10 ml-10">
                            @php
                                $isStep1Done = $status > 1 && $status != 8;
                                $isStep1Current = $status == 1;
                                $isStep1Revision = $status == 8;
                            @endphp
                            <span
                                class="{{ $isStep1Done ? 'bg-green-500' : ($isStep1Current ? 'bg-sky-600' : ($isStep1Revision ? 'bg-orange-500' : 'bg-slate-200 dark:bg-slate-600')) }} absolute -left-5 flex h-10 w-10 items-center justify-center rounded-full ring-8 ring-white dark:ring-slate-800/50">
                                @if ($isStep1Done)
                                    <x-heroicon-s-check class="h-5 w-5 text-white" />
                                @else
                                    <x-heroicon-s-pencil-square
                                        class="{{ $isStep1Current || $isStep1Revision ? 'text-white' : 'text-slate-500 dark:text-slate-300' }} h-5 w-5" />
                                @endif
                            </span>
                            <h4
                                class="{{ $isStep1Done ? 'text-green-700 dark:text-green-400' : ($isStep1Current ? 'text-sky-800 dark:text-sky-300' : ($isStep1Revision ? 'text-orange-800 dark:text-orange-300' : 'text-slate-900 dark:text-white')) }} mb-1 text-lg font-semibold">
                                {{ $isStep1Revision ? 'Revisi Jawaban Instrumen' : 'Jawab Instrumen' }}
                            </h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                {{ $isStep1Revision ? 'Auditor meminta perbaikan pada jawaban instrumen Anda.' : 'Isi dan lengkapi semua instrumen audit yang tersedia.' }}
                            </p>
                            @if ($isStep1Current || $isStep1Revision)
                                <a href="{{ $instrumenRoute }}"
                                    class="{{ $isStep1Revision ? 'bg-orange-600 hover:bg-orange-700 focus:ring-orange-300 dark:focus:ring-orange-800' : 'bg-sky-600 hover:bg-sky-700 focus:ring-sky-300 dark:focus:ring-sky-800' }} mt-3 inline-flex items-center rounded-lg px-4 py-2 text-sm font-medium text-white focus:outline-none focus:ring-4">
                                    {{ $isStep1Revision ? 'Kerjakan Revisi' : 'Mulai Jawab' }}
                                    <x-heroicon-s-arrow-right class="ms-2 h-4 w-4" />
                                </a>
                            @endif
                        </li>

                        {{-- Langkah 2: Lihat Jadwal Asesmen Lapangan --}}
                        <li class="mb-10 ml-10">
                            @php
                                $isStep2Done = $status > 3;
                                $isStep2Current = $status == 3;
                            @endphp
                            <span
                                class="{{ $isStep2Done ? 'bg-green-500' : ($isStep2Current ? 'bg-sky-600' : 'bg-slate-200 dark:bg-slate-600') }} absolute -left-5 flex h-10 w-10 items-center justify-center rounded-full ring-8 ring-white dark:ring-slate-800/50">
                                @if ($isStep2Done)
                                    <x-heroicon-s-check class="h-5 w-5 text-white" />
                                @else
                                    <x-heroicon-s-calendar-days
                                        class="{{ $isStep2Current ? 'text-white' : 'text-slate-500 dark:text-slate-300' }} h-5 w-5" />
                                @endif
                            </span>
                            <h4
                                class="{{ $isStep2Done ? 'text-green-700 dark:text-green-400' : ($isStep2Current ? 'text-sky-800 dark:text-sky-300' : 'text-slate-900 dark:text-white') }} mb-1 text-lg font-semibold">
                                Jadwal Asesmen Lapangan
                            </h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Lihat jadwal asesmen lapangan yang telah
                                ditentukan oleh auditor.</p>
                            @if ($isStep2Current)
                                <a href="{{ $assessmentScheduleRoute }}"
                                    class="mt-3 inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800">
                                    Lihat Jadwal
                                    <x-heroicon-s-arrow-right class="ms-2 h-4 w-4" />
                                </a>
                            @endif
                        </li>

                        {{-- Langkah 3: Jawab Daftar Tilik --}}
                        <li class="mb-10 ml-10">
                            @php
                                $isStep3Done = $status > 5;
                                $isStep3Current = $status == 5;
                            @endphp
                            <span
                                class="{{ $isStep3Done ? 'bg-green-500' : ($isStep3Current ? 'bg-sky-600' : 'bg-slate-200 dark:bg-slate-600') }} absolute -left-5 flex h-10 w-10 items-center justify-center rounded-full ring-8 ring-white dark:ring-slate-800/50">
                                @if ($isStep3Done)
                                    <x-heroicon-s-check class="h-5 w-5 text-white" />
                                @else
                                    <x-heroicon-s-document-check
                                        class="{{ $isStep3Current ? 'text-white' : 'text-slate-500 dark:text-slate-300' }} h-5 w-5" />
                                @endif
                            </span>
                            <h4
                                class="{{ $isStep3Done ? 'text-green-700 dark:text-green-400' : ($isStep3Current ? 'text-sky-800 dark:text-sky-300' : 'text-slate-900 dark:text-white') }} mb-1 text-lg font-semibold">
                                Jawab Daftar Tilik
                            </h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Berikan respon terhadap daftar tilik yang
                                dibuat oleh auditor untuk verifikasi.</p>
                            @if ($isStep3Current)
                                <a href="{{ $tilikResponseRoute }}"
                                    class="mt-3 inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800">
                                    Jawab Daftar Tilik
                                    <x-heroicon-s-arrow-right class="ms-2 h-4 w-4" />
                                </a>
                            @endif
                        </li>

                        {{-- Langkah 4: Lihat Laporan Temuan --}}
                        <li class="mb-10 ml-10">
                            @php
                                $isStep4Done = $status > 7;
                                $isStep4Current = $status == 7;
                            @endphp
                            <span
                                class="{{ $isStep4Done ? 'bg-green-500' : ($isStep4Current ? 'bg-sky-600' : 'bg-slate-200 dark:bg-slate-600') }} absolute -left-5 flex h-10 w-10 items-center justify-center rounded-full ring-8 ring-white dark:ring-slate-800/50">
                                @if ($isStep4Done)
                                    <x-heroicon-s-check class="h-5 w-5 text-white" />
                                @else
                                    <x-heroicon-s-document-text
                                        class="{{ $isStep4Current ? 'text-white' : 'text-slate-500 dark:text-slate-300' }} h-5 w-5" />
                                @endif
                            </span>
                            <h4
                                class="{{ $isStep4Done ? 'text-green-700 dark:text-green-400' : ($isStep4Current ? 'text-sky-800 dark:text-sky-300' : 'text-slate-900 dark:text-white') }} mb-1 text-lg font-semibold">
                                Laporan Temuan & Tindak Lanjut
                            </h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Periksa laporan temuan dari auditor dan
                                siapkan rencana tindak lanjut.</p>
                            @if ($isStep4Current)
                                <a href="{{ $laporanTemuanRoute }}"
                                    class="mt-3 inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-800">
                                    Lihat Laporan
                                    <x-heroicon-s-arrow-right class="ms-2 h-4 w-4" />
                                </a>
                            @endif
                        </li>

                        {{-- Langkah 5: Audit Selesai --}}
                        <li class="ml-10">
                            {{-- PERUBAHAN: Dianggap selesai jika status 10 (Closing) atau lebih --}}
                            @php $isStep5Done = $status >= 10; @endphp
                            <span
                                class="{{ $isStep5Done ? 'bg-green-500' : 'bg-slate-200 dark:bg-slate-600' }} absolute -left-5 flex h-10 w-10 items-center justify-center rounded-full ring-8 ring-white dark:ring-slate-800/50">
                                @if ($isStep5Done)
                                    <x-heroicon-s-shield-check class="h-5 w-5 text-white" />
                                @else
                                    <x-heroicon-s-shield-check class="h-5 w-5 text-slate-500 dark:text-slate-300" />
                                @endif
                            </span>
                            <h4
                                class="{{ $isStep5Done ? 'text-green-700 dark:text-green-400' : 'text-slate-900 dark:text-white' }} mb-1 text-lg font-semibold">
                                Audit Selesai
                            </h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Seluruh proses audit untuk unit kerja Anda
                                telah selesai.</p>
                        </li>

                    </ol>
                </div>
            </div>

            {{-- Sidebar Status --}}
            <div class="w-full lg:w-1/3">
                <div
                    class="sticky top-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-lg dark:border-slate-700 dark:bg-slate-800/50">
                    <h4 class="mb-4 text-xl font-bold text-slate-800 dark:text-slate-100">Status Audit Saat Ini</h4>
                    <div class="mb-4">
                        <span
                            class="{{ [
                                'gray' => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300',
                                'blue' => 'bg-blue-100 dark:bg-blue-800 text-blue-700 dark:text-blue-300',
                                'sky' => 'bg-sky-100 dark:bg-sky-800 text-sky-700 dark:text-sky-300',
                                'yellow' => 'bg-yellow-100 dark:bg-yellow-800 text-yellow-700 dark:text-yellow-300',
                                'amber' => 'bg-amber-100 dark:bg-amber-800 text-amber-700 dark:text-amber-300',
                                'orange' => 'bg-orange-100 dark:bg-orange-800 text-orange-700 dark:text-orange-300',
                                'rose' => 'bg-rose-100 dark:bg-rose-800 text-rose-700 dark:text-rose-300',
                                'pink' => 'bg-pink-100 dark:bg-pink-800 text-pink-700 dark:text-pink-300',
                                'teal' => 'bg-teal-100 dark:bg-teal-800 text-teal-700 dark:text-teal-300',
                                'green' => 'bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-300',
                            ][$progressInfo['color']] }} inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold">
                            {{ $progressInfo['text'] }}
                        </span>
                    </div>

                    <div class="mb-2 h-2.5 w-full rounded-full bg-slate-200 dark:bg-slate-700">
                        <div class="{{ $progressInfo['progressBg'] }} h-2.5 rounded-full"
                            style="width: {{ $progressInfo['value'] }}%"></div>
                    </div>
                    <p class="mb-6 text-right text-sm font-medium text-slate-600 dark:text-slate-400">
                        {{ $progressInfo['value'] }}% Selesai
                    </p>

                    <div class="mt-4 border-t border-slate-200 pt-4 dark:border-slate-700">
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            Progress akan diperbarui secara otomatis. Mohon periksa halaman ini secara berkala untuk melihat
                            tugas berikutnya yang perlu Anda selesaikan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
