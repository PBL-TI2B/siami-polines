<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\LaporanPtpp;
use Illuminate\Http\Request;

class LaporanPtppController extends Controller
{
    private const API_BASE_URL = 'http://127.0.0.1:5000/api/laporan-ptpp';

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
            $response = Http::get(self::API_BASE_URL . '/kategori-temuan');
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
        $query = LaporanPtpp::query();

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
            $apiResponse = Http::post(self::API_BASE_URL, $validated);
            if (!$apiResponse->successful()) {
                Log::warning('Gagal mengirim laporan ke API: ' . $apiResponse->status(), ['response' => $apiResponse->body()]);
            }

            Log::info('Laporan dibuat', ['id' => $report->id, 'user' => auth()->check() ? auth()->user()->id : 'guest']);

            return redirect()->route('auditor.laporan.index')
                            ->with('success', 'Laporan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan laporan: ' . $e->getMessage(), ['request' => $request->all()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan laporan: ' . $e->getMessage());
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
            return redirect()->route('auditor.laporan-ptpp.index')
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
            $apiResponse = Http::put(self::API_BASE_URL . "/{$id}", $validated);
            if (!$apiResponse->successful()) {
                Log::warning('Gagal memperbarui laporan di API: ' . $apiResponse->status(), ['response' => $apiResponse->body()]);
            }

            Log::info('Laporan diperbarui', ['id' => $report->id, 'user' => auth()->check() ? auth()->user()->id : 'guest']);

            return redirect()->route('auditor.laporan-ptpp.index')
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
            $apiResponse = Http::delete(self::API_BASE_URL . "/{$id}");
            if (!$apiResponse->successful()) {
                Log::warning('Gagal menghapus laporan di API: ' . $apiResponse->status(), ['response' => $apiResponse->body()]);
            }

            Log::info('Laporan dihapus', ['id' => $id, 'user' => auth()->check() ? auth()->user()->id : 'guest']);

            return redirect()->route('auditor.laporan-ptpp.index')
                            ->with('success', 'Laporan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus laporan: ' . $e->getMessage());
            return redirect()->route('auditor.laporan-ptpp.index')
                           ->with('error', 'Terjadi kesalahan saat menghapus laporan.');
        }
    }
}
