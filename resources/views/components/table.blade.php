@props(['headers', 'data', 'perPage' => 5, 'route'])

<div class="rounded-2xl bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700">
    <!-- Table Controls -->
    <x-table-controls :route="$route" :perPage="$perPage" />

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 border-t border-b border-gray-200 dark:border-gray-600">
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col" class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <x-pagination :data="$data->appends(['per_page' => request('per_page')])" />
</div>
