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
    public function edit($id)
    {
        return view('auditor.daftar-tilik.edit', compact('id'));
    }
    public function store(Request $request)
    {
        // Validasi dan simpan ke database
    }
     public function admintilik()
    {
        return view('admin.daftar-tilik.index');
    }
    public function editadmin($id)
    {
        return view('admin.daftar-tilik.edit', compact('id'));
    }
    public function createadmin()
    {
        return view('admin.daftar-tilik.create');
    }
    public function auditeetilik($auditingId)
    {
        return view('auditee.daftar-tilik.index', compact('auditingId'));
    }
    public function createauditee($tilik_id)
    {
        return view('auditee.daftar-tilik.create', compact('tilik_id'));
    }
    public function editauditee($id)
    {
        return view('auditee.daftar-tilik.edit', compact('id'));
    }
}

