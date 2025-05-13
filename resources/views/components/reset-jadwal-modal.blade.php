@props([
    'id',
    'action',
    'title' => 'Konfirmasi Reset Semua Jadwal',
    'warningMessage' => 'Reset ini akan menghapus seluruh data jadwal audit yang telah dibuat.',
])

<div id="{{ $id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-700">
                <div class="flex items-center">
                    <div
                        class="flex items-center justify-center w-10 h-10 rounded-full bg-red-100 dark:bg-red-900">
                        <x-heroicon-o-trash class="w-5 h-5 text-red-600 dark:text-red-300" />
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
                        {{ $warningMessage }}
                    </p>
                </div>
                <form action="{{ $action }}" method="POST" onsubmit="return validateResetInput('{{ $id }}')">
                    @csrf
                    <div class="mb-4">
                        <input type="text" id="reset-input-{{ $id }}" name="reset_confirmation"
                            class="block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:text-white"
                            placeholder="Ketik 'RESET' untuk konfirmasi" required>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <x-button type="button" color="gray" data-modal-hide="{{ $id }}">
                            Batal
                        </x-button>
                        <x-button type="submit" color="red">
                            Reset Semua Jadwal
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan script validasi -->
@once
    <script>
        function validateResetInput(id) {
            const input = document.getElementById('reset-input-' + id);
            if (input && input.value.trim() !== 'RESET') {
                alert('Konfirmasi tidak valid. Ketik "RESET" dengan huruf kapital.');
                input.focus();
                return false;
            }
            return true;
        }
    </script>
@endonce