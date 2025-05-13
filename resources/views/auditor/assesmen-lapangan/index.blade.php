@extends('layouts.app')

@section('title', 'Asesmen Lapangan')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[['label' => 'Laporan', 'url' => route('auditor.dashboard.index')]]" />

    <!-- Page Title -->
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
        Jadwal Asesmen Lapangan
    </h1>
    <p class="mb-6 text-gray-600 dark:text-gray-300">
        Jadwal asesmen belum ditetapkan
    </p>

    <!-- Filter Section -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 w-full max-w-3xl">
        <form action="#" method="GET">
            <div class="mb-4">
                <label for="matriks" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Matriks
                </label>
                <select id="matriks" name="matriks" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Pilih Matriks</option>
                    <option value="matriks1">Matriks 1</option>
                    <option value="matriks2">Matriks 2</option>
                </select>
            </div>

            <div class="flex gap-2">
                <x-button type="submit" color="sky">
                    Tampilkan
                </x-button>
                <x-button type="reset" color="gray">
                    Reset
                </x-button>
            </div>
        </form>
    </div>
</div>
@endsection
