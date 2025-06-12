@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Str;

    $menuItems = [];
    $message = null;
    $error = null;

    if (session('token') && session('role_id')) {
        try {
            $roleId = session('role_id');
            $response = Http::get('http://localhost:5000/api/sidebar-menu', ['role_id' => $roleId]);
            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    $menuItems = $data['data'];
                } else {
                    $error = $data['message'] ?? 'Gagal mengambil menu sidebar.';
                }
            } else {
                $error = 'Gagal terhubung ke server menu.';
            }
        } catch (\Exception $e) {
            $error = 'Terjadi kesalahan saat memuat menu.';
            Log::error('Sidebar Menu Exception', ['error' => $e->getMessage()]);
        }
    } else {
        $error = 'Silakan login untuk melihat menu.';
    }

    function isRouteActive($menuRoute, $menuParams = [])
    {
        if (empty($menuRoute)) {
            return false;
        }

        // Cek apakah route yang diberikan adalah 'auditee.audit.index' atau 'auditor.audit.index'
        if ($menuRoute === 'auditee.audit.index') {
            return request()->is('auditee/audit', 'auditee/audit/*');
        }
        if ($menuRoute === 'auditor.audit.index') {
            return request()->is('auditor/audit', 'auditor/audit/*');
        }

        // Jika ada parameter, cek juga parameter route-nya dan query string
        if (!empty($menuParams)) {
            foreach ($menuParams as $key => $value) {
                // Cek parameter dari route atau query string
                $param = request()->route($key) ?? request()->query($key);
                if ($param != $value) {
                    return false;
                }
            }
        }

        // Aturan Default untuk menu lainnya
        // Cek nama route secara persis.
        return request()->routeIs($menuRoute);
    }

    function generateSidebarUrl($item)
    {
        $route = $item['route'];
        $params = $item['routeParams'] ?? [];
        if (Route::has($route)) {
            return route($route, $params);
        }
        return url($route);
    }

    function isDropdownOpen($item)
    {
        if (!isset($item['subItems']) || empty($item['subItems'])) {
            return false;
        }
        foreach ($item['subItems'] as $subItem) {
            if (isRouteActive($subItem['route'], $subItem['routeParams'] ?? [])) {
                return true;
            }
        }
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
            @if (!$error)
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Tidak ada menu tersedia untuk peran Anda.
                </p>
            @endif
        @else
            <ul class="space-y-1 font-medium">
                @foreach ($menuItems as $item)
                    @if (isset($item['dropdown']) && $item['dropdown'] && !empty($item['subItems']))
                        @php $isOpen = isDropdownOpen($item); @endphp
                        <li>
                            <button type="button"
                                class="{{ $isOpen ? 'bg-sky-100 text-sky-900 dark:bg-sky-800 dark:text-sky-100' : '' }} group flex w-full items-center justify-between rounded-lg p-3 text-gray-600 transition-all duration-300 hover:scale-[1.02] hover:bg-sky-100 hover:text-sky-900 dark:text-gray-200 dark:hover:bg-sky-800 dark:hover:text-sky-100"
                                data-collapse-toggle="dropdown-{{ Str::slug($item['label']) }}"
                                aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
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
                                    @php $isSubItemActive = isRouteActive($subItem['route'], $subItem['routeParams'] ?? []); @endphp
                                    <li>
                                        <a href="{{ generateSidebarUrl($subItem) }}"
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
                        @php $isActive = isRouteActive($item['route'], $item['routeParams'] ?? []); @endphp
                        <li>
                            <a href="{{ generateSidebarUrl($item) }}"
                                class="{{ $isActive ? 'bg-sky-100 text-sky-900 dark:bg-sky-800 dark:text-sky-100' : '' }} group flex items-center rounded-lg p-3 text-gray-600 transition-all duration-300 hover:scale-[1.02] hover:bg-sky-100 hover:text-sky-900 dark:text-gray-200 dark:hover:bg-sky-800 dark:hover:text-sky-100"
                                aria-current="{{ $isActive ? 'page' : 'false' }}">
                                <x-dynamic-component :component="$item['icon']"
                                    class="{{ $isActive ? 'text-sky-900 dark:text-sky-100' : '' }} h-5 w-5 text-gray-500 transition duration-300 group-hover:text-sky-900 dark:text-gray-400 dark:group-hover:text-sky-100" />
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
    // Toggle sidebar visibility on small screens
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
