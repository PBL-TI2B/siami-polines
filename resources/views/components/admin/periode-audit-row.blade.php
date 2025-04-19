@props(['periode', 'index', 'firstItem'])

<tr
    class="bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
    <td class="w-4 p-4 border-r border-gray-200 dark:border-gray-700">
        <input type="checkbox"
            class="w-4 h-4 text-sky-800 bg-gray-100 dark:bg-gray-600 border-gray-200 dark:border-gray-500 rounded focus:ring-sky-500 dark:focus:ring-sky-600">
    </td>
    <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
        {{ $firstItem + $index }}
    </td>
    <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
        {{ $periode->nama_periode ?? 'N/A' }}
    </td>
    <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
        @if ($periode->tanggal_mulai)
            {{ $periode->tanggal_mulai->format('d F Y') }}
        @else
            N/A
        @endif
    </td>
    <td class="px-4 py-4 sm:px-6 text-gray-900 dark:text-gray-200 border-r border-gray-200 dark:border-gray-700">
        @if ($periode->tanggal_berakhir)
            {{ $periode->tanggal_berakhir->format('d F Y') }}
        @else
            N/A
        @endif
    </td>
    <td class="px-4 py-4 sm:px-6 border-r border-gray-200 dark:border-gray-700">
        <span
            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $periode->status == 'Berakhir' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300' }}">
            {{ $periode->status ?? 'Tidak Diketahui' }}
        </span>
    </td>
    <td class="px-4 py-4 sm:px-6 flex flex-col sm:flex-row gap-2 border-gray-200 dark:border-gray-700">
        @if ($periode->status != 'Berakhir')
            <button data-modal-target="close-periode-modal-{{ $periode->periode_id }}"
                data-modal-toggle="close-periode-modal-{{ $periode->periode_id }}"
                class="text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-600 font-medium rounded-lg text-sm px-3 py-1.5 flex items-center transition-all duration-200">
                <x-heroicon-o-lock-closed class="w-4 h-4 mr-1" />
                Tutup
            </button>
        @endif
        <a href="{{ route('periode-audit.edit', $periode->periode_id) }}"
            class="text-white bg-sky-800 hover:bg-sky-900 focus:ring-4 focus:ring-sky-300 dark:focus:ring-sky-600 font-medium rounded-lg text-sm px-3 py-1.5 flex items-center transition-all duration-200">
            <x-heroicon-o-pencil class="w-4 h-4 mr-1" />
            Edit
        </a>
        <button data-modal-target="delete-periode-modal-{{ $periode->periode_id }}"
            data-modal-toggle="delete-periode-modal-{{ $periode->periode_id }}"
            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-600 font-medium rounded-lg text-sm px-3 py-1.5 flex items-center transition-all duration-200">
            <x-heroicon-o-trash class="w-4 h-4 mr-1" />
            Hapus
        </button>
    </td>
</tr>
