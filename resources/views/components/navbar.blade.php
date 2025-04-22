<nav
    class="bg-sky-800 border-b border-sky-700 px-6 py-3 dark:bg-sky-900 dark:border-sky-800 fixed left-0 right-0 top-0 z-50">
    <div class="flex flex-wrap justify-between items-center">
        <!-- Logo & Toggle -->
        <div class="flex justify-start items-center">
            <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar"
                class="p-2 mr-2 text-sky-200 rounded-lg cursor-pointer md:hidden hover:text-sky-800 hover:bg-sky-100 focus:bg-sky-100 dark:focus:bg-sky-700 focus:ring-2 focus:ring-sky-300 dark:focus:ring-sky-600 dark:text-sky-300 dark:hover:bg-sky-700 dark:hover:text-white">
                <x-heroicon-o-bars-3 class="w-6 h-6" />
                <span class="sr-only">Buka sidebar</span>
            </button>
            <a href="{{ route('dashboard.index') }}" class="flex items-center justify-between mr-4">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-8 h-8">
                <span
                    class="self-center text-xl md:text-2xl font-semibold whitespace-nowrap text-white dark:text-gray-200 ml-2">
                    SiAMI Polines
                </span>
            </a>
            <!-- Search -->
            <form action="#" method="GET" class="hidden md:block md:pl-2">
                <label for="topbar-search" class="sr-only">Cari</label>
                <div class="relative md:w-64">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5 text-sky-300 dark:text-sky-400" />
                    </div>
                    <input type="text" name="search" id="topbar-search"
                        class="bg-sky-700 border border-sky-500 text-sky-100 text-sm rounded-lg focus:ring-sky-300 focus:border-sky-300 block w-full pl-10 p-2.5 placeholder-sky-300 dark:bg-sky-900 dark:border-sky-700 dark:placeholder-sky-500 dark:text-sky-200 dark:focus:ring-sky-500 dark:focus:border-sky-500"
                        placeholder="Cari..." />
                </div>
            </form>
        </div>

        <!-- Right Actions -->
        <div class="flex items-center lg:order-2">
            <!-- Mobile Search Toggle -->
            <button type="button" data-drawer-target="sidebar" data-drawer-toggle="sidebar"
                class="hidden p-2 mr-1 text-sky-200 rounded-lg hover:text-sky-800 hover:bg-sky-100 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600 dark:text-sky-300 dark:hover:text-white dark:hover:bg-sky-700">
                <span class="sr-only">Buka pencarian</span>
                <x-heroicon-o-magnifying-glass class="w-6 h-6" />
            </button>
            <!-- Dark Mode Toggle -->
            <button type="button" id="theme-toggle"
                class="p-2 mr-1 text-sky-200 rounded-lg hover:text-sky-800 hover:bg-sky-100 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600 dark:text-sky-300 dark:hover:text-white dark:hover:bg-sky-700 transition-all duration-200">
                <span class="sr-only">Toggle dark mode</span>
                <x-heroicon-o-sun class="w-6 h-6 hidden dark:block" />
                <x-heroicon-o-moon class="w-6 h-6 block dark:hidden" />
            </button>
            <!-- Notifications -->
            <button type="button" data-dropdown-toggle="notification-dropdown"
                class="hidden md:block p-2 mr-1 text-sky-200 rounded-lg hover:text-sky-800 hover:bg-sky-100 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600 dark:text-sky-300 dark:hover:text-white dark:hover:bg-sky-700">
                <span class="sr-only">Lihat notifikasi</span>
                <x-heroicon-o-bell class="w-6 h-6" />
            </button>
            <!-- Notification Dropdown -->
            <div class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-sky-700 divide-y divide-sky-600 shadow-lg dark:divide-sky-800 dark:bg-sky-800 rounded-xl"
                id="notification-dropdown">
                <div
                    class="block py-2 px-4 text-base font-medium text-center text-sky-100 bg-sky-600 dark:bg-sky-700 dark:text-sky-200">
                    Notifikasi
                </div>
                <div>
                    <a href="#"
                        class="flex py-3 px-4 border-b hover:bg-sky-100 dark:hover:bg-sky-700 dark:border-sky-800">
                        <div class="flex-shrink-0">
                            <img class="w-11 h-11 rounded-full"
                                src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png"
                                alt="Bonnie Green avatar">
                            <div
                                class="flex absolute justify-center items-center ml-6 -mt-5 w-5 h-5 rounded-full border border-sky-200 bg-sky-700 dark:border-sky-800">
                                <x-heroicon-o-envelope class="w-3 h-3 text-sky-200" />
                            </div>
                        </div>
                        <div class="pl-3 w-full">
                            <div class="text-sky-200 font-normal text-sm mb-1.5 dark:text-sky-300">
                                Pesan baru dari <span class="font-semibold text-sky-100 dark:text-sky-200">Bonnie
                                    Green</span>: "Hai, apa kabar? Siap untuk presentasi?"
                            </div>
                            <div class="text-xs font-medium text-sky-400 dark:text-sky-500">Beberapa saat lalu</div>
                        </div>
                    </a>
                </div>
                <a href="#"
                    class="block py-2 text-md font-medium text-center text-sky-100 bg-sky-600 hover:bg-sky-100 dark:bg-sky-700 dark:text-sky-200 dark:hover:text-sky-800 dark:hover:underline">
                    <div class="inline-flex items-center">
                        <x-heroicon-o-eye class="mr-2 w-4 h-4 text-sky-300 dark:text-sky-400" />
                        Lihat semua
                    </div>
                </a>
            </div>
            <!-- Apps -->
            <button type="button" data-dropdown-toggle="apps-dropdown"
                class="hidden md:block p-2 mr-1 text-sky-200 rounded-lg hover:text-sky-800 hover:bg-sky-100 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600 dark:text-sky-300 dark:hover:text-white dark:hover:bg-sky-700">
                <x-heroicon-o-squares-2x2 class="w-6 h-6" />
            </button>
            <!-- Apps Dropdown -->
            <div class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-sky-700 divide-y divide-sky-600 shadow-lg dark:bg-sky-800 dark:divide-sky-800 rounded-xl"
                id="apps-dropdown">
                <div
                    class="block py-2 px-4 text-base font-medium text-center text-sky-100 bg-sky-600 dark:bg-sky-700 dark:text-sky-200">
                    Aplikasi
                </div>
                <div class="grid grid-cols-3 gap-4 p-4">
                    <a href="#"
                        class="block p-4 text-center rounded-lg hover:bg-sky-100 dark:hover:bg-sky-700 group">
                        <x-heroicon-o-shopping-cart
                            class="mx-auto mb-1 w-7 h-7 text-sky-300 group-hover:text-sky-800 dark:text-sky-400 dark:group-hover:text-sky-200" />
                        <div class="text-sm text-sky-100 dark:text-sky-200">Penjualan</div>
                    </a>
                    <a href="#"
                        class="block p-4 text-center rounded-lg hover:bg-sky-100 dark:hover:bg-sky-700 group">
                        <x-heroicon-o-users
                            class="mx-auto mb-1 w-7 h-7 text-sky-300 group-hover:text-sky-800 dark:text-sky-400 dark:group-hover:text-sky-200" />
                        <div class="text-sm text-sky-100 dark:text-sky-200">Pengguna</div>
                    </a>
                </div>
            </div>
            <!-- User Menu -->
            <button type="button"
                class="flex mx-3 text-sm bg-sky-700 rounded-full md:mr-0 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                <span class="sr-only">Buka menu pengguna</span>
                <img class="w-8 h-8 rounded-full"
                    src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png"
                    alt="Foto pengguna">
            </button>
            <!-- User Dropdown -->
            <div class="hidden z-50 my-4 w-56 text-base list-none bg-sky-700 divide-y divide-sky-600 shadow dark:bg-sky-800 dark:divide-sky-800 rounded-xl"
                id="dropdown">
                <div class="py-3 px-4">
                    <span class="block text-sm font-semibold text-sky-100 dark:text-sky-200">Guest</span>
                    <span class="block text-sm text-sky-200 truncate dark:text-sky-300">guest@example.com</span>
                </div>
                <ul class="py-1 text-sky-200 dark:text-sky-300" aria-labelledby="dropdown">
                    <li>
                        <a href="#"
                            class="block py-2 px-4 text-sm hover:bg-sky-100 hover:text-sky-800 dark:hover:bg-sky-700 dark:hover:text-sky-200">Profil
                            Saya</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-4 text-sm hover:bg-sky-100 hover:text-sky-800 dark:hover:bg-sky-700 dark:hover:text-sky-200">Pengaturan
                            Akun</a>
                    </li>
                </ul>
                <ul class="py-1 text-sky-200 dark:text-sky-300" aria-labelledby="dropdown">
                    <li>
                        <a href="#"
                            class="block py-2 px-4 text-sm hover:bg-sky-100 hover:text-sky-800 dark:hover:bg-sky-700 dark:hover:text-sky-200">Keluar</a>
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
