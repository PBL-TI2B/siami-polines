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
use App\Http\Controllers\AuditController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\PeriodeAudit;
use App\Http\Controllers\LaporanTemuanController;
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
        Route::get('/download', [PlotingAMIController::class, 'download'])->name('admin.ploting-ami.download');
        Route::get('/{id}/edit', [PlotingAMIController::class, 'edit'])->name('admin.ploting-ami.edit');
        Route::put('/{id}', [PlotingAMIController::class, 'update'])->name('admin.ploting-ami.update');
        Route::get('/{id}/revisi', [PlotingAMIController::class, 'revisi'])->name('admin.ploting-ami.revisi');
    });

    // Daftar Tilik
    Route::prefix('daftar-tilik')->group(function () {
        //Route::get('/', [DaftarTilikController::class, 'index'])->name('admin.daftar-tilik.index');
        //Route::post('/', [DaftarTilikController::class, 'store'])->name('admin.daftar-tilik.store');
        Route::get('/', [DaftarTilikController::class, 'admintilik'])->name('admin.daftar-tilik.index');
        Route::get('/{id}/edit', [DaftarTilikController::class, 'editadmin'])->name('admin.daftar-tilik.edit');
        Route::get('/create', [DaftarTilikController::class, 'createadmin'])->name('admin.daftar-tilik.create');
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
        Route::get('/create/prodi', [DataInstrumenController::class, 'storeprodi'])->name('admin.data-instrumen.tambahprodi');
        Route::get('/create', [DataInstrumenController::class, 'store'])->name('admin.data-instrumen.tambah');
        Route::get('/{sasaran_strategis_id}/edit', [DataInstrumenController::class, 'edit'])->name('admin.data-instrumen.edit');
        Route::get('/prodi/{set_instrumen_unit_kerja_id}/edit', [DataInstrumenController::class, 'editprodi'])->name('admin.data-instrumen.editprodi');
        //Route::get('/edit/{type?}', [DataInstrumenController::class, 'edit'])->name('admin.data-instrumen.edit');
        Route::get('/upt', [DataInstrumenController::class, 'upt'])->name('admin.data-instrumen.instrumenupt');
        Route::get('/prodi', [DataInstrumenController::class, 'prodi'])->name('admin.data-instrumen.instrumenprodi');
        Route::get('/jurusan', [DataInstrumenController::class, 'jurusan'])->name('admin.data-instrumen.instrumenjurusan');
        Route::get('/export', [DataInstrumenController::class, 'export'])->name('admin.data-instrumen.export');
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

    //Route::resource('daftar-tilik', DaftarTilikController::class)->only(['index', 'create', 'store']);

    // Route::get('/daftar-tilik', [DaftarTilikController::class, 'auditortilik'])->name('auditor.daftar-tilik.index');
    // Route::get('/daftar-tilik/{id}/edit', [DaftarTilikController::class, 'edit'])->name('auditor.daftar-tilik.edit');
    // Route::get('/daftar-tilik/create', [DaftarTilikController::class, 'create'])->name('auditor.daftar-tilik.create');

    //Route::post('/daftar-tilik', [DaftarTilikController::class, 'store'])->name('auditor.daftar-tilik.store');

    Route::prefix('audit')->group(function () {
        Route::get('/', [AuditController::class, 'auditorIndexPage'])->name('auditor.audit.index');
        Route::get('/detail/{id}', [AuditController::class, 'auditorAuditPage'])->name('auditor.audit.audit');
        Route::get('/auditings', [AuditController::class, 'getAuditingsByUser'])->name('auditor.auditings');
        Route::get('/daftar-tilik/{auditingId}', [DaftarTilikController::class, 'auditortilik'])->name('auditor.daftar-tilik.index');
        Route::get('/daftar-tilik/{id}/edit', [DaftarTilikController::class, 'edit'])->name('auditor.daftar-tilik.edit');
        Route::get('/daftar-tilik/create', [DaftarTilikController::class, 'create'])->name('auditor.daftar-tilik.create');
    });

    Route::prefix('assesmen-lapangan')->group(function () {
        Route::get('/', [PlotingAMIController::class, 'editJadwal'])->name('auditor.assesmen-lapangan.index');
        Route::get('/{id}/edit', [PlotingAMIController::class, 'edit'])->name('auditor.assesmen-lapangan.edit');
        Route::put('/auditor/assesmen-lapangan/{id}', [PlotingAMIController::class, 'updateJadwal'])->name('auditor.assesmen-lapangan.update');
    });

    // Rute untuk data-instrumen
    Route::get('/data-instrumen', [DataInstrumenControllerAuditor::class, 'index'])->name('auditor.data-instrumen.index');
    Route::get('/data-instrumen/upt', [DataInstrumenControllerAuditor::class, 'auditorInsUpt'])->name('auditor.data-instrumen.instrumenupt');
    Route::get('/data-instrumen/prodi/{id}', [AuditController::class, 'auditorShowInstrumenProdi'])->name('auditor.data-instrumen.instrumenprodi');
    Route::get('/data-instrumen/jurusan/{id}', [AuditController::class, 'auditorShowInstrumenJurusan'])->name('auditor.data-instrumen.instrumenjurusan');
    Route::patch('/data-instrumen/jurusan/update/{id}', [AuditController::class, 'auditorUpdateInstrumenResponse'])->name('auditor.instrumen.update')->where('id', '[0-9]+');

    Route::get('/laporan', function () {
        return view('auditor.laporan.index');
    })->name('auditor.laporan.index');

    Route::get('/laporan', [LaporanTemuanController::class, 'index'])->name('auditor.laporan.index');
    Route::post('/laporan', [LaporanTemuanController::class, 'store'])->name('auditor.laporan.store');

    Route::get('/ptpp', function () {
        return view('auditor.ptpp.index');
    })->name('auditor.ptpp.index');
});


Route::prefix('auditee')->middleware('auth.ami:auditee')->group(function () {
    Route::get('/dashboard', function () {
        return view('auditee.dashboard.index');
    })->name('auditee.dashboard.index');
    Route::prefix('pengisian-instrumen')->group(function () {
        Route::get('/', function () {
            return view('auditee.pengisian-instrumen.index');
        })->name('auditee.pengisian-instrumen.index');
        Route::get('/instrumen-upt', function ($id) {
            return view('auditee.pengisian-instrumen.instrumen-upt');
        })->name('auditee.pengisian-instrumen.instrumen-upt');
    });
    Route::get('/tindak-lanjut-perbaikan', function () {
        return view('auditee.tindak-lanjut-perbaikan.index');
    })->name('auditee.tindak-lanjut-perbaikan.index');
    Route::get('/riwayat-audit', function () {
        return view('auditee.riwayat-audit.index');
    })->name('auditee.riwayat-audit.index');

    Route::prefix('audit')->group(function () {
        // Rute untuk halaman utama audit auditee
        Route::get('/', [AuditController::class, 'auditeeIndexPage'])->name('auditee.audit.index');
        Route::get('detail/{auditingId}', [AuditController::class, 'showAuditeeAuditProgress'])->name('auditee.audit.progress-detail');
        Route::get('/auditings', [AuditController::class, 'getAuditingsByUser'])->name('auditee.auditings');

        // Rute untuk instrumen
        Route::get('/instrumen-upt/{auditingId}', [AuditController::class, 'showAuditeeInstrumenUPT'])->name('auditee.data-instrumen.instrumenupt');
        Route::get('/instrumen-prodi/{auditingId}', [AuditController::class, 'showAuditeeInstrumenProdi'])->name('auditee.data-instrumen.instrumenprodi');
        Route::get('/instrumen-jurusan/{auditingId}', [AuditController::class, 'showAuditeeInstrumenJurusan'])->name('auditee.data-instrumen.instrumenjurusan');

        // Rute untuk Assesmen Lapangan
        Route::get('/assesmen-lapangan', [PlotingAMIController::class, 'lihatJadwal'])->name('auditee.assesmen-lapangan.index');

        // Rute untuk daftar tilik
        Route::prefix('daftar-tilik')->group(function () {
            Route::get('/{auditingId}', [DaftarTilikController::class, 'auditeetilik'])->name('auditee.daftar-tilik.index');
            Route::get('/{id}/edit', [DaftarTilikController::class, 'editauditee'])->name('auditee.daftar-tilik.edit');
            Route::get('/{tilik_id}/create', [DaftarTilikController::class, 'createauditee'])->name('auditee.daftar-tilik.create');
        });
    });


    // Data Instrumen
    Route::prefix('data-instrumen')->group(function () {
        Route::get('/', [DataInstrumenController::class, 'index'])->name('auditee.data-instrumen.index');
        Route::get('/create/responses/upt/{response_id}', [DataInstrumenController::class, 'auditeeuptresponse'])->name('auditee.data-instrumen.tambahupt');
        Route::get('/create/responses/prodi/{response_id}', [DataInstrumenController::class, 'auditeeprodiresponse'])->name('auditee.data-instrumen.tambahprodi');
        Route::get('/create', [DataInstrumenController::class, 'store'])->name('auditee.data-instrumen.tambah');
        Route::get('/{sasaran_strategis_id}/edit', [DataInstrumenController::class, 'edit'])->name('auditee.data-instrumen.edit');
        Route::get('/prodi/{response_id}/edit', [DataInstrumenController::class, 'auditeeeditprodiresponse'])->name('auditee.data-instrumen.editprodi');
        Route::get('/export', [DataInstrumenController::class, 'export'])->name('auditee.data-instrumen.export');
    });

});

Route::prefix('kepala-pmpp')->middleware('auth.ami:kepala-pmpp')->group(function () {
    Route::get('/dashboard', fn() => view('kepala-pmpp.dashboard.index'))->name('kepala-pmpp.dashboard.index');
    Route::get('/rapat-tinjauan-manajemen', fn() => view('kepala-pmpp.rapat-tinjauan-manajemen.index'))->name('kepala-pmpp.rapat-tinjauan-manajemen.index');
    Route::prefix('ploting-ami')->group(function () {
        Route::get('/', [\App\Http\Controllers\PlotingAMIController::class, 'kepalaIndex'])->name('kepala-pmpp.ploting-ami.index');
        Route::get('/download-rtm/{auditing}', [PlotingAMIController::class, 'downloadRTM'])->name('kepala-pmpp.ploting-ami.download-rtm');
        Route::get('/download-laporan/{auditing}', [PlotingAMIController::class, 'downloadLaporan'])->name('kepala-pmpp.ploting-ami.download-laporan');
        Route::get('/download-ptpp/{auditing}', [PlotingAMIController::class, 'downloadptpp'])->name('kepala-pmpp.ploting-ami.download-ptpp');
    });
    Route::get('/daftar-tilik', fn() => view('kepala-pmpp.daftar-tilik.index'))->name('kepala-pmpp.daftar-tilik.index');
    Route::get('/data-instrumen', fn() => view('kepala-pmpp.data-instrumen.index'))->name('kepala-pmpp.data-instrumen.index');
    Route::get('/data-instrumen/upt', fn() => view('kepala-pmpp.data-instrumen.upt'))->name('kepala-pmpp.data-instrumen.instrumenupt');
    Route::get('/data-instrumen/prodi', fn() => view('kepala-pmpp.data-instrumen.prodi'))->name('kepala-pmpp.data-instrumen.instrumenprodi');
    Route::get('/data-instrumen/jurusan', fn() => view('kepala-pmpp.data-instrumen.jurusan'))->name('kepala-pmpp.data-instrumen.instrumenjurusan');
    Route::get('/ptpp', fn() => view('kepala-pmpp.ptpp.index'))->name('kepala-pmpp.ptpp.index');
});

Route::prefix('admin-unit')->middleware('auth.ami:admin-unit')->group(function () {
    Route::get('/dashboard', fn() => view('admin-unit.dashboard.index'))->name('admin-unit.dashboard.index');
    Route::get('/ploting-ami', fn() => view('admin-unit.ploting-ami.index'))->name('admin-unit.ploting-ami.index');
    Route::get('/unit-kerja', fn() => view('admin-unit.unit-kerja.index'))->name('admin-unit.unit-kerja.index');
    Route::get('/data-instrumen', fn() => view('admin-unit.data-instrumen.index'))->name('admin-unit.data-instrumen.index');
    Route::get('/data-instrumen/upt', fn() => view('admin-unit.data-instrumen.upt'))->name('admin-unit.data-instrumen.instrumenupt');
    Route::get('/data-instrumen/prodi', fn() => view('admin-unit.data-instrumen.prodi'))->name('admin-unit.data-instrumen.instrumenprodi');
});

//Route::get('/pengaturan-akun', [UserController::class, 'editpassword'])->name('pengaturan-akun');
//Route::get('/edit-profile', [UserController::class, 'editprofile'])->name('profile.editProfile');
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
