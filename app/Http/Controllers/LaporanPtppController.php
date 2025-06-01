<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LaporanPtpp;
use Illuminate\Http\Request;

class LaporanPtppController extends Controller
{
    /**
     * Menampilkan dashboard auditor.
     */
    public function dashboard()
    {
        return view('auditor.dashboard.index');
    }

    /**
     * Menampilkan daftar laporan.
     */
    public function index(Request $request)
    {
        $reports = LaporanPtpp::paginate($request->input('entries', 10));
        return view('auditor.laporan.index', compact('reports'));
    }

    /**
     * Menampilkan form untuk membuat laporan baru.
     */
    public function create()
    {
        return view('auditor.laporan.tambah');
    }

    /**
     * Menyimpan laporan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'standar' => 'required|string|max:255',
            'uraian_temuan' => 'required|string',
            'kategori_temuan' => 'required|in:NC,AOC,OFI',
            'saran_perbaikan' => 'nullable|string',
            'status' => 'required|string|max:255',
        ]);

        LaporanPtpp::create($request->all()); // Perbaiki dari Laporan ke LaporanPtpp

        return redirect()->route('auditor.laporan.index')
                        ->with('success', 'Laporan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit laporan.
     */
    public function edit($id)
    {
        $report = LaporanPtpp::findOrFail($id);
        return view('auditor.laporan.edit', compact('report'));
    }

    /**
     * Memperbarui laporan di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'standar' => 'required|string|max:255',
            'uraian_temuan' => 'required|string',
            'kategori_temuan' => 'required|in:NC,AOC,OFI',
            'saran_perbaikan' => 'nullable|string',
            'status' => 'required|string|max:255',
        ]);

        $report = LaporanPtpp::findOrFail($id);
        $report->update($request->all());

        return redirect()->route('auditor.laporan.index')
                        ->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Menghapus laporan dari database.
     */
    public function destroy($id)
    {
        $report = LaporanPtpp::findOrFail($id);
        $report->delete();

        return redirect()->route('auditor.laporan.index')
                        ->with('success', 'Laporan berhasil dihapus.');
    }
}