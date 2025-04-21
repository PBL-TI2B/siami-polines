<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarTilikController extends Controller
{
    public function index()
    {
        return view('admin.daftar-tilik.index');
    }
}
