@extends('layouts.app')

@section('title', 'Auditee AMI')

@section('content')
    {{-- Template untuk ikon yang akan digunakan di JavaScript --}}
    <div style="display: none;" id="heroicon-templates">
        <x-heroicon-o-check class="icon-completed h-4 w-4 text-green-600 lg:h-5 lg:w-5 dark:text-green-300" />
    </div>

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
        ]" />
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl dark:text-gray-200">
                Audit AMI
            </h1>
        </div>

        {{-- Penyesuaian tampilan periode --}}
        <div class="mb-4 flex">
            <div id="periodeDisplayContainer" class="flex items-center gap-x-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Periode:</span>
                <div
                    class="inline-flex items-center gap-x-2 rounded-2xl bg-sky-100 px-3 py-1.5 text-xs sm:text-sm dark:bg-sky-800">
                    <x-heroicon-o-calendar-days class="h-4 w-4 shrink-0 text-sky-600 sm:h-5 sm:w-5 dark:text-sky-300" />
                    {{-- ID diubah untuk nama periode dinamis --}}
                    <span id="dynamicPeriodeName" class="font-semibold text-sky-600 dark:text-sky-400">
                        Memuat periode...
                    </span>
                </div>
            </div>
        </div>

        <div class="mb-10">
            <div class="overflow-x-auto rounded-lg bg-white shadow-md dark:bg-gray-800">
                <table id="jadwalAuditTable" class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead
                        class="border-b border-gray-200 bg-gray-100 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="px-4 py-3 sm:px-6">No</th>
                            <th scope="col" class="px-4 py-3 sm:px-6">Unit Kerja</th>
                            <th scope="col" class="px-4 py-3 sm:px-6">Waktu Audit</th>
                            <th scope="col" class="px-4 py-3 sm:px-6">Auditee</th>
                            <th scope="col" class="px-4 py-3 sm:px-6">Auditee 2</th>
                            <th scope="col" class="px-4 py-3 sm:px-6">Auditor 1</th>
                            <th scope="col" class="px-4 py-3 sm:px-6">Auditor 2</th>
                            <th scope="col" class="px-4 py-3 sm:px-6">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr>
                            <td colspan="8" class="py-6 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex items-center justify-center"><svg
                                        class="-ml-1 mr-3 h-5 w-5 animate-spin text-blue-500"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>Memuat data audit...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <h2 class="mb-6 mt-8 text-base font-semibold text-gray-900 sm:text-lg dark:text-gray-200">
                Progres Auditing Auditee
            </h2>

            @php
                $jenisUnitId = session('jenis_unit_id');
                $instrumenRoute = match ($jenisUnitId) {
                    1 => route('auditee.data-instrumen.instrumenupt'),
                    2 => route('auditee.data-instrumen.instrumenjurusan'),
                    3 => route('auditee.data-instrumen.instrumenprodi'),
                    default => '#',
                };
                $assessmentScheduleRoute = route('auditee.assesmen-lapangan.index');
                $tilikResponseRoute = '#';
            @endphp

            <ol id="auditProgressStepper" class="mb-8 flex w-full items-start">
                <li id="progressStep1" class="group relative flex w-full flex-col sm:flex-row sm:items-center">
                    <a href="{{ $instrumenRoute }}" id="progressLink1"
                        class="group pointer-events-none relative z-10 flex flex-col items-center px-2 py-1 text-center opacity-50 sm:text-left">
                        <span id="progressIconContainer1"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100 ring-2 ring-gray-200 transition-all duration-200 group-hover:ring-gray-300 lg:h-12 lg:w-12 dark:bg-gray-700 dark:ring-gray-600 dark:group-hover:ring-gray-500">
                            <x-heroicon-s-pencil-square
                                class="progress-icon-default h-4 w-4 text-gray-500 lg:h-5 lg:w-5 dark:text-gray-300" />
                        </span>
                        <span id="progressText1"
                            class="mt-2 text-xs font-medium text-gray-500 sm:text-sm dark:text-gray-400">Response Instrumen</span>
                    </a>
                    <div data-line-id="1" class="-mx-2 hidden h-[3px] flex-1 bg-gray-200 sm:block dark:bg-gray-700"></div>
                </li>

                <li id="progressStep2" class="group relative flex w-full flex-col sm:flex-row sm:items-center">
                    <a href="{{ $assessmentScheduleRoute }}" id="progressLink2"
                        class="group pointer-events-none relative z-10 flex flex-col items-center px-2 py-1 text-center opacity-50 sm:text-left">
                        <span id="progressIconContainer2"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100 ring-2 ring-gray-200 transition-all duration-200 group-hover:ring-gray-300 lg:h-12 lg:w-12 dark:bg-gray-700 dark:ring-gray-600 dark:group-hover:ring-gray-500">
                            <x-heroicon-s-clock
                                class="progress-icon-default h-4 w-4 text-gray-500 lg:h-5 lg:w-5 dark:text-gray-300" />
                        </span>
                        <span id="progressText2"
                            class="mt-2 text-xs font-medium text-gray-500 sm:text-sm dark:text-gray-400">Jadwal Asesmen
                            Lapangan</span>
                    </a>
                    <div data-line-id="2" class="-mx-2 hidden h-[3px] flex-1 bg-gray-200 sm:block dark:bg-gray-700"></div>
                </li>

                <li id="progressStep3" class="group relative flex w-full flex-col sm:flex-row sm:items-center">
                    <a href="{{ $tilikResponseRoute }}" id="progressLink3"
                        class="group pointer-events-none relative z-10 flex flex-col items-center px-2 py-1 text-center opacity-50 sm:text-left">
                        <span id="progressIconContainer3"
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100 ring-2 ring-gray-200 transition-all duration-200 group-hover:ring-gray-300 lg:h-12 lg:w-12 dark:bg-gray-700 dark:ring-gray-600 dark:group-hover:ring-gray-500">
                            <x-heroicon-s-check-circle
                                class="progress-icon-default h-4 w-4 text-gray-500 lg:h-5 lg:w-5 dark:text-gray-300" />
                        </span>
                        <span id="progressText3"
                            class="mt-2 text-xs font-medium text-gray-500 sm:text-sm dark:text-gray-400">Response Tilik</span>
                    </a>
                </li>
            </ol>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            const tableBody = document.getElementById("tableBody");
            // Menggunakan ID baru untuk elemen nama periode dinamis
            const dynamicPeriodeNameElem = document.getElementById("dynamicPeriodeName");

            const heroiconTemplates = document.getElementById('heroicon-templates');
            const checkIconHtml = heroiconTemplates.querySelector('.icon-completed').outerHTML;

            const defaultIconHtml = {
                1: document.getElementById('progressIconContainer1').innerHTML,
                2: document.getElementById('progressIconContainer2').innerHTML,
                3: document.getElementById('progressIconContainer3').innerHTML,
            };

            function updateProgressStep(stepNumber, status, route = '#') {
                const link = document.getElementById(`progressLink${stepNumber}`);
                const iconContainer = document.getElementById(`progressIconContainer${stepNumber}`);
                const text = document.getElementById(`progressText${stepNumber}`);
                const line = document.querySelector(`div[data-line-id="${stepNumber}"]`);

                // Reset kelas dasar container ikon, mempertahankan kelas hover ring
                iconContainer.className =
                    'flex items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 shrink-0 transition-all duration-200 group-hover:ring-gray-300 dark:group-hover:ring-gray-500';
                text.className = 'mt-2 text-xs sm:text-sm font-medium transition-colors duration-200';
                link.setAttribute('href', route);
                link.classList.remove('pointer-events-none', 'opacity-50');

                let currentIconElement;

                if (status === 'completed') {
                    iconContainer.innerHTML = checkIconHtml;
                    // Semua ring konsisten ring-2
                    iconContainer.classList.add('bg-green-100', 'dark:bg-green-800', 'ring-2', 'ring-green-300',
                        'dark:ring-green-600');
                    text.classList.add('text-green-700', 'dark:text-green-300');
                    if (line) line.className =
                        'hidden sm:block flex-1 h-[3px] -mx-2 bg-green-500 dark:bg-green-600';
                } else {
                    iconContainer.innerHTML = defaultIconHtml[stepNumber];
                    currentIconElement = iconContainer.querySelector('svg.progress-icon-default');

                    if (status === 'current') {
                        // Semua ring konsisten ring-2, sebelumnya ring-4 untuk current
                        iconContainer.classList.add('bg-blue-100', 'dark:bg-blue-800', 'ring-2',
                            'ring-blue-300', 'dark:ring-blue-500');
                        if (currentIconElement) {
                            currentIconElement.classList.remove('text-gray-500', 'dark:text-gray-300');
                            currentIconElement.classList.add('text-blue-600', 'dark:text-blue-300');
                        }
                        text.classList.add('text-blue-700', 'dark:text-blue-300');
                        if (line) line.className =
                            'hidden sm:block flex-1 h-[3px] -mx-2 bg-gray-200 dark:bg-gray-700';
                    } else { // pending
                        // Semua ring konsisten ring-2
                        iconContainer.classList.add('bg-gray-100', 'dark:bg-gray-700', 'ring-2',
                            'ring-gray-200', 'dark:ring-gray-600');
                        text.classList.add('text-gray-500', 'dark:text-gray-400');
                        link.classList.add('pointer-events-none', 'opacity-50');
                        if (line) line.className =
                            'hidden sm:block flex-1 h-[3px] -mx-2 bg-gray-200 dark:bg-gray-700';
                    }
                }
            }

            function updateOverallProgress(currentAuditStatus) {
                const status = parseInt(currentAuditStatus) || 0;
                const instrumentRoute = "{{ $instrumenRoute }}";
                const assessmentRoute = "{{ $assessmentScheduleRoute }}";
                const tilikRoute = "{{ $tilikResponseRoute }}";

                if (status === 1) updateProgressStep(1, 'current', instrumentRoute);
                else if (status > 1) updateProgressStep(1, 'completed', instrumentRoute);
                else updateProgressStep(1, 'pending', instrumentRoute);

                if (status === 2 || status === 3) updateProgressStep(2, 'current', assessmentRoute);
                else if (status > 3) updateProgressStep(2, 'completed', assessmentRoute);
                else updateProgressStep(2, 'pending', assessmentRoute);

                if (status >= 4 && status <= 8) updateProgressStep(3, 'current', tilikRoute);
                else if (status > 8) updateProgressStep(3, 'completed', tilikRoute);
                else updateProgressStep(3, 'pending', tilikRoute);
            }

            try {
                const response = await fetch("{{ route('auditee.auditings') }}");
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const result = await response.json();
                if (!result.data) throw new Error(result.message || 'Data tidak ditemukan');

                const data = result.data;

                if (data.length === 0) {
                    tableBody.innerHTML =
                        `<tr><td colspan="8" class="py-6 text-center text-gray-500 dark:text-gray-400">Tidak ada data audit untuk periode ini.</td></tr>`;
                    // Memperbarui elemen nama periode dinamis
                    dynamicPeriodeNameElem.textContent = 'Belum ada';
                    updateOverallProgress(0);
                    return;
                }

                const currentAudit = data[0];
                const periodeNama = currentAudit.periode?.nama_periode ?? 'Tidak Diketahui';
                // Memperbarui elemen nama periode dinamis
                dynamicPeriodeNameElem.textContent = periodeNama;
                tableBody.innerHTML = "";

                const statusMap = {
                    1: { label: 'Pengisian Instrumen', color: 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300' },
                    2: { label: 'Desk Evaluation', color: 'bg-sky-100 dark:bg-sky-900 text-sky-800 dark:text-sky-300' },
                    3: { label: 'Penjadwalan AL', color: 'bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-300' },
                    4: { label: 'Pertanyaan Tilik', color: 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300' },
                    5: { label: 'Tilik Dijawab', color: 'bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-300' },
                    6: { label: 'Laporan Temuan', color: 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-300' },
                    7: { label: 'Revisi Auditee', color: 'bg-rose-100 dark:bg-rose-900 text-rose-800 dark:text-rose-300' },
                    8: { label: 'Sudah Revisi', color: 'bg-pink-100 dark:bg-pink-900 text-pink-800 dark:text-pink-300' },
                    9: { label: 'Closing', color: 'bg-teal-100 dark:bg-teal-900 text-teal-800 dark:text-teal-300' },
                    10: { label: 'Selesai', color: 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' }
                };

                data.forEach((item, index) => {
                    const statusInfo = statusMap[item.status] || { label: `Status ${item.status}`, color: 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' };
                    const waktuAuditFormatted = item.jadwal_audit ?? 'Belum diatur';
                    const rowHTML = `
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-4 py-3 sm:px-6">${index + 1}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap">${item.unit_kerja?.nama_unit_kerja ?? 'N/A'}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap">${waktuAuditFormatted}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap">${item.auditee1?.nama ?? 'N/A'}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap">${item.auditee2?.nama ?? '-'}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap">${item.auditor1?.nama ?? 'N/A'}</td>
                            <td class="px-4 py-3 sm:px-6 whitespace-nowrap">${item.auditor2?.nama ?? '-'}</td>
                            <td class="px-4 py-3 sm:px-6">
                                <span class="${statusInfo.color} inline-flex rounded-full px-3 py-1 text-xs font-semibold leading-tight">
                                    ${statusInfo.label}
                                </span>
                            </td>
                        </tr>`;
                    tableBody.insertAdjacentHTML('beforeend', rowHTML);
                });
                updateOverallProgress(currentAudit?.status);
            } catch (err) {
                console.error("Gagal memuat data:", err);
                tableBody.innerHTML =
                    `<tr><td colspan="8" class="py-6 text-center text-red-500 dark:text-red-400">Gagal memuat data audit. Silakan coba lagi nanti.</td></tr>`;
                // Memperbarui elemen nama periode dinamis
                dynamicPeriodeNameElem.textContent = 'Gagal dimuat';
                updateOverallProgress(0);
            }
        });
    </script>
@endsection
