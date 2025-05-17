@props(['route', 'perPage' => 5])

<div class="flex flex-col items-center justify-between gap-4 p-4 sm:flex-row">
    <div class="flex items-center gap-2">
        <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
        <form action="{{ $route }}" method="GET">
            <select id="table-entries" name="per_page"
                class="w-18 gap-4 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                onchange="this.form.submit()">
                <option value="5" {{ request('per_page', $perPage) == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('per_page', $perPage) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page', $perPage) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page', $perPage) == 50 ? 'selected' : '' }}>50</option>
            </select>
        </form>
        <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
    </div>
    <div class="relative w-full sm:w-auto">
        <form action="{{ $route }}" method="GET">
            <input type="hidden" name="per_page" value="{{ request('per_page', $perPage) }}">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <x-heroicon-o-magnifying-glass class="h-4 w-4 text-gray-500 dark:text-gray-400" />
            </div>
            <input type="search" name="search" placeholder="Cari" value="{{ request('search') }}"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pl-10 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
        </form>
    </div>
</div>
