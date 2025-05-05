@extends('layouts.app')

@section('title', 'Edit Jadwal Audit')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('dashboard.index')],
            ['label' => 'Jadwal Audit', 'url' => route('jadwal-audit.index')],
            ['label' => 'Edit Jadwal Audit', 'url' => route('jadwal-audit.edit', $audit->auditing_id)],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Edit Jadwal Audit
        </h1>

        <form id="editJadwalForm" action="{{ route('jadwal-audit.update', $audit->auditing_id) }}" method="POST" class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Unit Kerja -->
                <div>
                    <label for="unit_kerja" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit Kerja</label>
                    <select id="unit_kerja" name="unit_kerja_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Unit Kerja</option>
                    </select>
                </div>

                <!-- Waktu Audit -->
                <div>
                    <label for="waktu_audit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu Audit</label>
                    <input type="date" id="waktu_audit" name="waktu_audit"
                        value="{{ $audit->periode->tanggal_mulai ?? '' }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                </div>

                <!-- Auditee 1 -->
                <div>
                    <label for="auditee_1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee 1</label>
                    <select id="auditee_1" name="user_id_1_auditee"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditee 1</option>
                    </select>
                </div>

                <!-- Auditor 1 -->
                <div>
                    <label for="auditor_1" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor 1</label>
                    <select id="auditor_1" name="user_id_1_auditor"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditor 1</option>
                    </select>
                </div>

                <!-- Auditee 2 -->
                <div>
                    <label for="auditee_2" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee 2</label>
                    <select id="auditee_2" name="user_id_2_auditee"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditee 2</option>
                    </select>
                </div>

                <!-- Auditor 2 -->
                <div>
                    <label for="auditor_2" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor 2</label>
                    <select id="auditor_2" name="user_id_2_auditor"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditor 2</option>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const auditId = "{{ $audit->auditing_id }}";

        // Fetch existing data for the form
        fetch(`/api/penjadwalan/${auditId}`)
            .then(response => response.json())
            .then(data => {
                if (data.data) {
                    document.getElementById('unit_kerja').value = data.data.unit_kerja.nama_unit_kerja;
                    document.getElementById('waktu_audit').value = data.data.jadwal_audit;
                    document.getElementById('auditee_1').value = data.data.auditee_1.nama;
                    document.getElementById('auditee_2').value = data.data.auditee_2.nama;
                    document.getElementById('auditor_1').value = data.data.auditor_1.nama;
                    document.getElementById('auditor_2').value = data.data.auditor_2.nama;
                }
            });

        // Submit form
        document.getElementById('editJadwalForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = {
                auditor_1: document.getElementById('auditor_1').value,
                auditor_2: document.getElementById('auditor_2').value,
                auditee_1: document.getElementById('auditee_1').value,
                auditee_2: document.getElementById('auditee_2').value,
                unit_kerja: document.getElementById('unit_kerja').value,
                jadwal_audit: document.getElementById('waktu_audit').value,
            };

            fetch(`/api/penjadwalan/${auditId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) throw new Error('Gagal memperbarui data jadwal audit');
                return response.json();
            })
            .then(data => {
                alert('Jadwal audit berhasil diperbarui!');
            })
            .catch(error => {
                alert('Terjadi kesalahan: ' + error.message);
            });
        });
    });
</script>
@endpush