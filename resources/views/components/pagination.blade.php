@props(['data'])

<div class="p-4">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        @if (isset($data) && $data->total() > 0)
            <span class="text-sm text-gray-700 dark:text-gray-300">
                Menampilkan <strong>{{ $data->firstItem() }}</strong> hingga <strong>{{ $data->lastItem() }}</strong>
                dari <strong>{{ $data->total() }}</strong> hasil
            </span>
            <nav aria-label="Navigasi Paginasi">
                <ul class="inline-flex -space-x-px text-sm">
                    <li>
                        <a href="{{ $data->previousPageUrl() }}"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-l-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 {{ $data->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }}">
                            <x-heroicon-s-chevron-left class="w-4 h-4 mr-1" />
                        </a>
                    </li>
                    @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
                        <li>
                            <a href="{{ $url }}"
                                class="flex items-center justify-center px-3 h-8 leading-tight {{ $page == $data->currentPage() ? 'text-sky-800 bg-sky-50 dark:bg-sky-900 dark:text-sky-200 border-sky-300 dark:border-sky-700' : 'text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200' }} border transition-all duration-200">
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ $data->nextPageUrl() }}"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-r-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-200 transition-all duration-200 {{ $data->hasMorePages() ? '' : 'cursor-not-allowed opacity-50' }}">
                            <x-heroicon-s-chevron-right class="w-4 h-4 ml-1" />
                        </a>
                    </li>
                </ul>
            </nav>
        @else
            <span class="text-sm text-gray-700 dark:text-gray-300">
                Tidak ada data untuk ditampilkan.
            </span>
        @endif
    </div>
</div>
