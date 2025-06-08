@props(['items'])

<nav class="mb-3 flex" aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-1 md:gap-2">
        @foreach ($items as $index => $item)
            <li class="flex items-center">
                @if ($index === 0)
                    <!-- Item pertama (Dashboard dengan ikon Home) -->
                    <a href="{{ $item['url'] }}"
                       class="group inline-flex items-center text-sm font-medium text-gray-700 transition-colors duration-200 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white"
                       aria-label="Home">
                        <x-heroicon-o-home
                            class="mr-2 h-4 w-4 text-gray-600 transition-colors duration-200 group-hover:text-blue-600 dark:text-gray-400 dark:group-hover:text-white"
                            aria-hidden="true" />
                        <span>{{ $item['label'] }}</span>
                    </a>
                @else
                    <!-- Chevron sebagai pemisah -->
                    <x-heroicon-s-chevron-right class="mx-1 h-4 w-4 text-gray-400 dark:text-gray-500"
                        aria-hidden="true" />
                    @if ($index !== count($items) - 1)
                        <!-- Item lainnya dengan link -->
                        <a href="{{ $item['url'] }}"
                           class="ml-1 md:ml-2  text-sm font-medium text-gray-700 transition-colors duration-200 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <!-- Item aktif (tanpa link) -->
                        <span class="ml-1 md:ml-2 text-sm font-medium text-gray-500 dark:text-gray-400"
                              aria-current="page">{{ $item['label'] }}</span>
                    @endif
                @endif
            </li>
        @endforeach
    </ol>
</nav>
