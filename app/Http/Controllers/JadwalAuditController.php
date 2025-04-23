<?php

namespace App\Http\Controllers;

use App\Models\Auditing;
use App\Models\PeriodeAudit;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalAuditController extends Controller
{
    public function index()
    {
        return view('admin.jadwal-audit.index');
    }

    public function getAllJadwalAudit() {
        $jadwalAudit = Auditing::with('user', 'shop')->get();

        return response()->json([
            'data' => $jadwalAudit
        ], 200);
    }

    public function makeJadwalAudit(Request $request) {
        $request ->validate([
            'user_id_1_auditor' => 'required|string|exist:user,nama',
            'user_id_2_auditor' => 'string|exist:user,nama',
            'user_id_1_auditee' => 'required|string|exist:user,nama',
            'user_id_2_auditee' => 'string|exist:user,nama',
            'unit_kerja_id' => 'required|string|exist:unit_kerja,nama_unit_kerja',
            'periode_id' => 'required|string|exist:periode,nama',
        ]);

        $user_auditor1 = User::where('nama', $request->nama)->first();
        $user_auditor2 = User::where('nama', $request->nama)->first();
        $user_auditee1 = User::where('nama', $request->nama)->first();
        $user_auditee2 = User::where('nama', $request->nama)->first();
        $unit_kerja = UnitKerja::where('nama_unit', $request->nama_unit)->first();
        $periode = PeriodeAudit::where('nama', $request->nama)->first();

        if (!$user_auditor1 || !$user_auditee1 || !$unit_kerja || !$periode) {
            return response()->json(['message'=>'data tidak ditemukan'], 404);
        }

        $audit = Auditing::create([
            'user_id_1_auditor' => $user_auditor1->user_id,
            'user_id_2_auditor' => $user_auditor2->user_id,
            'user_id_1_auditee' => $user_auditee1->user_id,
            'user_id_2_auditee' => $user_auditee2->user_id,
            'unit_kerja_id' => $unit_kerja->id_unit_kerja,
            'periode_id' => $periode->periode_id,
        ]);

        return response()->json([
            'message'=> 'Data jadwal audit berhasil disimpan!',
            'data' => $audit,
        ], 201);
    }
}
