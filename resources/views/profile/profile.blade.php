@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-lg rounded-lg p-8">
        <div class="flex items-center mb-8">
            <div class="ml-6">
                <h2 class="text-3xl font-extrabold text-gray-800 mb-1">Profil Pengguna</h2>
                <p class="text-gray-500 text-sm">Informasi akun Anda</p>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 text-gray-700">
            <div class="flex items-center">
                <span class="w-36 font-semibold text-gray-600">Nama</span>
                <span class="flex-1" id="nama"></span>
            </div>
            <div class="flex items-center">
                <span class="w-36 font-semibold text-gray-600">Email</span>
                <span class="flex-1" id="email"></span>
            </div>
            <div class="flex items-center">
                <span class="w-36 font-semibold text-gray-600">NIP</span>
                <span class="flex-1" id="nip"></span>
            </div>
            <div class="flex items-center">
                <span class="w-36 font-semibold text-gray-600">Role</span>
                <span class="flex-1" id="role"></span>
            </div>
            <div class="flex items-center">
                <span class="w-36 font-semibold text-gray-600">Unit Kerja</span>
                <span class="flex-1" id="unit_kerja"></span>
            </div>
            <div class="mt-6 flex gap-3 justify-end">
                <x-button id="btnEditProfile" color="sky">
                    <x-heroicon-o-pencil class="w-5 h-5" />
                    Edit
                </x-button>
                <x-button id="btnEditPassword" color="sky">
                    <x-heroicon-o-pencil class="w-5 h-5" />
                    Edit Password
                </x-button>
                <x-button color="gray" icon="heroicon-o-x-mark" href="{{ route('auditor.daftar-tilik.index') }}">
                    Kembali
                </x-button>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profile -->
<div id="modalEditProfile" class="fixed inset-0 z-50 flex items-center justify-center bg-white/30 backdrop-blur-sm hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        <h3 class="text-xl font-bold mb-4">Edit Profil</h3>
        <form id="formEditProfile">
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Nama</label>
                <input type="text" id="edit_nama" name="nama" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" id="edit_email" name="email" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">NIP</label>
                <input type="text" id="edit_nip" name="nip" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" id="cancelEdit" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditPassword" class="fixed inset-0 z-50 flex items-center justify-center bg-white/30 backdrop-blur-sm hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        <h3 class="text-xl font-bold mb-4">Edit Password</h3>
        <form id="formEditPassword">
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Password Lama</label>
                <input type="password" id="old_password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Password Baru</label>
                <input type="password" id="new_password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="password" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" id="cancelPasswordEdit" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded hover:bg-sky-700">Simpan</button>
            </div>
        </form>
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
    // Pindahkan ke paling atas sebelum DOMContentLoaded
function showToast(message, success = true) {
    const responseModal = document.getElementById('responseModal');
    const modalMessage = document.getElementById('modalMessage');
    const modalIcon = document.getElementById('modalIcon');
    modalMessage.textContent = message;

    // Ganti ikon dan warna jika error
    if (success) {
        modalIcon.classList.remove('text-red-500', 'bg-red-100', 'dark:bg-red-800', 'dark:text-red-200');
        modalIcon.classList.add('text-green-500', 'bg-green-100', 'dark:bg-green-800', 'dark:text-green-200');
        modalIcon.innerHTML = `
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
        `;
    } else {
        modalIcon.classList.remove('text-green-500', 'bg-green-100', 'dark:bg-green-800', 'dark:text-green-200');
        modalIcon.classList.add('text-red-500', 'bg-red-100', 'dark:bg-red-800', 'dark:text-red-200');
        modalIcon.innerHTML = `
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-1-5h2v2h-2v-2Zm0-8h2v6h-2V5Z"/>
            </svg>
        `;
    }

    responseModal.classList.remove('hidden');
    responseModal.classList.add('opacity-100');

    // Auto close after 2.5s
    setTimeout(() => {
        responseModal.classList.add('hidden');
    }, 2500);
}

    let userData = {};
    document.addEventListener('DOMContentLoaded', function () {
        const UserId = {{ session('user.user_id') ?? 'null' }};
        if (UserId) {
            fetch(`http://127.0.0.1:5000/api/data-user/${UserId}`)
                .then(res => {
                    if (!res.ok) throw new Error('Gagal mengambil data user.');
                    return res.json();
                })
                .then(response => {
                    // Simpan response ke variable
                    const data = response.data || {};
                    userData = data; // simpan untuk modal
                    document.getElementById('nama').textContent = data.nama || '-';
                    document.getElementById('email').textContent = data.email || '-';
                    document.getElementById('nip').textContent = data.nip || '-';
                    document.getElementById('role').textContent = (data.role && data.role.nama_role) ? data.role.nama_role : '-';
                    document.getElementById('unit_kerja').textContent = (data.unit_kerja && data.unit_kerja.nama_unit_kerja) ? data.unit_kerja.nama_unit_kerja : '-';
                })
                .catch(error => {
                    document.getElementById('nama').textContent = 'Gagal memuat data';
                    document.getElementById('email').textContent = '-';
                    document.getElementById('nip').textContent = '-';
                    document.getElementById('role').textContent = '-';
                    document.getElementById('unit_kerja').textContent = '-';
                });
        }


        // Modal logic
        const modal = document.getElementById('modalEditProfile');
        const btnEdit = document.getElementById('btnEditProfile');
        const closeModal = document.getElementById('closeModal');
        const cancelEdit = document.getElementById('cancelEdit');
        const formEdit = document.getElementById('formEditProfile');

        btnEdit.addEventListener('click', function() {
            // Isi field modal dengan data user
            document.getElementById('edit_nama').value = userData.nama || '';
            document.getElementById('edit_email').value = userData.email || '';
            document.getElementById('edit_nip').value = userData.nip || '';
            modal.classList.remove('hidden');
        });

        closeModal.addEventListener('click', function() {
            modal.classList.add('hidden');
        });
        cancelEdit.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        formEdit.addEventListener('submit', function(e) {
            e.preventDefault();

            // Ambil data dari form
            const updatedData = {
                nama: document.getElementById('edit_nama').value,
                email: document.getElementById('edit_email').value,
                nip: document.getElementById('edit_nip').value,
                role_id: userData.role ? userData.role.role_id : null,
                unit_kerja_id: userData.unit_kerja ? userData.unit_kerja.unit_kerja_id : null,
                // password bisa dikosongkan jika tidak diubah
                password: '', // atau ambil dari input jika ada 
            };

            // Simpan ke backend (contoh pakai fetch PUT)
            fetch(`http://127.0.0.1:5000/api/data-user/${UserId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                // Tambahkan header autentikasi jika diperlukan
                // 'Authorization': `Bearer ${yourToken}`
            },
            body: JSON.stringify(updatedData)
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(err => {
                    throw new Error(`Gagal menyimpan data: ${err.message || res.statusText}`);
                });
            }
            return res.json();
        })
        .then(response => {
            document.getElementById('nama').textContent = updatedData.nama;
            document.getElementById('email').textContent = updatedData.email;
            document.getElementById('nip').textContent = updatedData.nip;
            modal.classList.add('hidden');
            showToast('Profil berhasil diperbarui!', true);
        })
        .catch(error => {
            console.error('Error:', error);
            showToast(error.message || 'Gagal menyimpan data!', false);
        });
        });
    });

    const modalPassword = document.getElementById('modalEditPassword');
    const btnEditPassword = document.getElementById('btnEditPassword');
    const closeModalPassword = modalPassword.querySelector('#closeModal');
    const cancelEditPassword = modalPassword.querySelector('#cancelPasswordEdit');
    const formEditPassword = document.getElementById('formEditPassword');

    btnEditPassword.addEventListener('click', function() {
        // Kosongkan field password
        formEditPassword.reset();
        modalPassword.classList.remove('hidden');
    });

    closeModalPassword.addEventListener('click', function() {
        modalPassword.classList.add('hidden');
    });
    cancelEditPassword.addEventListener('click', function() {
        modalPassword.classList.add('hidden');
    });

    formEditPassword.addEventListener('submit', function(e) {
        e.preventDefault();

        const passwordLama = document.getElementById('old_password').value;
        const passwordBaru = document.getElementById('new_password').value;
        const konfirmasiPassword = document.getElementById('confirm_password').value;

        if (!passwordLama || !passwordBaru || !konfirmasiPassword) {
            showToast('Semua field password wajib diisi!', false);
            return;
        }
        if (passwordBaru !== konfirmasiPassword) {
            showToast('Konfirmasi password tidak cocok!', false);
            return;
        }

        UserId = {{ session('user.user_id') ?? 'null' }};

        // Kirim ke backend (ganti endpoint sesuai API Anda)
        fetch(`http://127.0.0.1:5000/api/data-user/${UserId}/change-password`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                old_password: passwordLama,
                new_password: passwordBaru,
                new_password_confirmation: konfirmasiPassword
            })
        })
        .then(res => {
            if (!res.ok) {
                return res.json().then(err => {
                    throw new Error(err.message || 'Gagal mengubah password!');
                });
            }
            return res.json();
        })
        .then(response => {
            modalPassword.classList.add('hidden');
            showToast('Password berhasil diubah!', true);
        })
        .catch(error => {
            showToast(error.message || 'Gagal mengubah password!', false);
        });
    });
</script>
@endsection