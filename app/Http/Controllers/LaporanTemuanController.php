<?php

namespace App\Http\Controllers;

use App\Models\LaporanTemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LaporanTemuanController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        // Ambil ID pengguna yang terautentikasi
        $userId = auth()->id();

        // Ambil audit dari API
        try {
            $response = Http::get("http://127.0.0.1:5000/api/auditings/userID={$userId}");
            $audits = $response->successful() ? ($response->json('data') ?? $response->json() ?? []) : [];
            if (!$response->successful()) {
                \Log::error('Gagal mengambil audit dari API', ['status' => $response->status(), 'body' => $response->body()]);
            }
        } catch (\Exception $e) {
            $audits = [];
            \Log::error('Kesalahan saat mengambil audit dari API', ['error' => $e->getMessage()]);
        }

        // Ambil kriteria dari API
        try {
            $response = Http::get("http://127.0.0.1:5000/api/kriteria");
            $kriterias = $response->successful() ? ($response->json('data') ?? $response->json() ?? []) : [];
            if (!$response->successful()) {
                \Log::error('Gagal mengambil kriteria dari API', ['status' => $response->status(), 'body' => $response->body()]);
            }
        } catch (\Exception $e) {
            $kriterias = [];
            \Log::error('Kesalahan saat mengambil kriteria dari API', ['error' => $e->getMessage()]);
        }

        $kategori_temuan = ['NC', 'AOC', 'OFI'];

        return view('auditor.laporan.index', compact('audits', 'kriterias', 'kategori_temuan'));
    }

    public function store(Request $request)
    {
        // Ambil ID kriteria yang valid untuk validasi
        try {
            $kriteriaIds = collect(Http::get("http://127.0.0.1:5000/api/kriteria")->json('data') ?? Http::get("http://127.0.0.1:5000/api/kriteria")->json() ?? [])->pluck('kriteria_id')->toArray();
        } catch (\Exception $e) {
            $kriteriaIds = [];
            \Log::error('Kesalahan saat mengambil kriteria untuk validasi', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error-messages', 'Gagal memvalidasi kriteria: ' . $e->getMessage())->withInput();
        }

        // Validasi permintaan
        $validated = $request->validate([
            'auditing_id' => 'required|integer',
            'standar' => 'required|array|min:1',
            'standar.*' => ['required', 'integer', 'in:' . implode(',', $kriteriaIds)],
            'uraian_temuan' => 'required|string|max:1000',
            'kategori_temuan' => 'required|in:NC,AOC,OFI',
            'saran_perbaikan' => 'nullable|string|max:1000',
        ], [
            'auditing_id.required' => 'Audit wajib dipilih.',
            'standar.required' => 'Standar wajib dipilih.',
            'standar.*.in' => 'Standar yang dipilih tidak valid.',
            'uraian_temuan.required' => 'Uraian temuan wajib diisi.',
            'kategori_temuan.required' => 'Kategori temuan wajib dipilih.',
        ]);

        try {
            DB::beginTransaction();

            // Simpan LaporanTemuan secara lokal
            $laporan = LaporanTemuan::create([
                'auditing_id' => $validated['auditing_id'],
                'standar' => $validated['standar'], // Simpan array ke kolom JSON
                'uraian_temuan' => $validated['uraian_temuan'],
                'kategori_temuan' => $validated['kategori_temuan'],
                'saran_perbaikan' => $validated['saran_perbaikan'] ?? null,
            ]);

            // Kirim ke API
            $payload = [
                'auditing_id' => $validated['auditing_id'],
                'standar' => $validated['standar'], // Kirim sebagai array
                'uraian_temuan' => $validated['uraian_temuan'],
                'kategori_temuan' => $validated['kategori_temuan'],
                'saran_perbaikan' => $validated['saran_perbaikan'] ?? null,
            ];

            $response = Http::post('http://127.0.0.1:5000/api/laporan-temuan', $payload);

            if (!$response->successful() || ($response->json('status') !== 'success')) {
                throw new \Exception($response->json('message') ?? 'Permintaan API gagal: ' . $response->status());
            }

            DB::commit();

            return redirect()->route('auditor.audit.index')->with('success', 'Laporan temuan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Kesalahan saat menyimpan laporan temuan', ['error' => $e->getMessage(), 'payload' => $payload ?? []]);
            return redirect()->back()->with('error-messages', 'Gagal menyimpan laporan temuan: ' . $e->getMessage())->withInput();
        }
    }
}
