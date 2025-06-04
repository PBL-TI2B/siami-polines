<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Auditing;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function auditeeIndexPage()
    {
        return view('auditee.audit.index');
    }

    public function getAuditingsByUser()
    {
        $userId = session('user')['user_id'] ?? null;

        if (!$userId) {
            return response()->json(['message' => 'User tidak login'], 401);
        }

        try {
            $response = Http::get("http://127.0.0.1:5000/api/auditings/userID={$userId}");

            if ($response->successful()) {
                $data = $response->json();

                // Ambil jenis_unit_id jika tersedia
                $jenisUnitId = $data['data'][0]['unit_kerja']['jenis_unit_id'] ?? null;
                $auditingId = $data['data'][0]['auditing_id'] ?? null;
                $status = $data['data'][0]['status'] ?? null;
                $unitKerjaId = $data['data'][0]['unit_kerja']['unit_kerja_id'] ?? null;

                // Simpan ke session (opsional)
                if ($jenisUnitId !== null) {
                    session(['jenis_unit_id' => $jenisUnitId]);
                }
                if ($auditingId !== null) {
                    session(['auditing_id' => $auditingId]);
                }
                if ($status !== null) {
                    session(['status' => $status]);
                }
                if ($unitKerjaId !== null) {
                    session(['unit_kerja_id' => $unitKerjaId]);
                }

                // Kembalikan respons seperti biasa, bisa juga sertakan jenis_unit_id
                return response()->json([
                    'message' => $data['message'],
                    'jenis_unit_id' => $jenisUnitId,
                    'data' => $data['data']
                ]);
            } else {
                return response()->json([
                    'message' => 'Gagal mengambil data dari API',
                    'status' => $response->status(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghubungi API',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan halaman detail progress untuk satu audit spesifik.
     * Mengambil semua audit user, lalu memfilter berdasarkan auditingId dari route.
     */
    public function showAuditeeAuditProgress(Request $request, $auditingId) // $auditingId dari parameter route
    {
        $userId = session('user')['user_id'] ?? null;
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat progress audit.');
        }

        try {
            // 1. Ambil SEMUA audit yang terkait dengan userID dari session
            $response = Http::get("http://127.0.0.1:5000/api/auditings/userID={$userId}");

            if ($response->successful()) {
                $apiData = $response->json();
                $allUserAudits = $apiData['data'] ?? []; // Ini adalah array dari semua audit user
                $audit = null; // Variabel untuk menyimpan audit yang cocok

                // 2. Cari audit spesifik dari daftar berdasarkan $auditingId dari route
                if (is_array($allUserAudits)) {
                    foreach ($allUserAudits as $item) {
                        // Pastikan $item adalah array atau objek yang bisa diakses fieldnya
                        if (is_array($item) && isset($item['auditing_id'])) {
                            if ((string)$item['auditing_id'] === (string)$auditingId) {
                                $audit = $item;
                                break; // Hentikan loop setelah audit ditemukan
                            }
                        }
                    }
                }

                if (!$audit) {
                    Log::warning("Audit spesifik dengan ID {$auditingId} tidak ditemukan untuk user {$userId} setelah memfilter dari list API.", ['auditing_id_route' => $auditingId, 'user_id_session' => $userId]);
                    return back()->with('error', 'Data audit spesifik (ID: ' . $auditingId . ') tidak ditemukan untuk Anda.');
                }
                // 3. Pastikan user yang login adalah auditee pada audit spesifik ini
                $isAuditee1 = isset($audit['user_id_1_auditee']) && $audit['user_id_1_auditee'] == $userId;
                $isAuditee2 = isset($audit['user_id_2_auditee']) && $audit['user_id_2_auditee'] == $userId;

                if (!$isAuditee1 && !$isAuditee2) {
                    Log::warning("Akses ditolak (setelah filter) untuk user {$userId} ke audit ID {$auditingId}. Auditee IDs: " . ($audit['user_id_1_auditee'] ?? 'N/A') . ", " . ($audit['user_id_2_auditee'] ?? 'N/A'));
                    abort(403, 'Anda tidak memiliki hak akses untuk melihat progress audit ini.');
                }

                // Mendapatkan jenis_unit_id dari data audit SPESIFIK yang telah ditemukan
                if (!isset($audit['unit_kerja']['jenis_unit_id'])) {
                    Log::warning("Jenis Unit Kerja tidak ditemukan untuk audit ID: {$auditingId}", ['audit_data' => $audit]);
                    return back()->with('error', 'Informasi Jenis Unit Kerja tidak ditemukan untuk audit ini.');
                }
                $jenisUnitId = (int)$audit['unit_kerja']['jenis_unit_id'];

                $currentAuditingIdForRoutes = $audit['auditing_id'] ?? $auditingId;

                $instrumenRoute = match ($jenisUnitId) {
                    1 => route('auditee.data-instrumen.instrumenupt', ['auditingId' => $currentAuditingIdForRoutes]),
                    2 => route('auditee.data-instrumen.instrumenjurusan', ['auditingId' => $currentAuditingIdForRoutes]),
                    3 => route('auditee.data-instrumen.instrumenprodi', ['auditingId' => $currentAuditingIdForRoutes]),
                    default => '#',
                };
                $assessmentScheduleRoute = route('auditee.assesmen-lapangan.index', ['auditingId' => $currentAuditingIdForRoutes]);
                $tilikResponseRoute = '#';

                return view('auditee.audit.progress-detail', [
                    'audit' => $audit,
                    'instrumenRoute' => $instrumenRoute,
                    'assessmentScheduleRoute' => $assessmentScheduleRoute,
                    'tilikResponseRoute' => $tilikResponseRoute,
                ]);

            } else if ($response->status() == 404) {
                return back()->with('error', 'Tidak ada data audit yang ditemukan untuk user Anda dari sistem eksternal.');
            } else {
                Log::error('Gagal mengambil daftar audit (untuk filtering) dari API eksternal: ' . $response->status() . ' - ' . $response->body());
                return back()->with('error', 'Gagal mengambil data audit dari API. Status: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error("Exception saat mengambil/memfilter audit (ID: {$auditingId}) dari API: " . $e->getMessage());
            return back()->with('error', 'Terjadi masalah saat menghubungi layanan audit.');
        }
    }


    public function auditorIndexPage()
    {
        return view('auditor.audit.index');
    }

     public function auditorAuditPage($id)
{
    $auditing = Auditing::with(['unitKerja', 'auditor1', 'auditor2', 'auditee1', 'auditee2', 'periode'])
        ->findOrFail($id);
    return view('auditor.audit.audit', compact('auditing'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
