@extends('layouts.app')

@section('title', 'Edit Laporan Temuan')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <x-breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('auditor.dashboard.index')],
        ['label' => 'Audit', 'url' => route('auditor.audit.index')],
        ['label' => 'Laporan Temuan', 'url' => route('auditor.laporan.index', ['auditingId' => $auditingId])],
        ['label' => 'Edit Laporan', 'url' => '#'],
    ]" />

    <!-- Heading -->
    <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
        Edit Laporan Temuan
    </h1>

    <div class="mb-3 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
        {{-- Toast Notifications (These are now fully managed by Laravel session after full page reload) --}}
        @if (session('success'))
            <x-toast id="toast-success" type="success" :message="session('success')" />
        @endif

        @if (session('error') || $errors->any())
            <x-toast id="toast-danger" type="danger">
                @if (session('error'))
                    {{ session('error') }}<br>
                @endif
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </x-toast>
        @endif

        {{-- Removed Loading Indicator HTML --}}


        <form id="laporan-form" method="POST" action="{{ route('auditor.laporan.update', ['auditingId' => $auditingId, 'laporan_temuan_id' => $findingData['laporan_temuan_id']]) }}" class="space-y-6">
            @csrf {{-- Required for Laravel --}}
            @method('PUT') {{-- Use PUT method for update --}}
            <input type="hidden" name="auditing_id" value="{{ $auditingId }}">
            <input type="hidden" name="laporan_temuan_id" value="{{ $findingData['laporan_temuan_id'] }}">

            {{-- --- FORM SECTION FOR A SINGLE FINDING ONLY --- --}}
            @if (empty($kriterias))
                <div class="mt-1 text-sm text-red-600 dark:text-red-400">
                    Tidak ada kriteria tersedia. <button type="button" onclick="window.location.reload()" class="underline hover:text-red-700">Coba lagi</button> atau
                    <a href="#" class="underline hover:text-red-700">hubungi administrator</a>.
                </div>
            @else
                <div class="finding-item mb-6 p-4 border border-gray-200 rounded-lg dark:border-gray-600">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="kriteria_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Standar <span class="text-red-500">*</span></label>
                            <select name="kriteria_id" id="kriteria_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>
                                <option value="" disabled>Pilih Standar</option>
                                @foreach ($kriterias as $kriteria)
                                    <option value="{{ $kriteria['kriteria_id'] }}" {{ old('kriteria_id', $findingData['kriteria_id'] ?? '') == $kriteria['kriteria_id'] ? 'selected' : '' }}>
                                        {{ $kriteria['nama_kriteria'] ?? 'Standar ' . $kriteria['kriteria_id'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="uraian_temuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Uraian Temuan <span class="text-red-500">*</span></label>
                            <textarea name="uraian_temuan" id="uraian_temuan" rows="4" placeholder="Masukkan uraian temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>{{ old('uraian_temuan', $findingData['uraian_temuan'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label for="kategori_temuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Temuan <span class="text-red-500">*</span></label>
                            <select name="kategori_temuan" id="kategori_temuan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>
                                <option value="" disabled>Pilih Kategori</option>
                                @foreach (['NC', 'AOC', 'OFI'] as $kategori)
                                    <option value="{{ $kategori }}" {{ old('kategori_temuan', $findingData['kategori_temuan'] ?? '') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="saran_perbaikan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Saran Perbaikan</label>
                            <textarea name="saran_perbaikan" id="saran_perbaikan" rows="4" placeholder="Masukkan saran perbaikan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm">{{ old('saran_perbaikan', $findingData['saran_perbaikan'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            @endif
            {{-- --- END OF FORM SECTION FOR A SINGLE FINDING ONLY --- --}}

            {{-- Deskripsi Kategori Temuan --}}
            <div class="mt-6 text-sm text-gray-700 dark:text-gray-300 space-y-3">
                <p><strong>NC (Non-Conformity)</strong> adalah temuan yang bersifat ketidaksesuaian mayor, yaitu temuan-temuan yang memiliki dampak luas/kritikal terhadap persyaratan mutu produk/pelayanan dan persyaratan sistem manajemen mutu.</p>
                <p class="pl-4 italic">Contoh: Pelanggaran sistem secara total (sistem tidak dilaksanakan).</p>

                <p><strong>AOC (Area of Concern)</strong> adalah temuan yang bersifat ketidaksesuaian minor, yaitu temuan-temuan yang memiliki dampak kecil/terbatas terhadap persyaratan mutu produk/pelayanan dan persyaratan sistem manajemen mutu.</p>
                <p class="pl-4 italic">Contoh: Ketidaksempurnaan dan ketidakkonsistenan dalam penerapan sistem.</p>

                <p><strong>OFI (Opportunity for Improvement)</strong> adalah temuan yang bukan merupakan ketidaksesuaian yang dimaksudkan untuk penyempurnaan-penyempurnaan.</p>
                <p class="pl-4 italic">** Catatan: Hanya diisi bila auditor dapat memastikan saran perbaikannya adalah efektif.</p>
            </div>


            <div class="mt-6 flex gap-3 justify-end">
                <button type="submit" class="bg-sky-600 text-white text-sm font-medium py-2 px-4 rounded hover:bg-blue-700 {{ empty($kriterias) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ empty($kriterias) ? 'disabled' : '' }}>
                    Perbarui
                </button>
                <button type="button" class="bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 text-sm font-medium py-2 px-4 rounded hover:bg-gray-300 dark:hover:bg-gray-600" onclick="window.location.href='{{ route('auditor.laporan.index', ['auditingId' => $auditingId]) }}'">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('laporan-form');
        const submitButton = form.querySelector('button[type="submit"]');
        // Removed loadingIndicator constant as the element is no longer in HTML
        // const loadingIndicator = document.getElementById('loading-indicator');

        // Function to create and display a dynamic toast message
        // This function is still here but will only be used for client-side validation hints now.
        function showToast(message, type) {
            let toastContainer = document.getElementById('toast-notification-container');
            if (!toastContainer) {
                const newContainer = document.createElement('div');
                newContainer.id = 'toast-notification-container';
                newContainer.className = 'fixed top-4 right-4 z-50 flex flex-col items-end space-y-3';
                document.body.appendChild(newContainer);
                toastContainer = newContainer;
            }

            const toast = document.createElement('div');
            let bgColorClass = '';
            let textColorClass = '';
            let borderColorClass = '';

            if (type === 'success') {
                bgColorClass = 'bg-green-50 dark:bg-green-900/50';
                textColorClass = 'text-green-700 dark:text-green-300';
                borderColorClass = 'border-green-200 dark:border-green-700';
            } else if (type === 'danger') {
                bgColorClass = 'bg-red-50 dark:bg-red-900/50';
                textColorClass = 'text-red-700 dark:text-red-300';
                borderColorClass = 'border-red-200 dark:border-red-700';
            } else {
                bgColorClass = 'bg-blue-50 dark:bg-blue-900/50';
                textColorClass = 'text-blue-700 dark:text-blue-300';
                borderColorClass = 'border-blue-200 dark:border-blue-700';
            }

            toast.className = `p-4 rounded-lg text-sm border shadow-md transition-all duration-300 ease-out transform translate-x-full opacity-0 ${bgColorClass} ${textColorClass} ${borderColorClass}`;
            toast.innerHTML = `<div>${message}</div>`;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            }, 100);

            setTimeout(() => {
                toast.classList.remove('translate-x-0', 'opacity-100');
                toast.classList.add('translate-x-full', 'opacity-0');
                toast.addEventListener('transitionend', () => toast.remove());
            }, 5000);
        }

        // Form submission handler
        form.addEventListener('submit', (e) => { // Removed 'async' keyword
            // No e.preventDefault() here; let the form submit traditionally

            // Disable button immediately on submit
            submitButton.disabled = true;
            // Removed loadingIndicator.classList.remove('hidden');

            // Client-side validation before sending (basic check for required fields)
            // This part runs before the form is actually sent, providing immediate feedback.
            // If validation fails, we stop the submission and re-enable button.
            const kriteriaIdInput = form.querySelector('[name="kriteria_id"]');
            const uraianTemuanInput = form.querySelector('[name="uraian_temuan"]');
            const kategoriTemuanInput = form.querySelector('[name="kategori_temuan"]');

            if (!kriteriaIdInput.value || !uraianTemuanInput.value.trim() || !kategoriTemuanInput.value) {
                showToast('Harap lengkapi semua kolom wajib.', 'danger');
                submitButton.disabled = false;
                // Removed loadingIndicator.classList.add('hidden');
                e.preventDefault(); // Prevent form submission if client-side validation fails
                return;
            }

            // If client-side validation passes, the form will submit normally.
            // The loading indicator (if it were there) would remain visible until the page reloads.
        });

        // Logic to disable submit button if no kriterias are available on initial load
        if (@json($kriterias).length === 0) {
            submitButton.disabled = true;
            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        }

        // Removed add/remove finding logic as this form is for a single finding
    });
</script>
@endp
