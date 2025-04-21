@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">

    <!-- Heading -->
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200 mb-8">
        Dashboard
    </h1>
    <div class="flex flex-row gap-7">
        <div class=" flex flex-col gap-5">
            <div class="flex flex-row gap-5">
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <p class="text-md text-gray-700 dark:text-gray-400">Audit dalam Proses</p>
                    <p class="text-xl text-bold dark:text-gray-400"> 3 </p>
                </a>
            </div>
            <div>


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
        </div>
        <div>
            <div class="w-[700px] overflow-x-auto shadow-md sm:rounded-lg">
                <div class="flex flex-column mb-3 sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4 px-2 py-2">
                    <div class="">
                        <!-- Dropdown menu -->
                        <p class="text-xl font-bold">Daftar Auditee</p>
                    </div>
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                    </div>
                </div>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <!-- <th scope="col" class="px-6 py-3">
                    Price
                </th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                1
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                John Doe
                            </th>
                            <td class="px-6 py-4">
                                johndoe123@gmail.com
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                2
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Jane Doe
                            </th>
                            <td class="px-6 py-4">
                                janedoe456@gmail.com
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                3
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Lionel Messi
                            </th>
                            <td class="px-6 py-4">
                                goat10@gmail.com
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                4
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Cristiano ronaldo
                            </th>
                            <td class="px-6 py-4">
                                cristiano7@gmail.com
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">
                                5
                            </td>
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Neymar Jr
                            </th>
                            <td class="px-6 py-4">
                                neymar11@gmail.com
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection