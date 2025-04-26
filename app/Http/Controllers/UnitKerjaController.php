<?php

namespace App\Http\Controllers;

use App\Models\JenisUnit;
use App\Models\UnitKerja;
use Illuminate\Auth\Events\Validated;
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

        // Mapping string type ke ID jenis unit
        $typeMapping = [
            'upt' => 1,
            'jurusan' => 2,
            'prodi' => 3,
        ];

        // Ambil ID jenis unit dari mapping
        $jenisUnitId = $typeMapping[$type] ?? null;

        // Query dasar
        $query = UnitKerja::query();

        // Filter pencarian
        if ($search) {
            $query->where('nama_unit_kerja', 'like', "%{$search}%");
        }

        // Filter berdasarkan jenis unit (jika ada)
        if ($jenisUnitId) {
            $query->where('jenis_unit_id', $jenisUnitId);
        }

        // Pagination
        $paginatedUnits = $query->paginate($perPage);

        // Pilih view berdasarkan type
        switch ($type) {
            case 'upt':
                return view('admin.unit-kerja.index', ['units' => $paginatedUnits]);
            case 'prodi':
                return view('admin.unit-kerja.prodi', ['units' => $paginatedUnits]);
            case 'jurusan':
                return view('admin.unit-kerja.jurusan', ['units' => $paginatedUnits]);
            default:
                // Jika tidak ada type, tampilkan view default atau error
                return view('admin.unit-kerja.index', ['units' => $paginatedUnits]);
        }
    }

    public function create($type = null) {
        return view('admin.unit-kerja.create', compact('type'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama_unit_kerja' => 'required|string|max:100',
            'type' => 'nullable|string',
        ]);

        $typeMapping = [
            'upt' => 1,
            'jurusan' => 2,
            'prodi' => 3,
        ];

        $jenis_unit_id = $typeMapping[$validated['type']];

        $unitKerja = new UnitKerja();
        $unitKerja->nama_unit_kerja = $validated['nama_unit_kerja'];
        $unitKerja->jenis_unit_id = $jenis_unit_id;
        $unitKerja->save();

        return redirect()->route('unit-kerja', ['type' => $validated['type']])->with('success', 'Data unit kerja berhasil ditambahkan');
    }

    public function edit($id, $type = null)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        return view('admin.unit-kerja.edit', compact('unitKerja', 'type'));
    }

    public function update(Request $request, $id, $type = null)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'nama_unit_kerja' => 'required|string|max:100',
            'type' => 'nullable|string',
        ]);

        // Mapping jenis unit berdasarkan type
        $typeMapping = [
            'upt' => 1,
            'jurusan' => 2,
            'prodi' => 3,
        ];

        // Ambil ID jenis unit dari mapping
        $jenisUnitId = $typeMapping[$validated['type']] ?? null;

        // Cari unit kerja yang akan diupdate
        $unitKerja = UnitKerja::findOrFail($id);

        // Update data unit kerja
        $unitKerja->update([
            'nama_unit_kerja' => $request->input('nama_unit_kerja'),
            'jenis_unit_id' => $jenisUnitId,
        ]);

        // Redirect ke halaman yang sesuai dengan tipe unit yang sudah diupdate
        return redirect()->route('unit-kerja', ['type' => $validated['type']])
            ->with('success', 'Unit Kerja berhasil diupdate!');
    }

    public function destroy($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        $unitKerja->delete();
        return redirect()->route('unit-kerja', ['type' => 'upt'])->with('success', 'Periode audit berhasil dihapus.');
    }
}
