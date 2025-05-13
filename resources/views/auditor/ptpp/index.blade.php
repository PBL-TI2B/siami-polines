@extends('layouts.app')

@section('title', 'Ptpp')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">

        <!-- Heading -->
        <div>
            <x-breadcrumb :items="[['label' => 'Ptpp', 'url' => route('auditor.ptpp.index')]]" />
        <div>
        <h1 class="mb-8 text-3xl font-bold text-gray-900 dark:text-gray-200">
            PTPP
        </h1>

        <!-- Form Section -->
        <div
            class="mb-8 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-200 dark:border-gray-700 dark:bg-gray-800">
            <form>
                <div class="mb-6 grid grid-cols-1 gap-6">
                    <!-- Nama Periode -->
                    <x-form-input id="ptpp" name="ptpp" label="Kepada Yth. " placeholder="Nama Standar"
                        :required="true" maxlength="255" />
                    <div class="grid gap-2">
                        <label class="inline-flex" for="Jurusan/bagian/unit">Jurusan/bagian/unit</label>
                        <select id="Jurusan/bagian/unit"
                            class="appearance-none rounded-md border-gray-300 bg-gray-50 px-4 py-2 pr-10 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">UPT</option>
                            <option value="">Jurusan</option>
                            <option value="">Prodi</option>
                        </select>
                    </div>

                    <x-form-input id="ptpp" name="ptpp" label="Prosedur/Proses"
                        placeholder="Proses atau proses yang digunakan" :required="true" maxlength="255" />

                    <div class="grid gap-2">
                        <label class="inline-flex" for="Jurusan/bagian/unit">Hasil Temuan Ketidaksesuaian</label>
                        <textarea placeholder="Isi hasil temuan disini"
                            class="block h-32 w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 transition-all duration-200 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            name="" id=""></textarea>
                    </div>
                    <x-form-input id="ptpp" name="ptpp" label="Kategori Temuan"
                        placeholder="pilih kategori temuan ketidaksesuaian" :required="true" maxlength="255" />
                    <x-form-input id="ptpp" name="ptpp" label="Tanggal Perbaikan" placeholder="28 Oktober 2025"
                        :required="true" maxlength="255" />
                    <div class="grid gap-2">
                        <label class="inline-flex" for="Auditor">Auditor</label>
                        <select id="Auditor"
                            class="appearance-none rounded-md border-gray-300 bg-gray-50 px-4 py-2 pr-10 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Auditor 1</option>
                            <option value="">Auditor 2</option>
                        </select>
                    </div>
                    <div class="grid gap-2">
                        <label class="inline-flex" for="Auditor">Auditee</label>
                        <select id="Auditor"
                            class="appearance-none rounded-md border-gray-300 bg-gray-50 px-4 py-2 pr-10 text-sm text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Auditee 1</option>
                            <option value="">Auditee 2</option>
                        </select>
                    </div>
                    <div class="grid gap-2">
                        <label class="inline-flex" for="Jurusan/bagian/unit">Analisa Penyebab</label>
                        <textarea placeholder="Isi analisa penyebab pada kolom ini"
                            class="block h-32 w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 transition-all duration-200 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            name="" id=""></textarea>
                    </div>
                    <div class="grid gap-2">
                        <label class="inline-flex" for="Jurusan/bagian/unit">Tindakan Perbaikan</label>
                        <textarea placeholder="Isi tindakan perbaikan pada kolom ini"
                            class="block h-32 w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 transition-all duration-200 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            name="" id=""></textarea>
                    </div>
                    <div class="grid gap-2">
                        <label class="inline-flex" for="Jurusan/bagian/unit">Tindakan Pencegahan</label>
                        <textarea placeholder="Isi tindakan pencegahan pada kolom ini"
                            class="block h-32 w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 transition-all duration-200 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            name="" id=""></textarea>
                    </div>
                    <div class="grid gap-2">
                        <label class="inline-flex" for="Jurusan/bagian/unit">Tanda Tangan Auditee</label>
                        <textarea placeholder=""
                            class="block h-32 w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 transition-all duration-200 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            name="" id=""></textarea>
                    </div>
                    <div class="grid gap-2">
                        <label class="inline-flex" for="Jurusan/bagian/unit">Pemeriksaan Hasil Tindakan Perbaikan (close
                            out): (diisi oleh auditor)</label>
                        <textarea placeholder="Isi Hasil Pemeriksaan Tindakan Perbaikan pada kolom ini"
                            class="block h-32 w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 transition-all duration-200 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            name="" id=""></textarea>
                    </div>
                    <div class="grid gap-2">
                        <label class="inline-flex" for="Jurusan/bagian/unit">Hasil Verifikasi</label>
                        <textarea placeholder="Isi Hasil Verifikasi pada kolom ini"
                            class="block h-32 w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 transition-all duration-200 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            name="" id=""></textarea>
                    </div>
                    <div class="grid gap-2">
                        <label class="inline-flex" for="Jurusan/bagian/unit">Tanda Tangan Auditor</label>
                        <textarea placeholder=""
                            class="block h-32 w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 transition-all duration-200 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            name="" id=""></textarea>
                    </div>
                    <div class="grid gap-2">
                        <label class="inline-flex" for="Jurusan/bagian/unit">Tanda Tangan Auditee</label>
                        <textarea placeholder=""
                            class="block h-32 w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 transition-all duration-200 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            name="" id=""></textarea>
                    </div>


                </div>
        </div>
        <div class="mb-6 grid grid-cols-1 gap-6 md:grid-cols-2">
        </div>

        <!-- Form Buttons -->
        <div class="flex space-x-3">
            <x-button type="submit" color="sky" icon="heroicon-o-check">
                Simpan
            </x-button>
            <x-button color="gray" icon="heroicon-o-x-mark" href="{{ route('admin.periode-audit.index') }}">
                Batal
            </x-button>
        </div>
        </form>
    </div>

@endsection
