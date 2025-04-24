<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PeriodeAudit;
use Illuminate\Http\Request;

class PeriodeAuditController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search');

        $periodeAudits = PeriodeAudit::query()
            ->when($search, fn($q) => $q->where('nama_periode', 'like', "%{$search}%"))
            ->with('auditings') // sesuaikan jika ada relasi
            ->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar periode audit berhasil diambil.',
            'data' => $periodeAudits,
        ]);
    }

    public function show($id)
    {
        $periodeAudit = PeriodeAudit::with('auditings')->find($id);

        if (!$periodeAudit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Periode audit tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail periode audit berhasil diambil.',
            'data' => $periodeAudit,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_periode'     => 'required|string|max:255|unique:periode_audits,nama_periode',
            'tanggal_mulai'    => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status'           => 'required|in:Sedang Berjalan,Berakhir',
        ]);

        $periodeAudit = PeriodeAudit::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Periode audit berhasil ditambahkan.',
            'data' => $periodeAudit,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $periodeAudit = PeriodeAudit::find($id);

        if (!$periodeAudit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Periode audit tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        $request->validate([
            'nama_periode'     => 'required|string|max:255|unique:periode_audits,nama_periode,' . $id . ',periode_id',
            'tanggal_mulai'    => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status'           => 'required|in:Sedang Berjalan,Berakhir',
        ]);

        $periodeAudit->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Periode audit berhasil diperbarui.',
            'data' => $periodeAudit,
        ]);
    }

    public function destroy($id)
    {
        $periodeAudit = PeriodeAudit::find($id);

        if (!$periodeAudit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Periode audit tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        $periodeAudit->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Periode audit berhasil dihapus.',
            'data' => null,
        ]);
    }

    public function close($id)
    {
        $periodeAudit = PeriodeAudit::find($id);

        if (!$periodeAudit) {
            return response()->json([
                'status' => 'error',
                'message' => 'Periode audit tidak ditemukan.',
                'data' => null,
            ], 404);
        }

        $periodeAudit->update(['status' => 'Berakhir']);

        return response()->json([
            'status' => 'success',
            'message' => 'Periode audit berhasil ditutup.',
            'data' => $periodeAudit,
        ]);
    }

    public function open(Request $request)
    {
        $request->validate([
            'nama_periode'     => 'required|string|max:255|unique:periode_audits,nama_periode',
            'tanggal_mulai'    => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        // Tutup semua periode aktif terlebih dahulu
        PeriodeAudit::where('status', 'Sedang Berjalan')->update([
            'status' => 'Berakhir'
        ]);

        // Buka periode baru
        $periodeAudit = PeriodeAudit::create([
            'nama_periode'     => $request->nama_periode,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'status'           => 'Sedang Berjalan',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Periode audit baru berhasil dibuka.',
            'data' => $periodeAudit,
        ], 201);
    }

    public function active()
    {
        $periode = PeriodeAudit::where('status', 'Sedang Berjalan')->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Periode audit aktif berhasil diambil.',
            'data' => $periode,
        ]);
    }
}
