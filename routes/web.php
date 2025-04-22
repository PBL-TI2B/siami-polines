<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodeAuditController;
use App\Http\Controllers\JadwalAuditController;
use App\Http\Controllers\DaftarTilikController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\DataInstrumenController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

// Route untuk Dashboard

// Route untuk Admin dengan prefix 'admin'
Route::prefix('admin')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    });

    // Periode Audit
    Route::prefix('periode-audit')->group(function () {
        Route::get('/', [PeriodeAuditController::class, 'index'])->name('periode-audit.index');
        Route::get('/create', [PeriodeAuditController::class, 'create'])->name('periode-audit.create');
        Route::post('/', [PeriodeAuditController::class, 'store'])->name('periode-audit.store');
        Route::get('/{id}/edit', [PeriodeAuditController::class, 'edit'])->name('periode-audit.edit');
        Route::put('/{id}', [PeriodeAuditController::class, 'update'])->name('periode-audit.update');
        Route::delete('/{id}', [PeriodeAuditController::class, 'destroy'])->name('periode-audit.destroy');
        Route::patch('/{id}/close', [PeriodeAuditController::class, 'close'])->name('periode-audit.close');
    });

    // Jadwal Audit
    Route::prefix('jadwal-audit')->group(function () {
        Route::get('/', [JadwalAuditController::class, 'index'])->name('jadwal-audit');
    });

    // Daftar Tilik
    Route::prefix('daftar-tilik')->group(function () {
        Route::get('/', [DaftarTilikController::class, 'index'])->name('daftar-tilik');
    });

    // Data Unit (Unit Kerja)
    Route::prefix('unit-kerja')->group(function () {
        Route::get('/{type?}', [UnitKerjaController::class, 'index'])->name('unit-kerja');
        Route::get('/create', [UnitKerjaController::class, 'create'])->name('unit-kerja.create');
        Route::post('/', [UnitKerjaController::class, 'store'])->name('unit-kerja.store');
        Route::get('/{id}/edit', [UnitKerjaController::class, 'edit'])->name('unit-kerja.edit');
        Route::put('/{id}', [UnitKerjaController::class, 'update'])->name('unit-kerja.update');
        Route::delete('/{id}', [UnitKerjaController::class, 'destroy'])->name('unit-kerja.destroy');
    });

    // Data Instrumen
    Route::prefix('data-instrumen')->group(function () {
        Route::get('/{type?}', [DataInstrumenController::class, 'index'])->name('data-instrumen');
    });

    // Data User
    Route::prefix('data-user')->group(function () {
        Route::get('/', [DataUserController::class, 'index'])->name('data-user');
    });

    // Laporan
    Route::prefix('laporan')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('laporan');
    });
});

// Route untuk Logout
Route::post('/logout', function () {
    // Logika logout (misalnya menggunakan Auth::logout())
    return redirect('/login');
})->name('logout');
