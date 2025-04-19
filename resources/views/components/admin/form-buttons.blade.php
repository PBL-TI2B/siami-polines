@props(['submitLabel' => 'Simpan', 'cancelRoute'])

<div class="flex space-x-3">
    <button type="submit"
        class="text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:outline-none focus:ring-sky-300 dark:focus:ring-sky-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center transition-all duration-200">
        <x-heroicon-o-check class="w-5 h-5 mr-2" />
        {{ $submitLabel }}
    </button>
    <a href="{{ $cancelRoute }}"
        class="text-gray-900 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:focus:ring-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center transition-all duration-200">
        <x-heroicon-o-x-mark class="w-5 h-5 mr-2" />
        Batal
    </a>
</div>
