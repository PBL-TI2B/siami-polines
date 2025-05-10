@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Data User', 'url' => route('admin.data-user.index')],
            ['label' => 'Tambah User'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-4 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Daftar User
        </h1>

        <!-- Form -->
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <form id="user-form" enctype="multipart/form-data">
                @csrf

                <!-- Upload Foto -->
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Upload Foto</label>
                    <div class="flex items-center">
                        <div class="mr-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-200">
                            <img id="preview-image" class="hidden h-16 w-16 rounded-full object-cover" src="#"
                                alt="Preview">
                            <svg id="default-icon" class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label for="file-upload"
                                class="inline-flex cursor-pointer items-center rounded-lg bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-900">
                                Pilih File
                            </label>
                            <input id="file-upload" name="foto" type="file" class="hidden" accept="image/*">
                            <p id="file-name" class="text-sm text-gray-500 dark:text-gray-400">Tidak ada file yang dipilih
                            </p>
                        </div>
                    </div>
                    <p id="foto-error" class="mt-1 hidden text-sm text-red-500"></p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Kolom Kiri -->
                    <div>
                        <!-- Nama -->
                        <div class="mb-4">
                            <label for="nama"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Nama</label>
                            <input type="text" id="nama" name="nama" placeholder="Masukkan nama anda"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <p id="nama-error" class="mt-1 hidden text-sm text-red-500"></p>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" id="email" name="email" placeholder="Masukkan email anda"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <p id="email-error" class="mt-1 hidden text-sm text-red-500"></p>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div>
                        <!-- NIP -->
                        <div class="mb-4">
                            <label for="nip"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">NIP</label>
                            <input type="text" id="nip" name="nip" placeholder="NIP"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <p id="nip-error" class="mt-1 hidden text-sm text-red-500"></p>
                        </div>

                        <!-- Password -->
                        <div class="relative mb-4">
                            <label for="password"
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                            <input type="password" id="password" name="password" placeholder="********"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                            <button type="button" id="toggle-password"
                                class="absolute inset-y-0 right-0 mt-6 flex items-center pr-3">
                                <svg id="eye-open" class="hidden h-5 w-5 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <svg id="eye-closed" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                    </path>
                                </svg>
                            </button>
                            <p id="password-error" class="mt-1 hidden text-sm text-red-500"></p>
                        </div>
                    </div>
                </div>

                <!-- Unit Kerja -->
                <div class="mb-6">
                    <label for="unit_kerja_id"
                        class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Unit Kerja</label>
                    <select name="unit_kerja_id" id="unit_kerja_id"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        <option value="">Pilih Unit Kerja</option>
                        @foreach (\App\Models\UnitKerja::all() as $unit)
                            <option value="{{ $unit->id ?? $unit->nama_unit_kerja }}">{{ $unit->nama_unit_kerja }}</option>
                        @endforeach
                    </select>
                    <p id="unit_kerja_id-error" class="mt-1 hidden text-sm text-red-500"></p>
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-200">Role</label>
                    <div class="flex flex-wrap gap-4">
                        @foreach (['Admin', 'Admin Unit', 'Auditor', 'Auditee', 'Kepala PMPP'] as $role)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="roles[]" value="{{ $role }}"
                                    class="h-4 w-4 rounded border-gray-200 bg-gray-100 text-sky-800 focus:ring-sky-500 dark:border-gray-500 dark:bg-gray-600 dark:focus:ring-sky-600">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">{{ $role }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p id="roles-error" class="mt-1 hidden text-sm text-red-500"></p>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-3">
                    <x-button type="submit" color="sky" icon="heroicon-o-check" id="submit-button">
                        Simpan Perubahan
                    </x-button>
                    <x-button color="gray" icon="heroicon-o-x-mark" href="{{ route('admin.data-user.index') }}">
                        Batal
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle Password Visibility
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            }
        });

        // Image Preview
        document.getElementById('file-upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewImage = document.getElementById('preview-image');
            const defaultIcon = document.getElementById('default-icon');
            const fileName = document.getElementById('file-name');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    defaultIcon.classList.add('hidden');
                    fileName.textContent = file.name;
                };
                reader.readAsDataURL(file);
            } else {
                previewImage.classList.add('hidden');
                defaultIcon.classList.remove('hidden');
                fileName.textContent = 'Tidak ada file yang dipilih';
            }
        });

        // Form Submission
        document.getElementById('user-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            // Reset error messages
            document.querySelectorAll('[id$="-error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
            document.querySelectorAll('input, select').forEach(el => {
                el.classList.remove('border-red-500');
            });

            const form = e.target;
            const formData = new FormData(form);
            const roles = Array.from(form.querySelectorAll('input[name="roles[]"]:checked')).map(input => input
                .value);

            // Append roles to FormData
            formData.delete('roles[]');
            roles.forEach(role => formData.append('roles[]', role));

            const submitButton = document.getElementById('submit-button');
            const originalButtonText = submitButton.textContent;
            submitButton.disabled = true;
            submitButton.textContent = 'Menyimpan...';

            try {
                const response = await fetch('/api/users', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: formData,
                });

                const result = await response.json();

                if (response.ok) {
                    alert(result.message);
                    window.location.href = '{{ route('admin.data-user.index') }}';
                } else {
                    const errors = result.errors || {
                        message: result.message || 'Gagal membuat user'
                    };
                    if (errors.message) {
                        alert('Kesalahan: ' + errors.message);
                    } else {
                        for (const [field, messages] of Object.entries(errors)) {
                            const errorElement = document.getElementById(`${field}-error`);
                            const inputElement = form.querySelector(`[name="${field}"]`) || form.querySelector(
                                `[name="${field}[]"]`);
                            if (errorElement && inputElement) {
                                errorElement.textContent = messages.join(', ');
                                errorElement.classList.remove('hidden');
                                inputElement.classList.add('border-red-500');
                            } else if (field === 'roles') {
                                const rolesError = document.getElementById('roles-error');
                                rolesError.textContent = messages.join(', ');
                                rolesError.classList.remove('hidden');
                            }
                        }
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim formulir.');
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = originalButtonText;
            }
        });
    </script>
@endsection
