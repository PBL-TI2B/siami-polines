<nav
    class="fixed left-0 right-0 top-0 z-50 border-b border-sky-700 bg-sky-800 px-6 py-3 dark:border-sky-800 dark:bg-sky-900">
    <div class="flex flex-wrap items-center justify-between">
        <!-- Logo & Toggle -->
        <div class="flex items-center justify-start">
            <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar"
                class="mr-2 cursor-pointer rounded-lg p-2 text-sky-200 hover:bg-sky-100 hover:text-sky-800 focus:bg-sky-100 focus:ring-2 focus:ring-sky-300 md:hidden dark:text-sky-300 dark:hover:bg-sky-700 dark:hover:text-white dark:focus:bg-sky-700 dark:focus:ring-sky-600">
                <x-heroicon-o-bars-3 class="h-6 w-6" />
                <span class="sr-only">Buka sidebar</span>
            </button>
            <a href="{{ route('admin.dashboard.index') }}" class="mr-4 flex items-center justify-between">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-8">
                <span
                    class="ml-2 self-center whitespace-nowrap text-xl font-semibold text-white md:text-2xl dark:text-gray-200">
                    SiAMI Polines
                </span>
            </a>
            <!-- Search -->
            <form action="#" method="GET" class="hidden md:block md:pl-2">
                <label for="topbar-search" class="sr-only">Cari</label>
                <div class="relative md:w-64">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <x-heroicon-o-magnifying-glass class="h-5 w-5 text-sky-300 dark:text-sky-400" />
                    </div>
                    <input type="text" name="search" id="topbar-search"
                        class="block w-full rounded-lg border border-sky-500 bg-sky-700 p-2.5 pl-10 text-sm text-sky-100 placeholder-sky-300 focus:border-sky-300 focus:ring-sky-300 dark:border-sky-700 dark:bg-sky-900 dark:text-sky-200 dark:placeholder-sky-500 dark:focus:border-sky-500 dark:focus:ring-sky-500"
                        placeholder="Cari..." />
                </div>
            </form>
        </div>

        <!-- Right Actions -->
        <div class="flex items-center lg:order-2">
            <!-- Mobile Search Toggle -->
            <button type="button" data-drawer-target="sidebar" data-drawer-toggle="sidebar"
                class="mr-1 hidden rounded-lg p-2 text-sky-200 hover:bg-sky-100 hover:text-sky-800 focus:ring-4 focus:ring-sky-300 dark:text-sky-300 dark:hover:bg-sky-700 dark:hover:text-white dark:focus:ring-sky-600">
                <span class="sr-only">Buka pencarian</span>
                <x-heroicon-o-magnifying-glass class="h-6 w-6" />
            </button>
            <!-- Dark Mode Toggle -->
            <button type="button" id="theme-toggle"
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
                <div
                    class="block bg-sky-600 px-4 py-2 text-center text-base font-medium text-sky-100 dark:bg-sky-700 dark:text-sky-200">
                    Notifikasi
                </div>
                <div>
                    <a href="#"
                        class="flex border-b px-4 py-3 hover:bg-sky-100 dark:border-sky-800 dark:hover:bg-sky-700">
                        <div class="flex-shrink-0">
                            <img class="h-11 w-11 rounded-full"
                                src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png"
                                alt="Bonnie Green avatar">
                            <div
                                class="absolute -mt-5 ml-6 flex h-5 w-5 items-center justify-center rounded-full border border-sky-200 bg-sky-700 dark:border-sky-800">
                                <x-heroicon-o-envelope class="h-3 w-3 text-sky-200" />
                            </div>
                        </div>
                        <div class="w-full pl-3">
                            <div class="mb-1.5 text-sm font-normal text-sky-200 dark:text-sky-300">
                                Pesan baru dari <span class="font-semibold text-sky-100 dark:text-sky-200">Bonnie
                                    Green</span>: "Hai, apa kabar? Siap untuk presentasi?"
                            </div>
                            <div class="text-xs font-medium text-sky-400 dark:text-sky-500">Beberapa saat lalu</div>
                        </div>
                    </a>
                </div>
                <a href="#"
                    class="text-md block bg-sky-600 py-2 text-center font-medium text-sky-100 hover:bg-sky-100 dark:bg-sky-700 dark:text-sky-200 dark:hover:text-sky-800 dark:hover:underline">
                    <div class="inline-flex items-center">
                        <x-heroicon-o-eye class="mr-2 h-4 w-4 text-sky-300 dark:text-sky-400" />
                        Lihat semua
                    </div>
                </a>
            </div>
            <!-- Apps -->
            <!-- <button type="button" data-dropdown-toggle="apps-dropdown"
                class="mr-1 hidden rounded-lg p-2 text-sky-200 hover:bg-sky-100 hover:text-sky-800 focus:ring-4 focus:ring-sky-300 md:block dark:text-sky-300 dark:hover:bg-sky-700 dark:hover:text-white dark:focus:ring-sky-600">
                <x-heroicon-o-squares-2x2 class="h-6 w-6" />
            </button> -->
            <!-- Apps Dropdown -->
            <div class="z-50 my-4 hidden max-w-sm list-none divide-y divide-sky-600 overflow-hidden rounded-xl bg-sky-700 text-base shadow-lg dark:divide-sky-800 dark:bg-sky-800"
                id="apps-dropdown">
                <div
                    class="block bg-sky-600 px-4 py-2 text-center text-base font-medium text-sky-100 dark:bg-sky-700 dark:text-sky-200">
                    Aplikasi
                </div>
                <div class="grid grid-cols-3 gap-4 p-4">
                    <a href="#"
                        class="group block rounded-lg p-4 text-center hover:bg-sky-100 dark:hover:bg-sky-700">
                        <x-heroicon-o-shopping-cart
                            class="mx-auto mb-1 h-7 w-7 text-sky-300 group-hover:text-sky-800 dark:text-sky-400 dark:group-hover:text-sky-200" />
                        <div class="text-sm text-sky-100 dark:text-sky-200">Penjualan</div>
                    </a>
                    <a href="#"
                        class="group block rounded-lg p-4 text-center hover:bg-sky-100 dark:hover:bg-sky-700">
                        <x-heroicon-o-users
                            class="mx-auto mb-1 h-7 w-7 text-sky-300 group-hover:text-sky-800 dark:text-sky-400 dark:group-hover:text-sky-200" />
                        <div class="text-sm text-sky-100 dark:text-sky-200">Pengguna</div>
                    </a>
                </div>
            </div>
            <!-- User Menu -->
            <button type="button"
                class="mx-3 flex rounded-full bg-sky-700 text-sm focus:ring-4 focus:ring-sky-300 md:mr-0 dark:focus:ring-sky-600"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                <span class="sr-only">Buka menu pengguna</span>
                <img class="h-8 w-8 rounded-full"
                    src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png"
                    alt="Foto pengguna">
            </button>
            <!-- User Dropdown -->
            <div class="z-50 my-4 hidden w-56 list-none divide-y divide-sky-600 rounded-xl bg-sky-700 text-base shadow dark:divide-sky-800 dark:bg-sky-800"
                id="dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm font-semibold text-sky-100 dark:text-sky-200">Guest</span>
                    <span class="block truncate text-sm text-sky-200 dark:text-sky-300">guest@example.com</span>
                </div>
                <ul class="py-1 text-sky-200 dark:text-sky-300" aria-labelledby="dropdown">
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
    const themeToggleBtn = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        htmlElement.classList.add(savedTheme);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        htmlElement.classList.add('dark');
    }

    themeToggleBtn.addEventListener('click', () => {
        htmlElement.classList.toggle('dark');
        const isDark = htmlElement.classList.contains('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    });
</script>
