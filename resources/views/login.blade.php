<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Audit Mutu Internal</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.css" />
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 to-purple-500 relative">

  <!-- Background -->
  <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('/images/bg_login.png'); z-index: 0;"></div>

  <!-- Login Card -->
  <div class="relative z-10 bg-white/90 rounded-lg border-2 border-purple-500 p-8 w-full max-w-md shadow-lg text-center">

    <!-- Logo -->
    <div class="flex justify-center mb-4">
      <img src="/images/Logo-Polines.png" alt="Logo" class="h-14">
    </div>

    <!-- Title -->
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Audit Mutu Internal</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf

      @if($errors->any())
        <div class="text-red-600 text-sm">
          {{ $errors->first() }}
        </div>
      @endif

      <!-- EMAIL -->
      <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
        <div class="relative">
          <input type="email" name="email" id="email" required
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
            placeholder="Enter your email" />
          <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
            {{-- <!-- Email Icon -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5"
              viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M21.75 7.5v9A2.25 2.25 0 0119.5 18.75H4.5A2.25 2.25 0 012.25 16.5v-9M21.75 7.5l-9.75 6-9.75-6" />
            </svg> --}}
          </div>
        </div>
      </div>

      <!-- PASSWORD -->
      <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
        <div class="relative">
          <input type="password" name="password" id="password" required
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-10 p-2.5"
            placeholder="Enter your password" />
          <button type="button" id="togglePassword"
            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
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
      </div>

      <!-- Submit Button -->
      <button type="submit"
        class="w-full text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition">
        Masuk
      </button>
    </form>

    {{-- <p class="mt-4 text-sm text-gray-700">Belum punya akun? <a href="register" class="text-blue-700 hover:underline">Daftar sekarang</a></p> --}}
  </div>

  <!-- Toggle Password Script -->
  <script>
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");

    togglePassword.addEventListener("click", () => {
      const type = passwordInput.type === "password" ? "text" : "password";
      passwordInput.type = type;

      eyeIcon.innerHTML = type === "text" ?
        `<path stroke-linecap="round" stroke-linejoin="round"
            d="M3.98 8.223a10.477 10.477 0 00-.733 1.064C2.25 10.75 5.25 16.5 12 16.5s9.75-5.75 9.75-6.75
              c-.186-.331-.407-.65-.66-.954M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />`
        :
        `<path stroke-linecap="round" stroke-linejoin="round"
            d="M2.25 12c0 1.25 3.75 6.75 9.75 6.75S21.75 13.25 21.75 12
              18 5.25 12 5.25 2.25 10.75 2.25 12z" />
         <path stroke-linecap="round" stroke-linejoin="round"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
    });
  </script>
</body>
</html>