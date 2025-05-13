@extends('layouts.app')

@section('title', 'Tambah Pertanyaan')

@section('content')
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Tambah Pertanyaan</h1>

        <form action="{{ route('auditor.daftar-tilik.store') }}" method="POST">
            @csrf

            <!-- Dropdown Kriteria -->
            <div class="mb-4">
                <label for="kriteria" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kriteria</label>
                <select name="kriteria" id="kriteria"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <option value="" disabled selected class="text-gray-400">Pilih Kriteria</option>
                    @for ($i = 1; $i <= 9; $i++)
                        <option value="{{ $i }}">Kriteria {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <!-- Kolom Pertanyaan -->
            <div class="mb-4">
                <label for="pertanyaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pertanyaan</label>
                <textarea name="pertanyaan" id="pertanyaan" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan pertanyaan..."></textarea>
            </div>

            <!-- Kolom Indikator -->
            <div class="mb-4">
                <label for="indikator" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Indikator Kinerja Renstra & LKPS</label>
                <textarea name="indikator" id="indikator" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Indikator..."></textarea>
            </div>

            <!-- Kolom D -->
            <div class="mb-4">
                <label for="sumber_data" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sumber Bukti</label>
                <input type="text" name="sumber_data" id="sumber_data"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan bukti...">
            </div>

            <div class="mb-4">
                <label for="metode_perhitungan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Metode Perhitungan</label>
                <input type="text" name="metode_perhitungan" id="metode_perhitungan"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan metode perhitungan...">
            </div>

            <!-- Kolom Target -->
            <div class="mb-4">
                <label for="target" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Target</label>
                <input type="text" name="target" id="target"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan target...">
            </div>


            <div class="mt-3 flex gap-3">
                <x-button type="submit" color="sky" icon="heroicon-o-plus">
                    Simpan
                </x-button>
                <x-button color="gray" icon="heroicon-o-x-mark" href="{{ route('auditor.daftar-tilik.index') }}">
                    Batal
                </x-button>
            </div>
        </form>
    </div>
@endsection
