<aside id="sidebar"
    class="fixed top-[64px] left-0 z-40 w-64 h-[calc(100vh-64px)] transition-transform -translate-x-full bg-white border-r border-gray-200 md:block md:translate-x-0 dark:bg-gray-800 dark:border-gray-700 shadow-lg"
    aria-label="Sidebar">
    <div class="h-full p-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-1 font-medium">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center p-3 text-gray-900 text-sm rounded-lg dark:text-gray-200 hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 transition-all duration-200 dark:hover:bg-sky-900 dark:hover:text-white group {{ request()->routeIs('dashboard') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                    <x-heroicon-o-home
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('dashboard') ? 'text-sky-800' : '' }}" />
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <!-- Periode Audit -->
            <li>
                <button type="button"
                    class="flex items-center w-full p-3 text-sm text-gray-900 rounded-lg transition-all duration-200 hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 dark:text-gray-200 dark:hover:bg-sky-900 dark:hover:text-white group {{ request()->routeIs('periode-audit.*') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}"
                    data-collapse-toggle="dropdown-periode-audit"
                    aria-expanded="{{ request()->routeIs('periode-audit.*') ? 'true' : 'false' }}">
                    <x-heroicon-o-calendar-days
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('periode-audit.*') ? 'text-sky-800' : '' }}" />
                    <span class="flex-1 ms-3 text-left whitespace-nowrap">Periode Audit</span>

                </button>

            </li>
            <!-- Jadwal Audit -->
            <li>
                <a href="{{ route('jadwal-audit') }}"
                    class="flex items-center p-3 text-gray-900 text-sm rounded-lg dark:text-gray-200 hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 transition-all duration-200 dark:hover:bg-sky-900 dark:hover:text-white group {{ request()->routeIs('jadwal-audit') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                    <x-heroicon-o-clock
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('jadwal-audit') ? 'text-sky-800' : '' }}" />
                    <span class="ms-3">Jadwal Audit</span>
                </a>
            </li>
            <!-- Daftar Tilik -->
            <li>
                <a href="{{ route('daftar-tilik') }}"
                    class="flex items-center p-3 text-gray-900 text-sm rounded-lg dark:text-gray-200 hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 transition-all duration-200 dark:hover:bg-sky-900 dark:hover:text-white group {{ request()->routeIs('daftar-tilik') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                    <x-heroicon-o-check-circle
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('daftar-tilik') ? 'text-sky-800' : '' }}" />
                    <span class="ms-3">Daftar Tilik</span>
                </a>
            </li>
            <!-- Data Unit -->
            <li>
                <button type="button"
                    class="flex items-center w-full p-3 text-sm text-gray-900 rounded-lg transition-all duration-200 hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 dark:text-gray-200 dark:hover:bg-sky-900 dark:hover:text-white group {{ request()->routeIs('data-unit.*') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}"
                    data-collapse-toggle="dropdown-data-unit"
                    aria-expanded="{{ request()->routeIs('data-unit.*') ? 'true' : 'false' }}">
                    <x-heroicon-o-building-office
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('data-unit.*') ? 'text-sky-800' : '' }}" />
                    <span class="flex-1 ms-3 text-left whitespace-nowrap">Data Unit</span>
                    <x-heroicon-s-chevron-down
                        class="w-3 h-3 {{ request()->routeIs('data-unit.*') ? 'text-sky-800 rotate-180' : 'text-gray-500 dark:text-gray-400' }} transition-transform duration-200" />
                </button>
                <ul id="dropdown-data-unit"
                    class="{{ request()->routeIs('data-unit.*') ? '' : 'hidden' }} py-2 space-y-2">
                    <li>
                        <a href="{{ route('data-unit') }}"
                            class="flex items-center w-full p-2 text-gray-900 text-sm transition-all duration-200 rounded-lg pl-11 group hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 dark:text-gray-200 dark:hover:bg-sky-900 dark:hover:text-white {{ request()->routeIs('data-unit') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                            <x-heroicon-o-list-bullet
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('data-unit') ? 'text-sky-800' : '' }}" />
                            <span class="ms-3">Daftar UPT</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('data-unit') }}"
                            class="flex items-center w-full p-2 text-gray-900 text-sm transition-all duration-200 rounded-lg pl-11 group hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 dark:text-gray-200 dark:hover:bg-sky-900 dark:hover:text-white {{ request()->routeIs('data-unit') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                            <x-heroicon-o-list-bullet
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('data-unit') ? 'text-sky-800' : '' }}" />
                            <span class="ms-3">Daftar Prodi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('data-unit') }}"
                            class="flex items-center w-full p-2 text-gray-900 text-sm transition-all duration-200 rounded-lg pl-11 group hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 dark:text-gray-200 dark:hover:bg-sky-900 dark:hover:text-white {{ request()->routeIs('data-unit') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                            <x-heroicon-o-list-bullet
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('data-unit') ? 'text-sky-800' : '' }}" />
                            <span class="ms-3">Daftar Jurusan</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- Data Instrumen -->
            <li>
                <a href="{{ route('data-instrumen') }}"
                    class="flex items-center p-3 text-gray-900 text-sm rounded-lg dark:text-gray-200 hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 transition-all duration-200 dark:hover:bg-sky-900 dark:hover:text-white group {{ request()->routeIs('data-instrumen') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                    <x-heroicon-o-clipboard-document
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('data-instrumen') ? 'text-sky-800' : '' }}" />
                    <span class="ms-3">Data Instrumen</span>
                </a>
            </li>
            <!-- Data User -->
            <li>
                <a href="{{ route('data-user') }}"
                    class="flex items-center p-3 text-gray-900 text-sm rounded-lg dark:text-gray-200 hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 transition-all duration-200 dark:hover:bg-sky-900 dark:hover:text-white group {{ request()->routeIs('data-user') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                    <x-heroicon-o-users
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('data-user') ? 'text-sky-800' : '' }}" />
                    <span class="ms-3">Data User</span>
                </a>
            </li>
            <!-- Laporan -->
            <li>
                <a href="{{ route('laporan') }}"
                    class="flex items-center p-3 text-gray-900 text-sm rounded-lg dark:text-gray-200 hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 transition-all duration-200 dark:hover:bg-sky-900 dark:hover:text-white group {{ request()->routeIs('laporan') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                    <x-heroicon-o-document-text
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('laporan') ? 'text-sky-800' : '' }}" />
                    <span class="ms-3">Laporan</span>
                </a>
            </li>
            <!-- Logout -->
            <li>
                <a href="{{ route('logout') }}"
                    class="flex items-center p-3 text-gray-900 text-sm rounded-lg dark:text-gray-200 hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 transition-all duration-200 dark:hover:bg-sky-900 dark:hover:text-white group {{ request()->routeIs('logout') ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                    <x-heroicon-o-arrow-left-on-rectangle
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs('logout') ? 'text-sky-800' : '' }}" />
                    <span class="ms-3">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
