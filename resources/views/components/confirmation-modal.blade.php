@props([
    'id',
    'title',
    'action',
    'method' => 'POST',
    'type' => 'delete',
    'formClass',
    'itemName' => null, // Nama item untuk validasi (opsional)
    'warningMessage' => null, // Pesan peringatan kustom (opsional)
])

<div id="{{ $id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-700">
                <div class="flex items-center">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full {{ $type === 'delete' ? 'bg-red-100 dark:bg-red-900' : ($type === 'cancel' ? 'bg-gray-100 dark:bg-gray-900' : 'bg-yellow-100 dark:bg-yellow-900') }}">
                        @if ($type === 'delete')
                            <x-heroicon-o-trash class="w-5 h-5 text-red-600 dark:text-red-300" />
                        @elseif ($type === 'cancel')
                            <x-heroicon-o-x-mark class="w-5 h-5 text-gray-600 dark:text-gray-300" />
                        @else
                            <x-heroicon-o-lock-closed class="w-5 h-5 text-yellow-600 dark:text-yellow-300" />
                        @endif
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900 dark:text-gray-200">
                        {{ $title }}
                    </h3>
                </div>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-700 dark:hover:text-white"
                    data-modal-hide="{{ $id }}">
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 md:p-5">
                <p class="text-sm text-gray-900 dark:text-gray-200 mb-4">
                    Untuk {{ $type === 'delete' ? 'menghapus' : ($type === 'cancel' ? 'membatalkan' : 'menutup') }} data
                    ini, harap masukkan nama:
                </p>
                @if ($itemName)
                    <input type="text" name="confirm_name" id="confirm_name_{{ $id }}"
                        class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 mb-4 transition-all duration-200"
                        placeholder="Masukkan nama" required>
                @endif

                <div class="p-3 mb-4 bg-yellow-50 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 rounded-lg">
                    <p class="text-sm">
                        <span class="font-semibold">Perhatian:</span>
                        @if ($warningMessage)
                            {{ $warningMessage }}
                        @else
                            @if ($type === 'delete')
                                Menghapus data ini akan menghapus seluruh riwayat terkait.
                            @elseif ($type === 'cancel')
                                Membatalkan akan menghapus semua perubahan yang belum disimpan.
                            @else
                                Menutup data ini akan mengakhiri seluruh aktivitas terkait dan tidak dapat diubah
                                kembali.
                            @endif
                        @endif
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-2">
                    <x-button type="button" color="gray" data-modal-hide="{{ $id }}">
                        Batal
                    </x-button>
                    <form action="{{ $action }}" method="POST" class="{{ $formClass }}">
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
