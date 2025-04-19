<?php

namespace App\Http\Controllers;

use App\Models\PeriodeAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeriodeAuditController extends Controller
{
    /**
     * Display a listing of the audit periods.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('per_page', 5);

        $periodeAudits = PeriodeAudit::when($search, function ($query, $search) {
            return $query->where('nama_periode', 'like', "%{$search}%");
        })->paginate($perPage)->withQueryString();

        $menus = [
            ['name' => 'Dashboard', 'href' => route('dashboard'), 'icon' => 'home', 'sub_menu' => null],
            [
                'name' => 'Periode Audit',
                'href' => route('periode-audit.index'),
                'icon' => 'calendar',
                'sub_menu' => [
                    ['name' => 'List Periode', 'href' => route('periode-audit.index'), 'icon' => 'list-bullet'],
                    ['name' => 'Tambah Periode', 'href' => '#', 'icon' => 'plus'],
                ],
            ],
            ['name' => 'Data Unit', 'href' => route('data-unit'), 'icon' => 'building-office', 'sub_menu' => null],
            ['name' => 'Data Instrumen', 'href' => route('data-instrumen'), 'icon' => 'clipboard-document', 'sub_menu' => null],
            ['name' => 'Data User', 'href' => route('data-user'), 'icon' => 'users', 'sub_menu' => null],
            ['name' => 'Laporan', 'href' => route('laporan'), 'icon' => 'document-text', 'sub_menu' => null],
        ];

        return view('admin.periode-audit.index', compact('periodeAudits', 'menus'));
    }

    /**
     * Store a newly created audit period in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date|before_or_equal:tanggal_berakhir',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        PeriodeAudit::create([
            'nama_periode' => $request->nama_periode,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status' => 'Sedang Berjalan',
        ]);

        return redirect()->route('periode-audit.index')->with('success', 'Periode audit berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified audit period.
     */
    public function edit($periode_id)
    {
        $periodeAudit = PeriodeAudit::findOrFail($periode_id);
        return view('admin.periode-audit.edit', compact('periodeAudit'));
    }

    /**
     * Update the specified audit period in storage.
     */
    public function update(Request $request, $periode_id)
    {
        $periodeAudit = PeriodeAudit::findOrFail($periode_id);

        $validator = Validator::make($request->all(), [
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date|before_or_equal:tanggal_berakhir',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $periodeAudit->update([
            'nama_periode' => $request->nama_periode,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
        ]);

        return redirect()->route('periode-audit.index')->with('success', 'Periode audit berhasil diperbarui.');
    }

    /**
     * Remove the specified audit period from storage.
     */
    public function destroy($periode_id)
    {
        $periodeAudit = PeriodeAudit::findOrFail($periode_id);
        $periodeAudit->delete();

        return redirect()->route('periode-audit.index')->with('success', 'Periode audit berhasil dihapus.');
    }

    /**
     * Close the specified audit period.
     */
    public function close($periode_id)
    {
        $periodeAudit = PeriodeAudit::findOrFail($periode_id);
        $periodeAudit->update(['status' => 'Berakhir']);

        return redirect()->route('periode-audit.index')->with('success', 'Periode audit berhasil ditutup.');
    }
}
