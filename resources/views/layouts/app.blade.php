<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>{{ config('app.name', 'SiAMI') }}</title>
</head>
<body class="font-inter bg-neutral-50">
    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <!-- Main Content -->
    <div class="ml-80">
        <!-- Header -->
        @include('layouts.partials.header')

        <!-- Page Content -->
        <main class="p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>