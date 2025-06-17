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
                <button type="button" id="closeModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="formEditPassword">
                <div class="grid gap-4 mb-4 sm:grid-cols-1">
                    <div>
                        <label for="old_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Lama</label>
                        <input type="password" id="old_password" name="old_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div>
                        <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Baru</label>
                        <input type="password" id="new_password" name="new_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <div>
                        <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi Password Baru</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
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

<div id="responseModal" class="hidden fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow dark:text-gray-400 dark:divide-gray-700 space-x dark:bg-gray-800" role="alert">
    <div id="modalIcon" class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
        </svg>
        <span class="sr-only">Success icon</span>
    </div>
    <div class="ps-4 text-sm font-normal" id="modalMessage">Message here.</div>
    <button type="button" id="closeResponseModal" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
        </svg>
    </button>
</div>


<script>
// Pindahkan ke paling atas sebelum DOMContentLoaded
function showToast(message, success = true) {
    const responseModal = document.getElementById('responseModal');
    const modalMessage = document.getElementById('modalMessage');
    const modalIcon = document.getElementById('modalIcon');
    const closeButton = document.getElementById('closeResponseModal');
    
    modalMessage.textContent = message;

    // Ganti ikon dan warna
    const successClasses = ['text-green-500', 'bg-green-100', 'dark:bg-green-800', 'dark:text-green-200'];
    const errorClasses = ['text-red-500', 'bg-red-100', 'dark:bg-red-800', 'dark:text-red-200'];
    const successIcon = `
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
        </svg><span class="sr-only">Success icon</span>`;
    const errorIcon = `
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-1-5h2v2h-2v-2Zm0-8h2v6h-2V5Z"/>
        </svg><span class="sr-only">Error icon</span>`;

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
    responseModal.classList.add('flex'); // Use flex for Flowbite toast

    // Auto close function
    const autoClose = setTimeout(() => {
        responseModal.classList.add('hidden');
        responseModal.classList.remove('flex');
    }, 3000);

    // Manual close
    closeButton.onclick = () => {
        clearTimeout(autoClose);
        responseModal.classList.add('hidden');
        responseModal.classList.remove('flex');
    };
}

let userData = {};
// Menggunakan instance Flowbite untuk mengelola modal secara programmatic
let modalProfileInstance = null;
let modalPasswordInstance = null;

document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi instance Modal Flowbite
    const modalProfileEl = document.getElementById('modalEditProfile');
    const modalPasswordEl = document.getElementById('modalEditPassword');
    
    // Opsi default untuk modal (biarkan kosong jika tidak ada kustomisasi)
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
                // ... set lainnya ke '-'
            });
    }

    // --- Modal Edit Profile Logic ---
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

    // --- Modal Edit Password Logic ---
    const btnEditPassword = document.getElementById('btnEditPassword');
    const closeModalPassword = modalPasswordEl.querySelector('#closeModal');
    const cancelEditPassword = modalPasswordEl.querySelector('#cancelPasswordEdit');
    const formEditPassword = document.getElementById('formEditPassword');

    btnEditPassword.addEventListener('click', () => {
        formEditPassword.reset();
        modalPasswordInstance.show();
    });

    closeModalPassword.addEventListener('click', () => modalPasswordInstance.hide());
    cancelEditPassword.addEventListener('click', () => modalPasswordInstance.hide());

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