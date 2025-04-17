<header class="border-b border-gray-200">
    <div class="flex justify-between items-center p-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm font-medium text-neutral-500">
            @yield('breadcrumb')
        </div>

        <!-- User Menu -->
        <div class="flex items-center gap-4">
            <button class="p-2 rounded-lg border border-white bg-sky-800">
                <x-heroicon-o-bell class="w-6 h-6 text-white" />
            </button>
            <div class="flex items-center gap-3">
                <x-heroicon-o-user-circle class="w-10 h-10 text-sky-800" />
                <span class="text-sky-800 font-semibold">Nama Dosen, S.Kom,. M.Kom</span>
            </div>
        </div>
    </div>
</header>