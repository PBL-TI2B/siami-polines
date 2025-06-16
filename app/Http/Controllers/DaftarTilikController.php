<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditing;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class DaftarTilikController extends Controller
{
    public function index()
    {
        return view('admin.daftar-tilik.index');
    }
    public function auditortilik($auditingId)
    {
        // Ambil data auditing berdasarkan ID
        $auditing = \App\Models\Auditing::findOrFail($auditingId);
        return view('auditor.daftar-tilik.index', compact('auditing', 'auditingId'));
    }
    public function create()
    {
        return view('auditor.daftar-tilik.create'); // Pastikan file ini ada
    }
    public function edit($id)
    {
        return view('auditor.daftar-tilik.edit', compact('id'));
    }
    public function store(Request $request)
    {
        // Validasi dan simpan ke database
    }
     public function admintilik()
    {
        return view('admin.daftar-tilik.index');
    }
    public function editadmin($id)
    {
        return view('admin.daftar-tilik.edit', compact('id'));
    }
    public function createadmin()
    {
        return view('admin.daftar-tilik.create');
    }
    public function auditeetilik(Request $request, $auditingId)
    {
        $userId = session('user')['user_id'] ?? null;
        $unitKerjaId = session('unit_kerja_id') ?? null;
        $status = session('status') ?? null;

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengakses daftar tilik.');
        }

        try {
            // Ambil data audit dari API berdasarkan userId
            $response = Http::get("http://127.0.0.1:5000/api/auditings/userID={$userId}");

            if (!$response->successful()) {
                \Log::error("Gagal mengambil data audit untuk user {$userId}: " . $response->body());
                return back()->with('error', 'Gagal mengambil data audit dari sistem eksternal.');
            }

            $apiData = $response->json();
            $allUserAudits = $apiData['data'] ?? [];

            // Cari audit spesifik berdasarkan auditingId
            $audit = null;
            foreach ($allUserAudits as $item) {
                if (is_array($item) && isset($item['auditing_id']) && (string)$item['auditing_id'] === (string)$auditingId) {
                    $audit = $item;
                    break;
                }
            }

            if (!$audit) {
                \Log::warning("Audit dengan ID {$auditingId} tidak ditemukan untuk user {$userId}.");
                return back()->with('error', 'Data audit tidak ditemukan.');
            }

            // Validasi auditee
            $isAuditee1 = isset($audit['user_id_1_auditee']) && $audit['user_id_1_auditee'] == $userId;
            $isAuditee2 = isset($audit['user_id_2_auditee']) && $audit['user_id_2_auditee'] == $userId;

            if (!$isAuditee1 && !$isAuditee2) {
                \Log::warning("Akses ditolak untuk user {$userId} ke audit ID {$auditingId}.");
                abort(403, 'Anda tidak memiliki hak akses untuk audit ini.');
            }

            // Simpan data ke session jika belum ada
            session([
                'auditing_id' => $audit['auditing_id'],
                'unit_kerja_id' => $audit['unit_kerja']['unit_kerja_id'] ?? $unitKerjaId,
                'status' => $audit['status'] ?? $status,
            ]);

            // Kirim auditingId ke view
            return view('auditee.daftar-tilik.index', [
                'auditingId' => $audit['auditing_id'],
                'status' => $audit['status'] ?? $status,
                'audit' => $audit,
            ]);
        } catch (\Exception $e) {
            \Log::error("Gagal memuat halaman daftar tilik untuk audit ID {$auditingId}: " . $e->getMessage());
            return back()->with('error', 'Terjadi masalah saat memuat halaman daftar tilik.');
        }
    }
    public function createauditee($tilik_id)
    {
        return view('auditee.daftar-tilik.create', compact('tilik_id'));
    }
    public function editauditee($id)
    {
        return view('auditee.daftar-tilik.edit', compact('id'));
    }
}

