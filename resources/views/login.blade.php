<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Audit Mutu Internal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-400 to-purple-500">
    <x-progress-bar />

    <div class="absolute inset-0 bg-cover bg-center opacity-30"
        style="background-image: url('/images/bg_login.png'); z-index: 0;"></div>

    <div
        class="relative z-10 w-full max-w-md rounded-lg border-2 border-purple-500 bg-white/90 p-8 text-center shadow-lg">

        <div class="mb-4 flex justify-center">
            <img src="/images/Logo-Polines.png" alt="Logo" class="h-14">
        </div>

        <h2 class="mb-6 text-xl font-semibold text-gray-800">Audit Mutu Internal</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            @if ($errors->any())
                <div class="text-sm text-red-600">
                    {{ $errors->first() }}
                </div>
            @endif

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

            <div>
                <label for="password" class="mb-2 block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-center text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter your password" />
                    <button type="button" id="togglePassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                        <x-heroicon-o-eye id="eyeIcon" class="h-5 w-5" />
                        <x-heroicon-o-eye-slash id="eyeSlashIcon" class="hidden h-5 w-5" />
                    </button>
                </div>
            </div>

            <button type="submit"
                class="w-full rounded-lg bg-blue-800 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-900 focus:outline-none focus:ring-4 focus:ring-blue-300">
                Masuk
            </button>
        </form>

        {{-- <p class="mt-4 text-sm text-gray-700">Belum punya akun? <a href="register" class="text-blue-700 hover:underline">Daftar sekarang</a></p> --}}
    </div>

    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");
        const eyeSlashIcon = document.getElementById("eyeSlashIcon");

        togglePassword.addEventListener("click", () => {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;

            if (type === "text") {
                eyeIcon.classList.add("hidden");
                eyeSlashIcon.classList.remove("hidden");
            } else {
                eyeIcon.classList.remove("hidden");
                eyeSlashIcon.classList.add("hidden");
            }
        });
    </script>
</body>
</html>