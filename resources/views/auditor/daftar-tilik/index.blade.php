@extends('layouts.app')

@section('title', 'Daftar Tilik')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard.index')],
            ['label' => 'Daftar Tilik', 'url' => route('daftar-tilik.index')],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Daftar Tilik
        </h1>

    @endsection
