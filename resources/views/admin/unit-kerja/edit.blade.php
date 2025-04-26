@extends('layouts.app')

@section('title', 'Edit Data Unit')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('dashboard.index')],
            ['label' => 'Data Unit', 'url' => route('unit-kerja')],
            ['label' => 'Daftar ' . ucfirst($type), 'url' => route('unit-kerja', ['type' => $type])],
            ['label' => 'Edit'],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Edit Data {{ ucfirst($type) }}
        </h1>

        <div
            class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm mb-3 border border-gray-200 dark:border-gray-700 transition-all duration-200">
            <form action="{{ route('unit-kerja.update', ['id' => $unitKerja->unit_kerja_id, 'type' => $type]) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="grid gap-6 grid-cols-1">
                    <!-- Nama Periode -->
                    <x-form-input id="nama_unit_kerja" name="nama_unit_kerja" label="Nama Unit Kerja AMI"
                        placeholder="Masukkan nama Unit" value="{{ $unitKerja->nama_unit_kerja }}" :required="true" maxlength="255" />
                </div>
                <div class="flex gap-3 mt-3">
                    <x-button type="submit" color="sky" icon="heroicon-o-plus">
                        Simpan
                    </x-button>
                    <x-button color="gray" icon="heroicon-o-x-mark" href="{{ route('unit-kerja', ['type' => $type]) }}">
                        Batal
                    </x-button>
                </div>
            </form>
        </div>

    @endsection
