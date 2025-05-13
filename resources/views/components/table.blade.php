@props(['headers', 'data', 'perPage' => 5, 'route'])

<div class="rounded-2xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
    <!-- Table Controls -->
    <x-table-controls :route="$route" :perPage="$perPage" />

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead
                class="border-b border-t border-gray-200 bg-gray-50 text-xs uppercase text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                <tr>
                    @foreach ($headers as $header)
                        <th scope="col" class="border-r border-gray-200 px-4 py-3 sm:px-6 dark:border-gray-600">
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
