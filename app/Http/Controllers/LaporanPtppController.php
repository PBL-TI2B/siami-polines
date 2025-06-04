<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\LaporanPtpp;
use App\Models\Auditing;
use Illuminate\Http\Request;

class LaporanPtppController extends Controller
{
    private const API_BASE_URL = 'http://127.0.0.1:5000/api/laporan-ptpp';
    private const AUDITING_API_URL = 'http://127.0.0.1:5000/api/auditings';

    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Mengambil daftar kategori temuan dari API.
     */
    public function getKategoriTemuanFromApi()
    {
        try {
            $response = Http::timeout(10)->get(self::API_BASE_URL . '/kategori-temuan');
            if ($response->successful()) {
                return $response->json()['data'] ?? ['NC', 'AOC', 'OFI'];
            } else {
                Log::error('Gagal mengambil kategori temuan dari API: ' . $response->status());
                return ['NC', 'AOC', 'OFI'];
            }
        } catch (\Exception $e) {
            Log::error('Error saat mengambil kategori temuan dari API: ' . $e->getMessage());
            return ['NC', 'AOC', 'OFI'];
        }
    }

    /**
     * Mengambil status auditing dari API.
     */
    private function getAuditingStatusFromApi($auditingId)
    {
        try {
            $response = Http::timeout(30)->get(self::AUDITING_API_URL . "/{$auditingId}");
            Log::info('API Response for auditing status:', ['response' => $response->json(), 'status' => $response->status()]);
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'status' => $data['data']['status'] ?? null,
                    'name' => $data['data']['name'] ?? 'Belum Ditetapkan',
                    'color' => $data['data']['color'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
                ];
            } else {
                Log::error('Gagal mengambil status auditing dari API: ' . $response->status());
                return null;
            }
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
        if (!$auditingId) {
            Log::warning('Auditing ID tidak tersedia di session', ['user' => auth()->user()->id]);
            return redirect()->route('auditor.dashboard.index')->with('error', 'Pilih audit terlebih dahulu.');
        }
        $query = LaporanPtpp::select('id', 'standar', 'uraian_temuan', 'kategori_temuan', 'saran_perbaikan');
        if ($search = $request->input('search')) {
            $query->where('standar', 'like', "%{$search}%")
                ->orWhere('uraian_temuan', 'like', "%{$search}%");
        }
        $reports = $query->paginate($request->input('entries', 10));
        return view('auditor.laporan.index', compact('reports'));
    }

    /**
     * Menampilkan form untuk membuat laporan baru.
     */
    public function create()
    {
        $kategori_temuan = $this->getKategoriTemuanFromApi();
        return view('auditor.laporan.tambah', compact('kategori_temuan'));
    }

    /**
     * Menyimpan laporan baru ke database dan API.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'standar' => 'required|string|max:255',
                'uraian_temuan' => 'required|string',
                'kategori_temuan' => 'required|in:NC,AOC,OFI',
                'saran_perbaikan' => 'nullable|string',
            ], [
                'standar.required' => 'Kolom standar wajib diisi.',
                'uraian_temuan.required' => 'Kolom uraian temuan wajib diisi.',
                'kategori_temuan.required' => 'Kolom kategori temuan wajib diisi.',
                'kategori_temuan.in' => 'Kategori temuan harus NC, AOC, atau OFI.',
            ]);

            // Simpan ke database lokal
            $report = LaporanPtpp::create($validated);

            // Kirim ke API
            $apiResponse = Http::timeout(10)->post(self::API_BASE_URL, array_merge($validated, ['id' => $report->id]));
            if (!$apiResponse->successful()) {
                $report->delete();
                Log::error('Gagal mengirim laporan ke API: ' . $apiResponse->status(), ['response' => $apiResponse->body()]);
                return redirect()->back()->with('error', 'Gagal menyimpan laporan ke sistem eksternal.');
            }

            Log::info('Laporan dibuat', [
                'id' => $report->id,
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
            $report = LaporanPtpp::findOrFail($id);
            $kategori_temuan = $this->getKategoriTemuanFromApi();
            return view('auditor.laporan.edit', compact('report', 'kategori_temuan'));
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
                'standar' => 'required|string|max:255',
                'uraian_temuan' => 'required|string',
                'kategori_temuan' => 'required|in:NC,AOC,OFI',
                'saran_perbaikan' => 'nullable|string',
            ], [
                'standar.required' => 'Kolom standar wajib diisi.',
                'uraian_temuan.required' => 'Kolom uraian temuan wajib diisi.',
                'kategori_temuan.required' => 'Kolom kategori temuan wajib diisi.',
                'kategori_temuan.in' => 'Kategori temuan harus NC, AOC, atau OFI.',
            ]);

            $report = LaporanPtpp::findOrFail($id);
            $report->update($validated);

            // Kirim update ke API
            $apiResponse = Http::timeout(10)->put(self::API_BASE_URL . "/{$id}", $validated);
            if (!$apiResponse->successful()) {
                Log::warning('Gagal memperbarui laporan di API: ' . $apiResponse->status(), ['response' => $apiResponse->body()]);
                return redirect()->route('auditor.laporan.index')
                               ->with('error', 'Laporan diperbarui di lokal, tetapi gagal disinkronkan ke sistem eksternal.');
            }

            Log::info('Laporan diperbarui', [
                'id' => $report->id,
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
    public function destroy($id)
    {
        try {
            $report = LaporanPtpp::findOrFail($id);
            $report->delete();

            // Kirim permintaan hapus ke API
            $apiResponse = Http::timeout(10)->delete(self::API_BASE_URL . "/{$id}");
            if (!$apiResponse->successful()) {
                Log::warning('Gagal menghapus laporan di API: ' . $apiResponse->status(), ['response' => $apiResponse->body()]);
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
            if (!$auditingId) {
                Log::warning('Auditing ID tidak tersedia di session', ['user' => auth()->user()->id]);
                return back()->with('error', 'ID auditing tidak tersedia.');
            }

            // Validasi status dari API
            $apiStatus = $this->getAuditingStatusFromApi($auditingId);
            if ($apiStatus !== 6) {
                Log::warning('Submit tidak diizinkan untuk status saat ini', ['auditing_id' => $auditingId, 'status' => $apiStatus]);
                return back()->with('error', 'Submit tidak diizinkan untuk status saat ini.');
            }

            // Validasi status dari database lokal sebagai fallback
            $auditing = Auditing::findOrFail($auditingId);
            if ($auditing->status != 6) {
                Log::warning('Status database tidak sesuai dengan API', ['auditing_id' => $auditingId, 'db_status' => $auditing->status, 'api_status' => $apiStatus]);
                return back()->with('error', 'Status auditing tidak valid.');
            }

            // Update status di database lokal
            $auditing->update(['status' => 7]);

            // Update status di API
            $apiResponse = Http::timeout(10)->put(self::AUDITING_API_URL . "/{$auditingId}", ['status' => 7]);
            if (!$apiResponse->successful()) {
                Log::error('Gagal memperbarui status auditing di API: ' . $apiResponse->status(), ['response' => $apiResponse->body()]);
                return back()->with('error', 'Laporan disubmit di lokal, tetapi gagal disinkronkan ke sistem eksternal.');
            }

            Log::info('Laporan PTPP disubmit', [
                'auditing_id' => $auditingId,
                'user' => auth()->user()->id,
                'ip' => $request->ip(),
                'timestamp' => now()->toDateTimeString(),
            ]);

            return redirect()->route('auditor.laporan.index')->with('success', 'Laporan berhasil disubmit dan dikunci.');
        } catch (\Exception $e) {
            Log::error('Gagal submit laporan PTPP: ' . $e->getMessage(), ['auditing_id' => $auditingId ?? null]);
            return back()->with('error', 'Terjadi kesalahan saat submit laporan.');
        }
    }
}
