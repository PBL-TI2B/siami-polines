<?php

namespace App\Http\Controllers;

use App\Models\PeriodeAudit;
use Illuminate\Http\Request;


// class PeriodeAuditController extends Controller
// {
//     public function index()
//     {
//         return view('admin.periode-audit.index');
//     }

//     public function edit(PeriodeAudit $periodeAudit)
//     {
//         return view('admin.periode-audit.edit', compact('periodeAudit'));
//     }

//     public function update(Request $request, PeriodeAudit $periodeAudit)
//     {
//         $validated = $request->validate([
//             'nama_periode' => 'required|string|max:255',
//             'tanggal_mulai' => 'required|date',
//             'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
//         ]);

//         $periodeAudit->update($validated);

//         return redirect()->route('periode-audit.index')->with('success', 'Periode audit berhasil diperbarui.');
//     }
// }

class PeriodeAuditController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 5);
        $search = $request->query('search');
        $periodeAudits = PeriodeAudit::query()
            ->when($search, fn($q) => $q->where('nama_periode', 'like', "%{$search}%"))
            ->paginate($perPage);
        return view('admin.periode-audit.index', compact('periodeAudits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date_format:d-m-Y',
            'tanggal_berakhir' => 'required|date_format:d-m-Y|after_or_equal:tanggal_mulai',
        ]);

        PeriodeAudit::create([
            'nama_periode' => $request->nama_periode,
            'tanggal_mulai' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_mulai),
            'tanggal_berakhir' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_berakhir),
            'status' => 'Sedang Berjalan',
        ]);

        return redirect()->route('periode-audit.index')->with('success', 'Periode audit berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $periodeAudit = PeriodeAudit::findOrFail($id);
        return view('admin.periode-audit.edit', compact('periodeAudit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date_format:d-m-Y',
            'tanggal_berakhir' => 'required|date_format:d-m-Y|after_or_equal:tanggal_mulai',
        ]);

        $periodeAudit = PeriodeAudit::findOrFail($id);
        $periodeAudit->update([
            'nama_periode' => $request->nama_periode,
            'tanggal_mulai' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_mulai),
            'tanggal_berakhir' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_berakhir),
        ]);

        return redirect()->route('periode-audit.index')->with('success', 'Periode audit berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $periodeAudit = PeriodeAudit::findOrFail($id);
        $periodeAudit->delete();
        return redirect()->route('periode-audit.index')->with('success', 'Periode audit berhasil dihapus.');
    }

    public function close(Request $request, $id)
    {
        $periodeAudit = PeriodeAudit::findOrFail($id);
        $periodeAudit->update(['status' => 'Berakhir']);
        return redirect()->route('periode-audit.index')->with('success', 'Periode audit berhasil ditutup.');
    }
}
