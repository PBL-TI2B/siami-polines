<?php

namespace App\Http\Controllers;

use App\Models\Auditing;
use App\Models\PeriodeAudit;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class JadwalAuditController extends Controller
{
    public function index(Request $request)
    {
        // Ambil jumlah entri dari query string, default ke 10
        $entries = $request->get('per_page', 10);

        // Ambil kata kunci pencarian
        $search = $request->get('search', '');

        // query data dengan pencarian
        $auditings = Auditing::with([
            'auditor1', 'auditor2',
            'auditee1', 'auditee2',
            'unitKerja', 'periode'
        ])
        -> when($search, function ($query, $search) {
            $query->whereHas('unitKerja', function ($q) use ($search) {
                $q->where('nama_unit_kerja', 'like', "%{$search}%");
            })
            ->orWhereHas('auditor1', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })
            ->orWhereHas('auditor2', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })
            ->orWhereHas('auditee1', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })
            ->orWhereHas('auditee2', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })
            ->orWhereHas('periode', function ($q) use ($search) {
                $q->where('tanggal_mulai', 'like', "%{$search}%");
            });
        })
        ->paginate($entries);
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

    public function create()
{
    return view('admin.jadwal-audit.create');
}

public function makeJadwalAudit(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id_1_auditor' => 'required|exists:users,user_id',
        'user_id_2_auditor' => 'nullable|exists:users,user_id',
        'user_id_1_auditee' => 'required|exists:users,user_id',
        'user_id_2_auditee' => 'nullable|exists:users,user_id',
        'unit_kerja_id' => 'required|exists:unit_kerja,unit_kerja_id',
        'periode_id' => 'required|exists:periode_audit,periode_id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

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
        'message' => 'Data berhasil disimpan!',
        'data' => $audit
    ]);
}

public function destroy($id)
{
    // Cari data berdasarkan ID
    $audit = Auditing::findOrFail($id);

    // Hapus data
    $audit->delete();

    // Redirect atau kembalikan respons JSON
    return redirect()->route('jadwal-audit.index')->with('success', 'Jadwal audit berhasil dihapus.');
}

public function reset(Request $request)
{
    $request->validate([
        'reset_confirmation' => 'required|in:RESET',
    ]);

    // Hapus semua data jadwal audit
    JadwalAudit::truncate();

    return redirect()->route('jadwal-audit.index')->with('success', 'Semua jadwal audit berhasil direset.');
}

public function download()
{
    $auditings = Auditing::with([
        'auditor1', 'auditor2',
        'auditee1', 'auditee2',
        'unitKerja', 'periode'
    ])->get();

    $data = $auditings->map(function ($auditing) {
        return [
            'Unit Kerja' => $auditing->unitKerja->nama_unit_kerja ?? 'N/A',
            'Waktu Audit' => $auditing->periode->tanggal_mulai ? \Carbon\Carbon::parse($auditing->periode->tanggal_mulai)->format('d F Y') : 'N/A',
            'Auditee 1' => $auditing->auditee1->nama ?? 'N/A',
            'Auditee 2' => $auditing->auditee2->nama ?? '-',
            'Auditor 1' => $auditing->auditor1->nama ?? 'N/A',
            'Auditor 2' => $auditing->auditor2->nama ?? '-',
            'Status' => $auditing->status ?? 'Menunggu',
        ];
    });

    return Excel::download(new \App\Exports\JadwalAuditExport($data), 'jadwal_audit.xlsx');
}

public function edit($id) {
    //dd($id); // Debugging line to check the ID
    // Cari data jadwal audit berdasarkan ID
    $audit = Auditing::with(['auditor1', 'auditor2', 'auditee1', 'auditee2', 'unitKerja', 'periode'])->findOrFail($id);

    // Tampilkan halaman edit dengan data yang ditemukan
    return view('admin.jadwal-audit.edit', compact('audit'));
}

public function update(Request $request, $id) {
    // Validate the incoming request data
    $validatedData = $request->validate([
        'unit_kerja_id' => 'required|exists:unit_kerjas,id',
        'waktu_audit' => 'required|date',
        'user_id_1_auditee' => 'nullable|exists:users,id',
        'user_id_1_auditor' => 'nullable|exists:users,id',
        'user_id_2_auditee' => 'nullable|exists:users,id',
        'user_id_2_auditor' => 'nullable|exists:users,id',
    ]);

     // Find the audit record by ID
     $audit = Audit::findOrFail($id);

     // Update the audit record with validated data
     $audit->update($validatedData);
 
     // Redirect back with a success message
     return redirect()->route('jadwal-audit.index')->with('success', 'Jadwal Audit berhasil diperbarui.');
}
    
    // public function makeJadwalAudit(Request $request) {
    //     $request->validate([
    //         'user_id_1_auditor' => 'required|exists:users,user_id',
    //         'user_id_2_auditor' => 'nullable|exists:users,user_id',
    //         'user_id_1_auditee' => 'required|exists:users,user_id',
    //         'user_id_2_auditee' => 'nullable|exists:users,user_id',
    //         'unit_kerja_id' => 'required|exists:unit_kerja,unit_kerja_id',
    //         'periode_id' => 'required|exists:periode_audit,periode_id',
    //     ]);
    
    //     $audit = Auditing::create([
    //         'user_id_1_auditor' => $request->user_id_1_auditor,
    //         'user_id_2_auditor' => $request->user_id_2_auditor,
    //         'user_id_1_auditee' => $request->user_id_1_auditee,
    //         'user_id_2_auditee' => $request->user_id_2_auditee,
    //         'unit_kerja_id' => $request->unit_kerja_id,
    //         'periode_id' => $request->periode_id,
    //         'status' => 'Menunggu',
    //     ]);
    
    //     return response()->json([
    //         'message' => 'Data jadwal audit berhasil disimpan!',
    //         'data' => $audit,
    //     ], 201);
    // }
}
