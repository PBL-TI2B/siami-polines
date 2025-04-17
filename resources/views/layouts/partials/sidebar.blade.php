<aside class="w-80 h-screen fixed left-0 top-0 bg-white shadow-xl">
    <div class="p-8 pt-6">
        <!-- Logo -->
        <div class="mb-12 flex items-center gap-3">
            <img src="/logo.png" class="w-14 h-16" alt="Logo">
            <span class="text-2xl font-bold text-sky-800">SiAMI</span>
        </div>

        <!-- Navigation Menu -->
        <nav class="space-y-1">
            <x-sidebar-link icon="chart-pie" text="Dashboard" />
            <x-sidebar-link icon="calendar-days" text="Periode Audit" active />
            <x-sidebar-link icon="building-office" text="Data Unit" />
            <x-sidebar-link icon="clipboard-document-list" text="Data Instrumen" />
            <x-sidebar-link icon="user-group" text="Data User" />
            <x-sidebar-link icon="document-chart-bar" text="Laporan" />
            <x-sidebar-link icon="arrow-left-on-rectangle" text="Logout" />
        </nav>
    </div>
</aside>