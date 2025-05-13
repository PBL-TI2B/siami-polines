<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\DataInstrumenExport;
use Maatwebsite\Excel\Facades\Excel;
class DataInstrumenController extends Controller
{
    public function index()
    {
        return view('admin.data-instrumen.index');
    }
    public function store()
    {
        return view('admin.data-instrumen.tambah');
    }
    public function edit($sasaran_strategis_id)
    {
        return view('admin.data-instrumen.edit', compact('sasaran_strategis_id'));
    }
    public function upt()
    {
        return view('admin.data-instrumen.instrumenupt');
    }
    public function jurusan()
    {
        return view('admin.data-instrumen.instrumenjurusan');
    }
    public function prodi()
    {
        return view('admin.data-instrumen.instrumenprodi');
    }
    public function export()
    {
        return Excel::download(new DataInstrumenExport, 'data-instrumen-' . date('YmdHis') . '.xlsx');
    }
    
}
