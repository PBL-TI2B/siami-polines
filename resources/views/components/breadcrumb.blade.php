@props(['items'])

<nav class="mb-4 flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        @foreach ($items as $index => $item)
            @if ($index === count($items) - 1)
                <!-- Item aktif (tanpa link) -->
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-heroicon-s-chevron-right class="mx-1 h-4 w-4 text-gray-400 dark:text-gray-500"
                            aria-hidden="true" />
                        <span
                            class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $item['label'] }}</span>
                    </div>
                </li>
            @else
                <!-- Item dengan link -->
                <li>
                    <div class="flex items-center">
                        @if ($index === 0)
                            <!-- Item pertama (Dashboard dengan ikon Home) -->
                            <a href="{{ $item['url'] }}"
                                class="group inline-flex items-center text-sm font-medium text-gray-700 transition-colors duration-200 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                <x-heroicon-o-home
                                    class="mr-2 h-4 w-4 text-gray-700 transition-colors duration-200 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-white"
                                    aria-hidden="true" />
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @else
                            <!-- Item lainnya dengan chevron -->
                            <x-heroicon-s-chevron-right class="mx-1 h-4 w-4 text-gray-400 dark:text-gray-500"
                                aria-hidden="true" />
                            <a href="{{ $item['url'] }}"
                                class="ml-1 text-sm font-medium text-gray-700 transition-colors duration-200 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                                {{ $item['label'] }}
                            </a>
                        @endif
                    </div>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
