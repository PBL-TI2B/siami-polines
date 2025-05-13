<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeriodeAuditController;
use App\Http\Controllers\PlotingAMIController;
use App\Http\Controllers\DaftarTilikController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\DataInstrumenController;
use App\Http\Controllers\DataInstrumenControllerAuditor;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Livewire\PeriodeAudit;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('login');
});

// route register
// Route::get('/register', [RegisterController::class, 'index'])->name('register');

// route login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk Admin dengan prefix 'admin'
Route::prefix('admin')->middleware('auth.ami:admin')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    });
 // Route::get('/periode-audit', PeriodeAudit::class)->name('admin.periode-audit.index');

    // Periode Audit
    Route::prefix('periode-audit')->group(function () {
        Route::get('/', [PeriodeAuditController::class, 'index'])->name('admin.periode-audit.index');
        Route::get('/create', [PeriodeAuditController::class, 'create'])->name('admin.periode-audit.create');
        Route::post('/', [PeriodeAuditController::class, 'open'])->name('admin.periode-audit.open');
        Route::get('/{id}/edit', [PeriodeAuditController::class, 'edit'])->name('admin.periode-audit.edit');
        Route::put('/{id}', [PeriodeAuditController::class, 'update'])->name('admin.periode-audit.update');
        Route::delete('/{id}', [PeriodeAuditController::class, 'destroy'])->name('admin.periode-audit.destroy');
        Route::put('/{id}/close', [PeriodeAuditController::class, 'close'])->name('admin.periode-audit.close');
    });


    // Jadwal Audit
    Route::prefix('ploting-ami')->group(function () {
        Route::get('/', [PlotingAMIController::class, 'index'])->name('admin.ploting-ami.index');
        Route::get('/create', [PlotingAMIController::class, 'create'])->name('admin.ploting-ami.create'); // Route untuk halaman form
        Route::post('/store', [PlotingAMIController::class, 'makeJadwalAudit'])->name('admin.ploting-ami.store'); // Route untuk menyimpan data
        Route::delete('/{id}', [PlotingAMIController::class, 'destroy'])->name('admin.ploting-ami.destroy');
        Route::post('/reset', [PlotingAMIController::class, 'reset'])->name('admin.ploting-ami.reset');
        Route::get('/download', [PlotingAMIController::class, 'download'])->name('admin.ploting-ami.download');
        Route::get('/{id}/edit', [PlotingAMIController::class, 'edit'])->name('admin.ploting-ami.edit');
        Route::put('/{id}', [PlotingAMIController::class, 'update'])->name('admin.ploting-ami.update');
    });

    // Daftar Tilik
    Route::prefix('daftar-tilik')->group(function () {
        Route::get('/', [DaftarTilikController::class, 'index'])->name('admin.daftar-tilik.index');
    });

    // Data Unit (Unit Kerja)
    Route::prefix('unit-kerja')->group(function () {
        // Route::get('/', [UnitKerjaController::class, 'index'])->name('admin.unit-kerja.index');
        Route::get('/create/{type?}', [UnitKerjaController::class, 'create'])->name('unit-kerja.create');
        Route::get('/{id}/edit/{type?}', [UnitKerjaController::class, 'edit'])->name('unit-kerja.edit');
        Route::post('/', [UnitKerjaController::class, 'store'])->name('unit-kerja.store');
        Route::put('/{id}', [UnitKerjaController::class, 'update'])->name('unit-kerja.update');
        Route::delete('/{id}', [UnitKerjaController::class, 'destroy'])->name('unit-kerja.destroy');
        Route::get('/{type?}', [UnitKerjaController::class, 'index'])->name('admin.unit-kerja.index');
    });

    // // Data Instrumen
    Route::prefix('data-instrumen')->group(function () {
        Route::get('/', [DataInstrumenController::class, 'index'])->name('admin.data-instrumen.index');
        Route::get('/create/{type?}', [DataInstrumenController::class, 'store'])->name('admin.data-instrumen.tambah');
        Route::get('/edit/{type?}', [DataInstrumenController::class, 'edit'])->name('admin.data-instrumen.edit');
        Route::get('/upt', [DataInstrumenController::class, 'upt'])->name('admin.data-instrumen.instrumenupt');
        Route::get('/prodi', [DataInstrumenController::class, 'prodi'])->name('admin.data-instrumen.instrumenprodi');
        Route::get('/jurusan', [DataInstrumenController::class, 'jurusan'])->name('admin.data-instrumen.instrumenjurusan');
    });

    // Data User
    Route::prefix('data-user')->group(function () {
        Route::get('/', [DataUserController::class, 'index'])->name('admin.data-user.index');
        Route::get('/create', [DataUserController::class, 'create'])->name('admin.data-user.create');
        Route::post('/', [DataUserController::class, 'store'])->name('admin.data-user.store');
        Route::get('/{id}/edit', [DataUserController::class, 'edit'])->name('admin.data-user.edit');
        Route::put('/{id}', [DataUserController::class, 'update'])->name('admin.data-user.update');
        Route::delete('/{id}', [DataUserController::class, 'destroy'])->name('admin.data-user.destroy');
        Route::delete('/bulk-delete', [DataUserController::class, 'bulkDelete'])->name('admin.data-user.bulk-delete');
    });

    // Laporan
    Route::prefix('laporan')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->name('laporan.show');
        Route::get('/laporan/{laporan}/download', [LaporanController::class, 'download'])->name('laporan.download');
        Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
    });
});

Route::prefix('auditor')->middleware('auth.ami:auditor')->group(function () {
    Route::get('/dashboard', function () {
        return view('auditor.dashboard.index');
    })->name('auditor.dashboard.index');

    Route::get('/daftar-tilik', [DaftarTilikController::class, 'auditortilik'])->name('auditor.daftar-tilik.index');

    Route::get('/assesmen-lapangan', function () {
        return view('auditor.assesmen-lapangan.index');
    })->name('auditor.assesmen-lapangan.index');

    // Rute untuk data-instrumen
    Route::get('/data-instrumen', [DataInstrumenControllerAuditor::class, 'index'])->name('auditor.data-instrumen.index');
    Route::get('/data-instrumen/upt', [DataInstrumenControllerAuditor::class, 'auditorInsUpt'])->name('auditor.data-instrumen.upt');
    Route::get('/data-instrumen/prodi', [DataInstrumenControllerAuditor::class, 'auditorinsprodi'])->name('auditor.data-instrumen.instrumenprodi');
    Route::get('/data-instrumen/jurusan', [DataInstrumenControllerAuditor::class, 'auditorinsjurusan'])->name('auditor.data-instrumen.instrumenjurusan');

    Route::get('/laporan', function () {
        return view('auditor.laporan.index');
    })->name('auditor.laporan.index');

    Route::get('/ptpp', function () {
        return view('auditor.ptpp.index');
    })->name('auditor.ptpp.index');
});

Route::prefix('auditee')->middleware('auth.ami:auditee')->group(function () {
    Route::get('/dashboard', function () {
        return view('auditee.dashboard.index');
    })->name('auditee.dashboard.index');

    ROute::get('/pengisian-form-AMI', function () {
        return view('auditee.pengisian-form-ami.index');
    })->name('auditee.pengisian-form-ami.index');
    Route::get('/tindak-lanjut-perbaikan', function () {
        return view('auditee.tindak-lanjut-perbaikan.index');
    })->name('auditee.tindak-lanjut-perbaikan.index');
    Route::get('/riwayat-audit', function () {
        return view('auditee.riwayat-audit.index');
    })->name('auditee.riwayat-audit.index');
});

