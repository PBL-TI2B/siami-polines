<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarTilikController extends Controller
{
    public function index()
    {
        return view('admin.daftar-tilik.index');
    }
    public function auditortilik()
    {
        return view('auditor.daftar-tilik.index');
    }
    public function create()
    {
        return view('auditor.daftar-tilik.create'); // Pastikan file ini ada
    }
    public function store(Request $request)
    {
        // Validasi dan simpan ke database
    }


}

