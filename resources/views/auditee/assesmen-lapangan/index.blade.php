@extends('layouts.app')

@section('title', 'Lihat Jadwal Asesmen Lapangan')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            ['label' => 'Lihat Asesmen Lapangan'],
        ]" />

        @if (session('success'))
            <div role="alert"
                class="mb-4 flex items-start rounded-lg bg-green-100 p-4 text-sm text-green-800 dark:bg-green-900 dark:text-green-300">
                <x-heroicon-s-check-circle class="mr-3 h-5 w-5 flex-shrink-0" />
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if (session('error'))
            <div role="alert"
                class="mb-4 flex items-start rounded-lg bg-red-100 p-4 text-sm text-red-800 dark:bg-red-900 dark:text-red-300">
                <x-heroicon-s-x-circle class="mr-3 h-5 w-5 flex-shrink-0" />
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <header class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl dark:text-white">
                Lihat Jadwal Asesmen Lapangan
            </h1>
        </header>

        <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-gray-800">
            {{-- BAGIAN UTAMA KARTU --}}
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-lg bg-sky-100 p-3 dark:bg-sky-900">
                        <x-heroicon-o-calendar-days class="h-6 w-6 text-sky-600 dark:text-sky-300" />
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            Jadwal yang Ditetapkan oleh Auditor
                        </p>
                        <div class="text-xl font-bold text-gray-900 dark:text-white">
                            @if (isset($auditing['jadwal_audit']) && $auditing['jadwal_audit'])
                                {{-- Tampilan tanggal --}}
                                <p>{{ \Carbon\Carbon::parse($auditing['jadwal_audit'])->isoFormat('dddd, D MMMM YYYY') }}
                                </p>
                            @else
                                {{-- State jika jadwal belum ada --}}
                                <p class="text-lg font-medium italic text-gray-500 dark:text-gray-400">
                                    Jadwal belum ditentukan
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAGIAN KETERANGAN KARTU --}}
            <div class="border-t border-gray-200 bg-gray-50 px-6 py-4 dark:border-gray-700 dark:bg-gray-800/50">
                <div class="flex items-center">
                    <x-heroicon-o-information-circle class="mr-3 h-6 w-6 flex-shrink-0 text-sky-500" />
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Pengingat:</strong> Mohon persiapkan dokumen yang diperlukan sebelum tanggal asesmen.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <x-button type="button" color="gray" icon="heroicon-o-arrow-left" onclick="history.back()">
                Kembali
            </x-button>
        </div>
    </div>
@endsection
