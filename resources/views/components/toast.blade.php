@props(['id', 'type' => 'success', 'message'])

<div id="{{ $id }}"
    class="fixed top-20 right-5 flex items-start sm:items-center w-auto max-w-xs sm:max-w-sm md:max-w-md lg:max-w-md p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 z-60 transition-opacity duration-300"
    role="alert">
    <div
        class="flex-shrink-0 flex items-center justify-center w-8 h-8 {{ $type === 'success' ? 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200' : 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200' }} rounded-lg">
        @if ($type === 'success')
            <x-heroicon-s-check-circle class="w-6 h-6" />
            <span class="sr-only">Ikon Sukses</span>
        @else
            <x-heroicon-s-x-circle class="w-6 h-6" />
            <span class="sr-only">Ikon Error</span>
        @endif
    </div>
    <div class="flex-1 min-w-0 ms-3 text-sm font-normal break-words">
        {{ $message ?? $slot }}
    </div>
    <button type="button"
        class="ms-3 flex-shrink-0 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
        data-dismiss-target="#{{ $id }}" aria-label="Tutup">
        <span class="sr-only">Tutup</span>
        <x-heroicon-s-x-mark class="w-5 h-5" />
    </button>
</div>
