@extends('layouts.app')

@section('title', 'Data Instrumen')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[['label' => 'Data Instrumen', 'url' => route('admin.data-instrumen.index')]]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Daftar Tilik
        </h1>

    @endsection
