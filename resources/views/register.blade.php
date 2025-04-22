<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register - Audit Mutu Internal</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 to-purple-500 relative">
  <!-- Background semi-transparent -->
  <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('/images/bg_login.png'); z-index: 0;"></div>

  <!-- Register Card -->
  <div class="relative z-10 bg-white/90 rounded-lg border-2 border-purple-500 p-8 w-full max-w-md shadow-lg text-center">
    <!-- Logo -->
    <div class="flex justify-center mb-4">
      <img src="/images/Logo-Polines.png" alt="Logo" class="h-14">
    </div>

    <!-- Title -->
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Registrasi Pengguna</h2>

    <!-- Form -->
    <form id="registerForm" class="space-y-4 text-left">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
        <input type="text" id="nama" class="w-full px-4 py-2 border rounded" required />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
        <input type="text" id="nip" class="w-full px-4 py-2 border rounded" required />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input type="email" id="email" class="w-full px-4 py-2 border rounded" required />
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" id="password" class="w-full px-4 py-2 border rounded" required />
      </div>
      <button type="submit" class="w-full bg-blue-800 text-white py-2 rounded hover:bg-blue-900 transition">Daftar</button>
    </form>

    <!-- Link ke login -->
    <p class="mt-4 text-sm">Sudah punya akun? <a href="/login" style="color: blue;">Masuk sekarang</a></p>
  </div>

  <!-- Script -->
  <script>
    const form = document.getElementById('registerForm');
    form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const data = {
        role_id: 3, // default role
        unit_kerja_id: 100, // default unit kerja
        nama: document.getElementById('nama').value,
        nip: document.getElementById('nip').value,
        email: document.getElementById('email').value,
        password: document.getElementById('password').value,
    };

    try {
        const response = await fetch('http://localhost:8000/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
        });

        const result = await response.json();
        if (response.ok) {
        alert("Registrasi berhasil! Token: " + result.token);
        window.location.href = '/login'; // arahkan ke route Laravel
        } else {
        alert("Error: " + JSON.stringify(result.errors));
        }
    } catch (err) {
        alert("Gagal terhubung ke server: " + err.message);
    }
    });
  </script>
</body>
</html>
