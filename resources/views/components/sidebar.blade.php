@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Log;

    $menuItems = [];
    $message = null;
    $error = null;

    // Ambil menu dari API jika pengguna terautentikasi
    if (session('token') && session('role_id')) {
        try {
            $roleId = session('role_id');
            $response = Http::timeout(5)->get('http://localhost:5000/api/sidebar-menu', [
                'role_id' => $roleId,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    $menuItems = $data['data'];
                    $message = $data['message'];
                    Log::info('Berhasil mengambil menu sidebar dari API', [
                        'role_id' => $roleId,
                        'role_name' => session('role'),
                        'message' => $message,
                        'menu_count' => count($menuItems),
                    ]);
                } else {
                    $error = $data['message'] ?? 'Gagal mengambil menu sidebar.';
                    Log::warning('API sidebar-menu mengembalikan status gagal', [
                        'role_id' => $roleId,
                        'message' => $error,
                    ]);
                }
            } else {
                $error = 'Gagal mengambil menu sidebar dari server. Silakan coba lagi nanti.';
                Log::error('Gagal mengambil menu sidebar dari API', [
                    'role_id' => $roleId,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            $error = 'Terjadi kesalahan saat mengambil menu sidebar';
            Log::error('Gagal mengambil menu sidebar: Kesalahan tak terduga', [
                'role_id' => $roleId ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    } else {
        $error = 'Silakan login untuk mengakses menu sidebar.';
        Log::warning('Gagal mengambil menu sidebar: Pengguna tidak terautentikasi', [
            'session' => session()->all(),
        ]);
    }

    // Fungsi helper untuk memeriksa apakah route dan parameter path cocok
    function isRouteActive($route, $routeParams = [])
    {
        $currentRoute = request()->route()->getName();
        $currentParams = request()->route()->parameters();

        // Khusus untuk auditor.data-instrumen.index dengan parameter type
        if ($route === 'auditor.data-instrumen.index' && isset($routeParams['type'])) {
            $type = $routeParams['type'];
            $targetRoute = "auditor.data-instrumen.{$type}";

            if ($currentRoute === $targetRoute) {
                Log::info('Route aktif berdasarkan type', [
                    'route' => $route,
                    'type' => $type,
                    'targetRoute' => $targetRoute,
                    'currentRoute' => $currentRoute,
                ]);
                return true;
            }
        }

        // Logika default untuk rute lainnya
        if (!request()->routeIs($route)) {
            Log::debug('Route tidak aktif', [
                'route' => $route,
                'current' => $currentRoute ?? 'undefined',
            ]);
            return false;
        }

        Log::debug('Memeriksa parameter route', [
            'route' => $route,
            'routeParams' => $routeParams,
            'currentParams' => $currentParams,
        ]);

        foreach ($routeParams as $key => $value) {
            if (!isset($currentParams[$key]) || (string) $currentParams[$key] !== (string) $value) {
                Log::debug('Parameter tidak cocok', [
                    'key' => $key,
                    'expected' => $value,
                    'actual' => $currentParams[$key] ?? 'unset',
                ]);
                return false;
            }
        }

        return true;
    }

    // Fungsi helper untuk memeriksa apakah dropdown harus terbuka
    function isDropdownOpen($item)
    {
        if (!isset($item['subItems']) || empty($item['subItems'])) {
            return false;
        }

        foreach ($item['subItems'] as $subItem) {
            if (isRouteActive($subItem['route'], $subItem['routeParams'])) {
                Log::info('Dropdown terbuka', [
                    'menu' => $item['label'],
                    'subItem' => $subItem['label'],
                    'route' => $subItem['route'],
                    'params' => $subItem['routeParams'],
                ]);
                return true;
            }
        }

        Log::debug('Dropdown tidak terbuka', ['menu' => $item['label']]);
        return false;
    }
@endphp

<aside id="sidebar"
    class="fixed left-0 top-[64px] z-40 h-[calc(100vh-64px)] w-64 -translate-x-full border-r border-gray-200 bg-white shadow-sm transition-transform md:block md:translate-x-0 dark:border-gray-700 dark:bg-gray-800"
    aria-label="Sidebar">
    <div class="h-full overflow-y-auto p-4">
        @if ($error)
            <div class="mb-4 rounded-lg bg-red-100 p-3 text-sm text-red-700 dark:bg-red-900 dark:text-red-200">
                {{ $error }}
            </div>
        @endif

        @if (empty($menuItems))
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Tidak ada menu tersedia untuk peran Anda.
            </p>
        @else
            <ul class="space-y-1 font-medium">
                @foreach ($menuItems as $item)
                    @if (isset($item['dropdown']) && $item['dropdown'])
                        <!-- Dropdown Menu -->
                        @php
                            $isOpen = isDropdownOpen($item);
                        @endphp
                        <li>
                            <button type="button"
                                class="{{ $isOpen ? 'bg-sky-100 text-sky-900 dark:bg-sky-800 dark:text-sky-100' : '' }} group flex w-full items-center justify-between rounded-lg p-3 text-gray-600 transition-all duration-300 hover:scale-[1.02] hover:bg-sky-100 hover:text-sky-900 dark:text-gray-200 dark:hover:bg-sky-800 dark:hover:text-sky-100"
                                data-collapse-toggle="dropdown-{{ Str::slug($item['label']) }}"
                                aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                                aria-controls="dropdown-{{ Str::slug($item['label']) }}">
                                <div class="flex items-center">
                                    <x-dynamic-component :component="$item['icon']"
                                        class="{{ $isOpen ? 'text-sky-900 dark:text-sky-100' : '' }} h-5 w-5 text-gray-500 transition duration-300 group-hover:text-sky-900 dark:text-gray-400 dark:group-hover:text-sky-100" />
                                    <span class="ml-3 flex-1 text-left text-sm">{{ $item['label'] }}</span>
                                </div>
                                <x-heroicon-s-chevron-down data-icon="chevron-down"
                                    class="{{ $isOpen ? 'rotate-180' : '' }} h-4 w-4 text-gray-500 transition-transform duration-300 group-hover:text-sky-900 dark:text-gray-400 dark:group-hover:text-sky-100" />
                            </button>
                            <ul id="dropdown-{{ Str::slug($item['label']) }}"
                                class="{{ $isOpen ? '' : 'hidden' }} mt-1 space-y-1">
                                @foreach ($item['subItems'] as $subItem)
                                    @php
                                        $isSubItemActive = isRouteActive($subItem['route'], $subItem['routeParams']);
                                        $routeParams = $subItem['routeParams'] ?? [];
                                    @endphp
                                    <li>
                                        <a href="{{ route($subItem['route'], $routeParams) }}"
                                            class="{{ $isSubItemActive ? 'bg-sky-100 text-sky-900 dark:bg-sky-800 dark:text-sky-100' : '' }} group flex items-center rounded-lg p-3 pl-10 text-sm text-gray-600 transition-all duration-300 hover:scale-[1.02] hover:bg-sky-100 hover:text-sky-900 dark:text-gray-200 dark:hover:bg-sky-800 dark:hover:text-sky-100"
                                            aria-current="{{ $isSubItemActive ? 'page' : 'false' }}">
                                            <x-dynamic-component :component="$subItem['icon']"
                                                class="{{ $isSubItemActive ? 'text-sky-900 dark:text-sky-100' : '' }} h-5 w-5 text-gray-500 transition duration-300 group-hover:text-sky-900 dark:text-gray-400 dark:group-hover:text-sky-100" />
                                            <span class="ml-3">{{ $subItem['label'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <!-- Regular Menu Item -->
                        <li>
                            <a href="{{ route($item['route']) }}"
                                class="{{ request()->routeIs($item['route']) ? 'bg-sky-100 text-sky-900 dark:bg-sky-800 dark:text-sky-100' : '' }} group flex items-center rounded-lg p-3 text-gray-600 transition-all duration-300 hover:scale-[1.02] hover:bg-sky-100 hover:text-sky-900 dark:text-gray-200 dark:hover:bg-sky-800 dark:hover:text-sky-100"
                                aria-current="{{ request()->routeIs($item['route']) ? 'page' : 'false' }}">
                                <x-dynamic-component :component="$item['icon']"
                                    class="{{ request()->routeIs($item['route']) ? 'text-sky-900 dark:text-sky-100' : '' }} h-5 w-5 text-gray-500 transition duration-300 group-hover:text-sky-900 dark:text-gray-400 dark:group-hover:text-sky-100" />
                                <span class="ml-3 text-sm">{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </div>
</aside>

<script>
    document.querySelectorAll('[data-collapse-toggle]').forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-collapse-toggle');
            const target = document.getElementById(targetId);
            const chevron = button.querySelector('[data-icon="chevron-down"]');

            if (target && chevron) {
                target.classList.toggle('hidden');
                chevron.classList.toggle('rotate-180');
                const isExpanded = !target.classList.contains('hidden');
                button.setAttribute('aria-expanded', isExpanded);
            }
        });
    });
</script>
