<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\LaporanTemuan;
use App\Models\Auditing;
use Illuminate\Http\Request;

class LaporanTemuanController extends Controller
{
    private const API_BASE_URL = 'http://127.0.0.1:5000/api/laporan-temuan';
    private const AUDITING_API_URL = 'http://127.0.0.1:5000/api/auditings';
    private const KRITERIA_API_URL = 'http://127.0.0.1:5000/api/kriteria';

    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware(function ($request, $next) {
        //     if (!$request->session()->has('auditing_id')) {
        //         return redirect()->route('auditor.dashboard.index')->with('error', 'Pilih audit terlebih dahulu.');
        //     }
        //     return $next($request);
        // })->only(['index', 'create', 'store', 'submit']);
    }

    /**
     * Mengambil daftar kategori temuan dari API.
     */
    private function getKategoriTemuanFromApi()
    {
        try {
            $response = Http::timeout(10)->retry(3, 1000)->get(self::API_BASE_URL . '/kategori-temuan');
            if ($response->successful()) {
                return $response->json()['data'] ?? ['NC', 'AOC', 'OFI'];
            }
            Log::error('Gagal mengambil kategori temuan dari API', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return ['NC', 'AOC', 'OFI'];
        } catch (\Exception $e) {
            Log::error('Error saat mengambil kategori temuan dari API: ' . $e->getMessage());
            return ['NC', 'AOC', 'OFI'];
        }
    }

    /**
     * Mengambil daftar kriteria dari API.
     */
    private function getKriteriaFromApi()
    {
        try {
            $response = Http::timeout(10)->retry(3, 1000)->get(self::KRITERIA_API_URL);
            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }
            Log::error('Gagal mengambil kriteria dari API', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return [];
        } catch (\Exception $e) {
            Log::error('Error saat mengambil kriteria dari API: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mengambil status auditing dari API.
     */
    private function getAuditingStatusFromApi($auditingId)
    {
        try {
            $response = Http::timeout(10)->retry(3, 1000)->get(self::AUDITING_API_URL . "/{$auditingId}");
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'status' => $data['data']['status'] ?? null,
                    'name' => $data['data']['name'] ?? 'Belum Ditetapkan',
                    'color' => $data['data']['color'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
                ];
            }
            Log::error('Gagal mengambil status auditing dari API', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Error saat mengambil status auditing dari API: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Menampilkan dashboard auditor.
     */
    public function dashboard()
    {
        return view('auditor.dashboard.index');
    }

    /**
     * Menampilkan daftar laporan dengan paginasi dan pencarian.
     */
    public function index(Request $request)
    {
        $auditingId = $request->session()->get('auditing_id');
        $kriterias = $this->getKriteriaFromApi();
        $kategori_temuan = $this->getKategoriTemuanFromApi();
        $audits = Auditing::all();
        $query = LaporanTemuan::where('auditing_id', $auditingId)
                            ->select('laporan_temuan_id', 'auditing_id', 'standar', 'uraian_temuan', 'kategori_temuan', 'saran_perbaikan');
        if ($search = $request->input('search')) {
            $query->where('standar', 'like', "%{$search}%")
                  ->orWhere('uraian_temuan', 'like', "%{$search}%");
        }
        $reports = $query->paginate($request->input('entries', 10));
        return view('auditor.laporan.index', compact('reports', 'auditingId', 'audits', 'kriterias', 'kategori_temuan'));
    }

    /**
     * Menampilkan form untuk membuat laporan baru.
     */
    public function create(Request $request)
    {
        $auditingId = $request->session()->get('auditing_id');
        $kategori_temuan = $this->getKategoriTemuanFromApi();
        $kriterias = $this->getKriteriaFromApi();
        $audits = Auditing::all();
        return view('auditor.laporan.tambah', compact('kategori_temuan', 'kriterias', 'audits', 'auditingId'));
    }

    /**
     * Menyimpan laporan baru ke database dan API.
     */
    public function store(Request $request)
    {
        try {
            $auditingId = $request->session()->get('auditing_id');
            $validated = $request->validate([
                'auditing_id' => 'required|exists:auditings,auditing_id',
                'standar' => 'required|integer|exists:kriterias,kriteria_id',
                'uraian_temuan' => 'required|string',
                'kategori_temuan' => 'required|in:NC,AOC,OFI',
                'saran_perbaikan' => 'nullable|string',
            ], [
                'auditing_id.required' => 'Kolom audit wajib diisi.',
                'standar.required' => 'Kolom standar wajib diisi.',
                'standar.integer' => 'Standar harus berupa ID numerik.',
                'standar.exists' => 'Standar tidak ditemukan.',
                'uraian_temuan.required' => 'Kolom uraian temuan wajib diisi.',
                'kategori_temuan.required' => 'Kolom kategori temuan wajib diisi.',
                'kategori_temuan.in' => 'Kategori temuan harus NC, AOC, atau OFI.',
            ]);

            $report = LaporanTemuan::create($validated);
            // Pastikan laporan_temuan_id dikirim ke API
            $apiPayload = array_merge($validated, ['laporan_temuan_id' => $report->laporan_temuan_id]);
            $apiResponse = Http::timeout(10)->retry(3, 1000)->post(self::API_BASE_URL, $apiPayload);
            if (!$apiResponse->successful()) {
                $report->delete();
                Log::error('Gagal mengirim laporan ke API', [
                    'status' => $apiResponse->status(),
                    'response' => $apiResponse->body()
                ]);
                return redirect()->back()->with('error', 'Gagal menyimpan laporan ke sistem eksternal.');
            }

            Log::info('Laporan dibuat', [
                'id' => $report->laporan_temuan_id,
                'user' => auth()->user()->id,
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            return redirect()->route('auditor.laporan.index')
                            ->with('success', 'Laporan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan laporan: ' . $e->getMessage(), ['request' => $request->all()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan laporan.');
        }
    }

    /**
     * Menampilkan form untuk mengedit laporan.
     */
    public function edit($id)
    {
        try {
            $report = LaporanTemuan::findOrFail($id);
            $audits = Auditing::all();
            $kriterias = $this->getKriteriaFromApi();
            $kategori_temuan = $this->getKategoriTemuanFromApi();
            return view('auditor.laporan.edit', compact('report', 'audits', 'kriterias', 'kategori_temuan'));
        } catch (\Exception $e) {
            Log::error('Gagal mengambil laporan: ' . $e->getMessage());
            return redirect()->route('auditor.laporan.index')
                           ->with('error', 'Laporan tidak ditemukan.');
        }
    }

    /**
     * Memperbarui laporan di database dan API.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'auditing_id' => 'required|exists:auditings,auditing_id',
                'standar' => 'required|integer|exists:kriterias,kriteria_id',
                'uraian_temuan' => 'required|string',
                'kategori_temuan' => 'required|in:NC,AOC,OFI',
                'saran_perbaikan' => 'nullable|string',
            ], [
                'auditing_id.required' => 'Kolom audit wajib diisi.',
                'standar.required' => 'Kolom standar wajib diisi.',
                'standar.integer' => 'Standar harus berupa ID numerik.',
                'standar.exists' => 'Standar tidak ditemukan.',
                'uraian_temuan.required' => 'Kolom uraian temuan wajib diisi.',
                'kategori_temuan.required' => 'Kolom kategori temuan wajib diisi.',
                'kategori_temuan.in' => 'Kategori temuan harus NC, AOC, atau OFI.',
            ]);

            $report = LaporanTemuan::findOrFail($id);
            $report->update($validated);

            $apiPayload = array_merge($validated, ['laporan_temuan_id' => $report->laporan_temuan_id]);
            $apiResponse = Http::timeout(10)->retry(3, 1000)->put(self::API_BASE_URL . "/{$id}", $apiPayload);
            if (!$apiResponse->successful()) {
                Log::warning('Gagal memperbarui laporan di API', [
                    'status' => $apiResponse->status(),
                    'response' => $apiResponse->body()
                ]);
                return redirect()->route('auditor.laporan.index')
                               ->with('error', 'Laporan diperbarui di lokal, tetapi gagal disinkronkan ke sistem eksternal.');
            }

            Log::info('Laporan diperbarui', [
                'id' => $report->laporan_temuan_id,
                'user' => auth()->user()->id,
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            return redirect()->route('auditor.laporan.index')
                            ->with('success', 'Laporan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui laporan: ' . $e->getMessage(), ['request' => $request->all()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui laporan.');
        }
    }

    /**
     * Menghapus laporan dari database dan API.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $report = LaporanTemuan::findOrFail($id);
            $report->delete();

            $apiResponse = Http::timeout(10)->retry(3, 1000)->delete(self::API_BASE_URL . "/{$id}");
            if (!$apiResponse->successful()) {
                Log::warning('Gagal menghapus laporan di API', [
                    'status' => $apiResponse->status(),
                    'response' => $apiResponse->body()
                ]);
                return redirect()->route('auditor.laporan.index')
                               ->with('error', 'Laporan dihapus di lokal, tetapi gagal disinkronkan ke sistem eksternal.');
            }

            Log::info('Laporan dihapus', [
                'id' => $id,
                'user' => auth()->user()->id,
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            return redirect()->route('auditor.laporan.index')
                            ->with('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus laporan: ' . $e->getMessage());
            return redirect()->route('auditor.laporan.index')
                           ->with('error', 'Terjadi kesalahan saat menghapus laporan.');
        }
    }

    /**
     * Mengsubmit dan mengunci laporan.
     */
    public function submit(Request $request)
    {
        try {
            $auditingId = $request->session()->get('auditing_id');
            $apiStatus = $this->getAuditingStatusFromApi($auditingId);
            $auditing = Auditing::findOrFail($auditingId);

            // Sinkronkan status jika tidak sesuai
            if ($apiStatus['status'] !== $auditing->status) {
                Log::warning('Status tidak sinkron antara API dan database', [
                    'auditing_id' => $auditingId,
                    'api_status' => $apiStatus['status'],
                    'db_status' => $auditing->status
                ]);
                $auditing->update(['status' => $apiStatus['status']]);
            }

            if ($auditing->status != 6) {
                Log::warning('Submit tidak diizinkan untuk status saat ini', [
                    'auditing_id' => $auditingId,
                    'status' => $auditing->status
                ]);
                return back()->with('error', 'Status auditing tidak valid.');
            }

            $auditing->update(['status' => 7]);
            $apiResponse = Http::timeout(10)->retry(3, 1000)->put(self::AUDITING_API_URL . "/{$auditingId}", ['status' => 7]);
            if (!$apiResponse->successful()) {
                Log::error('Gagal memperbarui status auditing di API', [
                    'status' => $apiResponse->status(),
                    'response' => $apiResponse->body()
                ]);
                return back()->with('error', 'Laporan disubmit di lokal, tetapi gagal disinkronkan ke sistem eksternal.');
            }

            return redirect()->route('auditor.laporan.index')->with('success', 'Laporan berhasil disubmit dan dikunci.');
        } catch (\Exception $e) {
            Log::error('Gagal submit laporan: ' . $e->getMessage(), ['auditing_id' => $auditingId ?? null]);
            return back()->with('error', 'Terjadi kesalahan saat submit laporan.');
        }
    }
}
