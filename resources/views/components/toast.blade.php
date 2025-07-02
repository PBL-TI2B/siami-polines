@props(['id', 'type' => 'success', 'message'])

<div id="{{ $id }}"
    class="z-60 animate-fade-in fixed right-5 top-20 mb-4 flex w-auto max-w-xs items-start rounded-lg bg-white p-4 text-gray-500 shadow-sm sm:max-w-sm sm:items-center md:max-w-md lg:max-w-md dark:bg-gray-800 dark:text-gray-400"
    role="alert">
    <div
        class="{{ $type === 'success' ? 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200' : ($type === 'warning' ? 'text-yellow-500 bg-yellow-100 dark:bg-yellow-800 dark:text-yellow-200' : 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200') }} flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg">
        @if ($type === 'success')
            <x-heroicon-s-check-circle class="h-6 w-6" />
            <span class="sr-only">Ikon Sukses</span>
        @elseif ($type === 'warning')
            <x-heroicon-s-exclamation-triangle class="h-6 w-6" />
            <span class="sr-only">Ikon Peringatan</span>
        @else
            <x-heroicon-s-x-circle class="h-6 w-6" />
            <span class="sr-only">Ikon Error</span>
        @endif
    </div>
    <div class="ms-3 min-w-0 flex-1 break-words text-sm font-normal">
        {{ $message ?? $slot }}
    </div>
    <button type="button"
        class="ms-3 flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 dark:bg-gray-800 dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-white"
        onclick="closeServerToast('{{ $id }}')" aria-label="Tutup">
        <span class="sr-only">Tutup</span>
        <x-heroicon-s-x-mark class="h-5 w-5" />
    </button>
</div>

<script>
    function closeServerToast(toastId) {
        const toast = document.getElementById(toastId);
        if (toast) {
            toast.classList.remove('animate-fade-in');
            toast.classList.add('animate-fade-out');
            setTimeout(() => {
                toast.remove();
            }, 400);
        }
    }

    // Auto close server toasts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('{{ $id }}');
        if (toast) {
            setTimeout(() => {
                closeServerToast('{{ $id }}');
            }, 5000);
        }
    });
</script>
