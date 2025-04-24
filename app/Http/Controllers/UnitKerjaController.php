<?php

namespace App\Http\Controllers;

use App\Models\JenisUnit;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UnitKerjaController extends Controller
{
    public function index(Request $request, $type = null)
    {
        $perPage = $request->query('per_page', 5);
        $search = $request->query('search');
        $paginatedUnits = UnitKerja::query()
            ->when($search, fn($q) => $q->where('nama_periode', 'like', "%{$search}%"))
            ->paginate($perPage);
        return view('admin.unit-kerja.index', ['units' => $paginatedUnits]);
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
