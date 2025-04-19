@props(['route', 'perPage' => 5])

<div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
    <div class="flex items-center gap-2">
        <span class="text-sm text-gray-700 dark:text-gray-300">Tampilkan</span>
        <form action="{{ $route }}" method="GET">
            <select id="table-entries" name="per_page"
                class="w-18 gap-4 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 transition-all duration-200"
                onchange="this.form.submit()">
                <option value="5" {{ request('per_page', $perPage) == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
            </select>
        </form>
        <span class="text-sm text-gray-700 dark:text-gray-300">entri</span>
    </div>
    <div class="relative w-full sm:w-auto">
        <form action="{{ $route }}" method="GET">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <x-heroicon-o-magnifying-glass class="w-4 h-4 text-gray-500 dark:text-gray-400" />
            </div>
            <input type="search" name="search" placeholder="Cari" value="{{ request('search') }}"
                class="block w-full pl-10 p-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 transition-all duration-200">
        </form>
    </div>
</div>
