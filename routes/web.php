<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodeAuditController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('periode_audit', function () {
    return view('period-audit2');
});

// Admin routes for Periode Audit
Route::prefix('admin/periode-audit')
// ->middleware(['auth', 'admin'])
->group(function () {
    Route::get('/', [PeriodeAuditController::class, 'index'])->name('periode-audit.index');
    Route::post('/', [PeriodeAuditController::class, 'store'])->name('periode-audit.store');
    Route::get('/{periode_id}/edit', [PeriodeAuditController::class, 'edit'])->name('periode-audit.edit');
    Route::put('/{periode_id}', [PeriodeAuditController::class, 'update'])->name('periode-audit.update');
    Route::delete('/{periode_id}', [PeriodeAuditController::class, 'destroy'])->name('periode-audit.destroy');
    Route::patch('/{periode_id}/close', [PeriodeAuditController::class, 'close'])->name('periode-audit.close');
});

// Placeholder routes for other sidebar links (replace with actual controllers)
Route::get('/dashboard', fn() => view('admin.dashboard'))->middleware('auth')->name('dashboard');
Route::get('/data-unit', fn() => view('admin.data-unit'))->middleware('auth')->name('data-unit');
Route::get('/admin/jadwal-audit', function () {
    return view('jadwal-audit.index');
})->name('jadwal-audit');

Route::get('/admin/daftar-tilik', function () {
    return view('daftar-tilik.index');
})->name('daftar-tilik');

Route::get('/logout', function () {
    return redirect('/login');
})->name('logout');
Route::get('/data-instrumen', fn() => view('admin.data-instrumen'))->middleware('auth')->name('data-instrumen');
Route::get('/data-user', fn() => view('admin.data-user'))->middleware('auth')->name('data-user');
Route::get('/laporan', fn() => view('admin.laporan'))->middleware('auth')->name('laporan');
Route::post('/logout', fn() => auth()->logout() && redirect('/login'))->name('logout');

// // Authentication routes (ensure these are set up)
// Auth::routes();