@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">

    <!-- Heading -->
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
        Dashboard
    </h1>
    <div class="flex md:flex-row flex-col gap-7">
        <div class=" w-[700px] flex md:flex-col flex-row gap-5">
            <div class="flex md:flex-row flex-col gap-5">
                <a href="#" class="block max-w-sm p-6 bg-green-200 border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 ">
                    <div class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <p class="text-md text-gray-700 dark:text-gray-400">Audit Selesai</p>
                    <p class="text-xl text-bold dark:text-gray-400"> 2 </p>
                </a>
                <a href="#" class="block max-w-sm p-6 bg-yellow-200 border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <div class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <p class="text-md text-gray-700 dark:text-gray-400">Audit dalam Proses</p>
                    <p class="text-xl text-bold dark:text-gray-400"> 3 </p>
                </a>
            </div>
            <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4 gap-2">
                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Form yang belum diisi</h5>
                    <a href="#" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">
                        View all
                    </a>
                </div>
                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center">
                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        Form 1
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center">
                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        Form 2
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center">
                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        Form 3
                                    </p>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div>
            <div class="w-[700px] overflow-x-auto shadow-md p-2 sm:rounded-lg">
                <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4 px-2 py-2">
                    <div class="">
                        <!-- Dropdown menu -->
                        <p class="text-xl font-bold">Daftar Auditee</p>
                    </div>
                </div>
                <x-table :headers="['No', 'Nama', 'Email']" :data="$users" :route="route('dashboard.index')">
                    @foreach ($users as $index => $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user['name'] }}
                        </td>
                        <td class="px-4 py-3 sm:px-6 border-r border-gray-200 dark:border-gray-600">
                            {{ $user['email'] }}
                        </td>
                    </tr>
                    @endforeach
                </x-table>
            </div>

        </div>
    </div>
</div>

@endsection