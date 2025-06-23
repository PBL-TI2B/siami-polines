@extends('layouts.app')

@section('title', 'Permintaan Perbaikan dan Pencegahan (PTPP)')

@push('style')
    {{-- Pastikan Flowbite dan 'prose' style dari Tailwind Typography sudah ter-load --}}
@endpush

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            ['label' => 'Laporan Temuan', 'url' => route('auditee.laporan-temuan.index', ['auditingId' => 1])],
            ['label' => 'PTPP'],
        ]" />

        <div class="mb-8 mt-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Permintaan Perbaikan dan Pencegahan (PTPP)
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Lengkapi formulir Permintaan Perbaikan dan Pencegahan (PTPP) untuk temuan dari auditor.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-x-12 gap-y-8 lg:grid-cols-12">
            {{-- Stepper Navigation (Sisi Kiri) --}}
            <aside class="lg:col-span-4">
                <div class="space-y-4">
                    <div
                        class="flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div
                            class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 dark:bg-sky-900 dark:text-sky-300">
                            <x-heroicon-o-building-office-2 class="h-6 w-6" />
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Unit Kerja/Jurusan/Prodi</h3>
                            <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">Jurusan Teknik Mesin</p>
                        </div>
                    </div>
                    <div
                        class="flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div
                            class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 dark:bg-sky-900 dark:text-sky-300">
                            <x-heroicon-o-user-group class="h-6 w-6" />
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Auditor</h3>
                            <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">Dr. Ir. H. Muhammad
                                Hatta, M.T.</p>
                            <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">Ir. Budi Santoso, M.Sc.
                            </p>
                        </div>
                    </div>
                    <div
                        class="flex items-start gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div
                            class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-sky-100 text-sky-600 dark:bg-sky-900 dark:text-sky-300">
                            <x-heroicon-o-user class="h-6 w-6" />
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Auditee</h3>
                            <p class="mt-1 text-base font-semibold text-gray-900 dark:text-white">Siti Nurhaliza</p>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-gray-200 dark:border-gray-700">

                <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Proses PTPP</h2>
                <ol class="relative ml-4 space-y-12 border-l-2 border-gray-200 dark:border-gray-700">
                    <li class="pl-12">
                        <span
                            class="absolute -left-4 flex h-8 w-8 items-center justify-center rounded-full bg-green-600 ring-8 ring-white dark:bg-green-500 dark:ring-gray-900">
                            <x-heroicon-s-check class="h-5 w-5 text-white" />
                        </span>
                        <h3 class="text-lg font-medium leading-tight text-gray-900 dark:text-white">1. Detail Temuan</h3>
                        <p class="text-sm text-gray-500">Diterbitkan oleh Auditor.</p>
                    </li>
                    <li class="pl-12">
                        <span
                            class="absolute -left-4 flex h-8 w-8 items-center justify-center rounded-full bg-sky-600 ring-8 ring-white dark:bg-sky-500 dark:ring-gray-900">
                            <x-heroicon-s-pencil class="h-5 w-5 text-white" />
                        </span>
                        <h3 class="text-lg font-semibold leading-tight text-sky-600 dark:text-sky-400">2. Tindakan Perbaikan
                        </h3>
                        <p class="text-sm text-gray-500">Mohon untuk diisi.</p>
                    </li>
                    <li class="pl-12">
                        <span
                            class="absolute -left-4 flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 ring-8 ring-white dark:bg-gray-700 dark:ring-gray-900">
                            <x-heroicon-s-document-magnifying-glass class="h-5 w-5 text-gray-500 dark:text-gray-400" />
                        </span>
                        <h3 class="text-lg font-medium leading-tight text-gray-900 dark:text-white">3. Verifikasi Auditor
                        </h3>
                        <p class="text-sm text-gray-500">Menunggu hasil tindak lanjut.</p>
                    </li>
                </ol>
            </aside>

            {{-- Form Content (Sisi Kanan) --}}
            <div class="lg:col-span-8">
                <form action="#" method="POST">
                    @csrf
                    {{-- Bagian I: Detail Temuan (Read-only) --}}
                    <div class="mb-8">
                        <details
                            class="group rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800"
                            open>
                            <summary class="flex cursor-pointer list-none items-center justify-between p-4 sm:p-6">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">I. Detail Temuan Auditor
                                </h2>
                                <div class="text-gray-500">
                                    <x-heroicon-o-chevron-down
                                        class="block h-6 w-6 transition-all duration-300 group-open:-rotate-180" />
                                </div>
                            </summary>
                            <div class="border-t border-gray-200 p-4 sm:p-6 dark:border-gray-700">
                                <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400">Standar</label>
                                        <p class="mt-1 text-base text-gray-900 dark:text-white">STD/SPMI/01 - Penerimaan
                                            Mahasiswa Baru</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Kategori
                                            Temuan</label>
                                        <p class="mt-1"><span
                                                class="rounded-md bg-red-100 px-2.5 py-1 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300">NC</span>
                                        </p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Uraian
                                            Temuan Ketidaksesuaian</label>
                                        <blockquote
                                            class="mt-2 border-l-4 border-gray-300 bg-gray-50 p-4 dark:border-gray-600 dark:bg-gray-700/50">
                                            <p class="text-gray-800 dark:text-gray-200">Ditemukan bahwa beberapa dokumen
                                                persyaratan calon mahasiswa tidak terverifikasi dengan benar sesuai dengan
                                                standar yang telah ditetapkan.</p>
                                        </blockquote>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal
                                            Temuan</label>
                                        <p class="mt-1 text-base text-gray-900 dark:text-white">16 Juni 2025</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Batas
                                            Waktu Perbaikan</label>
                                        <p class="mt-1 text-base font-semibold text-red-600 dark:text-red-400">30 Juni 2025
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </details>
                    </div>

                    {{-- Bagian II: Tindak Lanjut oleh Auditee (Form Aktif) --}}
                    <div
                        class="rounded-2xl border-2 border-sky-500 bg-white p-4 shadow-lg sm:p-6 dark:border-sky-500 dark:bg-gray-800">
                        <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">II. Rencana Tindakan Perbaikan
                            dan Pencegahan</h2>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="analisa_penyebab"
                                    class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Analisa Akar
                                    Penyebab</label>
                                <textarea id="analisa_penyebab" name="analisa_penyebab" rows="4"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Jelaskan akar penyebab dari ketidaksesuaian..." required></textarea>
                            </div>
                            <div>
                                <label for="tindakan_perbaikan"
                                    class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Tindakan
                                    Perbaikan</label>
                                <textarea id="tindakan_perbaikan" name="tindakan_perbaikan" rows="4"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Jelaskan langkah-langkah perbaikan yang akan/telah diambil..." required></textarea>
                            </div>
                            <div>
                                <label for="tindakan_pencegahan"
                                    class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Tindakan
                                    Pencegahan</label>
                                <textarea id="tindakan_pencegahan" name="tindakan_pencegahan" rows="4"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Jelaskan langkah-langkah agar masalah tidak terulang di masa depan..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <details
                            class="group rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800"
                            open>
                            <summary class="flex cursor-pointer list-none items-center justify-between p-4 sm:p-6">
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">III. Verifikasi Auditor</h2>
                                <div class="text-gray-500">
                                    <x-heroicon-o-chevron-down
                                        class="block h-6 w-6 transition-all duration-300 group-open:-rotate-180" />
                                </div>
                            </summary>
                            <div class="border-t border-gray-200 p-4 sm:p-6 dark:border-gray-700">
                                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2">

                                    {{-- Kolom Auditee --}}
                                    <div class="flex flex-col text-center">
                                        <label class="text-sm font-medium text-gray-700 dark:text-gray-200">Auditee</label>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Menyatakan telah
                                            menyelesaikan tindak lanjut.</p>
                                        <div
                                            class="mt-4 flex flex-grow items-center justify-center rounded-lg border border-dashed border-gray-300 dark:border-gray-600">
                                            <span class="text-sm text-gray-400 dark:text-gray-500">Tanda Tangan
                                                Digital</span>
                                        </div>
                                        <div class="mt-4">
                                            <p class="font-semibold text-gray-900 dark:text-white">Siti Nurhaliza</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal: <span
                                                    class="font-medium text-gray-700 dark:text-gray-300">20 Juni
                                                    2025</span></p>
                                        </div>
                                    </div>

                                    {{-- Kolom Auditor --}}
                                    <div class="flex flex-col text-center">
                                        <label class="text-sm font-medium text-gray-700 dark:text-gray-200">Auditor</label>
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Memverifikasi hasil tindak
                                            lanjut.</p>
                                        <div
                                            class="mt-4 flex flex-grow items-center justify-center rounded-lg border border-dashed border-gray-300 dark:border-gray-600">
                                            <span class="text-sm text-gray-400 dark:text-gray-500">[ Belum Diverifikasi
                                                ]</span>
                                        </div>
                                        <div class="mt-4">
                                            <p class="font-semibold text-gray-900 dark:text-white">Dr. Ir. H. Muhammad
                                                Hatta, M.T.</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Verifikasi: <span
                                                    class="font-medium text-gray-700 dark:text-gray-300">-</span></p>
                                        </div>
                                    </div>

                                    {{-- Catatan Verifikasi Auditor --}}
                                    <div class="mt-4 sm:col-span-2">
                                        <label for="catatan_verifikasi"
                                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Catatan
                                            Hasil Verifikasi Auditor</label>
                                        <div
                                            class="min-h-[80px] w-full rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm text-gray-600 dark:border-gray-600 dark:bg-gray-700/50 dark:text-gray-300">
                                            <p>Tindak lanjut akan diperiksa oleh auditor setelah formulir ini dikirimkan.
                                                Hasil verifikasi dan catatan akan ditampilkan di sini.</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </details>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="mt-8 flex items-center justify-end space-x-4">
                        <x-button href="#" color="gray">
                            Kembali
                        </x-button>
                        <x-button type="submit" color="sky" icon="heroicon-o-paper-airplane">
                            Simpan & Kirim PTPP
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
