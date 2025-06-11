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
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;


class PlotingAMIController extends Controller
{
    public function index(Request $request)
    {
        $entries = $request->get('per_page', 10);
        $search = $request->get('search', '');
        $periodeId = $request->get('periode_id'); // Ambil periode_id dari request

        // Ambil semua periode untuk dropdown
        $periodes = PeriodeAudit::all();

        $auditings = Auditing::with([
            'auditor1', 'auditor2',
            'auditee1', 'auditee2',
            'unitKerja', 'periode'
        ])
        ->when($search, function ($query, $search) {
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
        ->when($periodeId, function ($query, $periodeId) {
            $query->where('periode_id', $periodeId);
        })
        ->paginate($entries);

        return view('admin.ploting-ami.index', compact('auditings', 'periodes', 'periodeId'));
    }

    /**
     * Tampilkan data Ploting AMI untuk kepala-pmpp (tabel saja, tanpa logic tidak perlu)
     */
    public function kepalaIndex(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $periodeId = $request->get('periode_id');
        $search = $request->get('search', '');

        // Ambil semua periode untuk dropdown
        $periodes = PeriodeAudit::all();

        $query = Auditing::with([
            'auditor1', 'auditor2',
            'auditee1', 'auditee2',
            'unitKerja', 'periode'
        ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('unitKerja', function ($q2) use ($search) {
                    $q2->where('nama_unit_kerja', 'like', "%{$search}%");
                })
                ->orWhereHas('auditor1', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('auditor2', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('auditee1', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('auditee2', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%");
                });
            });
        }
        if ($periodeId) {
            $query->where('periode_id', $periodeId);
        }

        $auditings = $query->paginate($perPage);

        return view('kepala-pmpp.ploting-ami.index', compact('auditings', 'periodes', 'periodeId'));
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

    public function editJadwal(Request $request)
    {
        $user = session('user')['user_id'];
        $auditing = session('auditing_id');
        $response = Http::get('http://127.0.0.1:5000/api/auditings/userID=' . $user);
        $auditingUnit = $response->json()['data'] ?? [];

        // Find the specific auditing record by ID
        $auditing = collect($auditingUnit)->firstWhere('auditing_id', $auditing);

        if (!$auditing) {
            abort(404, 'Auditing record not found');
        }

        return view('auditor.assesmen-lapangan.index', compact('auditing'));
    }

    public function updateJadwal(Request $request, $id)
    {
        $validated = $request->validate([
            'jadwal_audit' => 'nullable|date',
        ]);

        // Kirim update ke API untuk jadwal_audit
        $response = Http::asJson()->put("http://127.0.0.1:5000/api/auditings/$id", [
            'jadwal_audit' => $validated['jadwal_audit'],
        ]);

        if (!$response->successful()) {
            $errorMessage = $response->json()['message'] ?? 'Gagal memperbarui data audit di API.';
            return redirect()->back()->with('error', $errorMessage);
        }

        // Update status di endpoint responses/auditing jika status di session adalah 3 atau 4
        $auditingId = session('auditing_id');
        $auditStatus = session('status');

        if (in_array($auditStatus, [2, 3])) {
            Log::info('Updating status', ['auditingId' => $auditingId, 'auditStatus' => $auditStatus]);
            $statusResponse = Http::asJson()->put("http://127.0.0.1:5000/api/auditings/$auditingId", [
                'status' => 3,
            ]);

            if (!$statusResponse->successful()) {
                Log::error('Status update failed', [
                    'status_code' => $statusResponse->status(),
                    'response_body' => $statusResponse->body(),
                ]);
                $errorMessage = $statusResponse->json()['message'] ?? 'Gagal memperbarui status audit di API.';
                return redirect()->back()->with('error', $errorMessage);
            }
        }

        // Fetch the updated auditing record
        $user = session('user')['user_id'];
        $response = Http::get('http://127.0.0.1:5000/api/auditings/userID=' . $user);
        $auditingUnit = $response->json()['data'] ?? [];
        $auditing = collect($auditingUnit)->firstWhere('auditing_id', $id);

        if (!$auditing) {
            return redirect()->route('auditor.assesmen-lapangan.index')->with('error', 'Auditing record not found after update');
        }

        return redirect()->route('auditor.audit.index');
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

public function download()
{
    $auditings = Auditing::with([
        'auditor1', 'auditor2',
        'auditee1', 'auditee2',
        'unitKerja', 'periode'
    ])->get();

    $data = $auditings->map(function ($auditing) {
        $statusLabels = [
            1 => 'Pengisian Instrumen',
            2 => 'Desk Evaluation',
            3 => 'Penjadwalan AL',
            4 => 'Pertanyaan Tilik',
            5 => 'Tilik Dijawab',
            6 => 'Laporan Temuan',
            7 => 'Revisi',
            8 => 'Sudah revisi',
            9 => 'Closing',
            10 => 'Selesai',
        ];
        return [
            'Unit Kerja' => $auditing->unitKerja->nama_unit_kerja ?? 'N/A',
            'Waktu Audit' => $auditing->jadwal_audit ? \Carbon\Carbon::parse($auditing->jadwal_audit)->format('d F Y') : 'N/A',
            'Auditee 1' => $auditing->auditee1->nama ?? 'N/A',
            'Auditee 2' => $auditing->auditee2->nama ?? '-',
            'Auditor 1' => $auditing->auditor1->nama ?? 'N/A',
            'Auditor 2' => $auditing->auditor2->nama ?? '-',
            'Status' => $statusLabels[$auditing->status] ?? 'Menunggu',
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
        'jadwal_audit' => 'nullable|date',
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
    public function lihatJadwal(Request $request)
    {
        $user = session('user')['user_id'];
        $auditing = session('auditing_id');
        $response = Http::get('http://127.0.0.1:5000/api/auditings/userID=' . $user);
        $auditingUnit = $response->json()['data'] ?? [];

        // Find the specific auditing record by ID
        $auditing = collect($auditingUnit)->firstWhere('auditing_id', $auditing);

        if (!$auditing) {
            abort(404, 'Auditing record not found');
        }

        return view('auditee.assesmen-lapangan.index', compact('auditing'));
    }

    public function downloadptpp($id)
    {
        $audit = Auditing::with(['auditor1', 'auditor2', 'auditee1', 'auditee2', 'periode', 'unitKerja'])->findOrFail($id);

        if ($audit->status != 11) {
            return redirect()->back()->with('error', 'PTPP hanya tersedia jika status selesai.');
        }

        $pdf = Pdf::loadView('kepala-pmpp.ploting-ami.ptpp', compact('audit'));

        return $pdf->download('PTPP-'.$audit->unit_kerja.'.pdf');
    }

    // public function downloadRTM($auditingId)
    // {
    //     // Contoh: generate file RTM (bisa dari storage, atau generate on the fly)
    //     $filename = 'RTM_'.$auditingId.'.pdf';
    //     $path = storage_path('app/public/rtm/'.$filename);

    //     if (!file_exists($path)) {
    //         abort(404, 'File RTM tidak ditemukan');
    //     }

    //     return Response::download($path, $filename);
    // }

    // public function downloadLaporan($auditingId)
    // {
    //     // Contoh: generate file Laporan (bisa dari storage, atau generate on the fly)
    //     $filename = 'Laporan_'.$auditingId.'.pdf';
    //     $path = storage_path('app/public/laporan/'.$filename);

    //     if (!file_exists($path)) {
    //         abort(404, 'File Laporan tidak ditemukan');
    //     }

    //     return Response::download($path, $filename);
    // }
}
