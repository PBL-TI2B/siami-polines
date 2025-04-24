<?php

namespace App\Http\Controllers;

use App\Models\Auditing;
use App\Models\PeriodeAudit;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalAuditController extends Controller
{
    public function index(Request $request)
    {
        // Ambil jumlah entri dari query string, default ke 5
        $entries = $request->get('per_page', 5);

        $auditings = Auditing::with([
            'auditor1', 'auditor2',
            'auditee1', 'auditee2',
            'unitKerja', 'periode'
        ])->paginate($entries);
        return view('admin.jadwal-audit.index', compact('auditings'));
    }

    public function getAllJadwalAudit() {
        $jadwalAudit = Auditing::with([
            'auditor1', 'auditor2',
            'auditee1', 'auditee2',
            'unitKerja', 'periode'
        ])->get();
    
        return response()->json([
            'data' => $jadwalAudit
        ], 200);
    }
    
    public function makeJadwalAudit(Request $request) {
        $request->validate([
            'user_id_1_auditor' => 'required|exists:users,user_id',
            'user_id_2_auditor' => 'nullable|exists:users,user_id',
            'user_id_1_auditee' => 'required|exists:users,user_id',
            'user_id_2_auditee' => 'nullable|exists:users,user_id',
            'unit_kerja_id' => 'required|exists:unit_kerja,unit_kerja_id',
            'periode_id' => 'required|exists:periode_audit,periode_id',
        ]);
    
        $audit = Auditing::create([
            'user_id_1_auditor' => $request->user_id_1_auditor,
            'user_id_2_auditor' => $request->user_id_2_auditor,
            'user_id_1_auditee' => $request->user_id_1_auditee,
            'user_id_2_auditee' => $request->user_id_2_auditee,
            'unit_kerja_id' => $request->unit_kerja_id,
            'periode_id' => $request->periode_id,
            'status' => 'Menunggu',
        ]);
    
        return response()->json([
            'message' => 'Data jadwal audit berhasil disimpan!',
            'data' => $audit,
        ], 201);
    }
}
