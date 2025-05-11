@extends('layouts.app')

@section('title', 'Edit Data Unit')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data Unit', 'url' => route('admin.unit-kerja.index')],
            ['label' => 'Daftar ' . ucfirst($type), 'url' => route('admin.unit-kerja.index', ['type' => $type])],
            ['label' => 'Edit'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Edit Data {{ ucfirst($type) }}
        </h1>

        <div
            class="mb-3 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
            <form action="{{ route('unit-kerja.update', ['id' => $unitKerja->unit_kerja_id, 'type' => $type]) }}"
                method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Nama Periode -->
                    <x-form-input id="nama_unit_kerja" name="nama_unit_kerja" label="Nama Unit Kerja AMI"
                        placeholder="Masukkan nama Unit" value="{{ $unitKerja->nama_unit_kerja}}" :required="true"
                        maxlength="255" />
                    @if ($type === 'prodi')
                        <x-form-input id="jurusan" name="jurusan" label="Jurusan" 
                            placeholder="Masukkan nama jurusan prodi" value="{{ $unitKerja->parent->nama_unit_kerja  ?? '-'  }}" :required="true" maxlength="255" />
                    @endif
                </div>
                <div class="mt-3 flex gap-3">
                    <x-button type="submit" color="sky" icon="heroicon-o-plus">
                        Simpan
                    </x-button>
                    <x-button color="gray" icon="heroicon-o-x-mark"
                        href="{{ route('admin.unit-kerja.index', ['type' => $type]) }}">
                        Batal
                    </x-button>
                </div>
            </form>
        </div>

    @endsection
