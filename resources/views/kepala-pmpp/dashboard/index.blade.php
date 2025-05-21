@extends('layouts.app')

@section('title', 'Dashboard Kepala PMPP')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => route('kepala-pmpp.dashboard.index')]]" />
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200">Dashboard</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Periode Aktif:
                    <span
                        class="ml-1 inline-block rounded-full bg-sky-100 px-3 py-1 text-sm font-semibold text-sky-600 dark:bg-sky-800 dark:text-sky-400">
                        2024/2025 - Semester Genap
                    </span>
                </p>
            </div>
        </div>

    </div>

@endsection
