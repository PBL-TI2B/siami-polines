@extends('layouts.app')

@section('title', 'Data Instrumen Prodi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('auditee.dashboard.index')],
            ['label' => 'Audit', 'url' => route('auditee.audit.index')],
            ['label' => 'Response Instrumen'],
        ]" />

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
            Response Instrumen Prodi
        </h1>

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
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Ketersediaan Standar dan Dokumen (Ada/Tidak)</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pencapaian Standar SPT PT</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Pencapaian Standar SN DIKTI</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Lokal</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Nasional</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Daya Saing Internasional</th>
                            <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">Keterangan</th>
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
        <div>
            <x-button id="submit-lock-btn" type="submit" color="sky" icon="heroicon-o-plus" class="mt-8">
                Submit dan Kunci Jawaban
            </x-button>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Fetch both set-instrumen and responses data
    const auditingId = {{ session('auditing_id') }}; // Assume auditing_id is passed from Blade
    const auditStatus = {{ session('status') ?? 1 }}; // Get audit status, default to 1 if undefined

    Promise.all([
        fetch('http://127.0.0.1:5000/api/set-instrumen').then(res => res.json()),
        fetch(`http://127.0.0.1:5000/api/responses/auditing/${auditingId}`)
            .then(res => res.json())
            .catch(() => ({ data: [] })) // Return empty data array if responses fetch fails
    ])
        .then(([instrumenResult, responseResult]) => {
            const instrumenData = instrumenResult.data || [];
            const responseData = responseResult.data || [];

            // Create a map of responses by set_instrumen_unit_kerja_id
            const responseMap = {};
            responseData.forEach(response => {
                responseMap[response.set_instrumen_unit_kerja_id] = response;
            });

            const tableBody = document.getElementById('instrumen-table-body');
            let index = 1; // Nomor urut berdasarkan standar

            // If no instrumen data, show empty message
            if (!instrumenData.length) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="12" class="px-4 py-3 sm:px-6 text-center text-red-500">
                            Tidak ada data instrumen tersedia.
                        </td>
                    </tr>
                `;
                return;
            }

            const grouped = {};
            const rowspanStandar = {};

            // Group instrumen data as before
            instrumenData.forEach(item => {
                const standar = item.unsur.deskripsi.kriteria.nama_kriteria;
                const deskripsi = item.unsur.deskripsi.isi_deskripsi;
                const unsur = item.unsur.isi_unsur;

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

            // Helper function to render checklist
            const renderChecklist = (value) => {
                return value === '1' ? `
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                ` : '-';
            };

            // Iterate through grouped data
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
                            const response = responseMap[item.set_instrumen_unit_kerja_id] || {};
                            const row = document.createElement('tr');
                            let html = '';

                            // Kolom No
                            if (!nomorDisplayed) {
                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForStandar}">${index}</td>`;
                                nomorDisplayed = true;
                            }

                            // Kolom Standar
                            if (!standarDisplayed) {
                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForStandar}">${standar}</td>`;
                                standarDisplayed = true;
                            }

                            // Kolom Deskripsi
                            if (!deskripsiDisplayed) {
                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForDeskripsi}">${deskripsi}</td>`;
                                deskripsiDisplayed = true;
                            }

                            // Kolom Unsur
                            if (!unsurDisplayed) {
                                html += `<td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600" rowspan="${totalRowsForUnsur}">${unsur}</td>`;
                                unsurDisplayed = true;
                            }

                            // Response columns with checklist
                            html += `
                                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${response.ketersediaan_standar_dan_dokumen || '-'}</td>
                                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.spt_pt)}</td>
                                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.sn_dikti)}</td>
                                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.lokal)}</td>
                                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.nasional)}</td>
                                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">${renderChecklist(response.internasional)}</td>
                                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600">${response.keterangan || '-'}</td>
                                <td class="px-4 py-3 sm:px-6 border border-gray-200 dark:border-gray-600 text-center">
                                    ${auditStatus != 1 ? `
                                        <span class="text-gray-500 dark:text-gray-400">Jawaban Terkunci</span>
                                    ` : `
                                        <div class="flex items-center gap-2 justify-center">
                                            ${response.response_id ? `
                                                <a href="/auditee/data-instrumen/prodi/${response.response_id}/edit" title="Edit Response" class="text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M14 4a2.5 2.5 0 113.536 3.536L6.5 21H3v-3.5L14 4z"/>
                                                    </svg>
                                                </a>
                                                <button data-id="${response.response_id}" class="delete-btn text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12A2 2 0 0116.1 21H7.9a2 2 0 01-2-1.9L5 7m5-4h4m-4 0a2 2 0 00-2 2v1h8V5a2 2 0 00-2-2z"/>
                                                    </svg>
                                                </button>
                                            ` : `
                                                <a href="/auditee/data-instrumen/create/responses/prodi/${item.set_instrumen_unit_kerja_id}" title="Tambah Response" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </a>
                                            `}
                                        </div>
                                    `}
                                </td>
                            `;

                            row.innerHTML = html;
                            tableBody.appendChild(row);
                        });
                    }
                }
                index++;
            }

            // Handle "Submit dan Kunci Jawaban" button click
            const submitLockBtn = document.getElementById('submit-lock-btn');
            if (submitLockBtn) {
                // Disable button if auditStatus is not 1
                if (auditStatus != 1) {
                    submitLockBtn.disabled = true;
                    submitLockBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    submitLockBtn.addEventListener('click', function (e) {
                        e.preventDefault(); // Prevent default if button is in a form
                        if (confirm('Apakah Anda yakin ingin mengunci jawaban? Tindakan ini tidak dapat dibatalkan.')) {
                            fetch(`http://127.0.0.1:5000/api/auditings/${auditingId}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ status: 2 })
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Gagal mengunci jawaban');
                                    }
                                    return response.json();
                                })
                                .then(result => {
                                    // Update all "Aksi" columns to "Jawaban Terkunci"
                                    const rows = document.querySelectorAll('#instrumen-table-body tr');
                                    rows.forEach(row => {
                                        const actionCell = row.lastElementChild; // "Aksi" is the last td
                                        actionCell.innerHTML = `
                                            <span class="text-gray-500 dark:text-gray-400">Jawaban Terkunci</span>
                                        `;
                                        actionCell.classList.add('text-center'); // Ensure text is centered
                                    });

                                    // Disable the submit button to prevent further clicks
                                    submitLockBtn.disabled = true;
                                    submitLockBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                    
                                    alert('Jawaban berhasil dikunci!');
                                })
                                .catch(error => {
                                    console.error('Gagal mengunci jawaban:', error);
                                    alert('Gagal mengunci jawaban. Silakan coba lagi.');
                                });
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('Gagal mengambil data instrumen:', error);
            const tableBody = document.getElementById('instrumen-table-body');
            tableBody.innerHTML = `
                <tr>
                    <td colspan="12" class="px-4 py-3 sm:px-6 text-center text-red-500">
                        Gagal memuat data instrumen. Silakan coba lagi.
                    </td>
                </tr>
            `;
        });

    // Event listener for delete response buttons
    document.getElementById('instrumen-table-body').addEventListener('click', function (e) {
        const deleteBtn = e.target.closest('.delete-btn');
        if (deleteBtn) {
            e.preventDefault();
            const responseId = deleteBtn.getAttribute('data-id');

            if (confirm('Apakah Anda yakin ingin menghapus response ini?')) {
                fetch(`http://127.0.0.1:5000/api/responses/${responseId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal menghapus response');
                        }
                        return response.json();
                    })
                    .then(result => {
                        alert('Response berhasil dihapus!');
                        window.location.reload(); // Refresh to update table
                    })
                    .catch(error => {
                        console.error('Gagal menghapus response:', error);
                        alert('Gagal menghapus response. Silakan coba lagi.');
                    });
            }
        }
    });
});
</script>
@endsection