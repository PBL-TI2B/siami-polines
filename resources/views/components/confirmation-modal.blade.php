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
                        class="flex items-center justify-center w-10 h-10 rounded-full {{ 
                            $type === 'delete' ? 'bg-red-100 dark:bg-red-900' : 
                            ($type === 'cancel' ? 'bg-gray-100 dark:bg-gray-900' : 
                            ($type === 'lock' ? 'bg-blue-100 dark:bg-blue-900' :
                            ($type === 'accept' ? 'bg-green-100 dark:bg-green-900' :
                            ($type === 'revision' ? 'bg-yellow-100 dark:bg-yellow-900' : 'bg-yellow-100 dark:bg-yellow-900'))))
                        }}">
                        @if ($type === 'delete')
                            <x-heroicon-o-trash class="w-5 h-5 text-red-600 dark:text-red-300" />
                        @elseif ($type === 'cancel')
                            <x-heroicon-o-x-mark class="w-5 h-5 text-gray-600 dark:text-gray-300" />
                        @elseif ($type === 'lock')
                            <x-heroicon-o-lock-closed class="w-5 h-5 text-blue-600 dark:text-blue-300" />
                        @elseif ($type === 'accept')
                            <x-heroicon-o-check class="w-5 h-5 text-green-600 dark:text-green-300" />
                        @elseif ($type === 'revision')
                            <x-heroicon-o-arrow-path class="w-5 h-5 text-yellow-600 dark:text-yellow-300" />
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
                            @elseif ($type === 'lock')
                                Mengunci data ini akan mencegah perubahan lebih lanjut.
                            @elseif ($type === 'accept')
                                Menerima akan memfinalisasi data dan melanjutkan ke tahap berikutnya.
                            @elseif ($type === 'revision')
                                Meminta revisi akan mengirim data kembali untuk diperbaiki.
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
                        {{ $slot }}
                        <x-button type="submit" :color="$type === 'delete' ? 'red' : ($type === 'cancel' ? 'gray' : ($type === 'lock' ? 'sky' : ($type === 'accept' ? 'green' : ($type === 'revision' ? 'yellow' : 'yellow'))))">
                            {{ $type === 'delete' ? 'Hapus' : ($type === 'cancel' ? 'Batalkan' : ($type === 'lock' ? 'Submit & Kunci' : ($type === 'accept' ? 'Terima' : ($type === 'revision' ? 'Minta Revisi' : 'Tutup')))) }}
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
