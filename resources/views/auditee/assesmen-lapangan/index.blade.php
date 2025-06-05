@extends('layouts.app')

@section('title', 'Lihat Asesmen Lapangan')

{{-- @if(session('user'))
    <meta name="user-id" content="{{ session('user')['user_id'] }}">
@endif --}}

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditee.audit.index')],
        ['label' => 'Lihat Assesmen Lapangan'],
    ]" />

    <!-- Display Success Message -->
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700 dark:bg-green-900 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Display Error Message -->
    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-100 p-4 text-sm text-red-700 dark:bg-red-900 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
        Lihat Jadwal Asesmen Lapangan
    </h1>
<!-- 
    <h1>
        Jadwal Asesmen Lapangan: 
        @if(isset($auditing['jadwal_audit']))
            {{ \Carbon\Carbon::parse($auditing['jadwal_audit'])->format('d F Y') }}
        @else
            <span class="text-red-500">Belum ada jadwal yang ditetapkan</span>
        @endif
    </h1>
     -->
    <form class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label for="jadwal_audit" class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">
                Jadwal Asesmen Lapangan
            </label>
            <input type="date" id="jadwal_audit" name="jadwal_audit" disabled
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight dark:bg-gray-700 dark:text-white focus:outline-none focus:shadow-outline cursor-not-allowed"
                value="{{ isset($auditing['jadwal_audit']) ? \Carbon\Carbon::parse($auditing['jadwal_audit'])->format('Y-m-d') : '' }}"
            >
        </div>
    </form>
    <x-button id="back-btn" type="button" color="red" icon="heroicon-o-arrow-left" onclick="history.back()">
        Kembali
    </x-button>
</div>
@endsection