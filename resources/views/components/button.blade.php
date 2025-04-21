@props([
    'type' => 'button',
    'color' => 'sky', // sky, red, yellow, gray, dll.
    'icon' => null,
    'href' => null,
    'class' => '',
])

@php
    $baseClasses = "text-sm font-medium rounded-lg px-4 py-2 flex items-center transition-all duration-200 {$class}";
    $colorClasses = match ($color) {
        'sky' => 'text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600',
        'red'
            => 'text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-600',
        'yellow'
            => 'text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-600',
        'gray'
            => 'text-gray-900 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:focus:ring-gray-600',
        default => 'text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "{$baseClasses} {$colorClasses}"]) }}>
        @if ($icon)
            <x-dynamic-component :component="$icon" class="w-4 h-4 mr-2" />
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "{$baseClasses} {$colorClasses}"]) }}>
        @if ($icon)
            <x-dynamic-component :component="$icon" class="w-4 h-4 mr-2" />
        @endif
        {{ $slot }}
    </button>
@endif
