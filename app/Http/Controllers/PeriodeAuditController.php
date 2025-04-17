<?php

namespace App\Http\Controllers;

use App\Models\PeriodeAudit; // Pastikan model ini sudah ada
use Illuminate\Http\Request;

class PeriodeAuditController extends Controller
{
    public function index()
    {
        $periods = PeriodeAudit::paginate(10);
        return view('periode-audit.index', compact('periods'));
    }

    // Tambahkan method lainnya (create, store, edit, update, destroy) di sini
}