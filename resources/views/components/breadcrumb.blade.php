@props(['items'])

<nav class="flex mb-2" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        @foreach ($items as $index => $item)
            @if ($index === count($items) - 1)
                <li aria-current="page">
                    <div class="flex items-center">
                        <x-heroicon-s-chevron-right class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                        <span
                            class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ml-2">{{ $item['label'] }}</span>
                    </div>
                </li>
            @else
                <li class="inline-flex items-center">
                    <a href="{{ $item['url'] }}"
                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-sky-800 dark:text-gray-400 dark:hover:text-sky-200 transition-all duration-200">
                        @if ($index === 0)
                            <span class="inline-flex items-center">
                                <x-heroicon-o-home
                                    class="w-4 h-4 mr-2 text-gray-600 hover:text-sky-800 dark:text-gray-400 dark:hover:text-sky-200 transition-all duration-200" />
                                <span>{{ $item['label'] }}</span>
                            </span>
                        @else
                            <x-heroicon-s-chevron-right class="w-4 h-4 text-gray-400 dark:text-gray-500 mr-1" />
                            <span>{{ $item['label'] }}</span>
                        @endif
                    </a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
