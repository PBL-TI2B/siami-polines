@extends('layouts.app')

@section('title', 'Akun')

@section('content')
    <div class="max-w-3xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4"> Edit Profile</h1>

        <!-- Flash Message Container -->
        @if (session('success'))
            <div class="fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg bg-green-500 text-white">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg bg-red-500 text-white">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

            @csrf
            <div class="mb-4">
                <label for="old_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                <input type="password" name="old_password" id="old_password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan password lama...">
                @error('old_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="old_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="password" name="old_password" id="old_password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan password lama...">
                @error('old_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="old_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                <input type="password" name="old_password" id="old_password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan password lama...">
                @error('old_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIP</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-sky-500 focus:border-sky-500 sm:text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600"
                    placeholder="Masukkan password baru...">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-3 flex gap-3">
                <x-button type="submit" color="sky" icon="heroicon-o-plus">
                    Simpan
                </x-button>
                <x-button color="gray" icon="heroicon-o-x-mark" href="{{ route('auditor.daftar-tilik.index') }}">
                    Batal
                </x-button>
            </div>
        </form>
    </div>
@endsection