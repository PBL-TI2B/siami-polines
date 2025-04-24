@extends('layouts.app')

@section('title', 'Jadwal Audit')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard.index')],
            ['label' => 'Jadwal Audit', 'url' => route('jadwal-audit.index')],
            ['label' => 'Tambah Jadwal Audit', 'url' => route('jadwal-audit.create')],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Tambah Jadwal Audit
        </h1>

        <form action="{{ route('jadwal-audit.store') }}" method="POST"
            class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Unit Kerja -->
                <div>
                    <label for="unit_kerja" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit
                        Kerja</label>
                    <select id="unit_kerja" name="unit_kerja_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Unit Kerja</option>
                        @foreach ($unitKerja as $unit)
                            <option value="{{ $unit->unit_kerja_id }}">{{ $unit->nama_unit_kerja }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Waktu Audit -->
                <div>
                    <label for="waktu_audit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu
                        Audit</label>
                    <input type="date" id="waktu_audit" name="waktu_audit"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Periode AMI -->
                {{-- <div>
                    <label for="periode_ami" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Periode
                        AMI</label>
                    <select name="periode_id" class="form-control" required>
                        <option value="">-- Pilih Periode --</option>
                        @foreach ($periode as $p)
                            <option value="{{ $p->periode_id }}">{{ $p->nama_periode }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <!-- Auditee 1 -->
                <div>
                    <label for="auditee_1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee
                        1</label>
                    <select id="auditee_1" name="user_id_1_auditee"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditee 1</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Auditor 1 -->
                <div>
                    <label for="auditor_1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor
                        1</label>
                    <select id="auditor_1" name="user_id_1_auditor"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditor 1</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Auditee 2 -->
                <div>
                    <label for="auditee_2" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee
                        2</label>
                    <select id="auditee_2" name="user_id_2_auditee"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditee 2</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Auditor 2 -->
                <div>
                    <label for="auditor_2" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor
                        2</label>
                    <select id="auditor_2" name="user_id_2_auditor"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditor 2</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('jadwal-audit.index') }}"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md shadow hover:bg-gray-300">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-sky-800 text-white rounded-md shadow hover:bg-sky-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection
