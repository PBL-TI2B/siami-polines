<?php
@extends('layouts.app')

@section('title', 'Daftar Titik')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        <ol class="list-reset flex">
            <li><a href="{{ route('dashboard.index') }}" class="text-blue-600 hover:underline dark:text-blue-400">Dashboard</a></li>
            <li class="mx-2">/</li>
            <li class="text-gray-800 dark:text-gray-200">Daftar Tilik</li>
        </ol>
    </nav>

    <!-- Heading -->
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">
            Daftar Periksa
        </h1>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-2 mb-4">
        <button onclick="openModal('add')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded dark:bg-blue-700 dark:hover:bg-blue-800">
            + Tambah Pertanyaan
        </button>
        <button onclick="openModal('edit')" class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded dark:bg-blue-800 dark:hover:bg-blue-900">
            ✏️ Edit Pertanyaan
        </button>
        <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded dark:bg-blue-600 dark:hover:bg-blue-700">
            ⬇️ Unduh Data
        </button>
        <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded dark:bg-yellow-600 dark:hover:bg-yellow-700">
            ⬆️ Import Data
        </button>
    </div>

    <!-- Filter & Search -->
    <div class="flex flex-wrap items-center justify-between mb-4 gap-2">
        <div class="flex gap-2">
            <select class="border border-gray-300 rounded px-2 py-1 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                <option>Pilih Unit</option>
            </select>
            <select class="border border-gray-300 rounded px-2 py-1 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                <option>Pilih Periode Ami</option>
            </select>
        </div>
        <input type="text" placeholder="Search" class="border border-gray-300 rounded px-3 py-1 w-64 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" />
    </div>

    <!-- Kriteria Container -->
    <div id="kriteria-container" class="border border-blue-500 rounded p-4 bg-white shadow dark:bg-gray-800 dark:border-gray-600">
        <!-- Konten akan dimuat via JavaScript -->
    </div>

    <!-- Pagination -->
    <div class="flex justify-end gap-2 mt-4">
        <button onclick="showPrevious()" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-1 px-3 rounded dark:bg-yellow-600 dark:hover:bg-yellow-700">
            Previous
        </button>
        <button onclick="showNext()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded dark:bg-blue-700 dark:hover:bg-blue-800">
            Next
        </button>
    </div>

    <!-- Modal for Add/Edit -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg w-1/3 dark:bg-gray-800">
            <h3 class="text-xl font-bold mb-4 dark:text-gray-100" id="modalTitle"></h3>
            <div>
                <!-- Modal content will go here -->
                <input type="text" placeholder="Masukkan Pertanyaan" id="questionInput" class="border border-gray-300 rounded px-4 py-2 mb-4 w-full dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" />
                <button onclick="closeModal()" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded w-full dark:bg-gray-600 dark:hover:bg-gray-700">
                    Close
                </button>
                <button id="saveButton" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded w-full mt-2 dark:bg-blue-700 dark:hover:bg-blue-800">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>