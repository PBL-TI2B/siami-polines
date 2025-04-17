<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodeAuditController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('periode_audit', function () {
    return view('period-audit2');
});

