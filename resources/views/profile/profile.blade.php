@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden transition-all duration-300">
        <div class="p-8 sm:p-10">
            <div class="flex flex-col sm:flex-row items-start sm:items-center mb-10 pb-8 border-b border-gray-200 dark:border-gray-700">
                <div class="flex-shrink-0 mb-6 sm:mb-0 sm:mr-8 relative" id="profile-badge-container">
                    @php
                        $userName = auth()->user()->nama ?? 'Guest';
                        $initials = collect(explode(' ', $userName))
                            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                            ->take(2)
                            ->join('');
                        $colors = [
                            'bg-gradient-to-br from-red-400 to-pink-500',
                            'bg-gradient-to-br from-blue-400 to-indigo-500',
                            'bg-gradient-to-br from-green-400 to-teal-500',
                            'bg-gradient-to-br from-yellow-400 to-orange-500',
                            'bg-gradient-to-br from-purple-400 to-violet-500',
                            'bg-gradient-to-br from-pink-400 to-rose-500',
                            'bg-gradient-to-br from-indigo-400 to-blue-500',
                            'bg-gradient-to-br from-cyan-400 to-blue-500',
                            'bg-gradient-to-br from-orange-400 to-red-500',
                            'bg-gradient-to-br from-emerald-400 to-green-500',
                        ];
                        $colorIndex = strlen($userName) % count($colors);
                        $profileColor = $colors[$colorIndex];
                    @endphp
                    <div
                        class="{{ $profileColor }} flex h-24 w-24 items-center justify-center rounded-full text-4xl font-bold text-white"
                        id="profile-badge">
                        {{ $initials }}
                    </div>
                </div>
                <div>
                    <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">Profil Pengguna</h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-2 text-lg">Kelola informasi akun, email, dan data personal Anda dengan mudah.</p>
                </div>
            </div>

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-10 text-gray-700 dark:text-gray-300">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Nama Lengkap</dt>
                    <dd class="mt-2 text-xl font-bold text-gray-900 dark:text-white" id="nama">-</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Alamat Email</dt>
                    <dd class="mt-2 text-xl font-bold text-gray-900 dark:text-white" id="email">-</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">NIP</dt>
                    <dd class="mt-2 text-xl font-bold text-gray-900 dark:text-white" id="nip">-</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Role</dt>
                    <dd class="mt-2 text-xl font-bold text-gray-900 dark:text-white" id="role">-</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Unit Kerja</dt>
                    <dd class="mt-2 text-xl font-bold text-gray-900 dark:text-white" id="unit_kerja">-</dd>
                </div>
            </dl>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800/70 px-8 py-6 flex flex-col sm:flex-row items-center justify-end gap-4">
            @php
                $roleRoutes = [
                    1 => 'admin.dashboard.index',
                    2 => 'auditor.dashboard.index',
                    3 => 'auditee.dashboard.index',
                    4 => 'kepala-pmpp.dashboard.index',
                ];
                $routeName = $roleRoutes[session('role_id')] ?? 'default.route.name';
            @endphp

            <x-button color="gray" class="w-full sm:w-auto transition-transform hover:scale-105" icon="heroicon-o-arrow-left" href="{{ route($routeName) }}">
                Kembali
            </x-button>
            <x-button id="btnEditPassword" color="light" class="w-full sm:w-auto transition-transform hover:scale-105">
                <x-heroicon-o-key class="w-5 h-5 mr-2" />
                Ubah Password
            </x-button>
            <x-button id="btnEditProfile" color="sky" class="w-full sm:w-auto transition-transform hover:scale-105">
                <x-heroicon-o-pencil-square class="w-5 h-5 mr-2" />
                Edit Profil
            </x-button>
        </div>
    </div>
</div>

<div id="modalEditProfile" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
        <div class="relative p-6 bg-white rounded-2xl shadow-2xl dark:bg-gray-900 sm:p-8">
            <div class="flex justify-between items-center pb-4 mb-6 rounded-t border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Profil</h3>
                <button type="button" id="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-2 transition-colors dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="formEditProfile">
                <div class="grid gap-6 mb-6 sm:grid-cols-1">
                    <div>
                        <label for="edit_nama" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Nama</label>
                        <input type="text" id="edit_nama" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 block w-full p-3 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all duration-200" required>
                    </div>
                    <div>
                        <label for="edit_email" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Email</label>
                        <input type="email" id="edit_email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 block w-full p-3 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all duration-200" required>
                    </div>
                    <div>
                        <label for="edit_nip" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">NIP</label>
                        <input type="text" id="edit_nip" name="nip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 block w-full p-3 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all duration-200" required>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button type="submit" class="text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-semibold rounded-lg text-sm px-6 py-3 text-center dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800 transition-transform hover:scale-105">Simpan Perubahan</button>
                    <button type="button" id="cancelEdit" class="text-gray-600 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-semibold px-6 py-3 hover:text-gray-900 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-600 transition-transform hover:scale-105">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalEditPassword" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
        <div class="relative p-6 bg-white rounded-2xl shadow-2xl dark:bg-gray-900 sm:p-8">
            <div class="flex justify-between items-center pb-4 mb-6 rounded-t border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Ubah Password</h3>
                <button type="button" id="closeModalPasswordBtn" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-2 transition-colors dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="formEditPassword">
                <div class="grid gap-6 mb-6 sm:grid-cols-1">
                    <div>
                        <label for="old_password" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Password Lama</label>
                        <div class="relative">
                            <input type="password" id="old_password" name="old_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 block w-full p-3 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all duration-200" required>
                            <button type="button" id="toggleOldPassword" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="new_password" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 block w-full p-3 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all duration-200" required>
                            <button type="button" id="toggleNewPassword" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="confirm_password" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" id="confirm_password" name="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 block w-full p-3 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-all duration-200" required>
                            <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button type="submit" class="text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-semibold rounded-lg text-sm px-6 py-3 text-center dark:bg-sky-600 dark:hover:bg-sky-700 dark:focus:ring-sky-800 transition-transform hover:scale-105">Simpan Password</button>
                    <button type="button" id="cancelPasswordEdit" class="text-gray-600 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-semibold px-6 py-3 hover:text-gray-900 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-600 transition-transform hover:scale-105">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Toast -->
<div id="responseModal" class="hidden fixed top-6 right-6 z-50 bg-transparent transition-all duration-300">
    <div class="w-full max-w-md p-5 bg-white rounded-xl shadow-xl dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
            <div class="inline-flex items-center justify-center shrink-0 w-10 h-10 text-green-500 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300" id="modalIcon">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Ikon Sukses</span>
            </div>
            <div class="ml-4 text-base font-medium text-gray-700 dark:text-gray-300" id="modalMessage">
                Action completed successfully.
            </div>
            <button type="button" id="closeResponseModal" class="ml-auto -mx-1.5 -my-1.5 text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-2 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 transition-colors" aria-label="Tutup">
                <span class="sr-only">Tutup</span>
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
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

        if (!responseModal || !modalMessage || !modalIcon || !closeButton) {
            console.error("Toast elements not found. Please ensure 'responseModal', 'modalMessage', 'modalIcon', and 'closeResponseModal' exist in your HTML.");
            return;
        }

        modalMessage.textContent = message;

        const successClasses = ['text-green-500', 'bg-green-100', 'dark:bg-green-900', 'dark:text-green-300'];
        const errorClasses = ['text-red-500', 'bg-red-100', 'dark:bg-red-900', 'dark:text-red-300'];
        const successIcon = `
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
            </svg><span class="sr-only">Ikon Sukses</span>`;
        const errorIcon = `
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
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
            setTimeout(() => responseModal.classList.add('hidden'), 300);
        }, 3000);

        closeButton.onclick = () => {
            clearTimeout(autoClose);
            responseModal.classList.remove('opacity-100');
            responseModal.classList.add('opacity-0');
            setTimeout(() => responseModal.classList.add('hidden'), 300);
        };
    }

    let userData = {};
    let modalProfileInstance = null;
    let modalPasswordInstance = null;

    function updateProfileBadge() {
        const userName = userData.nama || 'Guest';
        const initials = userName.split(' ').map(word => word.charAt(0).toUpperCase()).slice(0, 2).join('');
        const colors = [
            'bg-gradient-to-br from-red-400 to-pink-500',
            'bg-gradient-to-br from-blue-400 to-indigo-500',
            'bg-gradient-to-br from-green-400 to-teal-500',
            'bg-gradient-to-br from-yellow-400 to-orange-500',
            'bg-gradient-to-br from-purple-400 to-violet-500',
            'bg-gradient-to-br from-pink-400 to-rose-500',
            'bg-gradient-to-br from-indigo-400 to-blue-500',
            'bg-gradient-to-br from-cyan-400 to-blue-500',
            'bg-gradient-to-br from-orange-400 to-red-500',
            'bg-gradient-to-br from-emerald-400 to-green-500',
        ];
        const colorIndex = userName.length % colors.length;
        const profileColor = colors[colorIndex];

        const badge = document.getElementById('profile-badge');
        if (badge) {
            badge.className = `${profileColor} flex h-24 w-24 items-center justify-center rounded-full text-4xl font-bold text-white`;
            badge.textContent = initials;
        }
    }

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

    document.addEventListener('DOMContentLoaded', function () {
        const modalProfileEl = document.getElementById('modalEditProfile');
        const modalPasswordEl = document.getElementById('modalEditPassword');

        const options = {
            placement: 'center-center',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/60 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
        };

        if (modalProfileEl) {
            modalProfileInstance = new Modal(modalProfileEl, options);
        }
        if (modalPasswordEl) {
            modalPasswordInstance = new Modal(modalPasswordEl, options);
        }

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
                    updateProfileBadge(); // Update badge after fetching user data
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                });
        }

        const btnEdit = document.getElementById('btnEditProfile');
        if (btnEdit && modalProfileEl) {
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
                    userData.nama = updatedData.nama; // Update userData with new name
                    document.getElementById('nama').textContent = updatedData.nama;
                    document.getElementById('email').textContent = updatedData.email;
                    document.getElementById('nip').textContent = updatedData.nip;
                    modalProfileInstance.hide();
                    updateProfileBadge(); // Update badge after successful edit
                    showToast('Profil berhasil diperbarui!', true);
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast(error.message || 'Gagal menyimpan data!', false);
                });
            });
        }

        const btnEditPassword = document.getElementById('btnEditPassword');
        const closeModalPassword = document.getElementById('closeModalPasswordBtn');
        const cancelEditPassword = document.getElementById('cancelPasswordEdit');
        const formEditPassword = document.getElementById('formEditPassword');

        function setupPasswordToggle(inputId, toggleId) {
            const passwordInput = document.getElementById(inputId);
            const toggleButton = document.getElementById(toggleId);

            if (!passwordInput || !toggleButton) {
                console.warn(`Elements with ID ${inputId} or ${toggleId} not found. Skipping password toggle setup.`);
                return;
            }

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

        if (btnEditPassword) {
            btnEditPassword.addEventListener('click', () => {
                formEditPassword.reset();
                document.getElementById('toggleOldPassword').innerHTML = eyeIcon;
                document.getElementById('old_password').type = 'password';
                document.getElementById('toggleNewPassword').innerHTML = eyeIcon;
                document.getElementById('new_password').type = 'password';
                document.getElementById('toggleConfirmPassword').innerHTML = eyeIcon;
                document.getElementById('confirm_password').type = 'password';

                if (modalPasswordInstance) {
                    modalPasswordInstance.show();
                }
            });
        }

        setupPasswordToggle('old_password', 'toggleOldPassword');
        setupPasswordToggle('new_password', 'toggleNewPassword');
        setupPasswordToggle('confirm_password', 'toggleConfirmPassword');

        if (closeModalPassword) {
            closeModalPassword.addEventListener('click', () => {
                if (modalPasswordInstance) {
                    modalPasswordInstance.hide();
                }
            });
        }
        if (cancelEditPassword) {
            cancelEditPassword.addEventListener('click', () => {
                if (modalPasswordInstance) {
                    modalPasswordInstance.hide();
                }
            });
        }

        if (formEditPassword) {
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
                    if (modalPasswordInstance) {
                        modalPasswordInstance.hide();
                    }
                    showToast('Password berhasil diubah!', true);
                })
                .catch(error => {
                    showToast(error.message || 'Gagal mengubah password!', false);
                });
            });
        }
    });
</script>
@endsection