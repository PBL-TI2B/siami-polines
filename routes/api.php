<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Api\PeriodeAuditController;
use App\Http\Controllers\SasaranStrategisController;
use App\Http\Controllers\ApiDataUserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Endpoint register /api/register
Route::post('/register', [RegisterController::class, 'register']);

// Endpoint login /api/login
Route::post('/login', [LoginController::class, 'login']);

// Endpoint untuk Periode Audit
Route::prefix('periode-audits')->group(function () {
    Route::get('/', [PeriodeAuditController::class, 'index']);
    Route::post('/', [PeriodeAuditController::class, 'store']);
    Route::get('/active', [PeriodeAuditController::class, 'active']);
    Route::post('/open', [PeriodeAuditController::class, 'open']);
    Route::get('/{id}', [PeriodeAuditController::class, 'show']);
    Route::put('/{id}', [PeriodeAuditController::class, 'update']);
    Route::put('/{id}/close', [PeriodeAuditController::class, 'close']);
    Route::delete('/{id}', [PeriodeAuditController::class, 'destroy']);
});

// Endpoint untuk Sasaran Strategis
Route::post('/sasaran-strategis', [SasaranStrategisController::class, 'store']);

// Endpoint untuk Data User
Route::prefix('data-user')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/', [ApiDataUserController::class, 'index'])->name('api.data-user.index');
    Route::post('/', [ApiDataUserController::class, 'store'])->name('api.data-user.store');
    Route::get('/{id}', [ApiDataUserController::class, 'show'])->name('api.data-user.show');
    Route::put('/{id}', [ApiDataUserController::class, 'update'])->name('api.data-user.update');
    Route::delete('/{id}', [ApiDataUserController::class, 'destroy'])->name('api.data-user.destroy');
    Route::delete('/bulk-destroy', [ApiDataUserController::class, 'bulkDestroy'])->name('api.data-user.bulk-destroy');
});
