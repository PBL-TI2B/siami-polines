<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalAuditController extends Controller
{
    public function index()
    {
        return view('admin.jadwal-audit.index');
    }
}
