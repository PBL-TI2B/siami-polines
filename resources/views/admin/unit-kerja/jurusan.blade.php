@extends('layouts.app')

@section('title', 'Data Unit')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data Unit', 'url' => route('admin.unit-kerja.index', ['type' => 'jurusan'])],
        
            ['label' => 'Daftar Jurusan'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Data Jurusan
        </h1>

        <div class="flex gap-2">
            <x-button href="{{ route('unit-kerja.create', ['type' => 'jurusan']) }}" color="sky" icon="heroicon-o-plus">
                Tambah Data
            </x-button>
        </div>

        <div class="pt-6">
            <x-table :headers="['No', 'Unit Kerja', 'Aksi']" :data="$units" :route="route('admin.unit-kerja.index', ['type' => 'jurusan'])">
                @foreach ($units as $index => $unit)
                    <tr
                        class="border-y border-gray-200 bg-white transition-all duration-200 hover:bg-gray-50 dark:border-gray-500 dark:bg-gray-800 dark:hover:bg-gray-600">
                        <td class="border-r border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-600">
                            {{ $index + 1 }}
                        </td>
                        <td
                            class="whitespace-nowrap border-r border-gray-200 px-4 py-4 font-medium text-gray-900 sm:px-6 dark:border-gray-600 dark:text-white">
                            {{ $unit['nama_unit_kerja'] }}
                        </td>
                        <x-table-row-actions :actions="[
                            [
                                'label' => 'Edit',
                                'color' => 'sky',
                                'icon' => 'heroicon-o-pencil',
                                'href' => route('unit-kerja.edit', ['id' => $unit['unit_kerja_id'], 'type' => 'jurusan']),
                            ],
                            [
                                'label' => 'Hapus',
                                'color' => 'red',
                                'icon' => 'heroicon-o-trash',
                                'modalId' => 'delete-unitKerja-modal-' . $unit['unit_kerja_id'],
                            ],
                        ]" />
                    </tr>

                    <x-confirmation-modal-periode id="delete-unitKerja-modal-{{ $unit['unit_kerja_id'] }}"
                    title="Konfirmasi Hapus Data" :action="route('unit-kerja.destroy', $unit['unit_kerja_id'])" method="DELETE" type="delete"
                    formClass="delete-modal-form" :itemName="$unit['nama_unit_kerja']" :warningMessage="'Apakah anda yakin untuk manghapus unit-kerja ini?.'" />
                @endforeach
            </x-table>
        </div>


    @endsection
