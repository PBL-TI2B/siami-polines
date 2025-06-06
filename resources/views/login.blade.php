<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Audit Mutu Internal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-400 to-purple-500">
    <!-- Page Loading -->
    <x-progress-bar />

    <!-- Background -->
    <div class="absolute inset-0 bg-cover bg-center opacity-30"
        style="background-image: url('/images/bg_login.png'); z-index: 0;"></div>

    <!-- Login Card -->
    <div
        class="relative z-10 w-full max-w-md rounded-lg border-2 border-purple-500 bg-white/90 p-8 text-center shadow-lg">

        <!-- Logo -->
        <div class="mb-4 flex justify-center">
            <img src="/images/Logo-Polines.png" alt="Logo" class="h-14">
        </div>

        <!-- Title -->
        <h2 class="mb-6 text-xl font-semibold text-gray-800">Audit Mutu Internal</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            @if ($errors->any())
                <div class="text-sm text-red-600">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- EMAIL -->
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email" required
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-center text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter your email" />
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    </div>
                </div>
            </div>

            <!-- PASSWORD -->
            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-center text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter your password" />
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                        <!-- Eye Icon -->
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
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
                class="w-full rounded-lg bg-blue-800 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-900 focus:outline-none focus:ring-4 focus:ring-blue-300">
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
              c-.186-.331-.407-.65-.66-.954M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18" />` :
                `<path stroke-linecap="round" stroke-linejoin="round"
            d="M2.25 12c0 1.25 3.75 6.75 9.75 6.75S21.75 13.25 21.75 12
              18 5.25 12 5.25 2.25 10.75 2.25 12z" />
         <path stroke-linecap="round" stroke-linejoin="round"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
        });
    </script>
</body>

</html>
