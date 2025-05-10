@extends('layouts.app')

@section('title', 'Jadwal Audit')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Jadwal Audit', 'url' => route('admin.jadwal-audit.index')],
            ['label' => 'Tambah Jadwal Audit', 'url' => route('jadwal-audit.create')],
        ]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Tambah Jadwal Audit
        </h1>

        <form id="jadwalForm" class="space-y-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Unit Kerja -->
                <div>
                    <label for="unit_kerja" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit
                        Kerja</label>
                    <select id="unit_kerja" name="unit_kerja_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Unit Kerja</option>
                    </select>
                </div>

                <!-- Waktu Audit -->
                <div>
                    <label for="waktu_audit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu
                        Audit</label>
                    <input type="date" id="waktu_audit" name="waktu_audit"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Auditee 1 -->
                <div>
                    <label for="auditee_1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee
                        1</label>
                    <select id="auditee_1" name="user_id_1_auditee"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditee 1</option>
                    </select>
                </div>

                <!-- Auditor 1 -->
                <div>
                    <label for="auditor_1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor
                        1</label>
                    <select id="auditor_1" name="user_id_1_auditor"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditor 1</option>
                    </select>
                </div>

                <!-- Auditee 2 -->
                <div>
                    <label for="auditee_2" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee
                        2</label>
                    <select id="auditee_2" name="user_id_2_auditee"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditee 2</option>
                    </select>
                </div>

                <!-- Auditor 2 -->
                <div>
                    <label for="auditor_2" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor
                        2</label>
                    <select id="auditor_2" name="user_id_2_auditor"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditor 2</option>
                    </select>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.jadwal-audit.index') }}"
                    class="rounded-md bg-gray-200 px-4 py-2 text-gray-800 shadow hover:bg-gray-300 dark:bg-gray-600 dark:text-white">Batal</a>
                <button type="submit"
                    class="rounded-md bg-sky-800 px-4 py-2 text-white shadow hover:bg-sky-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch Unit Kerja
            fetch('http://localhost:5000/api/unit-kerja') // Perbarui URL API
                .then(response => response.json())
                .then(data => {
                    const unitKerjaSelect = document.getElementById('unit_kerja');
                    data.forEach(unit => {
                        const option = document.createElement('option');
                        option.value = unit.nama_unit_kerja;
                        option.textContent = unit.nama_unit_kerja;
                        unitKerjaSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching unit kerja:', error); // Debug jika ada error
                });

            // Fetch Users (Auditee & Auditor)
            fetch('http://localhost:5000/api/users') // Perbarui URL API
                .then(response => response.json())
                .then(data => {
                    const selects = ['auditee_1', 'auditee_2', 'auditor_1', 'auditor_2'];
                    selects.forEach(id => {
                        const select = document.getElementById(id);
                        data.forEach(user => {
                            const option = document.createElement('option');
                            option.value = user.nama;
                            option.textContent = user.nama;
                            select.appendChild(option.cloneNode(true));
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching users:', error); // Debug jika ada error
                });

            // Submit form
            document.getElementById('jadwalForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = {
                    auditor_1: document.getElementById('auditor_1').value,
                    auditor_2: document.getElementById('auditor_2').value,
                    auditee_1: document.getElementById('auditee_1').value,
                    auditee_2: document.getElementById('auditee_2').value,
                    unit_kerja: document.getElementById('unit_kerja').value,
                    jadwal_audit: document.getElementById('waktu_audit').value,
                };

                fetch('http://localhost:5000/api/penjadwalan', { // Perbarui URL API
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Gagal menyimpan data jadwal audit');
                        return response.json();
                    })
                    .then(data => {
                        alert('Jadwal audit berhasil ditambahkan!');
                        document.getElementById('jadwalForm').reset();
                    })
                    .catch(error => {
                        alert('Terjadi kesalahan: ' + error.message);
                    });
            });
        });
    </script>
@endpush
