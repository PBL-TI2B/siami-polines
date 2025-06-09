@extends('layouts.app')

@section('title', 'Edit Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index')],
        ['label' => 'Edit Laporan', 'url' => ''],
    ]" />

    <h1 class="mb-5 text-3xl font-bold text-gray-900 dark:text-gray-200">
        Edit Laporan Temuan
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

    <form action="{{ route('auditor.laporan.update', $report->laporan_temuan_id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <label for="auditing_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Audit</label>
                <select id="auditing_id" name="auditing_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200" required>
                    <option value="">Pilih Audit</option>
                    @foreach ($audits as $audit)
                        <option value="{{ $audit->auditing_id }}" {{ old('auditing_id', $report->auditing_id) == $audit->auditing_id ? 'selected' : '' }}>
                            {{ $audit->name ?? 'Audit ' . $audit->auditing_id }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="standar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Standar</label>
                <select id="standar" name="standar" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200" required>
                    <option value="">Pilih Standar</option>
                    @foreach ($kriterias as $kriteria)
                        <option value="{{ $kriteria['kriteria_id'] }}" {{ old('standar', $report->standar) == $kriteria['kriteria_id'] ? 'selected' : '' }}>
                            {{ $kriteria['nama_kriteria'] ?? 'Standar ' . $kriteria['kriteria_id'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label for="uraian_temuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Uraian Temuan</label>
                <textarea id="uraian_temuan" name="uraian_temuan" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200" required>{{ old('uraian_temuan', $report->uraian_temuan) }}</textarea>
            </div>
            <div>
                <label for="kategori_temuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Perbaikan</label>
                <select id="kategori_temuan" name="kategori_temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategori_temuan as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori_temuan', $report->kategori_temuan) == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label for="saran_perbaikan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Saran Perbaikan</label>
                <textarea id="saran_perbaikan" name="saran_perbaikan" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200">{{ old('saran_perbaikan', $report->saran_perbaikan) }}</textarea>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection
