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
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 5);
        $search = $request->query('search');
        $type = $request->query('type');

        $typeMapping = [
            'upt' => 1,
            'jurusan' => 2,
            'prodi' => 3,
        ];

        $jenisUnitId = $typeMapping[$type] ?? null;

        $query = UnitKerja::query();

        if ($search) {
            $query->where('nama_unit_kerja', 'like', "%{$search}%");
        }

        if ($jenisUnitId) {
            $query->where('jenis_unit_id', $jenisUnitId);
        }

        $paginatedUnits = $query->paginate($perPage);

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
        return redirect()->route('unit-kerja', ['type' => 'upt'])->with('success', 'Periode audit berhasil dihapus.');
    }
}
