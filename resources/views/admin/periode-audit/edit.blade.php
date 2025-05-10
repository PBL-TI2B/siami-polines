@extends('layouts.app')

@section('title', 'Edit Periode Audit')

@section('content')
    <div class="container mx-auto px-4 py-4 sm:px-6 lg:px-8">
        <!-- Toast Notification -->
        @if (session('success'))
            <x-toast id="toast-success" type="success" :message="session('success')" />
        @endif

        @if ($errors->any())
            <x-toast id="toast-danger" type="danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </x-toast>
        @endif

        <!-- Breadcrumb -->
        <x-breadcrumb :items="[
            ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
            ['label' => 'Periode Audit', 'url' => route('admin.periode-audit.index')],
            ['label' => 'Edit Periode'],
        ]" />

        <!-- Heading -->
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            Edit Periode Audit
        </h1>

        <!-- Form Section -->
        <div
            class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
            <form action="{{ route('periode-audit.update', $periodeAudit->periode_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-6 grid grid-cols-1 gap-6">
                    <!-- Nama Periode -->
                    <x-form-input id="nama_periode" name="nama_periode" label="Nama Periode AMI"
                        placeholder="Masukkan nama periode" :value="$periodeAudit->nama_periode" :required="true" maxlength="255" />
                </div>
                <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Tanggal Mulai -->
                    <x-form-input id="tanggal_mulai" name="tanggal_mulai" label="Tanggal Mulai"
                        placeholder="Pilih tanggal mulai" :value="$periodeAudit->tanggal_mulai->format('d-m-Y')" :required="true" :datepicker="true" />
                    <!-- Tanggal Berakhir -->
                    <x-form-input id="tanggal_berakhir" name="tanggal_berakhir" label="Tanggal Berakhir"
                        placeholder="Pilih tanggal berakhir" :value="$periodeAudit->tanggal_berakhir->format('d-m-Y')" :required="true" :datepicker="true" />
                </div>

                <!-- Form Buttons -->
                <div class="flex space-x-3">
                    <x-button type="submit" color="sky" icon="heroicon-o-check">
                        Simpan Perubahan
                    </x-button>
                    <x-button color="gray" icon="heroicon-o-x-mark" href="{{ route('admin.periode-audit.index') }}">
                        Batal
                    </x-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script untuk mengatur toast -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Otomatis tutup toast setelah 5 detik
                const toasts = ['toast-success', 'toast-danger'];
                toasts.forEach(toastId => {
                    const toast = document.getElementById(toastId);
                    if (toast) {
                        toast.classList.remove('opacity-0');
                        toast.classList.add('opacity-100');
                        setTimeout(() => {
                            toast.classList.remove('opacity-100');
                            toast.classList.add('opacity-0');
                            setTimeout(() => {
                                toast.classList.add('hidden');
                            }, 300);
                        }, 5000);
                    }
                });
            });
        </script>
    @endpush
@endsection
