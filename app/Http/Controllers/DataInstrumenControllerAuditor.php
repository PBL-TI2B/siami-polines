<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataInstrumenControllerAuditor extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter 'type' dari query string
        $type = $request->query('type');

        // Redirect berdasarkan parameter 'type'
        switch ($type) {
            case 'upt':
                return redirect()->route('auditor.data-instrumen.upt');
            case 'prodi':
                return redirect()->route('auditor.data-instrumen.prodi');
            case 'jurusan':
                return redirect()->route('auditor.data-instrumen.jurusan');
            default:
                // Tampilan default jika tidak ada parameter atau parameter tidak valid
                return view('auditor.data-instrumen.index');
        }
    }

    public function auditorInsUpt()
    {
        // Tampilan untuk /auditor/data-instrumen/upt
        return view('auditor.data-instrumen.instrumen-upt');
    }

    public function auditorinsprodi()
    {
        // Tampilan untuk /auditor/data-instrumen/prodi
        return view('auditor.data-instrumen.instrumenprodi');
    }

    public function auditorinsjurusan()
    {
        // Tampilan untuk /auditor/data-instrumen/jurusan
        return view('auditor.data-instrumen.instrumenjurusan');
    }
}
