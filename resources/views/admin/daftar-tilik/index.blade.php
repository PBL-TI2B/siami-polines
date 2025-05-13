@extends('layouts.app')

@section('title', 'Daftar Titik')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        <ol class="list-reset flex">
            <li><a href="{{ route('dashboard.index') }}" class="text-blue-600 hover:underline dark:text-blue-400">Dashboard</a></li>
            <li class="mx-2">/</li>
            <li class="text-gray-800 dark:text-gray-200">Daftar Tilik</li>
        </ol>
    </nav>

    <!-- Heading -->
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">
            Daftar Periksa
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Daftar Tilik', 'url' => route('admin.daftar-tilik.index')],
        ]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Daftar Tilik
        </h1>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-2 mb-4">
        <button onclick="openModal('add')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded dark:bg-blue-700 dark:hover:bg-blue-800">
            ➕ Tambah Pertanyaan
        </button>
        <button onclick="openModal('edit')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded dark:bg-yellow-600 dark:hover:bg-yellow-700">
            📝 Edit Pertanyaan
        </button>
        <button onclick="downloadData()" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded dark:bg-blue-600 dark:hover:bg-blue-700">
            ⬇️ Unduh Data
        </button>
        <button onclick="importData()" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded dark:bg-yellow-600 dark:hover:bg-yellow-700">
            ⬆️ Import Data
        </button>
    </div>

    <!-- Filter & Search -->
    <div class="flex flex-wrap items-center justify-between mb-4 gap-2">
        <div class="flex gap-2">
            <select class="border border-gray-300 rounded px-2 py-1 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                <option>Pilih Unit</option>
            </select>
            <select class="border border-gray-300 rounded px-2 py-1 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                <option>Pilih Periode Ami</option>
            </select>
        </div>
        <input type="text" placeholder="Search" class="border border-gray-300 rounded px-3 py-1 w-64 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" />
    </div>

    <!-- Kriteria Container -->
    <div id="kriteria-container" class="border border-blue-500 rounded p-4 bg-white shadow dark:bg-gray-800 dark:border-gray-600">
        <!-- Konten akan dimuat via JavaScript -->
    </div>

    <!-- Pagination -->
    <div class="flex justify-end gap-2 mt-4">
        <button onclick="showPrevious()" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-1 px-3 rounded dark:bg-yellow-600 dark:hover:bg-yellow-700">
            Previous
        </button>
        <button onclick="showNext()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded dark:bg-blue-700 dark:hover:bg-blue-800">
            Next
        </button>
    </div>

   <!-- Modal -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded-lg w-full max-w-2xl dark:bg-gray-800">
        <h3 class="text-xl font-bold mb-4 dark:text-white" id="modalTitle"></h3>
        <div class="grid grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-100">
            <input id="field0" class="border p-2 rounded dark:bg-gray-700" placeholder="Daftar Pertanyaan" />
            <input id="field1" class="border p-2 rounded dark:bg-gray-700" placeholder="Indikator Kinerja Renstra & LKPS" />
            <input id="field2" class="border p-2 rounded dark:bg-gray-700" placeholder="Sumber Bukti/Bukti" />
            <input id="field3" class="border p-2 rounded dark:bg-gray-700" placeholder="Metode Perhitungan" />
            <input id="field4" class="border p-2 rounded dark:bg-gray-700" placeholder="Target" />
            <input id="field5" class="border p-2 rounded dark:bg-gray-700" placeholder="Realisasi" />
            <input id="field6" class="border p-2 rounded dark:bg-gray-700" placeholder="Standar Nasional / POLINES" />
            <input id="field7" class="border p-2 rounded dark:bg-gray-700" placeholder="Uraian Isian" />
            <input id="field8" class="border p-2 rounded dark:bg-gray-700" placeholder="Akar Penyebab" />
            <input id="field9" class="border p-2 rounded dark:bg-gray-700" placeholder="Akar Penunjang" />
            <input id="field10" class="border p-2 rounded dark:bg-gray-700" placeholder="Rencana Perbaikan & Tindak Lanjut '25" />
        </div>
        <div class="flex justify-end mt-4 gap-2">
            <button onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Tutup</button>
            <button onclick="saveQuestion()" id="saveButton" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </div>
</div>
<script>
    let editingRowIndex = null;

    function openModal(mode) {
        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modalTitle').innerText = mode === 'add' ? 'Tambah Pertanyaan' : 'Edit Pertanyaan';
        document.getElementById('saveButton').innerText = mode === 'add' ? 'Tambah' : 'Update';
        editingRowIndex = mode === 'edit' ? getSelectedRowIndex() : null;

        // Kosongkan form atau isi data jika mode edit
        for (let i = 0; i <= 10; i++) {
            document.getElementById('field' + i).value = editingRowIndex !== null ? 
                document.querySelector(`#tableBody tr:nth-child(${editingRowIndex + 1}) td:nth-child(${i + 2})`).innerText : '';
        }
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    function saveQuestion() {
        const values = [];
        for (let i = 0; i <= 10; i++) {
            values.push(document.getElementById('field' + i).value);
        }

        if (editingRowIndex !== null) {
            const row = document.querySelector(`#tableBody tr:nth-child(${editingRowIndex + 1})`);
            values.forEach((val, i) => row.children[i + 1].innerText = val);
        } else {
            const tableBody = document.getElementById('tableBody');
            const row = document.createElement('tr');
            row.innerHTML = `<td class="border px-2 py-1">${tableBody.children.length + 1}</td>` +
                values.map(val => `<td class="border px-2 py-1">${val}</td>`).join('');
            tableBody.appendChild(row);
        }

        closeModal();
    }

    function getSelectedRowIndex() {
        const rows = document.querySelectorAll('#tableBody tr');
        if (rows.length === 0) {
            alert('Tidak ada data untuk diedit!');
            return null;
        }
        return rows.length - 1; // Default: edit baris terakhir (bisa dimodifikasi untuk pilihan spesifik)
    }

    function downloadData() {
        let csv = 'No,Daftar Pertanyaan,Indikator Kinerja, Sumber Bukti,Metode Perhitungan,Target,Realisasi,Standar Nasional,Uraian Isian,Akar Penyebab,Akar Penunjang,Rencana Perbaikan\n';
        document.querySelectorAll('#tableBody tr').forEach(row => {
            const cols = Array.from(row.children).map(cell => `"${cell.innerText}"`);
            csv += cols.join(',') + '\n';
        });

        const blob = new Blob([csv], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = 'data_checklist.csv';
        link.click();
        URL.revokeObjectURL(url);
    }

    function importData() {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = '.csv';
        input.onchange = e => {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = () => {
                const lines = reader.result.split('\n').slice(1);
                lines.forEach(line => {
                    const cols = line.split(',').map(cell => cell.replace(/"/g, '').trim());
                    if (cols.length >= 11) {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td class="border px-2 py-1">${document.getElementById('tableBody').children.length + 1}</td>` +
                            cols.slice(0, 11).map(c => `<td class="border px-2 py-1">${c}</td>`).join('');
                        document.getElementById('tableBody').appendChild(row);
                    }
                });
            };
            reader.readAsText(file);
        };
        input.click();
    }

    function showPrevious() {
        alert("Pagination sebelumnya (belum diimplementasi backend)");
    }

    function showNext() {
        alert("Pagination berikutnya (belum diimplementasi backend)");
    }
</script>


<script>
    let currentKriteria = 1;

    const kriteriaData = {
        1: `
            <p class="font-semibold text-gray-700 mb-3 dark:text-gray-300">
                Kriteria : 1. Visi, Misi, Tujuan, Strategi
            </p>
            <div class="overflow-auto">
                <table class="w-full table-auto text-sm border-collapse border border-gray-300 dark:border-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-600 dark:text-gray-200">No</th>
                            <th class="border border-gray-300 px-2 py-2 dark:border-gray-600 dark:text-gray-200">Daftar Pertanyaan</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-600 dark:text-gray-200">Indikator Kinerja<br>Renstra & LKPS</th>
                            <th class="border border-gray-300 px-2 py-2 dark:border-gray-600 dark:text-gray-200">Sumber Bukti/Bukti</th>
                            <th class="border border-gray-300 px-2 py-2 dark:border-gray-600 dark:text-gray-200">Metode Perhitungan</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-600 dark:text-gray-200">Target</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-600 dark:text-gray-200">Realisasi</th>
                            <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-600 dark:text-gray-200">Standar Nasional</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-600 dark:text-gray-200">1</td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-600 dark:text-gray-200">Berapa persen pemenuhan Dosen dengan kualifikasi minimal S2 yang mengajar S1 dan Diploma</td>
                            <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-600 dark:text-gray-200">SPM 5.1.1</td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-600 dark:text-gray-200">Data pendidikan dosen</td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-600 dark:text-gray-200">Jumlah dosen S2 mengajar STr dan D3 / jumlah total dosen</td>
                            <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-600 dark:text-gray-200">100%</td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-600 dark:text-gray-200"></td>
                            <td class="border border-gray-300 px-2 py-2 dark:border-gray-600 dark:text-gray-200"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `,
             2: `
            <p class="font-semibold text-gray-700 mb-3 dark:text-gray-300">
    Kriteria : 2. Tata Kelola, Tata Pamong, dan Kerjasama
</p>
<div class="overflow-auto">
    <table class="w-full table-auto text-sm border-collapse border border-gray-300 dark:border-gray-600">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">No</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Daftar Pertanyaan</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Indikator Kinerja<br>Renstra & LKPS</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Sumber Bukti/Bukti</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Metode Perhitungan</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Target</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Realisasi</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Standar Nasional</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">1</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Berapa persen pemenuhan Dosen dengan kualifikasi minimal S2 yang mengajar S1 dan Diploma</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">SPM 5.1.1</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Data pendidikan dosen</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Jumlah dosen S2 mengajar STr dan D3 / jumlah total dosen</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">100%</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white"></td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white"></td>
            </tr>
        </tbody>
    </table>
</div>

         `,
         3: `
    <p class="font-semibold text-gray-700 mb-3 dark:text-gray-300">
    Kriteria : 3. Visi, Misi, Tujuan, Strategi
</p>
<div class="overflow-auto">
    <table class="w-full table-auto text-sm border-collapse border border-gray-300 dark:border-gray-600">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">No</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Daftar Pertanyaan</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Indikator Kinerja<br>Renstra & LKPS</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Sumber Bukti/Bukti</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Metode Perhitungan</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Target</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Realisasi</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Standar Nasional</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">1</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Berapa persen pemenuhan Dosen dengan kualifikasi minimal S2 yang mengajar S1 dan Diploma</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">SPM 5.1.1</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Data pendidikan dosen</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Jumlah dosen S2 mengajar STr dan D3 / jumlah total dosen</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">100%</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">100%</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white"></td>
            </tr>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">2</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Berapa persen pemenuhan Dosen dengan kualifikasi minimal S3 yang mengajar S2</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">SPM 5.1.2</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Data pendidikan dosen</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Jumlah dosen S3 mengajar S2 / jumlah total dosen</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">100%</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">100%</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white"></td>
            </tr>
        </tbody>
    </table>
</div>

`,
4: `
    <p class="font-semibold text-gray-700 mb-3 dark:text-gray-300">
    Kriteria : 4. Sumber Daya Manusia
</p>
<div class="overflow-auto">
    <table class="w-full table-auto text-sm border-collapse border border-gray-300 dark:border-gray-600">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">No</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Daftar Pertanyaan</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Indikator Kinerja<br>Renstra & LKPS</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Sumber Bukti/Bukti</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Metode Perhitungan</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Target</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Realisasi</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Standar Nasional</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">1</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Berapa persen dosen tetap yang memiliki sertifikasi pendidik</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">SPM 6.2.1</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Data dosen dan sertifikasi</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Jumlah dosen bersertifikat / jumlah dosen tetap</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">80%</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">75%</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white"></td>
            </tr>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">2</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Berapa persen dosen tetap yang memiliki jabatan fungsional minimal Lektor</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">SPM 6.3.2</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Data jabatan fungsional dosen</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Jumlah dosen Lektor ke atas / jumlah dosen tetap</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">70%</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">65%</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white"></td>
            </tr>
        </tbody>
    </table>
</div>

`,
5: `
    <p class="font-semibold text-gray-700 mb-3 dark:text-gray-300">
    Kriteria : 5. Tata Kelola
</p>
<div class="overflow-auto">
    <table class="w-full table-auto text-sm border-collapse border border-gray-300 dark:border-gray-600">
        <thead class="bg-gray-100 dark:bg-gray-700">
            <tr>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">No</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Daftar Pertanyaan</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Indikator Kinerja<br>Renstra & LKPS</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Sumber Bukti/Bukti</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Metode Perhitungan</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Target</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Realisasi</th>
                <th class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">Standar Nasional</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">1</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Apakah tersedia profil Lulusan, Capaian Pembelajaran Lulusan (CPL) sesuai dengan Profil Lulusan dan jenjang KKNI/SKKNI disertai bukti yang sahih dan sangat lengkap.</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">SPM 3.2.1</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Dokumen Kurikulum</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white"></td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white"></td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white"></td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white"></td>
            </tr>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">2</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Apakah tersedia dokumen kurikulum yang lengkap dengan SK kurikulum?</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white">SPM 3.2.1</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white">Dokumen Kurikulum</td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 dark:text-white"></td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white"></td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white"></td>
                <td class="border border-gray-300 dark:border-gray-600 px-2 py-2 text-center dark:text-white"></td>
            </tr>
        </tbody>
    </table>
</div>

`,
6: `
    <p class="font-semibold text-gray-700 mb-3 dark:text-gray-300">
    Kriteria : 6. Kurikulum dan Pembelajaran
</p>

<div class="overflow-auto">
    <table class="w-full table-auto text-sm border-collapse border border-gray-300 dark:border-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">No</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Daftar Pertanyaan</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Indikator Kinerja<br>Renstra & LKPS</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Sumber Bukti/Bukti</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Metode Perhitungan</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Target</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Realisasi</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Standar Nasional</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">1</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Apakah tersedia profil Lulusan, Capaian Pembelajaran Lulusan (CPL) sesuai dengan Profil Lulusan dan jenjang KKNI/SKKNI disertai bukti yang sahih dan sangat lengkap.</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">SPM 3.2.1</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Dokumen Kurikulum</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
            </tr>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">2</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Apakah tersedia dokumen kurikulum yang lengkap dengan SK kurikulum?</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">SPM 3.2.1</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Dokumen Kurikulum</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
            </tr>
        </tbody>
    </table>
</div>

`,
7: `
    <p class="font-semibold text-gray-700 mb-3 dark:text-gray-300">
    Kriteria : 7. Penelitian
</p>

<div class="overflow-auto">
    <table class="w-full table-auto text-sm border-collapse border border-gray-300 dark:border-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">No</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Daftar Pertanyaan</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Indikator Kinerja<br>Renstra & LKPS</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Sumber Bukti/Bukti</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Metode Perhitungan</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Target</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Realisasi</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Standar Nasional</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">1</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Apakah UPPS memiliki peta jalan yang memayungi tema penelitian dosen</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">IKU.2.01.01<br>Memiliki peta jalan yang memayungi tema penelitian dosen.</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Dokumen peta jalan penelitian</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Ketersediaan Dokumen</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
            </tr>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">2</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Apakah UPPS sudah melakukan evaluasi kesesuaian penelitian dosen dengan peta jalan</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">IKU.2.01.01<br>Melakukan evaluasi kesesuaian penelitian dosen dengan peta jalan</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Dokumen hasil evaluasi kesesuaian penelitian dosen dengan peta jalan penelitian</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Ketersediaan Dokumen</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
            </tr>
        </tbody>
    </table>
</div>

`,
8: `
    <p class="font-semibold text-gray-700 mb-3 dark:text-gray-300">
    Kriteria : 8. Pengabdian kepada Masyarakat
</p>

<div class="overflow-auto">
    <table class="w-full table-auto text-sm border-collapse border border-gray-300 dark:border-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">No</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Daftar Pertanyaan</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Indikator Kinerja<br>Renstra & LKPS</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Sumber Bukti/Bukti</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Metode Perhitungan</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Target</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Realisasi</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Standar Nasional</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">1</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Apakah UPPS memiliki peta jalan yang memayungi tema pengabdian dosen</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">IKU.2.02.01<br>Memiliki peta jalan yang memayungi tema pengabdian dosen</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Dokumen peta jalan pengabdian</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Ketersediaan Dokumen</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
            </tr>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">2</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Apakah UPPS sudah melakukan evaluasi kesesuaian pengabdian dosen dengan peta jalan</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">IKU.2.02.01<br>Melakukan evaluasi kesesuaian pengabdian dosen dengan peta jalan</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Dokumen hasil evaluasi kesesuaian pengabdian dosen dengan peta jalan pengabdian</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Ketersediaan Dokumen</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
            </tr>
        </tbody>
    </table>
</div>

`,
9: `
   <p class="font-semibold text-gray-700 mb-3 dark:text-gray-300">
    Kriteria : 9. Luaran Tridharma
</p>

<div class="overflow-auto">
    <table class="w-full table-auto text-sm border-collapse border border-gray-300 dark:border-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">No</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Daftar Pertanyaan</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Indikator Kinerja<br>Renstra & LKPS</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Sumber Bukti/Bukti</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Metode Perhitungan</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Target</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Realisasi</th>
                <th class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">Standar Nasional / POLINES</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Uraian Isian</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Akar Penyebab (Target tidak tercapai)</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Akar Penunjang (Target tercapai)</th>
                <th class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Rencana Perbaikan & Tindak Lanjut '25</th>
            </tr>
        </thead>
        <tbody>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">1</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Berapakah IPK lulusan (SPM.1.5.1)</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">3,3</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
            </tr>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">2</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Berapakah waktu tunggu lulusan yang mendapat pekerjaan (SPM.1.5.2)</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">0,3 Th</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
            </tr>
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">3</td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white">Berapakah jumlah hasil penelitian yang diaplikasikan</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white">14 Judul/Th</td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 text-center dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
                <td class="border border-gray-300 px-2 py-2 dark:border-gray-700 dark:text-white"></td>
            </tr>
        </tbody>
    </table>
   </div>

`

               
    };
    

    function renderKriteria() {
        document.getElementById('kriteria-container').innerHTML = kriteriaData[currentKriteria];
    }

    function showNext() {
        if (currentKriteria < Object.keys(kriteriaData).length) {
            currentKriteria++;
            renderKriteria();
        }
    }

    function showPrevious() {
        if (currentKriteria > 1) {
            currentKriteria--;
            renderKriteria();
        }
    }

    function openModal(action) {
        const modal = document.getElementById('modal');
        const modalTitle = document.getElementById('modalTitle');
        const saveButton = document.getElementById('saveButton');

        if (action === 'add') {
            modalTitle.textContent = 'Tambah Pertanyaan';
            saveButton.textContent = 'Save';
        } else if (action === 'edit') {
            modalTitle.textContent = 'Edit Pertanyaan';
            saveButton.textContent = 'Update';
        }

        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    // Tampilkan pertama kali
    renderKriteria();
</script>
@endsection

