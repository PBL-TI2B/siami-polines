@props([
    'id',
    'title',
    'action',
    'method' => 'POST',
    'type' => 'delete',
    'formClass',
    'itemName' => null,
    'warningMessage' => null,
])

<div id="{{ $id }}" tabindex="-1" aria-hidden="true"
    class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
            <!-- Modal Header -->
            <div class="flex items-center justify-between rounded-t border-b p-4 md:p-5 dark:border-gray-700">
                <div class="flex items-center">
                    <div
                        class="{{ $type === 'delete' ? 'bg-red-100 dark:bg-red-900' : ($type === 'cancel' ? 'bg-gray-100 dark:bg-gray-900' : 'bg-yellow-100 dark:bg-yellow-900') }} flex h-10 w-10 items-center justify-center rounded-full">
                        @if ($type === 'delete')
                            <x-heroicon-o-trash class="h-5 w-5 text-red-600 dark:text-red-300" />
                        @elseif ($type === 'cancel')
                            <x-heroicon-o-x-mark class="h-5 w-5 text-gray-600 dark:text-gray-300" />
                        @else
                            <x-heroicon-o-lock-closed class="h-5 w-5 text-yellow-600 dark:text-yellow-300" />
                        @endif
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900 dark:text-gray-200">
                        {{ $title }}
                    </h3>
                </div>
                <button type="button"
                    class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-700 dark:hover:text-white"
                    data-modal-hide="{{ $id }}">
                    <x-heroicon-o-x-mark class="h-5 w-5" />
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 md:p-5">
                @if ($itemName)
                    <p class="mb-4 text-sm text-gray-900 dark:text-gray-200">
                        Masukkan nama periode audit untuk konfirmasi:
                    </p>
                    <input type="text" id="confirm_name_{{ $id }}"
                        class="mb-4 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 transition-all duration-200 focus:border-sky-500 focus:ring-sky-500 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200"
                        placeholder="{{ $itemName ?? 'N/A' }}" required>
                    <p id="error_{{ $id }}" class="hidden text-sm text-red-600 dark:text-red-400"></p>
                @else
                    <p class="mb-4 text-sm text-gray-900 dark:text-gray-200">
                        Apakah Anda yakin ingin
                        {{ $type === 'delete' ? 'menghapus' : ($type === 'cancel' ? 'membatalkan' : 'menutup') }}
                        periode audit ini?
                    </p>
                @endif

                <div class="mb-4 rounded-lg bg-yellow-50 p-3 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                    <p class="text-sm">
                        <span class="font-semibold">Perhatian:</span>
                        {{ $warningMessage ?? ($type === 'delete' ? 'Menghapus periode audit ini akan menghapus seluruh riwayat terkait.' : 'Menutup periode audit ini akan mengakhiri seluruh aktivitas terkait dan tidak dapat diubah kembali.') }}
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-2">
                    <x-button type="button" color="gray" data-modal-hide="{{ $id }}">
                        Batal
                    </x-button>
                    <form action="{{ $action }}" method="POST" class="{{ $formClass }}"
                        data-expected-name="{{ $itemName }}">
                        @csrf
                        @if ($method !== 'POST')
                            @method($method)
                        @endif
                        <x-button type="submit" :color="$type === 'delete' ? 'red' : ($type === 'cancel' ? 'gray' : 'yellow')">
                            {{ $type === 'delete' ? 'Hapus' : ($type === 'cancel' ? 'Batalkan' : 'Tutup') }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
