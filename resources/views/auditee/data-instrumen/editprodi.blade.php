@extends('layouts.app')

@section('title', 'Edit Response Instrumen Prodi')

@section('content')
    <div class="max-w-3xl mx-auto py-6">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            ['label' => 'Response Instrumen', 'url' => route('auditee.data-instrumen.instrumenprodi')],
            ['label' => 'Edit Response Instrumen'],
        ]" />

        <h1 class="text-2xl font-bold mb-4">Edit Response Instrumen Prodi</h1>

        <!-- Flash Message -->
        <div id="flashMessage" class="hidden fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg"></div>

        <form id="instrumenForm">
            @csrf

            <!-- Ketersediaan Standar dan Dokumen -->
            <div class="mb-4">
                <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ketersediaan Standar dan Dokumen</span>
                <label class="inline-flex items-center mt-1">
                    <input type="radio" name="ketersediaan_standar" id="ketersediaan_ada" value="Ada" class="form-radio text-sky-600">
                    <span class="ml-2">Ada</span>
                </label>
                <label class="inline-flex items-center ml-6">
                    <input type="radio" name="ketersediaan_standar" id="ketersediaan_tidak" value="Tidak"class="form-radio text-red-600">
                    <span class="ml-2">Tidak</span>
                </label>
            </div>

            <!-- Aspek -->
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
                        <input type="radio" name="{{ $name }}" id="{{ $name }}_ada" value="1" class="form-radio text-sky-600">
                        <span class="ml-2">Ada</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" name="{{ $name }}" id="{{ $name }}_tidak" value="0" class="form-radio text-red-600">
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

        <div id="responseMessage" class="mt-4 hidden text-sm"></div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const responseId = "{{ $response_id }}";
            const endpoint = `http://127.0.0.1:5000/api/responses/${responseId}`;
            let currentData = {}; // Store fetched data

            // Fetch data & fill form
            fetch(endpoint)
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        const data = res.data;
                        currentData = data;

                        const ketersediaan = data.ketersediaan_standar_dan_dokumen;
                        if (ketersediaan === 'Ada') {
                            document.getElementById('ketersediaan_ada').checked = true;
                        } else {
                            document.getElementById('ketersediaan_tidak').checked = true;
                        }

                        const aspekMap = {
                            pencapaian_sptpt: data.spt_pt,
                            pencapaian_sndikti: data.sn_dikti,
                            daya_saing_lokal: data.lokal,
                            daya_saing_nasional: data.nasional,
                            daya_saing_internasional: data.internasional
                        };

                        for (const [name, value] of Object.entries(aspekMap)) {
                            const targetId = `${name}_${value === "1" ? "ada" : "tidak"}`;
                            const input = document.getElementById(targetId);
                            if (input) input.checked = true;
                        }

                        if (data.keterangan) {
                            document.getElementById('keterangan').value = data.keterangan;
                        }
                    } else {
                        alert('Gagal mengambil data: ' + res.message);
                    }
                })
                .catch(error => console.error('Fetch Error:', error));

            // Submit handler
            const form = document.getElementById('instrumenForm');
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Build payload
                const payload = {
                    auditing_id: currentData.auditing_id ?? null,
                    set_instrumen_unit_kerja_id: currentData.set_instrumen_unit_kerja_id ?? null,
                    ketersediaan_standar_dan_dokumen: document.querySelector('input[name="ketersediaan_standar"]:checked')?.value ?? null,
                    spt_pt: document.querySelector('input[name="pencapaian_sptpt"]:checked')?.value ?? null,
                    sn_dikti: document.querySelector('input[name="pencapaian_sndikti"]:checked')?.value ?? null,
                    lokal: document.querySelector('input[name="daya_saing_lokal"]:checked')?.value ?? null,
                    nasional: document.querySelector('input[name="daya_saing_nasional"]:checked')?.value ?? null,
                    internasional: document.querySelector('input[name="daya_saing_internasional"]:checked')?.value ?? null,
                    capaian: null,
                    sesuai: null,
                    lokasi_bukti_dukung: null,
                    minor: null,
                    mayor: null,
                    ofi: null,
                    keterangan: document.getElementById('keterangan').value || null
                };

                fetch(endpoint, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        showFlashMessage('Data berhasil diperbarui!', 'bg-green-100 text-green-800');
                        form.reset();
                        setTimeout(() => {
                            window.location.href = '{{ route("auditee.data-instrumen.instrumenprodi") }}';
                        }, 2000);
                    } else {
                        alert('Gagal memperbarui: ' + res.message);
                    }
                })
                .catch(err => {
                    console.error('Update Error:', err);
                    alert('Terjadi kesalahan saat mengirim data.');
                });
            });
        });

        function clearForm() {
            document.getElementById("instrumenForm").reset();
        }
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
    </script>
@endsection