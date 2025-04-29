<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Audit Mutu Internal</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 to-purple-500 relative">
  <!-- Background semi-transparent card -->
  <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('/images/bg_login.png'); z-index: 0;"></div>

  <!-- Login Card -->
  <div class="relative z-10 bg-white/90 rounded-lg border-2 border-purple-500 p-8 w-full max-w-md shadow-lg text-center">
    <!-- Logo -->
    <div class="flex justify-center mb-4">
      <img src="/images/Logo-Polines.png" alt="Logo" class="h-14">
    </div>
    
    <!-- Title -->
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Audit Mutu Internal</h2>

    <form method="POST" action="{{ route('login') }}" class="mb-4 relative">
      @csrf
      @if($errors->any())
        <div class="mb-4 text-red-600 text-sm">
          {{ $errors->first() }}
        </div>
      @endif
    
      <!-- EMAIL -->
      <div class="mb-4 text-left relative">
        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <input name="email" type="email" required
          class="w-full pl-4 pr-10 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Enter your email" />
        <div class="absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-400">
          <!-- Email Icon -->
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M21.75 7.5v9A2.25 2.25 0 0119.5 18.75H4.5A2.25 2.25 0 012.25 16.5v-9M21.75 7.5l-9.75 6-9.75-6" />
          </svg>
        </div>
      </div>
    
      <!-- PASSWORD -->
      <div class="mb-6 text-left relative">
        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input id="password" name="password" type="password" required
          class="w-full pl-4 pr-10 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Enter your password" />
        <button type="button" id="togglePassword"
          class="absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
          <!-- Eye Icon -->
          <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M2.25 12c0 1.25 3.75 6.75 9.75 6.75S21.75 13.25 21.75 12
                  18 5.25 12 5.25 2.25 10.75 2.25 12z" />
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </button>
      </div>
    
      <button type="submit"
        class="w-full bg-blue-800 text-white py-2 rounded hover:bg-blue-900 transition">
        Masuk
      </button>
    </form>

    <p>Belum punya akun? <a href="register" class="text-blue-700 hover:underline">Daftar sekarang</a></p>
  </div>
  <script>
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");
  
    togglePassword.addEventListener("click", () => {
      const type = passwordInput.type === "password" ? "text" : "password";
      passwordInput.type = type;
  
      // Toggle eye icon
      if (type === "text") {
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M3.98 8.223a10.477 10.477 0 00-.733 1.064C2.25 10.75 5.25 16.5 12 16.5s9.75-5.75 9.75-6.75
              c-.186-.331-.407-.65-.66-.954M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />
        `;
      } else {
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M2.25 12c0 1.25 3.75 6.75 9.75 6.75S21.75 13.25 21.75 12
               18 5.25 12 5.25 2.25 10.75 2.25 12z" />
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        `;
      }
    });
  </script> 
</body>
</html>