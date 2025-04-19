@props(['id', 'title', 'action', 'method' => 'POST', 'type' => 'delete', 'periode'])

<div id="{{ $id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-700">
                <div class="flex items-center">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full {{ $type === 'delete' ? 'bg-red-100 dark:bg-red-900' : 'bg-yellow-100 dark:bg-yellow-900' }}">
                        @if ($type === 'delete')
                            <x-heroicon-o-trash class="w-5 h-5 text-red-600 dark:text-red-300" />
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
            <div class="p-4 md:p-5">
                <p class="text-sm text-gray-900 dark:text-gray-200 mb-4">
                    Untuk {{ $type === 'delete' ? 'menghapus' : 'menutup' }} periode pelaksanaan AMI ini, harap masukkan
                    nama periode:
                </p>
                <input type="text" name="confirm_nama_periode"
                    id="confirm_nama_periode_{{ $periode->periode_id }}_{{ $type }}"
                    class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 mb-4 transition-all duration-200"
                    placeholder="Masukkan nama periode" required>
                <div class="p-3 mb-4 bg-yellow-50 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300 rounded-lg">
                    <p class="text-sm">
                        <span class="font-semibold">Perhatian:</span>
                        @if ($type === 'delete')
                            Menghapus periode ini akan menghapus seluruh riwayat pelaksanaan AMI pada periode tanggal
                            tersebut.
                        @else
                            Menutup periode ini akan mengakhiri seluruh aktivitas AMI pada periode tersebut dan tidak
                            dapat diubah kembali.
                        @endif
                    </p>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" data-modal-hide="{{ $id }}"
                        class="px-4 py-2 text-sm font-medium text-gray-900 bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 dark:focus:ring-gray-600">
                        Batal
                    </button>
                    <form action="{{ $action }}" method="POST" class="{{ $type }}-periode-form">
                        @csrf
                        @if ($method !== 'POST')
                            @method($method)
                        @endif
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white {{ $type === 'delete' ? 'bg-red-600 hover:bg-red-700 focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-600' : 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-300 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-600' }} rounded-lg focus:ring-4">
                            {{ $type === 'delete' ? 'Hapus' : 'Tutup' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
