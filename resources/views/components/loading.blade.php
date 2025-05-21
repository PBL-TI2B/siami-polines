@props(['id' => null])

<div id="{{ $id }}" class="relative">
    <div id="{{ $id }}-spinner"
        class="absolute inset-0 z-10 flex hidden items-center justify-center bg-white bg-opacity-75 transition-opacity duration-300">
        <div class="h-8 w-8 animate-spin rounded-full border-2 border-t-2 border-gray-200 border-t-sky-500"></div>
    </div>
    <div id="{{ $id }}-content">
        {{ $slot }}
    </div>
</div>
