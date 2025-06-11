{{-- @extends('layouts.app')

@section('title', 'Tambah Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index')],
        ['label' => 'Tambah Laporan', 'url' => route('auditor.laporan.create')],
    ]" />

    <h1 class="mb-5 text-3xl font-bold text-gray-900 dark:text-gray-200">
        Tambah Laporan Temuan
    </h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('auditor.laporan.store') }}" method="POST" id="laporanForm" class="space-y-6">
        @csrf
        <input type="hidden" name="auditing_id" value="{{ session('auditing_id') }}">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Audit</label>
                <input type="text" value="{{ session('auditing_id') ? 'Audit ' . session('auditing_id') : 'Tidak ada audit yang dipilih' }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-gray-100 dark:bg-gray-700 dark:text-gray-200" readonly>
            </div>
            <div id="kriteriaContainer">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Standar</label>
                <div class="mt-1 space-y-4">
                    <div class="flex items-end gap-2">
                        <select name="standar[]" class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200" required>
                            <option value="">Pilih Standar</option>
                            @foreach ($kriterias as $kriteria)
                                <option value="{{ $kriteria['kriteria_id'] }}" {{ old('standar.0') == $kriteria['kriteria_id'] ? 'selected' : '' }}>
                                    {{ $kriteria['nama_kriteria'] ?? 'Standar ' . $kriteria['kriteria_id'] }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" id="addKriteria" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700">Tambah Kriteria</button>
                    </div>
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="uraian_temuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Uraian Temuan</label>
                <textarea id="uraian_temuan" name="uraian_temuan" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200" required>{{ old('uraian_temuan') }}</textarea>
            </div>
            <div>
                <label for="kategori_temuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Perbaikan</label>
                <select id="kategori_temuan" name="kategori_temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategori_temuan as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori_temuan') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label for="saran_perbaikan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Saran Perbaikan</label>
                <textarea id="saran_perbaikan" name="saran_perbaikan" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200">{{ old('saran_perbaikan') }}</textarea>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Simpan
            </button>
        </div>
    </form>
    <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200">Catatan Kategori Temuan</h3>
        <ul class="mt-2 text-sm text-gray-700 dark:text-gray-300 list-disc pl-5">
            <li><strong>NC (Non-Conformity):</strong> Temuan ketidaksesuaian mayor yang memiliki dampak luas/kritikal terhadap persyaratan mutu produk/pelayanan dan persyaratan sistem manajemen mutu. Contoh: Pelanggaran sistem secara total (sistem tidak dilaksanakan).</li>
            <li><strong>AOC (Area of Concern):</strong> Temuan ketidaksesuaian minor yang memiliki dampak kecil/terbatas terhadap persyaratan mutu produk/pelayanan dan persyaratan sistem manajemen mutu. Contoh: Ketidaksempurnaan dan ketidakkonsistenan dalam penerapan sistem.</li>
            <li><strong>OFI (Opportunity for Improvement):</strong> Temuan yang bukan merupakan ketidaksesuaian, dimaksudkan untuk penyempurnaan.</li>
            <li><strong>Hanya diisi bila auditor dapat memastikan saran perbaikannya adalah efektif</strong>
        </ul>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addKriteriaButton = document.getElementById('addKriteria');
        const kriteriaContainer = document.getElementById('kriteriaContainer');
        let kriteriaCount = 1;

        addKriteriaButton.addEventListener('click', function() {
            kriteriaCount++;
            const newKriteria = document.createElement('div');
            newKriteria.className = 'flex items-end gap-2 mt-2';
            newKriteria.innerHTML = `
                <select name="standar[]" class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200" required>
                    <option value="">Pilih Standar</option>
                    @foreach ($kriterias as $kriteria)
                        <option value="{{ $kriteria['kriteria_id'] }}">
                            {{ $kriteria['nama_kriteria'] ?? 'Standar ' . $kriteria['kriteria_id'] }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="remove-kriteria px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
            `;
            kriteriaContainer.querySelector('div.space-y-4').appendChild(newKriteria);

            // Tambahkan event listener untuk tombol hapus
            newKriteria.querySelector('.remove-kriteria').addEventListener('click', function() {
                newKriteria.remove();
                kriteriaCount--;
            });
        });
    });
</script>
@endsection --}}
