<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Auditing;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


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
                //$jenisUnitId = $data['data'][0]['unit_kerja']['jenis_unit_id'] ?? null;
                $auditingId = $data['data'][0]['auditing_id'] ?? null;
                $status = $data['data'][0]['status'] ?? null;
                $unitKerjaId = $data['data'][0]['unit_kerja']['unit_kerja_id'] ?? null;

                // Simpan ke session (opsional)
                // if ($jenisUnitId !== null) {
                //     session(['jenis_unit_id' => $jenisUnitId]);
                // }
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
                    // 'jenis_unit_id' => $jenisUnitId,
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
                $allUserAudits = $apiData['data'] ?? [];
                $audit = null;

                // 2. Cari audit spesifik dari daftar berdasarkan $auditingId
                if (is_array($allUserAudits)) {
                    foreach ($allUserAudits as $item) {
                        if (is_array($item) && isset($item['auditing_id']) && (string)$item['auditing_id'] === (string)$auditingId) {
                            $audit = $item;
                            break;
                        }
                    }
                }

                if (!$audit) {
                    Log::warning("Audit spesifik dengan ID {$auditingId} tidak ditemukan untuk user {$userId}.", ['auditing_id_route' => $auditingId, 'user_id_session' => $userId]);
                    return back()->with('error', 'Data audit spesifik (ID: ' . $auditingId . ') tidak ditemukan untuk Anda.');
                }

                // ====================================================================
                //                        AWAL VALIDASI PERIODE BARU
                // ====================================================================
                $isPeriodeActive = false; // Nilai default
                if (isset($audit['periode']['tanggal_mulai']) && isset($audit['periode']['tanggal_berakhir'])) {
                    $now = Carbon::now()->startOfDay();
                    $startDate = Carbon::parse($audit['periode']['tanggal_mulai'])->startOfDay();
                    $endDate = Carbon::parse($audit['periode']['tanggal_berakhir'])->startOfDay();

                    // Cek apakah tanggal hari ini berada di antara tanggal mulai dan berakhir (inklusif)
                    if ($now->between($startDate, $endDate)) {
                        $isPeriodeActive = true;
                    }
                }
                // ====================================================================
                //                         AKHIR VALIDASI PERIODE BARU
                // ====================================================================


                // 3. Pastikan user yang login adalah auditee pada audit spesifik ini
                $isAuditee1 = isset($audit['user_id_1_auditee']) && $audit['user_id_1_auditee'] == $userId;
                $isAuditee2 = isset($audit['user_id_2_auditee']) && $audit['user_id_2_auditee'] == $userId;

                if (!$isAuditee1 && !$isAuditee2) {
                    Log::warning("Akses ditolak untuk user {$userId} ke audit ID {$auditingId}.");
                    abort(403, 'Anda tidak memiliki hak akses untuk melihat progress audit ini.');
                }

                // Mendapatkan jenis_unit_id dari data audit SPESIFIK
                if (!isset($audit['unit_kerja']['jenis_unit_id'])) {
                    Log::warning("Jenis Unit Kerja tidak ditemukan untuk audit ID: {$auditingId}", ['audit_data' => $audit]);
                    return back()->with('error', 'Informasi Jenis Unit Kerja tidak ditemukan untuk audit ini.');
                }
                $jenisUnitId = (int)$audit['unit_kerja']['jenis_unit_id'];
                $currentAuditingIdForRoutes = $audit['auditing_id'] ?? $auditingId;

                // Penentuan route berdasarkan jenis unit
                $instrumenRoute = match ($jenisUnitId) {
                    1 => route('auditee.data-instrumen.instrumenupt', ['auditingId' => $currentAuditingIdForRoutes]),
                    2 => route('auditee.data-instrumen.instrumenjurusan', ['auditingId' => $currentAuditingIdForRoutes]),
                    3 => route('auditee.data-instrumen.instrumenprodi', ['auditingId' => $currentAuditingIdForRoutes]),
                    default => '#',
                };
                $assessmentScheduleRoute = route('auditee.assesmen-lapangan.index', ['auditingId' => $currentAuditingIdForRoutes]);
                $tilikResponseRoute = route('auditee.daftar-tilik.index', ['auditingId' => $currentAuditingIdForRoutes]);
                $laporanTemuanRoute = route('auditee.laporan-temuan.index', ['auditingId' => $currentAuditingIdForRoutes]);

                return view('auditee.audit.progress-detail', [
                    'audit' => $audit,
                    'isPeriodeActive' => $isPeriodeActive, // <-- VARIABEL BARU DIKIRIM KE VIEW
                    'instrumenRoute' => $instrumenRoute,
                    'assessmentScheduleRoute' => $assessmentScheduleRoute,
                    'tilikResponseRoute' => $tilikResponseRoute,
                    'laporanTemuanRoute' => $laporanTemuanRoute,
                ]);

            } else if ($response->status() == 404) {
                return back()->with('error', 'Tidak ada data audit yang ditemukan untuk user Anda dari sistem eksternal.');
            } else {
                Log::error('Gagal mengambil daftar audit dari API eksternal: ' . $response->status() . ' - ' . $response->body());
                return back()->with('error', 'Gagal mengambil data audit dari API. Status: ' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error("Exception saat mengambil/memfilter audit (ID: {$auditingId}): " . $e->getMessage());
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

    public function showAuditeeLaporanTemuan(Request $request, $auditingId)
    {
        $userId = session('user')['user_id'] ?? null;
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengakses laporan temuan.');
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
            }            // Ambil data laporan temuan dari API
            $laporanTemuan = [];
            try {
                $temuanResponse = Http::timeout(30)->retry(2, 100)->get("http://127.0.0.1:5000/api/laporan-temuan", [
                    'auditing_id' => $auditingId
                ]);

                if ($temuanResponse->successful()) {
                    $temuanApiData = $temuanResponse->json();
                    $laporanTemuan = $temuanApiData['data'] ?? [];
                    \Log::info("Berhasil mengambil data laporan temuan untuk audit ID {$auditingId}", ['jumlah' => count($laporanTemuan)]);
                } else {
                    \Log::warning("Gagal mengambil data laporan temuan untuk audit ID {$auditingId}: Status " . $temuanResponse->status() . ", Body: " . $temuanResponse->body());
                }
            } catch (\Exception $e) {
                \Log::error("Exception saat mengambil data laporan temuan untuk audit ID {$auditingId}: " . $e->getMessage());
            }

            // Data sudah lengkap dari API, tidak perlu mapping tambahan
            // Karena API sudah mengembalikan data dengan struktur nested yang lengkap
            // kriteria: { kriteria_id, nama_kriteria }
            // response_tilik: { response_tilik_id, standar_nasional, akar_penyebab_penunjang, dll }

            // Kirim data ke view
            return view('auditee.laporan-temuan.index', [
                'audit' => $audit,
                'auditingId' => $auditingId,
                'laporanTemuan' => $laporanTemuan,
            ]);
        } catch (\Exception $e) {
            \Log::error("Gagal memuat halaman laporan temuan untuk audit ID {$auditingId}: " . $e->getMessage());
            return back()->with('error', 'Terjadi masalah saat memuat halaman laporan temuan.');
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
   public function auditorShowInstrumenUpt($id)
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
        return redirect()->route('login')->with('error', 'Silakan login untuk mengakses instrumen upt.');
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
        if ($jenisUnitId !== 1) {
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

        return view('auditor.data-instrumen.instrumenupt', compact('auditing', 'instrumenData'));
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        \Log::error("Data audit tidak ditemukan untuk ID: {$id}", ['exception' => $e->getMessage()]);
        return redirect()->route('auditor.audit.index')->with('error', 'Data audit tidak ditemukan.');
    } catch (\Exception $e) {
        \Log::error("Kesalahan saat mengambil data audit untuk ID: {$id}", ['exception' => $e->getMessage()]);
        return redirect()->route('auditor.audit.index')->with('error', 'Terjadi kesalahan saat mengambil data audit.');
    }
}
public function auditorShowInstrumenProdi($id)
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
        if ($jenisUnitId !== 3) {
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

        return view('auditor.data-instrumen.instrumenprodi', compact('auditing', 'instrumenData'));
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
    public function getAuditingsAuditor(Request $request, $auditingId)
    {
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
            session([
                'auditing_id' => $audit['auditing_id'],
                'unit_kerja_id' => $audit['unit_kerja']['unit_kerja_id'] ?? $unitKerjaId,
                'status' => $audit['status'] ?? $status,
                'jenis_unit_id' => $jenisUnitId,
            ]);
    }


    public function previewPTPP($id)
{
    try {
        // 1. Ambil data audit dari database
        $audit = Auditing::with(['auditor1', 'auditor2', 'auditee1', 'auditee2', 'periode', 'unitKerja'])
            ->findOrFail($id);

        $fileName = 'Permintaan Tindakan Perbaikan dan Pencegahan-' .
            ($audit->unitKerja->nama_unit_kerja ?? 'unit') . '-' . ($audit->periode->nama_periode) . '.pdf';


        // 2. Permintaan API untuk laporan temuan
        $laporanResponse = Http::get('http://127.0.0.1:5000/api/laporan-temuan', [
            'auditing_id' => $id
        ]);

        if (!$laporanResponse->successful()) {
            Log::error('Permintaan API laporan temuan untuk preview gagal: ' . $laporanResponse->status());
            return redirect()->back()->with('error', 'Gagal mengambil data laporan temuan untuk preview.');
        }

        $laporanApiResponse = $laporanResponse->json();
        if (!($laporanApiResponse['status'] ?? false)) {
            Log::error('API laporan temuan mengembalikan status false: ' . ($laporanApiResponse['message'] ?? 'No message'));
            return redirect()->back()->with('error', 'Data laporan temuan tidak valid.');
        }
        $laporanTemuan = $laporanApiResponse['data'];


        // 3. Permintaan API untuk response tilik
        $tilikResponse = Http::get("http://127.0.0.1:5000/api/response-tilik/auditing/{$id}");

        if (!$tilikResponse->successful()) {
            Log::error('Permintaan API response tilik untuk preview gagal: ' . $tilikResponse->status());
            return redirect()->back()->with('error', 'Gagal mengambil data response tilik untuk preview.');
        }

        $tilikApiResponse = $tilikResponse->json();
        // Perhatikan key 'success' sesuai contoh fungsi download
        if (!($tilikApiResponse['success'] ?? false)) {
            Log::error('API response tilik mengembalikan status false: ' . ($tilikApiResponse['message'] ?? 'No message'));
            return redirect()->back()->with('error', 'Data response tilik tidak valid.');
        }
        $responseTilik = $tilikApiResponse['data'];


        // 4. Kirim semua data yang diperlukan ke view PDF
        //    Pastikan view 'download-ptpp' juga diupdate untuk menerima $responseTilik jika diperlukan
        $pdf = Pdf::loadView('auditee.laporan-temuan.download-ptpp', compact('audit', 'laporanTemuan', 'responseTilik'));
        $pdf->setPaper('a4', 'portrait');

        // Set judul dokumen PDF (tidak berubah)
        $dompdf = $pdf->getDomPDF();
        $dompdf->get_canvas()->add_info('Title', $fileName);

        // 5. Tampilkan PDF di browser menggunakan stream()
        return $pdf->stream($fileName);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        \Log::error("Audit tidak ditemukan untuk preview PTPP, ID: {$id}", ['exception' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Data audit tidak ditemukan.');
    } catch (\Illuminate\Http\Client\RequestException $e) {
        \Log::error("Koneksi ke API gagal untuk preview PTPP audit ID {$id}: " . $e->getMessage());
        return redirect()->back()->with('error', 'Gagal terhubung ke layanan data.');
    } catch (\Exception $e) {
        \Log::error("Gagal generate PDF PTPP untuk audit ID {$id}: " . $e->getMessage());
        return redirect()->back()->with('error', 'Gagal menampilkan preview file PTPP.');
    }
}

    public function downloadPTPP($id)
    {
        try {
            // Ambil data audit
            $audit = Auditing::with(['auditor1', 'auditor2', 'auditee1', 'auditee2', 'periode', 'unitKerja'])
                ->findOrFail($id);

            // Ambil data laporan temuan dari API
            $response = Http::get("{$this->baseUrl}/laporan-temuan/{$id}");

            if (!$response->successful()) {
                \Log::error("Gagal mengambil data laporan temuan untuk PDF PTPP audit ID: {$id}");
                return redirect()->back()->with('error', 'Gagal mengambil data laporan temuan.');
            }

            $data = $response->json();
            $laporanTemuan = $data['data'] ?? [];

            // Log untuk debugging
            \Log::info("Data laporan temuan untuk PDF PTPP:", $laporanTemuan);

            if (empty($laporanTemuan)) {
                return redirect()->back()->with('error', 'Tidak ada data laporan temuan untuk dibuat PDF.');
            }

            $fileName = 'Permintaan Tindakan Perbaikan dan Pencegahan-' .
                ($audit->unitKerja->nama_unit_kerja ?? 'unit') . '-' . ($audit->periode->nama_periode) . '.pdf';

            $pdf = Pdf::loadView('auditee.laporan-temuan.download-ptpp', compact('audit', 'laporanTemuan'));

            return $pdf->download($fileName);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error("Audit tidak ditemukan untuk download PTPP, ID: {$id}", ['exception' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Data audit tidak ditemukan.');
        } catch (\Exception $e) {
            \Log::error("Gagal generate PDF PTPP untuk audit ID {$id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengunduh file PTPP.');
        }
    }

      public function downloadPresensi($id)
    {
        try {
            $audit = Auditing::with(['auditor1', 'auditor2', 'auditee1', 'auditee2', 'periode', 'unitKerja'])
                ->findOrFail($id);

            $fileName = 'Presensi Audit-' .
                ($audit->unitKerja->nama_unit_kerja ?? 'unit') . '-' . ($audit->periode->nama_periode) . '.pdf';

            $pdf = Pdf::loadView('auditor.audit.presensi', compact('audit'));

            return $pdf->download($fileName);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error("Audit tidak ditemukan untuk download PTPP, ID: {$id}", ['exception' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Data audit tidak ditemukan.');
        } catch (\Exception $e) {
            \Log::error("Gagal generate PDF PTPP untuk audit ID {$id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengunduh file PTPP.');
        }
    }

    public function tindakLanjutPTPP()
    {
        // $request->validate([
        //     'tindak_lanjut' => 'required|string|max:1000',
        // ]);

        // try {
        //     $audit = Auditing::findOrFail($id);
        //     $audit->tindak_lanjut = $request->tindak_lanjut;
        //     $audit->save();

        //     return redirect()->back()->with('success', 'Tindak lanjut berhasil disimpan.');
        // } catch (\Exception $e) {
        //     \Log::error("Gagal menyimpan tindak lanjut untuk audit ID {$id}: " . $e->getMessage());
        //     return redirect()->back()->with('error', 'Gagal menyimpan tindak lanjut. Silakan coba lagi.');
        // }

        return view ('auditee.laporan-temuan.tindak-lanjut');
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
