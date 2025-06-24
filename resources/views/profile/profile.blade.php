@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden">
        <div class="p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex-shrink-0 mb-4 sm:mb-0 sm:mr-6">
                    <div class="flex items-center justify-center h-20 w-20 rounded-full bg-sky-100 dark:bg-sky-900 text-sky-600 dark:text-sky-400">
                        <x-heroicon-o-user-circle class="h-12 w-12"/>
                    </div>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Profil Pengguna</h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Kelola informasi akun, email, dan data personal Anda.</p>
                </div>
            </div>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8 text-gray-700 dark:text-gray-300">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white" id="nama">-</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat Email</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white" id="email">-</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">NIP</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white" id="nip">-</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Role</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white" id="role">-</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Unit Kerja</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white" id="unit_kerja">-</dd>
                </div>
            </dl>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800/50 px-8 py-4 flex flex-col sm:flex-row items-center justify-end gap-3">
             @php
                $roleRoutes = [
                    1 => 'admin.dashboard.index',
                    2 => 'auditor.dashboard.index',
                    3 => 'auditee.dashboard.index',
                    4 => 'kepala-pmpp.dashboard.index',
                ];
                $routeName = $roleRoutes[session('role_id')] ?? 'default.route.name';
            @endphp

            <x-button color="gray" class="w-full sm:w-auto" icon="heroicon-o-arrow-left" href="{{ route($routeName) }}">
                Kembali
            </x-button>
            <x-button id="btnEditPassword" color="light" class="w-full sm:w-auto">
                <x-heroicon-o-key class="w-5 h-5 mr-2" />
                Ubah Password
            </x-button>
            <x-button id="btnEditProfile" color="sky" class="w-full sm:w-auto">
                <x-heroicon-o-pencil-square class="w-5 h-5 mr-2" />
                Edit Profil
            </x-button>
        </div>
    </div>
</div>

<div id="modalEditProfile" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Profil</h3>
                <button type="button" id="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="formEditProfile">
                <div class="grid gap-4 mb-4 sm:grid-cols-1">
                    <div>
                        <label for="edit_nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" id="edit_nama" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div>
                        <label for="edit_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" id="edit_email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div>
                        <label for="edit_nip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                        <input type="text" id="edit_nip" name="nip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button type="submit" class="text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800">Simpan Perubahan</button>
                    <button type="button" id="cancelEdit" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalEditPassword" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ubah Password</h3>
                <button type="button" id="closeModalPasswordBtn" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="formEditPassword">
                <div class="grid gap-4 mb-4 sm:grid-cols-1">
                    <div>
                        <label for="old_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Lama</label>
                        <div class="relative">
                            <input type="password" id="old_password" name="old_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            <button type="button" id="toggleOldPassword" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            <button type="button" id="toggleNewPassword" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" id="confirm_password" name="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button type="submit" class="text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800">Simpan Password</button>
                    <button type="button" id="cancelPasswordEdit" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Toast -->
<div id="responseModal" class="hidden fixed top-4 end-4 z-50 bg-transparent transition-opacity duration-300">
    <div class="w-full max-w-md p-4 bg-white rounded-lg shadow-lg dark:bg-gray-800">
        <div class="flex items-center">
            <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200" id="modalIcon">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Ikon Sukses</span>
            </div>
            <div class="ms-3 text-sm font-normal text-gray-500 dark:text-gray-400" id="modalMessage">
                Action completed successfully.
            </div>
            <button type="button" id="closeResponseModal" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Tutup">
                <span class="sr-only">Tutup</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
function showToast(message, success = true) {
    const responseModal = document.getElementById('responseModal');
    const modalMessage = document.getElementById('modalMessage');
    const modalIcon = document.getElementById('modalIcon');
    const closeButton = document.getElementById('closeResponseModal');
    
    modalMessage.textContent = message;

    const successClasses = ['text-green-500', 'bg-green-100', 'dark:bg-green-800', 'dark:text-green-200'];
    const errorClasses = ['text-red-500', 'bg-red-100', 'dark:bg-red-800', 'dark:text-red-200'];
    const successIcon = `
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
        </svg><span class="sr-only">Ikon Sukses</span>`;
    const errorIcon = `
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-1-5h2v2h-2v-2Zm0-8h2v6h-2V5Z"/>
        </svg><span class="sr-only">Ikon Error</span>`;

    if (success) {
        modalIcon.classList.remove(...errorClasses);
        modalIcon.classList.add(...successClasses);
        modalIcon.innerHTML = successIcon;
    } else {
        modalIcon.classList.remove(...successClasses);
        modalIcon.classList.add(...errorClasses);
        modalIcon.innerHTML = errorIcon;
    }
    
    responseModal.classList.remove('hidden');
    responseModal.classList.add('opacity-100');

    const autoClose = setTimeout(() => {
        responseModal.classList.remove('opacity-100');
        responseModal.classList.add('opacity-0');
        setTimeout(() => responseModal.classList.add('hidden'), 300); // Tunggu transisi selesai
    }, 3000);

    closeButton.onclick = () => {
        clearTimeout(autoClose);
        responseModal.classList.remove('opacity-100');
        responseModal.classList.add('opacity-0');
        setTimeout(() => responseModal.classList.add('hidden'), 300); // Tunggu transisi selesai
    };
}

let userData = {};
let modalProfileInstance = null;
let modalPasswordInstance = null;

document.addEventListener('DOMContentLoaded', function () {
    const modalProfileEl = document.getElementById('modalEditProfile');
    const modalPasswordEl = document.getElementById('modalEditPassword');
    
    const options = {
        placement: 'center-center',
        backdrop: 'dynamic',
        backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
        closable: true,
    };

    modalProfileInstance = new Modal(modalProfileEl, options);
    modalPasswordInstance = new Modal(modalPasswordEl, options);

    const UserId = {{ session('user.user_id') ?? 'null' }};
    if (UserId) {
        fetch(`http://127.0.0.1:5000/api/data-user/${UserId}`)
            .then(res => {
                if (!res.ok) throw new Error('Gagal mengambil data user.');
                return res.json();
            })
            .then(response => {
                const data = response.data || {};
                userData = data;
                document.getElementById('nama').textContent = data.nama || '-';
                document.getElementById('email').textContent = data.email || '-';
                document.getElementById('nip').textContent = data.nip || '-';
                document.getElementById('role').textContent = (data.role && data.role.nama_role) ? data.role.nama_role : '-';
                document.getElementById('unit_kerja').textContent = (data.unit_kerja && data.unit_kerja.nama_unit_kerja) ? data.unit_kerja.nama_unit_kerja : '-';
            })
            .catch(error => {
                console.error("Fetch error:", error);
                document.getElementById('nama').textContent = 'Gagal memuat data';
            });
    }

    const btnEdit = document.getElementById('btnEditProfile');
    const closeModal = modalProfileEl.querySelector('#closeModal');
    const cancelEdit = modalProfileEl.querySelector('#cancelEdit');
    const formEdit = document.getElementById('formEditProfile');

    btnEdit.addEventListener('click', () => {
        document.getElementById('edit_nama').value = userData.nama || '';
        document.getElementById('edit_email').value = userData.email || '';
        document.getElementById('edit_nip').value = userData.nip || '';
        modalProfileInstance.show();
    });

    closeModal.addEventListener('click', () => modalProfileInstance.hide());
    cancelEdit.addEventListener('click', () => modalProfileInstance.hide());

    formEdit.addEventListener('submit', function(e) {
        e.preventDefault();
        const updatedData = {
            nama: document.getElementById('edit_nama').value,
            email: document.getElementById('edit_email').value,
            nip: document.getElementById('edit_nip').value,
            role_id: userData.role ? userData.role.role_id : null,
            unit_kerja_id: userData.unit_kerja ? userData.unit_kerja.unit_kerja_id : null,
            password: '',
        };

        fetch(`http://127.0.0.1:5000/api/data-user/${UserId}`, {
            method: 'PUT',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(updatedData)
        })
        .then(res => res.ok ? res.json() : res.json().then(err => Promise.reject(err)))
        .then(response => {
            document.getElementById('nama').textContent = updatedData.nama;
            document.getElementById('email').textContent = updatedData.email;
            document.getElementById('nip').textContent = updatedData.nip;
            modalProfileInstance.hide();
            showToast('Profil berhasil diperbarui!', true);
        })
        .catch(error => {
            console.error('Error:', error);
            showToast(error.message || 'Gagal menyimpan data!', false);
        });
    });

    const btnEditPassword = document.getElementById('btnEditPassword');
    const closeModalPassword = modalPasswordEl.querySelector('#closeModalPasswordBtn');
    const cancelEditPassword = modalPasswordEl.querySelector('#cancelPasswordEdit');
    const formEditPassword = document.getElementById('formEditPassword');

    const eyeIcon = `
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        </svg>
    `;
    const eyeSlashIcon = `
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.243 4.243L6.228 6.228" />
        </svg>
    `;

    function setupPasswordToggle(inputId, toggleId) {
        const passwordInput = document.getElementById(inputId);
        const toggleButton = document.getElementById(toggleId);

        toggleButton.innerHTML = eyeIcon;

        toggleButton.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.innerHTML = eyeSlashIcon;
            } else {
                passwordInput.type = 'password';
                toggleButton.innerHTML = eyeIcon;
            }
        });
    }

    btnEditPassword.addEventListener('click', () => {
        formEditPassword.reset();
        modalPasswordInstance.show();
    });

    closeModalPassword.addEventListener('click', () => modalPasswordInstance.hide());
    cancelEditPassword.addEventListener('click', () => modalPasswordInstance.hide());

    setupPasswordToggle('old_password', 'toggleOldPassword');
    setupPasswordToggle('new_password', 'toggleNewPassword');
    setupPasswordToggle('confirm_password', 'toggleConfirmPassword');

    formEditPassword.addEventListener('submit', function(e) {
        e.preventDefault();
        const old_password = document.getElementById('old_password').value;
        const new_password = document.getElementById('new_password').value;
        const confirm_password = document.getElementById('confirm_password').value;

        if (!old_password || !new_password || !confirm_password) {
            showToast('Semua field password wajib diisi!', false);
            return;
        }
        if (new_password !== confirm_password) {
            showToast('Konfirmasi password tidak cocok!', false);
            return;
        }

        fetch(`http://127.0.0.1:5000/api/data-user/${UserId}/change-password`, {
            method: 'PUT',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                old_password,
                new_password,
                new_password_confirmation: confirm_password
            })
        })
        .then(res => res.ok ? res.json() : res.json().then(err => Promise.reject(err)))
        .then(response => {
            modalPasswordInstance.hide();
            showToast('Password berhasil diubah!', true);
        })
        .catch(error => {
            showToast(error.message || 'Gagal mengubah password!', false);
        });
    });
});
</script>
@endsection