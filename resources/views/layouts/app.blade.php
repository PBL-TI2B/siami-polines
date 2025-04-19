<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiAMI Polines - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col min-h-screen">
        <!-- Navbar -->
        <x-navbar />

        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main Content -->
        <main class="p-4 md:ml-64 h-auto pt-22 bg-gray-50 dark:bg-gray-900">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <!-- <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script> -->
</body>

</html>
