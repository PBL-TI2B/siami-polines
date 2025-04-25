<?php

namespace App\Http\Controllers;

use App\Models\JenisUnit;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class UnitKerjaController extends Controller
{
    public function index(Request $request, $type = null)
    {
        $perPage = $request->query('per_page', 5);
        $search = $request->query('search');
        $paginatedUnits = UnitKerja::query()
            ->when($search, fn($q) => $q->where('nama_periode', 'like', "%{$search}%"))
            ->paginate($perPage);

        // // Ambil nama route saat ini
        // $currentRoute = $request->route()->getName(); // contoh: unit-kerja.prodi

        // // Pisahkan bagian terakhir setelah titik
        // $type = explode('.', $currentRoute)[1] ?? null;

        Log::info('Nilai $type saat ini:', ['type' => $type]);

        return match ($type) {
            'upt' => view('admin.unit-kerja.index', ['units' => $paginatedUnits]),
            'prodi' => view('admin.unit-kerja.prodi', ['units' => $paginatedUnits]),
            'jurusan' => view('admin.unit-kerja.jurusan', ['units' => $paginatedUnits]),
            default => view('admin.unit-kerja.index', ['units' => $paginatedUnits]),
        };      
    }

    public function create() {
        return view('admin.unit-kerja.create');
    }

    public function edit($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        return view('admin.unit-kerja.edit', compact('unitKerja'));
    }

    public function destroy($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        $unitKerja->delete();
        return redirect()->route('unit-kerja.index')->with('success', 'Periode audit berhasil dihapus.');
    }
}
