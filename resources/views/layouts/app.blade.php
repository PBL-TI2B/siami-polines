<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiAMI Polines - @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 antialiased dark:bg-gray-900">
    <div class="flex min-h-screen flex-col">
        <!-- Progress Bar -->
        <x-progress-bar />

        <!-- Navbar -->
        <x-navbar />

        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main Content -->
        <main class="pt-22 h-auto bg-gray-50 p-4 md:ml-64 dark:bg-gray-900">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>
