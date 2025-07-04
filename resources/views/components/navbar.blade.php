<nav
    class="fixed left-0 right-0 top-0 z-50 border-b border-sky-700 bg-sky-800 px-4 py-3 dark:border-sky-800 dark:bg-sky-900">
    <div class="flex flex-wrap items-center justify-between">
        <!-- Logo & Toggle -->
        <div class="flex w-full items-center justify-between md:w-auto">
            <div class="flex items-center">
                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar"
                    class="mr-2 cursor-pointer rounded-lg p-2 text-sky-200 hover:bg-sky-100 hover:text-sky-800 focus:bg-sky-100 focus:ring-2 focus:ring-sky-300 md:hidden dark:text-sky-300 dark:hover:bg-sky-700 dark:hover:text-white dark:focus:bg-sky-700 dark:focus:ring-sky-600">
                    <x-heroicon-o-bars-3 class="h-6 w-6" />
                    <span class="sr-only">Buka sidebar</span>
                </button>
                <a href="{{ route('admin.dashboard.index') }}" class="mr-4 flex items-center justify-between md:ml-2">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-8">
                    <span
                        class="ml-2 self-center whitespace-nowrap text-xl font-semibold text-white md:text-2xl dark:text-gray-200">
                        SiAMI Polines
                    </span>
                </a>
            </div>
            <!-- Mobile User Menu Button -->
            <div class="flex items-center md:hidden">
                <!-- Dark Mode Toggle (mobile) -->
                <button type="button" id="theme-toggle"
                    class="mr-1 rounded-lg p-2 text-sky-200 transition-all duration-200 hover:bg-sky-100 hover:text-sky-800 focus:ring-4 focus:ring-sky-300 dark:text-sky-300 dark:hover:bg-sky-700 dark:hover:text-white dark:focus:ring-sky-600">
                    <span class="sr-only">Toggle dark mode</span>
                    <x-heroicon-o-sun class="hidden h-6 w-6 dark:block" />
                    <x-heroicon-o-moon class="block h-6 w-6 dark:hidden" />
                </button>
                <!-- User Menu Button (mobile) -->
                <button type="button"
                    class="ml-2 flex rounded-full bg-sky-700 text-sm focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600"
                    id="user-menu-button-mobile" aria-expanded="false" data-dropdown-toggle="dropdown-mobile">
                    <span class="sr-only">Buka menu pengguna</span>
                    @php
                        $userName = session('user.nama', 'Guest');
                        $initials = collect(explode(' ', $userName))
                            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                            ->take(2)
                            ->join('');
                        $colors = [
                            'bg-gradient-to-br from-red-400 to-pink-500',
                            'bg-gradient-to-br from-blue-400 to-indigo-500',
                            'bg-gradient-to-br from-green-400 to-teal-500',
                            'bg-gradient-to-br from-yellow-400 to-orange-500',
                            'bg-gradient-to-br from-purple-400 to-violet-500',
                            'bg-gradient-to-br from-pink-400 to-rose-500',
                            'bg-gradient-to-br from-indigo-400 to-blue-500',
                            'bg-gradient-to-br from-cyan-400 to-blue-500',
                            'bg-gradient-to-br from-orange-400 to-red-500',
                            'bg-gradient-to-br from-emerald-400 to-green-500',
                        ];
                        $colorIndex = strlen($userName) % count($colors);
                        $profileColor = $colors[$colorIndex];
                    @endphp
                    <div
                        class="{{ $profileColor }} flex h-8 w-8 items-center justify-center rounded-full text-xs font-semibold text-white">
                        {{ $initials }}
                    </div>
                </button>
            </div>
        </div>
        <!-- Right Actions (desktop) -->
        <div class="hidden w-auto md:flex md:items-center md:justify-end md:space-x-2 lg:order-2">
            <!-- Dark Mode Toggle (desktop) -->
            <button type="button" id="theme-toggle-desktop"
                class="mr-1 rounded-lg p-2 text-sky-200 transition-all duration-200 hover:bg-sky-100 hover:text-sky-800 focus:ring-4 focus:ring-sky-300 dark:text-sky-300 dark:hover:bg-sky-700 dark:hover:text-white dark:focus:ring-sky-600">
                <span class="sr-only">Toggle dark mode</span>
                <x-heroicon-o-sun class="hidden h-6 w-6 dark:block" />
                <x-heroicon-o-moon class="block h-6 w-6 dark:hidden" />
            </button>
            <!-- Notifications -->
            <!-- <button type="button" data-dropdown-toggle="notification-dropdown"
                class="mr-1 hidden rounded-lg p-2 text-sky-200 hover:bg-sky-100 hover:text-sky-800 focus:ring-4 focus:ring-sky-300 md:block dark:text-sky-300 dark:hover:bg-sky-700 dark:hover:text-white dark:focus:ring-sky-600">
                <span class="sr-only">Lihat notifikasi</span>
                <x-heroicon-o-bell class="h-6 w-6" />
            </button> -->
            <!-- Notification Dropdown -->
            <div class="z-50 my-4 hidden max-w-sm list-none divide-y divide-sky-600 overflow-hidden rounded-xl bg-sky-700 text-base shadow-lg dark:divide-sky-800 dark:bg-sky-800"
                id="notification-dropdown">
                <!-- ...existing code... -->
            </div>
            <!-- Apps -->
            <!-- <button type="button" data-dropdown-toggle="apps-dropdown"
                class="mr-1 hidden rounded-lg p-2 text-sky-200 hover:bg-sky-100 hover:text-sky-800 focus:ring-4 focus:ring-sky-300 md:block dark:text-sky-300 dark:hover:bg-sky-700 dark:hover:text-white dark:focus:ring-sky-600">
                <x-heroicon-o-squares-2x2 class="h-6 w-6" />
            </button> -->
            <!-- Apps Dropdown -->
            <div class="z-50 my-4 hidden max-w-sm list-none divide-y divide-sky-600 overflow-hidden rounded-xl bg-sky-700 text-base shadow-lg dark:divide-sky-800 dark:bg-sky-800"
                id="apps-dropdown">
                <!-- ...existing code... -->
            </div>
            <!-- User Menu (desktop) -->
            <button type="button"
                class="mx-3 flex rounded-full bg-sky-700 text-sm focus:ring-4 focus:ring-sky-300 md:mr-0 dark:focus:ring-sky-600"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                <span class="sr-only">Buka menu pengguna</span>
                <div
                    class="{{ $profileColor }} flex h-8 w-8 items-center justify-center rounded-full text-xs font-semibold text-white">
                    {{ $initials }}
                </div>
            </button>
            <!-- User Dropdown (desktop) -->
            <div class="z-50 my-4 hidden w-56 list-none divide-y divide-sky-600 rounded-xl bg-sky-700 text-base shadow dark:divide-sky-800 dark:bg-sky-800"
                id="dropdown">
                <div class="px-4 py-3">
                    <div class="mb-2">
                        <span class="block text-sm font-semibold text-sky-100 dark:text-sky-200">
                            {{ session('user.nama', 'Guest') }}
                        </span>
                        <span class="block truncate text-sm text-sky-200 dark:text-sky-300">
                            {{ session('user.email', 'Guest') }}
                        </span>
                    </div>
                </div>
                <ul class="py-1 text-sky-200 dark:text-sky-300" aria-labelledby="dropdown">
                    <li>
                        <a href="{{ route('profile') }}"
                            class="block px-4 py-2 hover:bg-sky-100 hover:text-sky-800 dark:hover:bg-sky-700 dark:hover:text-sky-200">
                            <div class="flex items-center">
                                <x-heroicon-o-user class="mr-2 h-4 w-4" />
                                Profil Saya
                            </div>
                        </a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center px-4 py-2 text-left text-sm text-sky-200 hover:bg-sky-100 hover:text-sky-800 dark:hover:bg-sky-700 dark:hover:text-sky-200">
                                <x-heroicon-o-arrow-right-on-rectangle class="mr-2 h-4 w-4" />
                                Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <!-- User Dropdown (mobile) -->
        <div class="md:hidden">
            <div class="absolute right-4 z-50 my-4 mt-2 hidden w-56 list-none divide-y divide-sky-600 rounded-xl bg-sky-700 text-base shadow dark:divide-sky-800 dark:bg-sky-800"
                id="dropdown-mobile">
                <div class="px-4 py-3">
                    <div class="mb-2">
                        <span class="block text-sm font-semibold text-sky-100 dark:text-sky-200">
                            {{ session('user.nama', 'Guest') }}
                        </span>
                        <span class="block truncate text-sm text-sky-200 dark:text-sky-300">
                            {{ session('user.email', 'Guest') }}
                        </span>
                    </div>
                </div>
                <ul class="py-1 text-sky-200 dark:text-sky-300" aria-labelledby="dropdown-mobile">
                    <li>
                        <a href="{{ route('profile') }}"
                            class="block px-4 py-2 text-sm hover:bg-sky-100 hover:text-sky-800 dark:hover:bg-sky-700 dark:hover:text-sky-200">
                            <div class="flex items-center">
                                <x-heroicon-o-user class="mr-2 h-4 w-4" />
                                Profil Saya
                            </div>
                        </a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center px-4 py-2 text-left text-sm text-sky-200 hover:bg-sky-100 hover:text-sky-800 dark:hover:bg-sky-700 dark:hover:text-sky-200">
                                <x-heroicon-o-arrow-right-on-rectangle class="mr-2 h-4 w-4" />
                                Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Dark Mode Script -->
<script>
    // Toggle dark mode for both desktop and mobile
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleBtnDesktop = document.getElementById('theme-toggle-desktop');
    const htmlElement = document.documentElement;

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        htmlElement.classList.add(savedTheme);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        htmlElement.classList.add('dark');
    }

    function toggleDarkMode() {
        htmlElement.classList.toggle('dark');
        const isDark = htmlElement.classList.contains('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    if (themeToggleBtn) themeToggleBtn.addEventListener('click', toggleDarkMode);
    if (themeToggleBtnDesktop) themeToggleBtnDesktop.addEventListener('click', toggleDarkMode);

    // Dropdown user menu toggle for mobile
    const userMenuBtnMobile = document.getElementById('user-menu-button-mobile');
    const dropdownMobile = document.getElementById('dropdown-mobile');
    if (userMenuBtnMobile && dropdownMobile) {
        userMenuBtnMobile.addEventListener('click', function() {
            dropdownMobile.classList.toggle('hidden');
        });
        document.addEventListener('click', function(e) {
            if (!userMenuBtnMobile.contains(e.target) && !dropdownMobile.contains(e.target)) {
                dropdownMobile.classList.add('hidden');
            }
        });
    }
    // Dropdown user menu toggle for desktop
    const userMenuBtn = document.getElementById('user-menu-button');
    const dropdown = document.getElementById('dropdown');
    if (userMenuBtn && dropdown) {
        userMenuBtn.addEventListener('click', function() {
            dropdown.classList.toggle('hidden');
        });
        document.addEventListener('click', function(e) {
            if (!userMenuBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    }
</script>
