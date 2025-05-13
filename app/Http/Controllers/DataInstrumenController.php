<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function edit()
    {
        return view('admin.data-instrumen.edit');
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
}
