@props([
    'actions' => [], // Array berisi aksi: ['label', 'color', 'icon', 'href', 'modalId', 'condition']
])

<td class="px-4 py-4 sm:px-6 flex flex-col sm:flex-row gap-2 border-gray-200 dark:border-gray-700">
    @foreach ($actions as $action)
        @if (!isset($action['condition']) || $action['condition'])
            @if (isset($action['modalId']))
                <x-button :color="$action['color']" :icon="$action['icon']" data-modal-target="{{ $action['modalId'] }}"
                    data-modal-toggle="{{ $action['modalId'] }}">
                    {{ $action['label'] }}
                </x-button>
            @else
                <x-button :color="$action['color']" :icon="$action['icon']" :href="$action['href']">
                    {{ $action['label'] }}
                </x-button>
            @endif
        @endif
    @endforeach
</td>
