<?php

namespace App\Http\Controllers;

use App\Models\JenisUnit;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function index(Request $request, $type = null)
    {
        return view('admin.unit-kerja.index');
    }
}
