@extends('layouts.app')

@section('title', 'Tambah Laporan')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="mb-6 text-2xl font-bold text-gray-900 dark:text-gray-200">
            Tambah Laporan
        </h1>

        @if (session('error') || $errors->any())
            <x-toast id="toast-danger" type="danger">
                @if (session('error'))
                    <p>{{ session('error') }}</p>
                @endif
                @if ($errors->any())
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </x-toast>
        @endif

        <form method="POST" action="{{ route('auditor.laporan.store') }}" class="space-y-6">
            @csrf
            <div>
                <label for="standar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Standar</label>
                <input type="text" name="standar" id="standar" value="{{ old('standar') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                @error('standar')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="uraian_temuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Uraian Temuan</label>
                <textarea name="uraian_temuan" id="uraian_temuan" rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('uraian_temuan') }}</textarea>
                @error('uraian_temuan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kategori_temuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Temuan</label>
                <select name="kategori_temuan" id="kategori_temuan"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    <option value="" disabled {{ old('kategori_temuan') ? '' : 'selected' }}>Pilih Kategori</option>
                    @foreach ($kategori_temuan as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori_temuan') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_temuan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="saran_perbaikan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Saran Perbaikan</label>
                <textarea name="saran_perbaikan" id="saran_perbaikan" rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ old('saran_perbaikan') }}</textarea>
                @error('saran_perbaikan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 p-4 bg-gray-100 rounded-md dark:bg-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-3">Keterangan Kategori Temuan</h3>
                <ul class="list-disc pl-5 text-gray-700 dark:text-gray-300 space-y-3">
                    <li>
                        <strong>NC (Non-Conformity)</strong>: Temuan ketidaksesuaian mayor yang berdampak luas/kritikal terhadap persyaratan mutu produk/pelayanan dan sistem manajemen mutu.
                        <br><em>Contoh: Pelanggaran sistem secara total (sistem tidak dilaksanakan).</em>
                    </li>
                    <li>
                        <strong>AOC (Area of Concern)</strong>: Temuan ketidaksesuaian minor yang berdampak kecil/terbatas terhadap persyaratan mutu produk/pelayanan dan sistem manajemen mutu.
                        <br><em>Contoh: Ketidaksempurnaan dan ketidakkonsistenan dalam penerapan sistem.</em>
                    </li>
                    <li>
                        <strong>OFI (Opportunity for Improvement)</strong>: Temuan bukan ketidaksesuaian, dimaksudkan untuk penyempurnaan.
                        <br><strong>** Hanya diisi bila auditor memastikan saran perbaikannya efektif.</strong>
                    </li>
                </ul>
            </div>

            <div class="flex justify-end mt-6">
                <x-button type="submit" color="sky" icon="heroicon-o-check" class="px-6 py-2">
                    Simpan
                </x-button>
            </div>
        </form>
    </div>
@endsection
