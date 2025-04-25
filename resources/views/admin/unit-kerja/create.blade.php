@extends('layouts.app')

@section('title', 'Tambah Data Unit')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('dashboard.index')],
            ['label' => 'Data Unit', 'url' => route('unit-kerja')],
            ['label' => 'Daftar UPT', 'url' => route('unit-kerja.index')],
            ['label' => 'Tambah Data'],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Tambah Data UPT
        </h1>

    @endsection
