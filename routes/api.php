<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PeriodeAuditController;
use App\Http\Controllers\SasaranStrategisController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// enpdoint register /api/register
// Route::post('/register', [RegisterController::class, 'register']);

// endpoint login /api/login
Route::post('/login', [AuthController::class, 'login']);

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

Route::post('/sasaran-strategis', [SasaranStrategisController::class, 'store']);
