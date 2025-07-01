@extends('layouts.app')

@section('title', 'Jadwal Audit')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Jadwal Audit', 'url' => route('admin.ploting-ami.index')],
            ['label' => 'Tambah Jadwal Audit', 'url' => route('admin.ploting-ami.create')],
        ]" />

        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Tambah Jadwal Audit
        </h1>

        <!-- Tambahkan Tom Select CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

        <form id="jadwalForm" class="space-y-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
            @csrf
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Unit Kerja -->
                <div>
                    <label for="unit_kerja_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit
                        Kerja</label>
                    <select id="unit_kerja_id" name="unit_kerja_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Unit Kerja</option>
                    </select>
                </div>
                <!-- Periode Audit -->
                <div>
                    <label for="periode_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Periode
                        Audit</label>
                    <select id="periode_id" name="periode_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Periode Audit</option>
                    </select>
                </div>
                <!-- Waktu Audit -->
                <div>
                    <label for="jadwal_audit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu
                        Audit</label>
                    <input type="date" id="jadwal_audit" name="jadwal_audit"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                </div>
                <!-- Auditee 1 -->
                <div>
                    <label for="user_id_1_auditee"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee 1</label>
                    <select id="user_id_1_auditee" name="user_id_1_auditee"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditee 1</option>
                    </select>
                </div>
                <!-- Auditor 1 -->
                <div>
                    <label for="user_id_1_auditor"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor 1</label>
                    <select id="user_id_1_auditor" name="user_id_1_auditor"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditor 1</option>
                    </select>
                </div>
                <!-- Auditee 2 -->
                <div>
                    <label for="user_id_2_auditee"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditee 2</label>
                    <select id="user_id_2_auditee" name="user_id_2_auditee"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditee 2</option>
                    </select>
                </div>
                <!-- Auditor 2 -->
                <div>
                    <label for="user_id_2_auditor"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Auditor 2</label>
                    <select id="user_id_2_auditor" name="user_id_2_auditor"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="">Pilih Auditor 2</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-start space-x-3">
                <a href="{{ route('admin.ploting-ami.index') }}"
                    class="rounded-md bg-gray-200 px-4 py-2 text-gray-800 shadow hover:bg-gray-300 dark:bg-gray-600 dark:text-white">Batal</a>
                <button type="submit"
                    class="rounded-md bg-sky-800 px-4 py-2 text-white shadow hover:bg-sky-700">Simpan</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            // Inisialisasi Tom Select setelah data dimuat
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
                    // Hapus opsi default saat user mulai mengetik atau membuka dropdown
                    function removeDefaultOption() {
                        const option = selectEl.querySelector('option[value=""]');
                        if (option) option.remove();
                    }
                    let previousValue = tom.getValue();
                    tom.on('type', removeDefaultOption);
                    tom.on('dropdown_open', function() {
                        previousValue = tom.getValue();
                        removeDefaultOption();
                        // Kosongkan input search Tom Select saat dropdown dibuka
                        const searchInput = tom.control_input;
                        if (searchInput) searchInput.value = '';
                        tom.clear();
                    });
                    tom.on('dropdown_close', function() {
                        // Jika tidak ada value yang dipilih, kembalikan ke value sebelumnya
                        if (!tom.getValue() && previousValue) {
                            tom.setValue(previousValue, true);
                        }
                    });
                }
            }

            // Fetch Unit Kerja
            fetch('http://127.0.0.1:5000/api/unit-kerja')
                .then(res => res.json())
                .then(data => {
                    const select = document.getElementById('unit_kerja_id');
                    data.data.forEach(item => {
                        select.innerHTML +=
                            `<option value="${item.unit_kerja_id}">${item.nama_unit_kerja}</option>`;
                    });
                    initTomSelect('unit_kerja_id');
                });

            fetch('http://127.0.0.1:5000/api/periode-audits')
                .then(res => res.json())
                .then(data => {
                    const select = document.getElementById('periode_id');
                    const periodeList = data.data.data;
                    if (periodeList && periodeList.length > 0) {
                        periodeList.forEach(item => {
                            select.innerHTML +=
                                `<option value="${item.periode_id}">${item.nama_periode}</option>`;
                        });
                    } else {
                        select.innerHTML += `<option value="">Data tidak tersedia</option>`;
                    }
                    initTomSelect('periode_id');
                })
                .catch(() => {
                    const select = document.getElementById('periode_id');
                    select.innerHTML += `<option value="">Gagal mengambil data</option>`;
                    initTomSelect('periode_id');
                });

            // Fetch Users
            fetch('http://127.0.0.1:5000/api/data-user')
                .then(res => res.json())
                .then(data => {
                    const auditees = data.data.filter(u => u.role_id == 3);
                    const auditors = data.data.filter(u => u.role_id == 2);
                    ['user_id_1_auditee', 'user_id_2_auditee'].forEach(id => {
                        const select = document.getElementById(id);
                        auditees.forEach(user => {
                            select.innerHTML +=
                                `<option value="${user.user_id}">${user.nama}</option>`;
                        });
                        initTomSelect(id);
                    });
                    ['user_id_1_auditor', 'user_id_2_auditor'].forEach(id => {
                        const select = document.getElementById(id);
                        auditors.forEach(user => {
                            select.innerHTML +=
                                `<option value="${user.user_id}">${user.nama}</option>`;
                        });
                        initTomSelect(id);
                    });
                });

            // Handle form submit
            document.getElementById('jadwalForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.delete('_token'); // Hapus CSRF token sebelum dikirim ke Flask
                formData.append('status', 1); // Tambahkan status default
                fetch('http://127.0.0.1:5000/api/auditings', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json().then(data => ({
                        status: res.status,
                        body: data
                    })))
                    .then(({
                        status,
                        body
                    }) => {
                        if (status === 200 || status === 201) {
                            // Simpan pesan sukses ke localStorage agar bisa diambil di index
                            localStorage.setItem('successToast', 'Data berhasil disimpan!');
                            window.location.href = "{{ route('admin.ploting-ami.index') }}";
                        } else {
                            alert('Gagal menyimpan data!\n' + (body.message || JSON.stringify(
                                body)));
                        }
                    })
                    .catch(err => alert('Gagal menyimpan data!'));
            });
        });
    </script>
@endsection
