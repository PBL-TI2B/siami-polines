@extends('layouts.app')

@section('title', 'Data Instrumen Prodi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data Instrumen Prodi', 'url' => route('admin.data-instrumen.instrumenprodi')],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Data Instrumen Prodi
        </h1>

        <!-- Toolbar -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-2">
                <x-button href="{{ route('admin.data-instrumen.tambahprodi') }}" color="sky" icon="heroicon-o-plus" class="shadow-md hover:shadow-lg transition-all">
                    Tambah Instrumen
                </x-button>
            </div>

            <!-- Filter Dropdowns -->
            <div class="flex flex-wrap gap-2">
                <select id="unitKerjaSelect" class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Jenis Unit</option>
                </select>
                <select id="periodeSelect" class="w-40 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg px-4 py-2 focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all duration-200">
                    <option selected disabled>Pilih Periode AMI</option>
                </select>
            </div>
        </div>

        <!-- Table and Pagination -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl">
            <!-- Table Controls -->
            <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-gray-800 rounded-t-2xl border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <form action="#" method="GET">
                        <select name="per_page" class="w-18 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200" onchange="this.form.submit()">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </form>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                </div>
                <div class="relative w-full sm:w-auto">
                    <form action="#" method="GET">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" placeholder="Cari" value="" class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">No</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Standar</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Deskripsi Area Audit-Sub Butir Standar</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pemeriksaan Pada Unsur</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Jenis Unit Kerja</th>
                            {{-- <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Ketersediaan Standar dan Dokumen (Ada/Tidak)</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pencapaian Standar SPT PT</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pencapaian Standar SN DIKTI</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Lokal</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Nasional</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Internasional</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Keterangan</th> --}}
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="instrumen-table-body" class="divide-y divide-gray-200 dark:divide-gray-700">
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>1</strong> hingga <strong>2</strong> dari <strong>1000</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul class="inline-flex -space-x-px text-sm">
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-l-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 cursor-not-allowed opacity-50">
                                    <x-heroicon-s-chevron-left class="w-4 h-4 mr-1" />
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-sky-800 bg-sky-50 dark:bg-sky-900 dark:text-sky-200 border-sky-300 dark:border-sky-700 border transition-all duration-200">
                                    1
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 border hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">
                                    2
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200">
                                    <x-heroicon-s-chevron-right class="w-4 h-4 ml-1" />
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to fetch and render the table based on jenis_unit_id
    function renderTable(jenisUnitId = 3) {
        const tableBody = document.getElementById('instrumen-table-body');
        tableBody.innerHTML = ''; // Clear the table before rendering

        fetch('http://127.0.0.1:5000/api/set-instrumen')
            .then(response => response.json())
            .then(result => {
                // Filter data based on jenis_unit_id (if provided)
                let data = result.data;
                if (jenisUnitId) {
                    data = result.data.filter(item => item.jenis_unit_id === parseInt(jenisUnitId));
                }

                // If no data after filtering, show a message
                if (data.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="12" class="px-4 py-3 sm:px-6 text-center text-gray-500">
                                Tidak ada data untuk unit kerja yang dipilih.
                            </td>
                        </tr>
                    `;
                    return;
                }

                let index = 1; // Nomor urut berdasarkan standar
                const grouped = {};
                const rowspanStandar = {};

                // Mengelompokkan data berdasarkan standar, deskripsi, dan unsur
                data.forEach(item => {
                    const standar = item.unsur?.deskripsi?.kriteria?.nama_kriteria || 'Tidak Diketahui';
                    const deskripsi = item.unsur?.deskripsi?.isi_deskripsi || 'Tidak Diketahui';
                    const unsur = item.unsur?.isi_unsur || 'Tidak Diketahui';

                    if (!grouped[standar]) {
                        grouped[standar] = {};
                        rowspanStandar[standar] = 0;
                    }

                    if (!grouped[standar][deskripsi]) {
                        grouped[standar][deskripsi] = {};
                    }

                    if (!grouped[standar][deskripsi][unsur]) {
                        grouped[standar][deskripsi][unsur] = [];
                    }

                    grouped[standar][deskripsi][unsur].push(item);
                    rowspanStandar[standar]++;
                });

                // Render the table
                for (const standar in grouped) {
                    let standarDisplayed = false;
                    let nomorDisplayed = false;

                    const totalRowsForStandar = Object.values(grouped[standar])
                        .map(desc => Object.values(desc).reduce((sum, arr) => sum + arr.length, 0))
                        .reduce((a, b) => a + b, 0);

                    for (const deskripsi in grouped[standar]) {
                        let deskripsiDisplayed = false;
                        const totalRowsForDeskripsi = Object.values(grouped[standar][deskripsi])
                            .reduce((sum, arr) => sum + arr.length, 0);

                        for (const unsur in grouped[standar][deskripsi]) {
                            let unsurDisplayed = false;
                            const items = grouped[standar][deskripsi][unsur];
                            const totalRowsForUnsur = items.length;

                            items.forEach(item => {
                                const row = document.createElement('tr');
                                let html = '';

                                if (!nomorDisplayed) {
                                    html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForStandar}">${index}</td>`;
                                    nomorDisplayed = true;
                                }

                                if (!standarDisplayed) {
                                    html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForStandar}">${standar}</td>`;
                                    standarDisplayed = true;
                                }

                                if (!deskripsiDisplayed) {
                                    html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForDeskripsi}">${deskripsi}</td>`;
                                    deskripsiDisplayed = true;
                                }

                                if (!unsurDisplayed) {
                                    html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForUnsur}">${unsur}</td>`;
                                    unsurDisplayed = true;
                                }

                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${item.jenisunit?.nama_jenis_unit || 'Tidak Diketahui'}</td>`;

                                html += `
                                    <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">
                                        <div class="flex items-center gap-2 justify-center">
                                            <a href="/admin/data-instrumen/prodi/${item.set_instrumen_unit_kerja_id}/edit" class="text-sky-600 dark:text-sky-400 hover:text-sky-800 dark:hover:text-sky-200 transition-colors duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"></path>
                                                </svg>
                                            </a>
                                            <button data-id="${item.set_instrumen_unit_kerja_id}" class="delete-btn text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 transition-colors duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a2 2 0 00-2 2v1h8V5a2 2 0 00-2-2zm-3 4h6"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                `;

                                row.innerHTML = html;
                                tableBody.appendChild(row);
                            });
                        }
                    }
                    index++; // Moved index increment to standar loop
                }
            })
            .catch(error => {
                console.error('Gagal mengambil data:', error);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="12" class="px-4 py-3 sm:px-6 text-center text-red-500">
                            Gagal memuat data. Silakan coba lagi.
                        </td>
                    </tr>
                `;
            });
    }

    // Initial table render with jenis_unit_id = 3
    renderTable(3);

    // =========================== BAGIAN 2: Dropdown Unit Kerja ===========================
    fetch('http://127.0.0.1:5000/api/jenis-units')
        .then(response => response.json())
        .then(result => {
            const data = result.data;
            const select = document.getElementById('unitKerjaSelect');

            // Add a default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Pilih Unit Kerja';
            select.appendChild(defaultOption);

            data.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit.jenis_unit_id;
                option.textContent = unit.nama_jenis_unit;
                select.appendChild(option);
            });

            // Set default selection to jenis_unit_id = 3
            select.value = '3';

            // Event listener for dropdown change
            select.addEventListener('change', function () {
                const selectedUnitId = select.value;
                renderTable(selectedUnitId);
            });
        })
        .catch(error => {
            console.error('Gagal memuat unit kerja:', error);
        });

    // =========================== BAGIAN 3: Dropdown Periode ===========================
    fetch('http://127.0.0.1:5000/api/periode-audits')
        .then(response => response.json())
        .then(result => {
            const data = result.data.data;
            const select = document.getElementById('periodeSelect');

            // Add a default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Pilih Periode';
            select.appendChild(defaultOption);

            data.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit.periode_id;
                option.textContent = unit.nama_periode;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Gagal memuat periode AMI:', error);
        });
});
// Event listener untuk tombol hapus
document.getElementById('instrumen-table-body').addEventListener('click', function (e) {
    const deleteBtn = e.target.closest('.delete-btn');
    if (deleteBtn) {
        e.preventDefault();
        const setInstrumenId = deleteBtn.getAttribute('data-id');

        if (confirm('Apakah Anda yakin ingin menghapus instrumen ini?')) {
            fetch(`http://127.0.0.1:5000/api/set-instrumen/${setInstrumenId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal menghapus instrumen');
                    }
                    return response.json();
                })
                .then(result => {
                    alert('Instrumen berhasil dihapus!');
                    window.location.href = '/admin/data-instrumen/prodi';
                })
                .catch(error => {
                    console.error('Gagal menghapus instrumen:', error);
                    alert('Gagal menghapus instrumen. Silakan coba lagi.');
                });
        }
    }
});

</script>
@endsection