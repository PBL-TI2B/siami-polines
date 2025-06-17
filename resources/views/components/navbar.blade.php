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
                <!-- Search di sebelah logo (desktop) -->
                <form action="#" method="GET" class="hidden md:ml-6 md:block">
                    <label for="topbar-search" class="sr-only">Cari</label>
                    <div class="relative w-64">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5 text-sky-300 dark:text-sky-400" />
                        </div>
                        <input type="text" name="search" id="topbar-search"
                            class="block w-full rounded-lg border border-sky-500 bg-sky-700 p-2.5 pl-10 text-sm text-sky-100 placeholder-sky-300 focus:border-sky-300 focus:ring-sky-300 dark:border-sky-700 dark:bg-sky-900 dark:text-sky-200 dark:placeholder-sky-500 dark:focus:border-sky-500 dark:focus:ring-sky-500"
                            placeholder="Cari..." />
                    </div>
                </form>
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
                    <img class="h-8 w-8 rounded-full"
                        src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png"
                        alt="Foto pengguna">
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
                <img class="h-8 w-8 rounded-full"
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR6G7fCMB6PcaJ-2N-do059HA3pRP746JM_HvSANwCtasmvwC8PlJEq7vmK&s=10 "
                    alt="Foto pengguna">
            </button>
            <!-- User Dropdown (desktop) -->
            <div class="z-50 my-4 hidden w-56 list-none divide-y divide-sky-600 rounded-xl bg-sky-700 text-base shadow dark:divide-sky-800 dark:bg-sky-800"
                id="dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm font-semibold text-sky-100 dark:text-sky-200">
                        {{ session('user.nama', 'Guest') }} </span>
                    <span
                        class="block truncate text-sm text-sky-200 dark:text-sky-300">{{ session('user.email', 'Guest') }}</span>
                </div>
                <ul class="py-1 text-sky-200 dark:text-sky-300" aria-labelledby="dropdown">
                    <li>
                        <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100">Profil Saya</a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full px-4 py-2 text-left text-sm text-sky-200 hover:bg-sky-100 hover:text-sky-800 dark:hover:bg-sky-700 dark:hover:text-sky-200">
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
                    <span class="block text-sm font-semibold text-sky-100 dark:text-sky-200">
                        {{ session('user.nama', 'Guest') }} </span>
                    <span
                        class="block truncate text-sm text-sky-200 dark:text-sky-300">{{ session('user.email', 'Guest') }}</span>
                </div>
                <ul class="py-1 text-sky-200 dark:text-sky-300" aria-labelledby="dropdown-mobile">
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-sm hover:bg-sky-100 hover:text-sky-800 dark:hover:bg-sky-700 dark:hover:text-sky-200">Profil
                            Saya</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 text-sm hover:bg-sky-100 hover:text-sky-800 dark:hover:bg-sky-700 dark:hover:text-sky-200">Pengaturan
                            Akun</a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full px-4 py-2 text-left text-sm text-sky-200 hover:bg-sky-100 hover:text-sky-800 dark:hover:bg-sky-700 dark:hover:text-sky-200">
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
