@extends('layouts.app')

@section('title', 'Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index')],
    ]" />

    <h1 class="mb-5 text-3xl font-bold text-gray-900 dark:text-gray-200">
        Laporan Temuan
    </h1>
    <div class="mb-4 flex">
        <div id="periodeDisplayContainer" class="flex items-center gap-x-2">
            <div class="inline-flex items-center gap-x-2 rounded-2xl bg-sky-100 px-3 py-1.5 text-xs sm:text-sm dark:bg-sky-800">
                <x-heroicon-o-calendar-days class="h-4 w-4 shrink-0 text-sky-600 sm:h-5 sm:w-5 dark:text-sky-300" />
                <span id="namaPeriode" class="font-semibold text-sky-600 dark:text-sky-300">
                    Memuat periode...
                </span>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto mt-5">
        <table id="jadwalAuditTable" class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    <th scope="col" class="rounded-lg border-l border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">No</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">No</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Standar</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Uraian Temuan</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Kategori Temuan</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Saran Perbaikan</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Status</th>
                    <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                <tr>
                    <td colspan="9" class="text-center py-4 text-gray-500">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    // Template URL routes dari Laravel, dengan placeholder :id
    const urls = {
        create: "{{ route('auditor.laporan.create') }}",
        edit: "{{ route('auditor.laporan.edit', ':id') }}",
        destroy: "{{ route('auditor.laporan.destroy', ':id') }}"
    };

    document.addEventListener("DOMContentLoaded", async function() {
        const tableBody = document.querySelector("#tableBody");
        const namaPeriodeElem = document.querySelector("#namaPeriode");
        let token = null;

        try {
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            token = tokenMeta ? tokenMeta.getAttribute('content') : '{{ csrf_token() }}'; // Fallback ke token Blade

            const response = await fetch("{{ route('auditor.laporan.index') }}", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });
            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.error || result.message || 'Gagal memuat data');
            }

            // Pastikan data ada dan merupakan array
            const data = Array.isArray(result.data) ? result.data : [];
            if (data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="9" class="py-4 text-center text-gray-500">Tidak ada data audit.</td></tr>`;
                namaPeriodeElem.textContent = 'Periode: -';
                return;
            }

            const periodeNama = data[0].periode?.nama_periode ?? 'Tidak diketahui';
            namaPeriodeElem.textContent = `Periode: ${periodeNama}`;

            tableBody.innerHTML = "";

            const statusMap = {
                1: 'Pengisian Instrumen',
                2: 'Desk Evaluation',
                3: 'Penjadwalan AL',
                4: 'Dijadwalkan AL',
                5: 'Pertanyaan Tilik',
                6: 'Tilik Dijawab',
                7: 'Laporan Temuan',
                8: 'Revisi',
                9: 'Sudah revisi',
                10: 'Closing',
                11: 'Selesai'
            };

            data.forEach((item, index) => {
                const statusName = statusMap[item.status] ?? 'Status Tidak Diketahui';

                // Pastikan id_laporan_temuan ada
                const id = item.id_laporan_temuan || item.laporan_temuan_id || index; // Fallback jika nama kolom berbeda
                const editUrl = urls.edit.replace(':id', id);
                const destroyUrl = urls.destroy.replace(':id', id);
                const createUrl = urls.create;

                tableBody.innerHTML += `
                    <tr>
                        <td class="px-4 py-2">${index + 1}</td>
                        <td class="px-4 py-2">${item.auditing_id ?? 'N/A'}</td>
                        <td class="px-4 py-2">${item.standar ?? 'Belum diatur'}</td>
                        <td class="px-4 py-2">${item.uraian_temuan ?? 'Belum diatur'}</td>
                        <td class="px-4 py-2">${item.kategori_perbaikan ?? 'Belum diatur'}</td>
                        <td class="px-4 py-2">${item.saran_perbaikan ?? 'Belum diatur'}</td>
                        <td class="px-4 py-2">${statusName}</td>
                        <td class="p-2  flex gap-2">
                            <a href="${createUrl}" class="inline-flex items-center rounded bg-sky-800 px-2 py-1 text-xs font-medium text-white hover:bg-sky-900">
                                Tambah
                            </a>
                            <a href="${editUrl}" class="inline-flex items-center rounded bg-yellow-600 px-2 py-1 text-xs font-medium text-white hover:bg-yellow-700">
                                Edit
                            </a>
                            <button
                                data-url="${destroyUrl}"
                                class="delete-button inline-flex items-center rounded bg-red-600 px-2 py-1 text-xs font-medium text-white hover:bg-red-700">
                                Hapus
                            </button>
                        </td>
                    </tr>`;
            });

            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', async function() {
                    if (!confirm('Apakah Anda yakin ingin menghapus laporan ini?')) return;

                    const url = this.getAttribute('data-url');

                    try {
                        const res = await fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json'
                            }
                        });

                        if (!res.ok) throw new Error('Gagal menghapus data.');

                        alert('Data berhasil dihapus.');
                        location.reload();
                    } catch (error) {
                        alert(error.message);
                    }
                });
            });

        } catch (err) {
            console.error('Error fetching data:', err);
            tableBody.innerHTML = `<tr><td colspan="9" class="py-4 text-center text-red-500">Gagal memuat data: ${err.message}</td></tr>`;
            namaPeriodeElem.textContent = 'Periode: -';
        }
    });
</script>
@endsection
