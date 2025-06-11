@extends('layouts.app')

@section('title', 'Auditee AMI - Progress Audit: ' . ($audit['unit_kerja']['nama_unit_kerja'] ?? 'Detail'))

@section('content')
    {{-- Template Ikon Blade --}}
    <div style="display: none;" id="blade-icon-templates">
        <span class="icon-template" data-icon-type="completed"><x-heroicon-s-check class="w-5 h-5" /></span>
        <span class="icon-template" data-icon-type="step1"><x-heroicon-s-pencil-square class="w-5 h-5" /></span>
        <span class="icon-template" data-icon-type="step2"><x-heroicon-s-clock class="w-5 h-5" /></span>
        <span class="icon-template" data-icon-type="step3"><x-heroicon-s-check-circle class="w-5 h-5" /></span>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            ['label' => 'Progress: ' . ($audit['unit_kerja']['nama_unit_kerja'] ?? $audit['auditing_id'] ?? 'Detail')]
        ]" />

        <div class="mt-5 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                Progress Audit: {{ $audit['unit_kerja']['nama_unit_kerja'] ?? 'Detail Audit' }}
            </h1>
        </div>

        <div class="mb-4 flex">
            <div class="flex items-center gap-x-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Periode:</span>
                <div class="inline-flex items-center gap-x-2 rounded-2xl bg-sky-100 px-3 py-1.5 text-xs sm:text-sm dark:bg-sky-800">
                     <x-heroicon-o-calendar-days class="h-4 w-4 shrink-0 text-sky-600 dark:text-sky-300 sm:h-5 sm:w-5" />
                    <span class="font-semibold text-sky-700 dark:text-sky-300">
                        {{ $audit['periode']['nama_periode'] ?? 'Tidak Diketahui' }}
                    </span>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="mb-6 rounded-md bg-red-100 p-4 dark:bg-red-900/30"> {{-- Penyesuaian warna background error di dark mode --}}
                <div class="flex">
                    <div class="shrink-0">
                        <x-heroicon-s-x-circle class="h-5 w-5 text-red-500 dark:text-red-400" />
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 sm:p-8">
            <ol id="auditProgressStepper" class="relative border-s border-gray-300 dark:border-gray-700 ml-4"> {{-- Warna border disesuaikan untuk dark mode --}}
                {{-- Langkah 1: Response Instrumen --}}
                <li id="progressStep1" class="mb-10 ms-8">
                    <span id="progressIconWrapper1" class="absolute flex items-center justify-center w-10 h-10 rounded-full -start-[21px] ring-4 ring-white dark:ring-gray-800">
                        <div id="progressIconContainer1" class="w-full h-full rounded-full flex items-center justify-center"></div>
                    </span>
                    <h3 id="progressTitle1" class="text-base font-semibold">Response Instrumen</h3>
                    <p id="progressStatusText1" class="text-sm font-normal">Menunggu untuk dimulai</p>
                    <a href="{{ $instrumenRoute }}" id="progressLink1" class="mt-2 inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg focus:z-10 focus:ring-4 focus:outline-none opacity-50 pointer-events-none">
                        Lihat Detail <x-heroicon-s-arrow-right class="w-3 h-3 ms-2 rtl:rotate-180"/>
                    </a>
                </li>

                {{-- Langkah 2: Jadwal Asesmen Lapangan --}}
                <li id="progressStep2" class="mb-10 ms-8">
                    <span id="progressIconWrapper2" class="absolute flex items-center justify-center w-10 h-10 rounded-full -start-[21px] ring-4 ring-white dark:ring-gray-800">
                         <div id="progressIconContainer2" class="w-full h-full rounded-full flex items-center justify-center"></div>
                    </span>
                    <h3 id="progressTitle2" class="text-base font-semibold">Jadwal Asesmen Lapangan</h3>
                    <p id="progressStatusText2" class="text-sm font-normal">Menunggu langkah sebelumnya</p>
                     <a href="{{ $assessmentScheduleRoute }}" id="progressLink2" class="mt-2 inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg focus:z-10 focus:ring-4 focus:outline-none opacity-50 pointer-events-none">
                        Lihat Detail <x-heroicon-s-arrow-right class="w-3 h-3 ms-2 rtl:rotate-180"/>
                    </a>
                </li>

                {{-- Langkah 3: Response Tilik --}}
                <li id="progressStep3" class="ms-8">
                    <span id="progressIconWrapper3" class="absolute flex items-center justify-center w-10 h-10 rounded-full -start-[21px] ring-4 ring-white dark:ring-gray-800">
                        <div id="progressIconContainer3" class="w-full h-full rounded-full flex items-center justify-center"></div>
                    </span>
                    <h3 id="progressTitle3" class="text-base font-semibold">Response Tilik</h3>
                    <p id="progressStatusText3" class="text-sm font-normal">Menunggu langkah sebelumnya</p>
                    <a href="{{ $tilikResponseRoute }}" id="progressLink3" class="mt-2 inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg focus:z-10 focus:ring-4 focus:outline-none opacity-50 pointer-events-none">
                        Lihat Detail <x-heroicon-s-arrow-right class="w-3 h-3 ms-2 rtl:rotate-180"/>
                    </a>
                </li>
            </ol>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentAuditStatus = {{ isset($audit['status']) ? (int)$audit['status'] : 0 }};
            const routes = { 1: "{{ $instrumenRoute }}", 2: "{{ $assessmentScheduleRoute }}", 3: "{{ $tilikResponseRoute }}" };

            const iconTemplatesContainer = document.getElementById('blade-icon-templates');
            const getIconHtml = (type) => {
                const templateSpan = iconTemplatesContainer.querySelector(`.icon-template[data-icon-type="${type}"]`);
                return templateSpan ? templateSpan.innerHTML : '<svg class="w-5 h-5"></svg>'; // Fallback SVG sederhana
            };

            const statusTextMap = { pending: "Menunggu langkah sebelumnya", current: "Sedang berlangsung", completed: "Selesai" };

            function updateStepUI(stepNumber, state) {
                const iconContainer = document.getElementById(`progressIconContainer${stepNumber}`);
                const title = document.getElementById(`progressTitle${stepNumber}`);
                const statusTextElem = document.getElementById(`progressStatusText${stepNumber}`);
                const link = document.getElementById(`progressLink${stepNumber}`);

                let iconHtml, iconColorClasses = [], containerBgClasses = [], titleColorClasses = [], statusTextColorClasses = [], linkClasses = [];

                // Default classes for link (akan ditimpa sebagian oleh state tertentu)
                linkClasses.push('bg-white', 'dark:bg-gray-700', 'border', 'border-gray-300', 'dark:border-gray-600',
                                'text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-50', 'dark:hover:bg-gray-600',
                                'focus:ring-gray-200', 'dark:focus:ring-gray-500');

                statusTextElem.textContent = statusTextMap[state] || "Status tidak diketahui";

                if (state === "completed") {
                    iconHtml = getIconHtml('completed');
                    containerBgClasses = ['bg-green-500', 'dark:bg-green-600'];
                    iconColorClasses = ['text-white'];
                    titleColorClasses = ['text-green-700', 'dark:text-green-400'];
                    statusTextColorClasses = ['text-green-600', 'dark:text-green-500'];
                    link.href = routes[stepNumber];
                    linkClasses.push('opacity-50', 'pointer-events-none');
                    // Link completed tetap dengan style default (tidak diwarnai khusus)
                } else if (state === "current") {
                    iconHtml = getIconHtml(`step${stepNumber}`);
                    containerBgClasses = ['bg-sky-600', 'dark:bg-sky-500']; // Warna primer untuk ikon aktif
                    iconColorClasses = ['text-white'];
                    titleColorClasses = ['text-sky-800', 'dark:text-sky-300'];
                    statusTextColorClasses = ['text-sky-700', 'dark:text-sky-400'];
                    link.href = routes[stepNumber];
                    linkClasses = ['bg-sky-50', 'dark:bg-sky-800', 'border', 'border-sky-300', 'dark:border-sky-600',
                                   'text-sky-700', 'dark:text-sky-200', 'hover:bg-sky-100', 'dark:hover:bg-sky-900',
                                   'focus:ring-sky-200', 'dark:focus:ring-sky-500'];
                } else { // pending
                    iconHtml = getIconHtml(`step${stepNumber}`);
                    containerBgClasses = ['bg-gray-200', 'dark:bg-gray-600']; // Lebih gelap dari bg-gray-700 agar terlihat
                    iconColorClasses = ['text-gray-500', 'dark:text-gray-400'];
                    titleColorClasses = ['text-gray-500', 'dark:text-gray-500']; // Judul lebih redup
                    statusTextColorClasses = ['text-gray-500', 'dark:text-gray-400'];
                    link.href = "#";
                    linkClasses.push('opacity-50', 'pointer-events-none');
                }

                iconContainer.innerHTML = iconHtml;
                iconContainer.className = 'w-full h-full rounded-full flex items-center justify-center transition-colors duration-300'; // Reset
                iconContainer.classList.add(...containerBgClasses);

                const svgElement = iconContainer.querySelector('svg');
                if (svgElement) {
                    const existingColorClasses = Array.from(svgElement.classList).filter(cls => cls.startsWith('text-'));
                    svgElement.classList.remove(...existingColorClasses);
                    svgElement.classList.add(...iconColorClasses);
                }

                title.className = 'text-lg font-semibold transition-colors duration-300'; // Reset
                title.classList.add(...titleColorClasses);

                statusTextElem.className = 'text-sm font-normal transition-colors duration-300'; // Reset
                statusTextElem.classList.add(...statusTextColorClasses);

                link.className = 'mt-2 inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg focus:z-10 focus:ring-4 focus:outline-none transition-colors duration-300'; // Reset base link classes
                link.classList.add(...linkClasses);
            }

            function updateOverallProgress(statusAuditGlobal) {
                const statusGlobal = parseInt(statusAuditGlobal) || 0;
                if (statusGlobal === 1 || statusGlobal === 8) updateStepUI(1, 'current');
                else if (statusGlobal > 1) updateStepUI(1, 'completed');
                else updateStepUI(1, 'pending');

                if (statusGlobal === 3) updateStepUI(2, 'current');
                else if (statusGlobal > 3) updateStepUI(2, 'completed');
                else updateStepUI(2, 'pending');

                if (statusGlobal === 5) updateStepUI(3, 'current');
                else if (statusGlobal > 5) updateStepUI(3, 'completed');
                else updateStepUI(3, 'pending');
            }

            updateOverallProgress(currentAuditStatus);
        });
    </script>
@endsection
