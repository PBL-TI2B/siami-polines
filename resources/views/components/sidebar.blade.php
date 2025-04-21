@props([
    'menuItems' => null, // Jika null, akan diambil dari database
])

@php
    if (!$menuItems) {
        // Ambil menu dan sub-menu dari database
        $menuItems = \App\Models\Menu::with('subMenus')
            ->get()
            ->map(function ($menu) {
                $item = [
                    'label' => $menu->nama_menu,
                    'route' => $menu->route ?? 'dashboard', // Fallback ke dashboard jika route tidak ada
                    'icon' => $menu->icon ?? 'heroicon-o-list-bullet', // Fallback ikon jika tidak ada
                ];

                if ($menu->subMenus->isNotEmpty()) {
                    $item['dropdown'] = true;
                    $item['subItems'] = $menu->subMenus
                        ->map(function ($subMenu) {
                            return [
                                'label' => $subMenu->nama_sub_menu,
                                'route' => $subMenu->route ?? 'dashboard',
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
@endphp

<aside id="sidebar"
    class="fixed top-[64px] left-0 z-40 w-64 h-[calc(100vh-64px)] transition-transform -translate-x-full bg-white border-r border-gray-200 md:block md:translate-x-0 dark:bg-gray-800 dark:border-gray-700 shadow-lg"
    aria-label="Sidebar">
    <div class="h-full p-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-1 font-medium">
            @foreach ($menuItems as $item)
                @if (isset($item['dropdown']) && $item['dropdown'])
                    <!-- Dropdown Menu -->
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-3 text-sm text-gray-900 rounded-lg transition-all duration-200 hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 dark:text-gray-200 dark:hover:bg-sky-900 dark:hover:text-white group {{ request()->routeIs($item['route']) ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}"
                            data-collapse-toggle="dropdown-{{ Str::slug($item['label']) }}"
                            aria-expanded="{{ request()->routeIs($item['route']) ? 'true' : 'false' }}">
                            <x-dynamic-component :component="$item['icon']"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs($item['route']) ? 'text-sky-800' : '' }}" />
                            <span class="flex-1 ms-3 text-left whitespace-nowrap">{{ $item['label'] }}</span>
                            <x-heroicon-s-chevron-down
                                class="w-3 h-3 {{ request()->routeIs($item['route']) ? 'text-sky-800 rotate-180' : 'text-gray-500 dark:text-gray-400' }} transition-transform duration-200" />
                        </button>
                        <ul id="dropdown-{{ Str::slug($item['label']) }}"
                            class="{{ request()->routeIs($item['route']) ? '' : 'hidden' }} py-2 space-y-2">
                            @foreach ($item['subItems'] as $subItem)
                                <li>
                                    <a href="{{ route($subItem['route'], $subItem['routeParams'] ?? []) }}"
                                        class="flex items-center w-full p-2 text-gray-900 text-sm transition-all duration-200 rounded-lg pl-11 group hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 dark:text-gray-200 dark:hover:bg-sky-900 dark:hover:text-white {{ request()->routeIs($subItem['route']) ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                                        <x-dynamic-component :component="$subItem['icon']"
                                            class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs($subItem['route']) ? 'text-sky-800' : '' }}" />
                                        <span class="ms-3">{{ $subItem['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <!-- Regular Menu Item -->
                    <li>
                        <a href="{{ route($item['route']) }}"
                            class="flex items-center p-3 text-sm text-gray-900 rounded-lg transition-all duration-200 hover:bg-sky-100 hover:scale-[1.02] hover:text-sky-800 dark:text-gray-200 dark:hover:bg-sky-900 dark:hover:text-white group {{ request()->routeIs($item['route']) ? 'bg-sky-100 dark:bg-sky-900 text-sky-800' : '' }}">
                            <x-dynamic-component :component="$item['icon']"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-sky-800 dark:group-hover:text-white {{ request()->routeIs($item['route']) ? 'text-sky-800' : '' }}" />
                            <span class="ms-3">{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
