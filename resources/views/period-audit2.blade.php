<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>SiAMI Polines - Periode Audit</title>
</head>
<body class="font-inter bg-neutral-50">
<div class="min-h-screen relative">
  <!-- Sidebar -->
  <div class="w-80 h-screen fixed left-0 top-0 bg-white shadow-xl">
    <div class="p-8 pt-6">
      <div class="space-y-1">
        <x-sidebar-link icon="chart-pie" text="Dashboard" />
        <x-sidebar-link icon="calendar-days" text="Periode Audit" active />
        <x-sidebar-link icon="building-office" text="Data Unit" />
        <x-sidebar-link icon="clipboard-document-list" text="Data Instrumen" />
        <x-sidebar-link icon="user-group" text="Data User" />
        <x-sidebar-link icon="document-chart-bar" text="Laporan" />
        <x-sidebar-link icon="arrow-left-on-rectangle" text="Logout" />
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="ml-80 p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-1">
      <div class="flex items-center gap-2 text-sm font-medium text-neutral-500">
        <span>Data User</span>
        <x-heroicon-o-chevron-right class="w-4 h-4" />
        <span class="text-sky-800">List</span>
      </div>
      <div class="flex items-center gap-4">
        <div class="p-2 rounded-lg border border-white">
          <x-heroicon-o-bell class="w-6 h-6 text-white" />
        </div>
        <div class="flex items-center gap-3">
          <x-heroicon-o-user-circle class="w-10 h-10 text-white" />
          <span class="text-white font-semibold">Nama Dosen, S.Kom,. M.Kom</span>
        </div>
      </div>
    </div>
    <h1 class="fi-header-heading text-3xl font-bold tracking-tight text-gray-950 sm:text-3xl mb-12">
            Periode Audit Mutu Internal
        </h1>

    <!-- Content -->
    <div class="space-y-8">
      <!-- Form Section -->
      <div class="rounded-2xl">
        
        <div class="space-y-4">
          <div>
            <label class="block text-base font-semibold mb-3">Nama Periode AMI</label>
            <input type="text" 
                   class="w-full px-4 py-3 border border-gray-300 focus:border-blue-400 rounded-xl bg-white text-gray-400 placeholder-gray-400 text-sm"
                   placeholder="Nama Periode AMI">    
          </div>
          
          <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
              <label class="block text-bsae font-semibold mb-3">Tanggal Mulai</label>
              <div class="relative">
                <input type="date" 
                       class="w-full px-4 py-3 border border-gray-300 focus:border-blue-400 rounded-xl bg-white text-gray-400 text-sm ">
                <!-- <x-heroicon-o-calendar class="w-6 h-6 absolute right-4 top-4 text-gray-400" /> -->
              </div>
            </div>
            
            <div>
              <label class="block text-base font-semibold mb-3">Tanggal Berakhir</label>
              <div class="relative">
                <input type="date" 
                       class="w-full px-4 py-3 border border-gray-300 focus:border-blue-400 rounded-xl bg-white text-gray-400 text-sm">
                <!-- <x-heroicon-o-calendar class="w-6 h-6 absolute right-4 top-4 text-gray-400" /> -->
              </div>
            </div>
          </div>
          
          <button class="bg-sky-800 text-white px-4 py-3 rounded-xl flex items-center gap-2 hover:bg-sky-900 transition">
            <x-heroicon-o-plus class="w-6 h-6" />
            <span class="text-sm font-semibold">Tambah Periode</span>
          </button>
        </div>
      </div>

      <!-- Table Section -->
      <div class="bg-white rounded-2xl border border-gray-300 overflow-hidden">
        <!-- Table Controls -->
        <div class="px-6 py-4 border-gray-300 flex justify-between items-center">
          <div class="flex items-center gap-2 text-neutral-500">
            <span class="text-sm">Show</span>
            <select class="px-2 py-2 border rounded-xl text-sm">
              <option>5</option>
              <option>10</option>
              <option>25</option>
              <option>50</option>
              </select>
              <span class="text-sm">entries</span>
          </div>
          <div class="relative">
            <input type="search" 
                   placeholder="Search" 
                   class="pl-11 pr-4 py-2 border border-gray-300 rounded-xl w-65 text-sm">
            <x-heroicon-o-magnifying-glass class="w-5 h-5 absolute left-3.5 top-2 text-neutral-400" />
          </div>
        </div>

        <!-- Table -->
        <table class="w-full">
          <thead class="bg-neutral-50 border-y border-gray-300">
            <tr>
              <th class="px-6 py-4 text-left font-semibold"><input type="checkbox" class="rounded border-gray-300"></th>
              <th class="px-4 py-4 text-left text-sm font-semibold">No</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">Nama Periode AMI</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal Mulai</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal Berakhir</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
              <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-y border-gray-300">
              <td class="px-6 py-4 text-sm"><input type="checkbox" class="rounded border-gray-300"></td>
              <td class="px-4 py-4 text-sm text-center">1</td>
              <td class="px-6 py-4 text-sm">Audit Mutu Internal 2024</td>
              <td class="px-6 py-4 text-sm">1 Januari 2024</td>
              <td class="px-6 py-4 text-sm">1 Mei 2024</td>
              <td class="px-6 py-4 text-sm">
                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">Berakhir</span>
              </td>
              <td class="px-6 py-4">
                <div class="flex gap-2">
                  <button class="p-2 bg-yellow-400 text-white rounded-lg flex gap-1 hover:bg-yellow-500">
                    <x-heroicon-o-lock-closed class="w-5 h-5 text-white -text-sm" />
                    <span class="text-sm">Tutup</span>
                  </button>
                  <button class="p-2 bg-sky-800 text-white rounded-lg flex gap-1 hover:bg-sky-900">
                    <x-heroicon-o-pencil class="w-5 h-5 text-white" />
                    <span class="text-sm">Edit</span>
                  </button>
                  <button class="p-2 bg-red-500 text-white rounded-lg flex gap-1 hover:bg-red-600">
                    <x-heroicon-o-trash class="w-5 h-5 text-white" />
                    <span class="text-sm">Delete</span>
                  </button>
                </div>
              </td>
            </tr>
            <tr class="border-y border-gray-300">
              <td class="px-6 py-4 text-sm"><input type="checkbox" class="rounded border-gray-300"></td>
              <td class="px-4 py-4 text-sm text-center">2</td>
              <td class="px-6 py-4 text-sm">Audit Mutu Internal 2025</td>
              <td class="px-6 py-4 text-sm">5 Januari 2025</td>
              <td class="px-6 py-4 text-sm">8 Mei 2025</td>
              <td class="px-6 py-4 text-sm">
                <span class="px-3 py-1 rounded-full bg-sky-100 text-sky-800">Sedang Berjalan</span>
              </td>
              <td class="px-6 py-4">
                <div class="flex gap-2">
                  <button class="p-2 bg-yellow-400 text-white rounded-lg flex gap-1 hover:bg-yellow-500">
                    <x-heroicon-o-lock-closed class="w-5 h-5 text-white -text-sm" />
                    <span class="text-sm">Tutup</span>
                  </button>
                  <button class="p-2 bg-sky-800 text-white rounded-lg flex gap-1 hover:bg-sky-900">
                    <x-heroicon-o-pencil class="w-5 h-5 text-white" />
                    <span class="text-sm">Edit</span>
                  </button>
                  <button class="p-2 bg-red-500 text-white rounded-lg flex gap-1 hover:bg-red-600">
                    <x-heroicon-o-trash class="w-5 h-5 text-white" />
                    <span class="text-sm">Delete</span>
                  </button>
                </div>
              </td>
            </tr>
            <!-- Tambahkan baris lainnya -->
          </tbody>
        </table>

        <!-- Table Footer -->
        <div class="px-6 py-4 text-neutral-500 text-sm">
          Showing 1 to 5 of 5 results
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>