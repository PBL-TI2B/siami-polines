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

    {{-- Template Ikon Blade --}}
    <div style="display: none;" id="blade-icon-templates">
        <span class="icon-template" data-icon-type="completed"><x-heroicon-s-check class="h-5 w-5" /></span>
        <span class="icon-template" data-icon-type="step1"><x-heroicon-s-pencil-square class="h-5 w-5" /></span>
        <span class="icon-template" data-icon-type="step2"><x-heroicon-s-clock class="h-5 w-5" /></span>
        <span class="icon-template" data-icon-type="step3"><x-heroicon-s-document-check class="h-5 w-5" /></span>
        <span class="icon-template" data-icon-type="step4"><x-heroicon-s-shield-check class="h-5 w-5" /></span>
    </div>

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
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                Progress Audit: {{ $audit['unit_kerja']['nama_unit_kerja'] ?? 'Detail Audit' }}
            </h1>
        </div>

        <div class="mb-4 flex">
            <div class="flex items-center gap-x-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Periode:</span>
                <div
                    class="inline-flex items-center gap-x-2 rounded-2xl bg-sky-100 px-3 py-1.5 text-xs sm:text-sm dark:bg-sky-800">
                    <x-heroicon-o-calendar-days class="h-4 w-4 shrink-0 text-sky-600 sm:h-5 sm:w-5 dark:text-sky-300" />
                    <span class="font-semibold text-sky-600 dark:text-sky-300">
                        {{ $audit['periode']['nama_periode'] ?? 'Tidak Diketahui' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow sm:p-8 dark:bg-gray-800">
            <ol id="auditProgressStepper" class="relative ml-4 border-s border-gray-300 dark:border-gray-700">
                {{-- Langkah 1: Jawab Instrumen --}}
                <li id="progressStep1" class="mb-10 ms-8">
                    <span id="progressIconWrapper1"
                        class="absolute -start-[21px] flex h-10 w-10 items-center justify-center rounded-full ring-4 ring-white dark:ring-gray-800">
                        <div id="progressIconContainer1"
                            class="flex h-full w-full items-center justify-center rounded-full"></div>
                    </span>
                    <h3 id="progressTitle1" class="text-base font-semibold">Jawab Instrumen</h3>
                    <p id="progressStatusText1" class="text-sm font-normal">Menunggu untuk dimulai</p>
                    <a href="{{ $instrumenRoute }}" id="progressLink1"
                        class="mt-2 inline-flex items-center rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-300 focus:z-10 focus:outline-none focus:ring-4">
                        Lihat Detail <x-heroicon-s-arrow-right class="ms-2 h-3 w-3 rtl:rotate-180" />
                    </a>
                </li>

                {{-- Langkah 2: Lihat Jadwal Asesmen Lapangan --}}
                <li id="progressStep2" class="mb-10 ms-8">
                    <span id="progressIconWrapper2"
                        class="absolute -start-[21px] flex h-10 w-10 items-center justify-center rounded-full ring-4 ring-white dark:ring-gray-800">
                        <div id="progressIconContainer2"
                            class="flex h-full w-full items-center justify-center rounded-full"></div>
                    </span>
                    <h3 id="progressTitle2" class="text-base font-semibold">Jadwal Asesmen Lapangan</h3>
                    <p id="progressStatusText2" class="text-sm font-normal">Menunggu langkah sebelumnya</p>
                    <a href="{{ $assessmentScheduleRoute }}" id="progressLink2"
                        class="mt-2 inline-flex items-center rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-300 focus:z-10 focus:outline-none focus:ring-4">
                        Lihat Detail <x-heroicon-s-arrow-right class="ms-2 h-3 w-3 rtl:rotate-180" />
                    </a>
                </li>

                {{-- Langkah 3: Jawab Daftar Tilik --}}
                <li id="progressStep3" class="mb-10 ms-8">
                    <span id="progressIconWrapper3"
                        class="absolute -start-[21px] flex h-10 w-10 items-center justify-center rounded-full ring-4 ring-white dark:ring-gray-800">
                        <div id="progressIconContainer3"
                            class="flex h-full w-full items-center justify-center rounded-full"></div>
                    </span>
                    <h3 id="progressTitle3" class="text-base font-semibold">Jawab Daftar Tilik</h3>
                    <p id="progressStatusText3" class="text-sm font-normal">Menunggu langkah sebelumnya</p>
                    <a href="{{ $tilikResponseRoute }}" id="progressLink3"
                        class="mt-2 inline-flex items-center rounded-lg px-4 py-2 text-sm font-medium transition-colors duration-300 focus:z-10 focus:outline-none focus:ring-4">
                        Lihat Detail <x-heroicon-s-arrow-right class="ms-2 h-3 w-3 rtl:rotate-180" />
                    </a>
                </li>

                {{-- Langkah 4: Audit Selesai --}}
                <li id="progressStep4" class="ms-8">
                    <span id="progressIconWrapper4"
                        class="absolute -start-[21px] flex h-10 w-10 items-center justify-center rounded-full ring-4 ring-white dark:ring-gray-800">
                        <div id="progressIconContainer4"
                            class="flex h-full w-full items-center justify-center rounded-full"></div>
                    </span>
                    <h3 id="progressTitle4" class="text-base font-semibold">Audit Selesai</h3>
                    <p id="progressStatusText4" class="text-sm font-normal">Menunggu langkah sebelumnya</p>
                </li>
            </ol>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentAuditStatus = {{ isset($audit['status']) ? (int) $audit['status'] : 0 }};
            const routes = {
                1: "{{ $instrumenRoute }}",
                2: "{{ $assessmentScheduleRoute }}",
                3: "{{ $tilikResponseRoute }}",
                4: "#"
            };

            const iconTemplatesContainer = document.getElementById('blade-icon-templates');
            const getIconHtml = (type) => {
                const templateSpan = iconTemplatesContainer.querySelector(
                    `.icon-template[data-icon-type="${type}"]`);
                return templateSpan ? templateSpan.innerHTML : '<svg class="w-5 h-5"></svg>';
            };

            const statusTextMap = {
                pending: "Menunggu langkah sebelumnya",
                current: "Sedang berlangsung",
                completed: "Selesai",
                revision: "Revisi Diperlukan"
            };

            function updateStepUI(stepNumber, state) {
                const iconContainer = document.getElementById(`progressIconContainer${stepNumber}`);
                const title = document.getElementById(`progressTitle${stepNumber}`);
                const statusTextElem = document.getElementById(`progressStatusText${stepNumber}`);
                const link = document.getElementById(`progressLink${stepNumber}`);

                let iconHtml, iconColorClasses = [],
                    containerBgClasses = [],
                    titleColorClasses = [],
                    statusTextColorClasses = [];

                statusTextElem.textContent = statusTextMap[state] || "Status tidak diketahui";

                // --- LOGIKA UNTUK GAYA TOMBOL DINAMIS ---
                if (link) {
                    // Definisikan semua kemungkinan kelas gaya tombol
                    const allButtonStyles = [
                        'bg-white', 'dark:bg-gray-700', 'border', 'border-gray-300', 'dark:border-gray-600',
                        'text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-50', 'dark:hover:bg-gray-600',
                        'focus:ring-gray-200', 'dark:focus:ring-gray-500',
                        'bg-sky-50', 'dark:bg-sky-800', 'border-sky-300', 'dark:border-sky-600', 'text-sky-700',
                        'dark:text-sky-200', 'hover:bg-sky-100', 'dark:hover:bg-sky-900', 'focus:ring-sky-200',
                        'dark:focus:ring-sky-500',
                        'bg-orange-50', 'dark:bg-orange-800/50', 'border-orange-300', 'dark:border-orange-600',
                        'text-orange-700', 'dark:text-orange-200', 'hover:bg-orange-100',
                        'dark:hover:bg-orange-900/50', 'focus:ring-orange-200', 'dark:focus:ring-orange-500',
                        'opacity-50', 'pointer-events-none'
                    ];
                    // Hapus semua kelas gaya sebelumnya untuk menghindari konflik
                    link.classList.remove(...allButtonStyles);

                    if (state === 'pending' || state === 'completed') {
                        link.classList.add('bg-white', 'dark:bg-gray-700', 'border', 'border-gray-300',
                            'dark:border-gray-600', 'text-gray-700', 'dark:text-gray-300', 'opacity-50',
                            'pointer-events-none');
                    } else if (state === 'current') {
                        link.classList.add('bg-sky-50', 'dark:bg-sky-800', 'border', 'border-sky-300',
                            'dark:border-sky-600', 'text-sky-700', 'dark:text-sky-200', 'hover:bg-sky-100',
                            'dark:hover:bg-sky-900', 'focus:ring-sky-200', 'dark:focus:ring-sky-500');
                    } else if (state === 'revision') {
                        link.classList.add('bg-orange-50', 'dark:bg-orange-800/50', 'border', 'border-orange-300',
                            'dark:border-orange-600', 'text-orange-700', 'dark:text-orange-200',
                            'hover:bg-orange-100', 'dark:hover:bg-orange-900/50', 'focus:ring-orange-200',
                            'dark:focus:ring-orange-500');
                    }
                }

                if (state === "completed") {
                    iconHtml = getIconHtml('completed');
                    containerBgClasses = ['bg-green-500', 'dark:bg-green-600'];
                    iconColorClasses = ['text-white'];
                    titleColorClasses = ['text-green-700', 'dark:text-green-400'];
                    statusTextColorClasses = ['text-green-600', 'dark:text-green-500'];
                } else if (state === "current" || state === "revision") {
                    iconHtml = getIconHtml(`step${stepNumber}`);
                    iconColorClasses = ['text-white'];

                    if (state === "revision") {
                        containerBgClasses = ['bg-orange-500', 'dark:bg-orange-600'];
                        titleColorClasses = ['text-orange-800', 'dark:text-orange-300'];
                        statusTextColorClasses = ['text-orange-700', 'dark:text-orange-400'];
                    } else {
                        containerBgClasses = ['bg-sky-600', 'dark:bg-sky-500'];
                        titleColorClasses = ['text-sky-800', 'dark:text-sky-300'];
                        statusTextColorClasses = ['text-sky-700', 'dark:text-sky-400'];
                    }
                } else {
                    iconHtml = getIconHtml(`step${stepNumber}`);
                    containerBgClasses = ['bg-gray-200', 'dark:bg-gray-600'];
                    iconColorClasses = ['text-gray-500', 'dark:text-gray-400'];
                    titleColorClasses = ['text-gray-500', 'dark:text-gray-500'];
                    statusTextColorClasses = ['text-gray-500', 'dark:text-gray-400'];
                }

                iconContainer.innerHTML = iconHtml;
                iconContainer.className =
                    'w-full h-full rounded-full flex items-center justify-center transition-colors duration-300';
                iconContainer.classList.add(...containerBgClasses);

                const svgElement = iconContainer.querySelector('svg');
                if (svgElement) {
                    svgElement.classList.remove(...Array.from(svgElement.classList).filter(cls => cls.startsWith(
                        'text-')));
                    svgElement.classList.add(...iconColorClasses);
                }

                title.className = 'text-base font-semibold transition-colors duration-300';
                title.classList.add(...titleColorClasses);

                statusTextElem.className = 'text-sm font-normal transition-colors duration-300';
                statusTextElem.classList.add(...statusTextColorClasses);
            }

            function updateOverallProgress(statusAuditGlobal) {
                const statusGlobal = parseInt(statusAuditGlobal) || 0;

                document.getElementById('progressTitle1').textContent = 'Jawab Instrumen';
                document.getElementById('progressTitle2').textContent = 'Lihat Jadwal Asesmen Lapangan';
                document.getElementById('progressTitle3').textContent = 'Jawab Daftar Tilik';

                if (statusGlobal === 8) {
                    updateStepUI(1, 'revision');
                    document.getElementById('progressTitle1').textContent = 'Revisi Jawaban Instrumen';
                    updateStepUI(2, 'completed');
                    updateStepUI(3, 'completed');
                    // Jika ada revisi pada daftar tilik, tampilkan status revisi
                    // updateStepUI(3, 'revision');
                    // document.getElementById('progressTitle3').textContent = 'Revisi Jawaban Daftar Tilik';
                    updateStepUI(4, 'pending');
                } else if (statusGlobal === 10) {
                    updateStepUI(1, 'completed');
                    updateStepUI(2, 'completed');
                    updateStepUI(3, 'completed');
                    updateStepUI(4, 'completed');
                } else {
                    if (statusGlobal === 1) updateStepUI(1, 'current');
                    else if (statusGlobal > 1) updateStepUI(1, 'completed');
                    else updateStepUI(1, 'pending');

                    if (statusGlobal === 3) updateStepUI(2, 'current');
                    else if (statusGlobal > 3) updateStepUI(2, 'completed');
                    else updateStepUI(2, 'pending');

                    if (statusGlobal === 5) updateStepUI(3, 'current');
                    else if (statusGlobal > 5) updateStepUI(3, 'completed');
                    else updateStepUI(3, 'pending');

                    updateStepUI(4, 'pending');
                }
            }

            updateOverallProgress(currentAuditStatus);
        });
    </script>
@endsection
