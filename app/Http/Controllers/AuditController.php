<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
                $tilikResponseRoute = route('auditee.daftar-tilik.index', ['auditingId' => $currentAuditingIdForRoutes]);

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

    public function showAuditeeInstrumenUPT(Request $request, $auditingId)
    {
        $userId = session('user')['user_id'] ?? null;
        $unitKerjaId = session('unit_kerja_id') ?? null;
        $status = session('status') ?? null;

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengakses instrumen jurusan.');
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

            // Validasi jenis unit (harus jurusan, jenis_unit_id = 1)
            $jenisUnitId = (int)($audit['unit_kerja']['jenis_unit_id'] ?? 0);
            if ($jenisUnitId !== 1) {
                \Log::warning("Jenis unit tidak valid untuk audit ID {$auditingId}. Ditemukan jenis_unit_id: {$jenisUnitId}");
                return back()->with('error', 'Halaman ini hanya untuk unit.');
            }

            // Simpan data ke session jika belum ada
            session([
                'auditing_id' => $audit['auditing_id'],
                'unit_kerja_id' => $audit['unit_kerja']['unit_kerja_id'] ?? $unitKerjaId,
                'status' => $audit['status'] ?? $status,
                'jenis_unit_id' => $jenisUnitId,
            ]);

            // Render view dengan data yang diperlukan
            return view('auditee.data-instrumen.instrumenupt', [
                'audit' => $audit,
                'auditingId' => $auditingId,
                'unitKerjaId' => session('unit_kerja_id'),
                'status' => session('status'),
            ]);
        } catch (\Exception $e) {
            \Log::error("Gagal memuat halaman instrumen unit untuk audit ID {$auditingId}: " . $e->getMessage());
            return back()->with('error', 'Terjadi masalah saat memuat halaman instrumen unit.');
        }
    }


    public function showAuditeeInstrumenJurusan(Request $request, $auditingId)
    {
        $userId = session('user')['user_id'] ?? null;
        $unitKerjaId = session('unit_kerja_id') ?? null;
        $status = session('status') ?? null;

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengakses instrumen jurusan.');
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

            // Validasi jenis unit (harus jurusan, jenis_unit_id = 2)
            $jenisUnitId = (int)($audit['unit_kerja']['jenis_unit_id'] ?? 0);
            if ($jenisUnitId !== 2) {
                \Log::warning("Jenis unit tidak valid untuk audit ID {$auditingId}. Ditemukan jenis_unit_id: {$jenisUnitId}");
                return back()->with('error', 'Halaman ini hanya untuk jurusan.');
            }

            // Simpan data ke session jika belum ada
            session([
                'auditing_id' => $audit['auditing_id'],
                'unit_kerja_id' => $audit['unit_kerja']['unit_kerja_id'] ?? $unitKerjaId,
                'status' => $audit['status'] ?? $status,
                'jenis_unit_id' => $jenisUnitId,
            ]);

            // Render view dengan data yang diperlukan
            return view('auditee.data-instrumen.instrumenjurusan', [
                'audit' => $audit,
                'auditingId' => $auditingId,
                'unitKerjaId' => session('unit_kerja_id'),
                'status' => session('status'),
            ]);
        } catch (\Exception $e) {
            \Log::error("Gagal memuat halaman instrumen jurusan untuk audit ID {$auditingId}: " . $e->getMessage());
            return back()->with('error', 'Terjadi masalah saat memuat halaman instrumen jurusan.');
        }
    }

    public function showAuditeeInstrumenProdi(Request $request, $auditingId)
    {
        $userId = session('user')['user_id'] ?? null;
        $unitKerjaId = session('unit_kerja_id') ?? null;
        $status = session('status') ?? null;

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengakses instrumen prodi.');
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

            // Validasi jenis unit (harus prodi, jenis_unit_id = 3)
            $jenisUnitId = (int)($audit['unit_kerja']['jenis_unit_id'] ?? 0);
            if ($jenisUnitId !== 3) {
                \Log::warning("Jenis unit tidak valid untuk audit ID {$auditingId}. Ditemukan jenis_unit_id: {$jenisUnitId}");
                return back()->with('error', 'Halaman ini hanya untuk prodi.');
            }

            // Simpan data ke session jika belum ada
            session([
                'auditing_id' => $audit['auditing_id'],
                'unit_kerja_id' => $audit['unit_kerja']['unit_kerja_id'] ?? $unitKerjaId,
                'status' => $audit['status'] ?? $status,
                'jenis_unit_id' => $jenisUnitId,
            ]);

            // Render view dengan data yang diperlukan
            return view('auditee.data-instrumen.instrumenprodi', [
                'auditingId' => $auditingId,
                'unitKerjaId' => session('unit_kerja_id'),
                'status' => session('status'),
            ]);
        } catch (\Exception $e) {
            \Log::error("Gagal memuat halaman instrumen prodi untuk audit ID {$auditingId}: " . $e->getMessage());
            return back()->with('error', 'Terjadi masalah saat memuat halaman instrumen prodi.');
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
        $jenisUnitId = $auditing->unitKerja->jenis_unit_id ?? null;
        return view('auditor.audit.audit', compact('auditing', 'jenisUnitId'));
    }
    public function auditorShowInstrumenJurusan($id)
{
    // Validasi ID
    if (!is_numeric($id) || $id <= 0) {
        \Log::warning("ID audit tidak valid: {$id}");
        return redirect()->route('auditor.audit.index')->with('error', 'ID audit tidak valid.');
    }

    // Periksa sesi pengguna
    $userId = session('user')['user_id'] ?? null;
    if (!$userId) {
        \Log::warning("Pengguna belum login untuk mengakses audit ID: {$id}");
        return redirect()->route('login')->with('error', 'Silakan login untuk mengakses instrumen jurusan.');
    }

    try {
        // Ambil data audit dengan relasi
        $auditing = Auditing::with(['unitKerja', 'auditor1', 'auditor2', 'auditee1', 'auditee2', 'periode'])
            ->findOrFail($id);

        // Validasi bahwa pengguna adalah auditor untuk audit ini
        if ($auditing->user_id_1_auditor != $userId && $auditing->user_id_2_auditor != $userId) {
            \Log::warning("Akses tidak sah ke audit ID: {$id} oleh pengguna ID: {$userId}");
            return redirect()->route('auditor.audit.index')->with('error', 'Anda tidak memiliki hak akses untuk audit ini.');
        }

        // Validasi jenis unit (harus jurusan, jenis_unit_id = 2)
        $jenisUnitId = $auditing->unitKerja->jenis_unit_id ?? null;
        if ($jenisUnitId !== 2) {
            \Log::warning("Jenis unit tidak valid untuk audit ID: {$id}. Ditemukan jenis_unit_id: {$jenisUnitId}");
            return redirect()->route('auditor.audit.index')->with('error', 'Halaman ini hanya untuk jurusan.');
        }

        // Ambil data dari API
        $response = Http::get("http://127.0.0.1:5000/api/instrumen-response");
        if ($response->successful()) {
            $allData = $response->json()['data'] ?? [];
            $filteredData = array_filter($allData, function ($item) use ($userId, $id) {
                return isset($item['auditing_id']) && $item['auditing_id'] === (int)$id &&
                       (isset($item['auditing']['user_id_1_auditor']) && $item['auditing']['user_id_1_auditor'] === $userId ||
                        isset($item['auditing']['user_id_2_auditor']) && $item['auditing']['user_id_2_auditor'] === $userId);
            });
            $instrumenData = array_values($filteredData);
        } else {
            \Log::error("Gagal mengambil data instrumen-response dari API: {$response->status()}", ['response' => $response->body()]);
            $instrumenData = [];
        }

        return view('auditor.data-instrumen.instrumenjurusan', compact('auditing', 'instrumenData'));
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        \Log::error("Data audit tidak ditemukan untuk ID: {$id}", ['exception' => $e->getMessage()]);
        return redirect()->route('auditor.audit.index')->with('error', 'Data audit tidak ditemukan.');
    } catch (\Exception $e) {
        \Log::error("Kesalahan saat mengambil data audit untuk ID: {$id}", ['exception' => $e->getMessage()]);
        return redirect()->route('auditor.audit.index')->with('error', 'Terjadi kesalahan saat mengambil data audit.');
    }
}
public function auditorUpdateInstrumenResponse(Request $request, $id)
{
    // Validasi ID audit
    if (!is_numeric($id) || $id <= 0) {
        \Log::warning("ID audit tidak valid: {$id}");
        return response()->json(['message' => 'ID audit tidak valid'], 400);
    }

    // Periksa sesi pengguna
    $userId = session('user')['user_id'] ?? null;
    if (!$userId) {
        \Log::warning("Pengguna belum login untuk memperbarui respons instrumen response ID: {$response_id}");
        return response()->json(['message' => 'Silakan login terlebih dahulu'], 401);
    }

    // Validasi input
    $request->validate([
        'audit_id' => 'required|integer',
        'sesuai' => 'nullable|string|max:1000',
        'minor' => 'nullable|string|max:1000',
        'mayor' => 'nullable|string|max:1000',
        'ofi' => 'nullable|string|max:1000',
    ]);

    try {
        // Periksa apakah audit ada dan pengguna adalah auditor
        $auditing = Auditing::with(['unitKerja', 'auditor1', 'auditor2'])
            ->findOrFail($request->audit_id);

        if ($auditing->user_id_1_auditor != $userId && $auditing->user_id_2_auditor != $userId) {
            \Log::warning("Akses tidak sah ke audit ID: {$request->audit_id} oleh pengguna ID: {$userId}");
            return response()->json(['message' => 'Anda tidak memiliki hak akses untuk audit ini'], 403);
        }

        // Kirim data ke API
        $response = Http::patch("http://127.0.0.1:5000/api/responses/{$response_id}", [
            'sesuai' => $request->sesuai,
            'minor' => $request->minor,
            'mayor' => $request->mayor,
            'ofi' => $request->ofi,
        ]);

        if ($response->successful()) {
            \Log::info("Berhasil memperbarui respons instrumen untuk response ID: {$response_id}", ['data' => $request->all()]);
            return response()->json(['message' => 'Data berhasil diperbarui'], 200);
        } else {
            \Log::error("Gagal memperbarui respons instrumen untuk response ID: {$response_id}", ['response' => $response->body()]);
            return response()->json(['message' => 'Gagal memperbarui data di API', 'error' => $response->body()], $response->status());
        }
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        \Log::error("Data audit tidak ditemukan untuk ID: {$request->audit_id}", ['exception' => $e->getMessage()]);
        return response()->json(['message' => 'Data audit tidak ditemukan'], 404);
    } catch (\Exception $e) {
        \Log::error("Kesalahan saat memperbarui respons instrumen untuk response ID: {$response_id}", ['exception' => $e->getMessage()]);
        return response()->json(['message' => 'Terjadi kesalahan saat memperbarui data'], 500);
    }
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
