@extends('layouts.app')

@section('title', 'Data Unit')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('dashboard.index')],
            ['label' => 'Data Unit', 'url' => route('unit-kerja')],
            ['label' => 'Daftar Prodi'],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Data Prodi
        </h1>

        <div
            class="flex gap-2">
            <x-button href="{{ route('unit-kerja.create', ['type' => 'prodi']) }}" color="sky" icon="heroicon-o-plus" >
                    Tambah Data
                </x-button>
            <x-button type="submit" color="sky" icon="heroicon-o-document-arrow-down">
                    Unduh Data
                </x-button>
            <x-button type="submit" color="yellow" icon="heroicon-o-document-arrow-up">
                    Import Data
                </x-button>
        </div>

        <div class="pt-6">
                <x-table :headers="['No', 'Unit Kerja', 'Aksi']" :data="$units" :route="route('unit-kerja', ['type' => 'prodi'])">
                    @foreach ($units as $index => $unit)
                    <tr class="bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                        <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-600 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $unit->nama_unit_kerja}}
                        </td>
                        <x-table-row-actions :actions="[
                        [
                            'label' => 'Edit',
                            'color' => 'sky',
                            'icon' => 'heroicon-o-pencil',
                            'href' => route('unit-kerja.edit', ['id' => $unit->unit_kerja_id, 'type' => 'prodi']),
                        ],
                        [
                            'label' => 'Hapus',
                            'color' => 'red',
                            'icon' => 'heroicon-o-trash',
                            'modalId' => 'delete-unitKerja-modal-' . $unit->unit_kerja_id,
                        ],
                    ]" />
                    </tr>
                    @endforeach
                </x-table>
        </div>


    @endsection
