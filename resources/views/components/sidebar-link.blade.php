@props(['icon', 'text', 'active' => false])

<a
    {{ $attributes->class([
        'flex items-center space-x-2 p-3 rounded-lg transition',
        'bg-sky-100 text-sky-800' => $active,
        'text-gray-600 hover:bg-gray-100' => !$active,
    ]) }}>
    <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-6 h-6" />
    <span class="font-medium">{{ $text }}</span>
</a>
