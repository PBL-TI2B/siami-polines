@extends('layouts.app')

@section('title', 'Instrumen UPT - Auditee')

<!-- Letakkan di head atau sebelum script Anda -->
@if (session('user'))
    <meta name="user-id" content="{{ session('user')['user_id'] }}">
@endif

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[['label' => 'Dashboard', 'url' => ''], ['label' => 'Instrumen UPT - Auditee']]" />

        <!-- Heading -->
        <h1 class="mb-6 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Instrumen UPT - Auditee
        </h1>

        <!-- Table and Pagination -->
        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <!-- Table Controls -->
            <div
                class="flex flex-col items-center justify-between gap-4 rounded-t-2xl border-b border-gray-200 bg-white p-4 sm:flex-row dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
                    <form action="#" method="GET">
                        <select name="per_page"
                            class="w-18 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                            onchange="this.form.submit()">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </form>
                    <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
                </div>
                <div class="relative w-full sm:w-auto">
                    <form action="#" method="GET">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" name="search" placeholder="Cari" value=""
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead
                        class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <tr>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">No
                            </th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Sasaran Strategis</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Indikator Kinerja</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Aktivitas</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Satuan</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Target</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Capaian</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
                                Lokasi Bukti Dukung</th>
                            <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="instrumen-upt-table-body">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4">
                <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        Menampilkan <strong>1</strong> hingga <strong>2</strong> dari <strong>1000</strong> hasil
                    </span>
                    <nav aria-label="Navigasi Paginasi">
                        <ul class="inline-flex -space-x-px text-sm">
                            <li>
                                <a href="#"
                                    class="flex h-8 cursor-not-allowed items-center justify-center rounded-l-lg border border-gray-300 bg-white px-3 leading-tight text-gray-500 opacity-50 transition-all duration-200 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    <x-heroicon-s-chevron-left class="mr-1 h-4 w-4" />
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center justify-center border border-sky-300 bg-sky-50 px-3 leading-tight text-sky-800 transition-all duration-200 dark:border-sky-700 dark:bg-sky-900 dark:text-sky-200">
                                    1
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center justify-center border border-gray-300 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    2
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex h-8 items-center justify-center rounded-r-lg border border-gray-300 bg-white px-3 leading-tight text-gray-500 transition-all duration-200 hover:bg-gray-100 hover:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200">
                                    <x-heroicon-s-chevron-right class="ml-1 h-4 w-4" />
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit data -->
    <div id="edit-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900/50 dark:bg-gray-900/80">
        <div class="flex min-h-screen items-center justify-center">
            <div class="w-full max-w-md rounded-lg bg-white p-6 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-200">Pengisian Instrumen</h2>
                    <button id="close-modal"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
                <form id="edit-form" class="mt-4 space-y-4">
                    <input type="hidden" id="instrumen-response-id">
                    <div>
                        <label for="capaian"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capaian</label>
                        <input type="text" id="capaian" name="capaian"
                            class="mt-1 w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </div>
                    <div>
                        <label for="lokasi-bukti-dukung"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Bukti Dukung</label>
                        <input type="text" id="lokasi-bukti-dukung" name="lokasi_bukti_dukung"
                            class="mt-1 w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    </div>
                    <div class="flex justify-end gap-2">
                        <x-button type="button" color="gray" id="cancel-btn"
                            class="rounded-lg bg-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-400 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                            Batal
                        </x-button>
                        <x-button type="submit" color="sky"
                            class="rounded-lg bg-sky-800 px-4 py-2 text-sm font-medium text-white hover:bg-sky-900">
                            Simpan
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const userId = {{ session('user.user_id', 0) }};

        // // Data dummy untuk simulasi
        // const dummyData = [{
        //         instrumen_response_id: 1,
        //         auditing: {
        //             user_id_auditee: userId
        //         },
        //         set_instrumen_unit_kerja: {
        //             aktivitas: {
        //                 indikator_kinerja: {
        //                     sasaran_strategis: {
        //                         nama_sasaran: "Meningkatkan Kualitas Pelayanan"
        //                     },
        //                     isi_indikator_kinerja: "Persentase kepuasan pelanggan"
        //                 },
        //                 nama_aktivitas: "Survei Kepuasan Pelanggan",
        //                 satuan: "Persen",
        //                 target: "90"
        //             }
        //         },
        //         response: {
        //             capaian: "85",
        //             lokasi_bukti_dukung: "/dokumen/survei.pdf"
        //         }
        //     },
        //     {
        //         instrumen_response_id: 2,
        //         auditing: {
        //             user_id_auditee: userId
        //         },
        //         set_instrumen_unit_kerja: {
        //             aktivitas: {
        //                 indikator_kinerja: {
        //                     sasaran_strategis: {
        //                         nama_sasaran: "Optimalisasi Proses Bisnis"
        //                     },
        //                     isi_indikator_kinerja: "Waktu penyelesaian proses"
        //                 },
        //                 nama_aktivitas: "Peningkatan Efisiensi Prosedur",
        //                 satuan: "Hari",
        //                 target: "5"
        //             }
        //         },
        //         response: {
        //             capaian: "4",
        //             lokasi_bukti_dukung: "/dokumen/prosedur.pdf"
        //         }
        //     }
        // ];

        // Kode fetch asli (dikomentar untuk penggunaan dummy data)
        fetch('http://127.0.0.1:5000/api/instrumen-response')
            .then(response => response.json())
            .then(result => {
                const allData = result.data;
                const tableBody = document.getElementById('instrumen-upt-table-body');

        // Ambil dan isi data tabel menggunakan dummy data
        const tableBody = document.getElementById('instrumen-upt-table-body');

        // Filter data berdasarkan user_id auditee
        const filteredData = dummyData.filter(item => {
            return item.auditing.user_id_auditee === userId;
        });

        // Kosongkan isi tabel
        tableBody.innerHTML = '';

        if (filteredData.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        Tidak ada data yang tersedia untuk auditee ini.
                    </td>
                </tr>
            `;
        } else {
            // Isi tabel dengan data yang sudah difilter
            filteredData.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';

                // Fungsi pembantu untuk mengakses properti bersarang dengan aman
                const getValue = (path, defaultValue = '-') => {
                    try {
                        const value = path.split('.').reduce((obj, key) => obj[key], item);
                        return value !== null && value !== undefined ? value : defaultValue;
                    } catch {
                        return defaultValue;
                    }
                };

                row.innerHTML = `
                    <td class="whitespace-nowrap border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">${index + 1}</td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('set_instrumen_unit_kerja.aktivitas.indikator_kinerja.sasaran_strategis.nama_sasaran')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('set_instrumen_unit_kerja.aktivitas.indikator_kinerja.isi_indikator_kinerja')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('set_instrumen_unit_kerja.aktivitas.nama_aktivitas')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('set_instrumen_unit_kerja.aktivitas.satuan')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('set_instrumen_unit_kerja.aktivitas.target')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('response.capaian')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('response.lokasi_bukti_dukung')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        <div class="flex items-center gap-2">
                            <button class="edit-btn rounded-lg bg-sky-800 p-2 text-white transition-all duration-200 hover:bg-sky-900"
                                data-id="${item.instrumen_response_id}"
                                data-capaian="${getValue('response.capaian')}"
                                data-lokasi="${getValue('response.lokasi_bukti_dukung')}">
                                <x-heroicon-s-pencil-square class="h-4 w-4" />
                            </button>
                        </div>
                    </td>
                `;

                tableBody.appendChild(row);
            });
        }

        // Modal handling
        const modal = document.getElementById('edit-modal');
        const closeModalBtn = document.getElementById('close-modal');
        const cancelBtn = document.getElementById('cancel-btn');
        const editForm = document.getElementById('edit-form');
        const instrumenResponseIdInput = document.getElementById('instrumen-response-id');
        const capaianInput = document.getElementById('capaian');
        const lokasiBuktiDukungInput = document.getElementById('lokasi-bukti-dukung');

        // Fungsi untuk membuka modal
        function openModal(id, capaian, lokasi) {
            instrumenResponseIdInput.value = id;
            capaianInput.value = capaian;
            lokasiBuktiDukungInput.value = lokasi;
            modal.classList.remove('hidden');
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            modal.classList.add('hidden');
            editForm.reset();
        }

        // Event listener untuk tombol edit
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const capaian = this.getAttribute('data-capaian');
                const lokasi = this.getAttribute('data-lokasi');
                openModal(id, capaian, lokasi);
            });
        });

        // Event listener untuk tombol tutup dan batal
        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        // Event listener untuk submit form
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const id = instrumenResponseIdInput.value;
            const capaian = capaianInput.value;
            const lokasiBuktiDukung = lokasiBuktiDukungInput.value;

            // Simulasi penyimpanan data (dummy)
            console.log(`Menyimpan data untuk instrumen_response_id: ${id}`);
            console.log(`Capaian: ${capaian}, Lokasi Bukti Dukung: ${lokasiBuktiDukung}`);
            alert('Data berhasil disimpan! (Simulasi)');

            // Update data dummy dan refresh tabel
            const item = dummyData.find(d => d.instrumen_response_id == id);
            if (item) {
                item.response.capaian = capaian;
                item.response.lokasi_bukti_dukung = lokasiBuktiDukung;
            }

            // Refresh tabel
            tableBody.innerHTML = '';
            filteredData.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700';

                const getValue = (path, defaultValue = '-') => {
                    try {
                        const value = path.split('.').reduce((obj, key) => obj[key], item);
                        return value !== null && value !== undefined ? value : defaultValue;
                    } catch {
                        return defaultValue;
                    }
                };

                row.innerHTML = `
                    <td class="whitespace-nowrap border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">${index + 1}</td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('set_instrumen_unit_kerja.aktivitas.indikator_kinerja.sasaran_strategis.nama_sasaran')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('set_instrumen_unit_kerja.aktivitas.indikator_kinerja.isi_indikator_kinerja')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('set_instrumen_unit_kerja.aktivitas.nama_aktivitas')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('set_instrumen_unit_kerja.aktivitas.satuan')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('set_instrumen_unit_kerja.aktivitas.target')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('response.capaian')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        ${getValue('response.lokasi_bukti_dukung')}
                    </td>
                    <td class="border-r border-gray-200 px-4 py-2 sm:px-6 dark:border-gray-600">
                        <div class="flex items-center gap-2">
                            <button class="edit-btn rounded-lg bg-sky-800 p-2 text-white transition-all duration-200 hover:bg-sky-900"
                                data-id="${item.instrumen_response_id}"
                                data-capaian="${getValue('response.capaian')}"
                                data-lokasi="${getValue('response.lokasi_bukti_dukung')}">
                                <x-heroicon-s-pencil-square class="h-4 w-4" />
                            </button>
                        </div>
                    </td>
                `;

                tableBody.appendChild(row);
            });

            // Tutup modal
            closeModal();

            // Kode fetch asli untuk menyimpan data (dikomentar)
            fetch('http://127.0.0.1:5000/api/instrumen-response/' + id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    capaian: capaian,
                    lokasi_bukti_dukung: lokasiBuktiDukung
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Data berhasil disimpan!');
                } else {
                    alert('Gagal menyimpan data: ' + result.message);
                }
            })
            .catch(error => {
                console.error('Gagal menyimpan data:', error);
                alert('Gagal menyimpan data. Silakan coba lagi.');
            });
        });

        // // Kode fetch untuk unit kerja (dikomentar)
        // fetch('http://127.0.0.1:5000/api/unit-kerja')
        //     .then(response => response.json())
        //     .then(result => {
        //         const data = result.data;
        //         const select = document.getElementById('unitKerjaSelect');
        //         data.forEach(unit => {
        //             const option = document.createElement('option');
        //             option.value = unit.unit_kerja_id;
        //             option.textContent = unit.nama_unit_kerja;
        //             select.appendChild(option);
        //         });
        //     })
        //     .catch(error => {
        //         console.error('Gagal memuat unit kerja:', error);
        //     });

        // // Kode fetch untuk periode (dikomentar)
        // fetch('http://127.0.0.1:5000/api/periode-audits')
        //     .then(response => response.json())
        //     .then(result => {
        //         const data = result.data.data;
        //         const select = document.getElementById('periodeSelect');
        //         data.forEach(unit => {
        //             const option = document.createElement('option');
        //             option.value = unit.periode_id;
        //             option.textContent = unit.nama_periode;
        //             select.appendChild(option);
        //         });
        //     })
        //     .catch(error => {
        //         console.error('Gagal memuat periode AMI:', error);
        //     });
    </script>
@endsection
