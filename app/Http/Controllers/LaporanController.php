<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan; 

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode');
        $laporan = Laporan::query();

        if ($periode) {
            $laporan->whereYear('tanggal_mulai', $periode);
        }

        $laporan = $laporan->paginate(10);

        return view('admin.laporan.index', compact('laporan'));
    }

}
