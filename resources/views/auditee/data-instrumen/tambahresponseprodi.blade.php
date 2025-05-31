@extends('layouts.app')

@section('title', 'Tambah Response Instrumen Prodi')

@section('content')
    <div class="max-w-3xl mx-auto py-6">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            ['label' => 'Response Instrumen', 'url' => route('auditee.data-instrumen.instrumenprodi')],
            ['label' => 'Tambah Response Instrumen'],
        ]" />

        <h1 class="text-2xl font-bold mb-4">Tambah Response Instrumen Prodi</h1>

        <!-- Flash Message Container -->
        <div id="flashMessage" class="hidden fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg"></div>

        <form id="instrumenForm" method="POST">
            @csrf

            <!-- Ketersediaan Standar dan Dokumen -->
            <div class="mb-4">
                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ketersediaan Standar dan Dokumen</span>
                <label class="inline-flex items-center mt-1">
                    <input type="radio" name="ketersediaan_standar" value="Ada" class="form-radio text-sky-600">
                    <span class="ml-2">Ada</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" name="ketersediaan_standar" value="Tidak" class="form-radio text-red-600">
                    <span class="ml-2">Tidak</span>
                </label>
            </div>

            <!-- Pencapaian Standar -->
            @php
                $aspects = [
                    'pencapaian_sptpt' => 'Pencapaian Standar SPT PT',
                    'pencapaian_sndikti' => 'Pencapaian Standar SN DIKTI',
                    'daya_saing_lokal' => 'Daya Saing Lokal',
                    'daya_saing_nasional' => 'Daya Saing Nasional',
                    'daya_saing_internasional' => 'Daya Saing Internasional'
                ];
            @endphp

            @foreach ($aspects as $name => $label)
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</span>
                    <label class="inline-flex items-center mt-1">
                        <input type="radio" name="{{ $name }}" value="1" class="form-radio text-sky-600">
                        <span class="ml-2">Ada</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" name="{{ $name }}" value="0" class="form-radio text-red-600">
                        <span class="ml-2">Tidak</span>
                    </label>
                </div>
            @endforeach

            <!-- Keterangan -->
            <div class="mb-4">
                <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan Keterangan..."></textarea>
            </div>

            <!-- Tombol -->
            <div class="mt-3 flex gap-3">
                <x-button type="submit" color="sky" icon="heroicon-o-plus">
                    Simpan
                </x-button>
                <x-button type="button" color="gray" icon="heroicon-o-trash" onclick="clearForm()">
                    Clear Form
                </x-button>
                <x-button color="red" icon="heroicon-o-x-mark" href="{{ route('auditee.data-instrumen.instrumenprodi') }}">
                    Batal
                </x-button>
            </div>
        </form>

        <!-- Response Message -->
        <div id="responseMessage" class="mt-4 hidden text-sm"></div>
    </div>
    <script>
        function clearForm() {
            const form = document.getElementById('instrumenForm');
            form.reset();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('instrumenForm');
            const auditingId = {{ session('auditing_id') }};

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const responseId = form.dataset.responseId;

                // Ambil value radio dan textarea
                const getRadioValue = (name) => {
                    const radios = document.getElementsByName(name);
                    for (let radio of radios) {
                        if (radio.checked) return radio.value;
                    }
                    return null;
                };

                const payload = {
                    auditing_id: auditingId, // Ubah sesuai kebutuhan jika dinamis
                    set_instrumen_unit_kerja_id: {{ $response_id }}, // Ubah sesuai kebutuhan jika dinamis
                    ketersediaan_standar_dan_dokumen: getRadioValue('ketersediaan_standar'),
                    spt_pt: getRadioValue('pencapaian_sptpt'),
                    sn_dikti: getRadioValue('pencapaian_sndikti'),
                    lokal: getRadioValue('daya_saing_lokal'),
                    nasional: getRadioValue('daya_saing_nasional'),
                    internasional: getRadioValue('daya_saing_internasional'),
                    keterangan: document.getElementById('keterangan').value
                };

                try {
                    const response = await fetch('http://127.0.0.1:5000/api/responses', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    });

                    const result = await response.json();

                    if (response.ok) {
                        showFlashMessage('Data berhasil disimpan!', 'bg-green-100 text-green-800');
                        form.reset();
                        setTimeout(() => {
                            window.location.href = '{{ route("auditee.data-instrumen.instrumenprodi") }}';
                        }, 2000);
                    } else {
                        showFlashMessage('Gagal menyimpan: ' + (result.message || 'Terjadi kesalahan'), 'bg-red-100 text-red-800');
                    }

                } catch (error) {
                    showFlashMessage('Error jaringan: ' + error.message, 'bg-red-100 text-red-800');
                }
            });

            function showFlashMessage(message, classes) {
                let flash = document.getElementById('flashMessage');
                if (!flash) {
                    flash = document.createElement('div');
                    flash.id = 'flashMessage';
                    document.body.appendChild(flash);
                }
                flash.textContent = message;
                flash.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${classes}`;
                flash.classList.remove('hidden');
                setTimeout(() => flash.classList.add('hidden'), 5000);
            }
        });
    </script>
@endsection