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
    public function storeprodi()
    {
        return view('admin.data-instrumen.tambahprodi');
    }
    public function editprodi($id)
    {
        return view('admin.data-instrumen.editprodi', compact('id'));
    }
    public function edit($sasaran_strategis_id)
    {
        return view('admin.data-instrumen.edit', compact('sasaran_strategis_id'));
    }
    public function upt()
    {
        return view('admin.data-instrumen.index');
    }
    public function jurusan()
    {
        return view('admin.data-instrumen.instrumenjurusan');
    }
    public function prodi()
    {
        return view('admin.data-instrumen.instrumenprodi');
    }
    public function auditeeupt()
    {
        return view('auditee.data-instrumen.instrumenupt');
    }
    public function auditeeuptresponse($response_id)
    {
        return view('auditee.data-instrumen.tambah-response-upt', compact('response_id'));
    }
    public function auditeeedituptresponse($response_id)
    {
        return view('auditee.data-instrumen.edit-upt', compact('response_id'));
    }

    public function auditeeprodi()
    {
        return view('auditee.data-instrumen.instrumenprodi');
    }
    public function auditeeprodiresponse($response_id)
    {
        return view('auditee.data-instrumen.tambahresponseprodi', compact('response_id'));
    }
    public function auditeeeditprodiresponse($response_id)
    {
        return view('auditee.data-instrumen.editprodi', compact('response_id'));
    }
    public function auditeejurusan()
    {
        return view('auditee.data-instrumen.instrumenjurusan');
    }
    public function export()
    {
        return Excel::download(new DataInstrumenExport, 'data-instrumen-' . date('YmdHis') . '.xlsx');
    }

}
