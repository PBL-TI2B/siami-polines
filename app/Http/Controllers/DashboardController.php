<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\PeriodeAudit;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }
}
