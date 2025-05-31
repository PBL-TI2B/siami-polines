@props(['items'])

<nav class="mb-4 flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        @foreach ($items as $index => $item)
            <li>
                <div class="flex items-center">
                    @if ($index === 0)
                        <!-- Item pertama dengan ikon -->
                        <a href="{{ $item['url'] }}"
                            class="group inline-flex items-center text-sm font-medium text-gray-700 transition-colors duration-200 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <!-- Custom SVG icon untuk progress -->
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4"/>
                            </svg>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @else
                        <!-- Item selanjutnya -->
                        <x-heroicon-s-chevron-right class="mx-1 h-4 w-4 text-gray-400 dark:text-gray-500"
                                aria-hidden="true" />
                        <a href="{{ $item['url'] }}"
                            class="ml-1 text-sm font-medium text-gray-700 transition-colors duration-200 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                            {{ $item['label'] }}
                        </a>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>