@extends('layouts.app')

@section('title', 'Edit Jadwal Audit')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    @if(session('error'))
    <div class="mb-4 rounded bg-red-100 px-4 py-3 text-red-700">
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 rounded bg-red-100 px-4 py-3 text-red-700">
        <ul class="mb-0">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Jadwal Audit', 'url' => route('admin.ploting-ami.index')],
        ['label' => 'Edit Jadwal Audit', 'url' => route('admin.ploting-ami.edit', $audit->auditing_id)],
    ]" />

    <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
        Edit Jadwal Audit
    </h1>

    <form action="{{ route('admin.ploting-ami.update', ['id' => $audit->auditing_id]) }}" method="POST" id="editJadwalForm" class="space-y-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Unit Kerja -->
            <div>
                <label for="unit_kerja_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit Kerja</label>
                <select id="unit_kerja_id" name="unit_kerja_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="">-- Pilih Unit Kerja --</option>
                    @foreach ($list_unitKerja as $id => $nama)
                    <option value="{{ $id }}" @if ($audit->unit_kerja_id === $id) selected @endif>
                        {{ $nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <!-- Waktu Audit -->
            <div>
                <label for="jadwal_audit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu Audit</label>
                <input type="date" id="jadwal_audit" name="jadwal_audit" value="{{ $audit->jadwal_audit ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
            </div>
            <!-- Link Audit (Baru) -->
            <div>
                <label for="link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link Audit</label>
                <input type="url" id="link" name="link" value="{{ $audit->link ?? '' }}" placeholder="https://..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
            </div>
            <!-- Auditee 1 -->
            <div>
                <label for="user_id_1_auditee" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee 1</label>
                <select id="user_id_1_auditee" name="user_id_1_auditee" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="">-- Pilih Auditee --</option>
                    @foreach ($list_auditee as $id => $nama)
                    <option value="{{ $id }}" @if ($audit->user_id_1_auditee === $id) selected @endif>
                        {{ $nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <!-- Auditor 1 -->
            <div>
                <label for="user_id_1_auditor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor 1</label>
                <select id="user_id_1_auditor" name="user_id_1_auditor" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="">-- Pilih Auditor --</option>
                    @foreach ($list_auditor as $id => $nama)
                    <option value="{{ $id }}" @if ($audit->user_id_1_auditor === $id) selected @endif>
                        {{ $nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <!-- Auditee 2 -->
            <div>
                <label for="user_id_2_auditee" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee 2</label>
                <select id="user_id_2_auditee" name="user_id_2_auditee"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="">-- Pilih Auditee --</option>
                    @foreach ($list_auditee as $id => $nama)
                    <option value="{{ $id }}" @if ($audit->user_id_2_auditee === $id) selected @endif>
                        {{ $nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <!-- Auditor 2 -->
            <div>
                <label for="user_id_2_auditor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor 2</label>
                <select id="user_id_2_auditor" name="user_id_2_auditor"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="">-- Pilih Auditor --</option>
                    @foreach ($list_auditor as $id => $nama)
                    <option value="{{ $id }}" @if ($audit->user_id_2_auditor === $id) selected @endif>
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

<!-- Tambahkan Tom Select CSS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

<!-- Tambahkan Tom Select JS dan inisialisasi -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function initTomSelect(id) {
        if (window.TomSelect) {
            const selectEl = document.getElementById(id);
            if (selectEl.tomselect) {
                selectEl.tomselect.destroy();
            }
            const tom = new TomSelect(`#${id}`, {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                allowEmptyOption: true,
                placeholder: 'Ketik untuk mencari...'
            });
            function removeDefaultOption() {
                const option = selectEl.querySelector('option[value=""]');
                if(option) option.remove();
            }
            tom.on('type', removeDefaultOption);
            tom.on('dropdown_open', function() {
                removeDefaultOption();
                const searchInput = tom.control_input;
                if (searchInput) searchInput.value = '';
            });
        }
    }
    // Inisialisasi Tom Select pada semua select yang relevan
    [
        'unit_kerja_id',
        'user_id_1_auditee',
        'user_id_1_auditor',
        'user_id_2_auditee',
        'user_id_2_auditor'
    ].forEach(initTomSelect);
});
</script>
@endsection