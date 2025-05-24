@extends('layouts.app')

@section('title', 'Edit Jadwal Audit')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Jadwal Audit', 'url' => route('admin.ploting-ami.index')],
        ['label' => 'Edit Jadwal Audit', 'url' => route('admin.ploting-ami.edit', $audit->auditing_id)],
    ]" />

    <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
        Edit Jadwal Audit
    </h1>

    <form action="{{ route('admin.ploting-ami.edit', ['id' => $audit->auditing_id]) }}" method="POST" id="editJadwalForm" class="space-y-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Unit Kerja -->
            <div>
                <label for="unit_kerja_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit Kerja</label>
                <select id="unitkerja" name="unitKerja" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="">-- Pilih Unit Kerja --</option>
                    @foreach ($list_unitKerja as $id => $nama)
                        <option value="{{ $id }}"
                            @if ($audit->unit_kerja_id === $id) selected @endif>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Waktu Audit -->
            <div>
                <label for="jadwal_audit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu Audit</label>
                <input type="date" id="jadwal_audit" name="jadwal_audit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
            </div>
            <!-- Auditee 1 -->
            <div>
                <label for="user_id_1_auditee" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee 1</label>
                <select id="Auditee" name="Auditee" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="">-- Pilih Auditee --</option>
                    @foreach ($list_auditee as $id => $nama)
                        <option value="{{ $id }}"
                            @if ($audit->user_id_1_auditee === $id) selected @endif>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Auditor 1 -->
            <div>
                <label for="user_id_1_auditor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor 1</label>
                <select id="Auditor" name="Auditor" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="">-- Pilih Auditor --</option>
                    @foreach ($list_auditor as $id => $nama)
                        <option value="{{ $id }}"
                            @if ($audit->user_id_1_auditor === $id) selected @endif>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Auditee 2 -->
            <div>
                <label for="user_id_2_auditee" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee 2</label>
                <select id="Auditee" name="Auditee" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="">-- Pilih Auditee --</option>
                    @foreach ($list_auditee as $id => $nama)
                        <option value="{{ $id }}"
                            @if ($audit->user_id_2_auditee === $id) selected @endif>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <!-- Auditor 2 -->
            <div>
                <label for="user_id_2_auditor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor 2</label>
                <select id="Auditor" name="Auditor" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="">-- Pilih Auditor --</option>
                    @foreach ($list_auditor as $id => $nama)
                        <option value="{{ $id }}"
                            @if ($audit->user_id_2_auditor === $id) selected @endif>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex justify-start space-x-3">
            <a href="{{ route('admin.ploting-ami.index') }}" class="rounded-md bg-gray-200 px-4 py-2 text-gray-800 shadow hover:bg-gray-300 dark:bg-gray-600 dark:text-white">Batal</a>
            <button type="submit" class="rounded-md bg-sky-800 px-4 py-2 text-white shadow hover:bg-sky-700">Simpan</button>
        </div>
    </form>
</div>

<!-- {{-- <script>
document.addEventListener('DOMContentLoaded', async function() {
    const auditId = "{{ $audit->auditing_id }}";
    // Ambil data audit yang akan diedit
    const auditRes = await fetch(`http://127.0.0.1:5000/api/auditings/${auditId}`).then(r => r.json());
    const audit = auditRes.data;

    // Isi Unit Kerja
    fetch('http://127.0.0.1:5000/api/unit-kerja')
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('unit_kerja_id');
            data.data.forEach(item => {
                select.innerHTML += `<option value="${item.unit_kerja_id}">${item.nama_unit_kerja}</option>`;
            });
            select.value = audit.unit_kerja_id;
        });

    // Isi Users
    fetch('http://127.0.0.1:5000/api/data-user')
        .then(res => res.json())
        .then(data => {
            const auditees = data.data.filter(u => u.role_id == 3);
            const auditors = data.data.filter(u => u.role_id == 2);

            ['user_id_1_auditee', 'user_id_2_auditee'].forEach((id, idx) => {
                const select = document.getElementById(id);
                auditees.forEach(user => {
                    select.innerHTML += `<option value="${user.user_id}">${user.nama}</option>`;
                });
                // Set value sesuai data lama
                select.value = idx === 0 ? audit.user_id_1_auditee : audit.user_id_2_auditee;
            });
            ['user_id_1_auditor', 'user_id_2_auditor'].forEach((id, idx) => {
                const select = document.getElementById(id);
                auditors.forEach(user => {
                    select.innerHTML += `<option value="${user.user_id}">${user.nama}</option>`;
                });
                // Set value sesuai data lama
                select.value = idx === 0 ? audit.user_id_1_auditor : audit.user_id_2_auditor;
            });
        });

    // Isi tanggal audit
    document.getElementById('jadwal_audit').value = audit.jadwal_audit ? audit.jadwal_audit.substring(0,10) : '';

    // Handle submit
    document.getElementById('editJadwalForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        //formData.delete('_token');
        formData.delete('_method');
        fetch(`http://127.0.0.1:5000/api/auditings/${auditId}`, {
            method: 'PUT',
            body: formData
        })
        .then(res => res.json().then(data => ({status: res.status, body: data})))
        .then(({status, body}) => {
            if (status === 200 || status === 201) {
                alert('Data berhasil diperbarui!');
                window.location.href = "{{ route('admin.ploting-ami.index') }}";
            } else {
                alert('Gagal memperbarui data!\n' + (body.message || JSON.stringify(body)));
            }
        })
        .catch(err => alert('Gagal memperbarui data!'));
    });
});
</script> --}} -->
@endsection