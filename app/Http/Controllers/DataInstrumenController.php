<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataInstrumenController extends Controller
{
    public function index()
    {
        return view('admin.data-instrumen.index');
    }

    public function auditorinsprodi()
    {
        return view('auditor.data-instrumen.instrumenprodi');
    }
}