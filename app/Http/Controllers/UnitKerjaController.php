<?php

namespace App\Http\Controllers;

use App\Models\JenisUnit;
use App\Models\UnitKerja;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UnitKerjaController extends Controller
{
    public function index(Request $request, $type = null)
    {
        $perPage = $request->query('per_page', 5);
        $search = $request->query('search');
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Mapping string type ke ID jenis unit
        $typeMapping = [
            'upt' => 1,
            'jurusan' => 2,
            'prodi' => 3,
        ];

        // Ambil ID jenis unit dari mapping
        $jenisUnitId = $typeMapping[$type] ?? null;

        $url = "http://127.0.0.1:5000/api/unit-kerja/$type";

        $response = Http::get($url, [
            'jenis_unit_id' => $jenisUnitId,
            'search' => $search,
        ]);

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari API',
                'error' => $response->body(),
            ], $response->status());
        }

        $json = $response->json();
        $unitsArray = $json['data'] ?? [];

        // Konversi ke koleksi
        $collection = collect($unitsArray);

        // Manual pagination
        $sliced = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedUnits = new LengthAwarePaginator(
            $sliced,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

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
            'jurusan' => 'nullable|string',
            'type' => 'nullable|string',
        ]);

        $typeMapping = [
            'upt' => 1,
            'jurusan' => 2,
            'prodi' => 3,
        ];

        $jenis_unit_id = $typeMapping[$validated['type']];

        $url = "http://127.0.0.1:5000/api/unit-kerja/{$validated['type']}";

        $payload = [
            'nama_unit_kerja' => $validated['nama_unit_kerja'],
            'jenis_unit_kerja' => $jenis_unit_id,
        ];

        if ($validated['type'] === 'prodi') {
            $payload['jurusan'] = $validated['jurusan'];
        }

        $response = Http::post($url, $payload);

        if (!$response->successful()) {
            // Bisa pilih log error, tampilkan notifikasi, dll.
            return redirect()->back()->with('error', 'Gagal mengirim data ke API.');
        }

        return redirect()
            ->route('admin.unit-kerja.index', ['type' => $validated['type']])
            ->with('success', 'Data unit kerja berhasil ditambahkan dan dikirim ke API');
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
            'jurusan' => 'nullable|string',
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
        $jurusan = $request->input('jurusan', null);

        // Cari unit kerja yang akan diupdate
        $unitKerja = UnitKerja::findOrFail($id);

        // Update data unit kerja
        $updateData = [
            'nama_unit_kerja' => $request->input('nama_unit_kerja'),
            'jenis_unit_id' => $jenisUnitId,
        ];

        if ($validated['type'] === 'prodi') {
            $updateData['jurusan'] = $jurusan;
        }

        // $unitKerja->update($updateData);

        $url = "http://127.0.0.1:5000/api/unit-kerja/$id";
        $response = Http::put($url, $updateData);

        // Redirect ke halaman yang sesuai dengan tipe unit yang sudah diupdate
        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Gagal mengirim data ke API.');
        }

        // Redirect ke halaman yang sesuai setelah update
        return redirect()->route('admin.unit-kerja.index', ['type' => $validated['type']])
            ->with('success', 'Unit Kerja berhasil diupdate!');
    }

    public function destroy($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        $unitKerja->delete();
        return redirect()->route('admin.unit-kerja.index', ['type' => 'upt'])->with('success', 'Periode audit berhasil dihapus.');
    }
}
