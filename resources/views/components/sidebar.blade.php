@props([
    'menuItems' => null,
])

@php
    use Illuminate\Support\Str;

    if (!$menuItems) {
        $menuItems = \App\Models\Menu::with('subMenus')
            ->get()
            ->map(function ($menu) {
                $item = [
                    'label' => $menu->nama_menu,
                    'route' => $menu->route ?? 'dashboard.index',
                    'icon' => $menu->icon ?? 'heroicon-o-list-bullet',
                ];

                if ($menu->subMenus->isNotEmpty()) {
                    $item['dropdown'] = true;
                    $item['subItems'] = $menu->subMenus
                        ->map(function ($subMenu) {
                            return [
                                'label' => $subMenu->nama_sub_menu,
                                'route' => $subMenu->route ?? 'dashboard.index',
                                'routeParams' => $subMenu->route_params
                                    ? json_decode($subMenu->route_params, true)
                                    : [],
                                'icon' => $subMenu->icon ?? 'heroicon-o-list-bullet',
                            ];
                        })
                        ->toArray();
                }

                return $item;
            })
            ->toArray();
    }

    // Fungsi helper untuk memeriksa apakah route dan parameter path cocok
    function isRouteActive($route, $routeParams = [])
    {
        if (!request()->routeIs($route)) {
            \Log::debug('Route not active', ['route' => $route, 'current' => request()->route()->getName()]);
            return false;
        }

        $currentParams = request()->route()->parameters();
        \Log::debug('Checking route params', [
            'route' => $route,
            'routeParams' => $routeParams,
            'currentParams' => $currentParams,
        ]);

        foreach ($routeParams as $key => $value) {
            if (!isset($currentParams[$key]) || (string) $currentParams[$key] !== (string) $value) {
                \Log::debug('Parameter mismatch', [
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
        if (!isset($item['subItems'])) {
            return false;
        }

        foreach ($item['subItems'] as $subItem) {
            if (isRouteActive($subItem['route'], $subItem['routeParams'])) {
                \Log::info('Dropdown open', [
                    'menu' => $item['label'],
                    'subItem' => $subItem['label'],
                    'route' => $subItem['route'],
                    'params' => $subItem['routeParams'],
                ]);
                return true;
            }
        }

        \Log::debug('Dropdown not open', ['menu' => $item['label']]);
        return false;
    }
@endphp

<aside id="sidebar"
    class="fixed left-0 top-[64px] z-40 h-[calc(100vh-64px)] w-64 -translate-x-full border-r border-gray-200 bg-white shadow-sm transition-transform md:block md:translate-x-0 dark:border-gray-700 dark:bg-gray-800"
    aria-label="Sidebar">
    <div class="h-full overflow-y-auto p-4">
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
                                    $routeParamValue = !empty($subItem['routeParams'])
                                        ? $subItem['routeParams']['type']
                                        : '';
                                @endphp
                                <li>
                                    <a href="{{ route($subItem['route'], $routeParamValue) }}"
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
    </div>
</aside>

<script>
    document.querySelectorAll('[data-collapse-toggle]').forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-collapse-toggle');
            const target = document.getElementById(targetId);
            const chevron = button.querySelector('[data-icon="chevron-down"]');

            if (chevron) {
                target.classList.toggle('hidden');
                chevron.classList.toggle('rotate-180');
                const isExpanded = !target.classList.contains('hidden');
                button.setAttribute('aria-expanded', isExpanded);
            }
        });
    });
</script>
