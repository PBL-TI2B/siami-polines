<?php

namespace App\Http\Controllers;

use App\Models\Auditing;
use App\Models\PeriodeAudit;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class PlotingAMIController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::get('http://127.0.0.1:5000/api/auditings');
        $auditings = $response->json()['data'] ?? [];
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
        return view('admin.ploting-ami.index', compact('auditings'));
    }

    public function indexAssesmen(Request $request) {
        $user = session('user')['user_id'];
        $perPage = $request->query('per_page', 5);
        $search = $request->query('search');
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $response = Http::get('http://127.0.0.1:5000/api/auditings/userID=' . $user);

        $json = $response->json();
        $auditingUnit = $json['data'] ?? [];

        $collection = collect($auditingUnit);
        // Ambil jumlah entri dari query string, default ke 10
        $sliced = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedUnits = new LengthAwarePaginator(
            $sliced,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('auditor.assesmen-lapangan.index', ['auditings' => $paginatedUnits]);
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
    $unitKerja = UnitKerja::all();
    $periodeAudit = PeriodeAudit::all();
    $auditors = User::where('role_id', 2)->get(); 
    $auditees = User::where('role_id', 3)->get();   

    return view('admin.ploting-ami.create', compact('unitKerja', 'periodeAudit', 'auditors', 'auditees'));
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
        'jadwal_audit' => 'nullable|date',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

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
    return redirect()->route('admin.ploting-ami.index')->with('success', 'Jadwal audit berhasil dihapus.');
}

public function reset(Request $request)
{
    $request->validate([
        'reset_confirmation' => 'required|in:RESET',
    ]);

   // Nonaktifkan foreign key checks
   \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

   // Hapus semua data jadwal audit
   Auditing::truncate();

   // Aktifkan kembali foreign key checks
   \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    return redirect()->route('admin.ploting-ami.index')->with('success', 'Semua jadwal audit berhasil direset.');
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
    $audit = Auditing::with(['auditor1', 'auditor2', 'auditee1', 'auditee2', 'unitKerja', 'periode'])->findOrFail($id);

    $list_auditor = [];
    $list_auditee = [];
    $list_unitKerja = [];

    try {
        $responseUser = Http::get('http://127.0.0.1:5000/api/data-user');
        $responseUnitKerja = Http::get('http://127.0.0.1:5000/api/unit-kerja');

        if ($responseUser->successful()) {
            $dataUser = collect($responseUser->json()['data'] ?? []);

            $list_auditor = $dataUser
                ->filter(fn($user) => $user['role_id'] == 2)
                ->pluck('nama', 'user_id')
                ->toArray();

            $list_auditee = $dataUser
                ->filter(fn($user) => $user['role_id'] == 3)
                ->pluck('nama', 'user_id')
                ->toArray();
        } else {
            Log::error('Gagal mengambil data user: ' . $responseUser->body());
        }

        if ($responseUnitKerja->successful()) {
            $list_unitKerja = collect($responseUnitKerja->json()['data'] ?? [])
                ->pluck('nama_unit_kerja', 'unit_kerja_id')
                ->toArray();
        } else {
            Log::error('Gagal mengambil data unit kerja: ' . $responseUnitKerja->body());
        }
    } catch (\Exception $e) {
        Log::error('Exception saat mengambil data: ' . $e->getMessage());
    }

    return view('admin.ploting-ami.edit', compact('audit', 'list_auditor', 'list_auditee', 'list_unitKerja'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'unit_kerja_id' => 'required|exists:unit_kerja,unit_kerja_id',
        'jadwal_audit' => 'required|date',
        'user_id_1_auditee' => 'required|exists:users,user_id',
        'user_id_2_auditee' => 'nullable|exists:users,user_id',
        'user_id_1_auditor' => 'required|exists:users,user_id',
        'user_id_2_auditor' => 'nullable|exists:users,user_id',
    ]);

    // Kirim update ke API
    $response = Http::asJson()->put("http://127.0.0.1:5000/api/auditings/{$id}", $validated);

    if (!$response->successful()) {
        $errorMessage = $response->json()['message'] ?? 'Gagal memperbarui data audit di API.';
        Log::error('Failed to update audit', ['id' => $id, 'response' => $response->body()]);
        return redirect()->back()->with('error', $errorMessage);
    }

    return redirect()->route('admin.ploting-ami.index')->with('success', 'Jadwal Audit berhasil diperbarui');
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
