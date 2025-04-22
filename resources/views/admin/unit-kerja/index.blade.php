@extends('layouts.app')

@section('title', 'Data Unit')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => route('dashboard.index')],
            ['label' => 'Data Unit', 'url' => route('unit-kerja')],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Data Unit
        </h1>


    @endsection
