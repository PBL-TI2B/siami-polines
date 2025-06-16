<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PeriodeAuditController extends Controller
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = 'http://localhost:5000/api';
    }

    /**
     * Menampilkan daftar periode audit
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 5);
            $search = $request->query('search');

            $response = Http::withToken(session('token'))
                ->timeout(5)
                ->get("{$this->apiBaseUrl}/periode-audits", [
                    'per_page' => $perPage,
                    'search' => $search,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    // Urutkan data: periode aktif (Sedang Berjalan) di atas
                    $periodeAuditsData = collect($data['data']['data'])->sortByDesc(function ($periode) {
                        return $periode['status'] === 'Sedang Berjalan' ? 1 : 0;
                    })->values()->all();

                    // Buat paginator
                    $periodeAudits = new \Illuminate\Pagination\LengthAwarePaginator(
                        $periodeAuditsData,
                        $data['data']['total'],
                        $data['data']['per_page'],
                        $data['data']['current_page'],
                        ['path' => $request->url(), 'query' => $request->query()]
                    );

                    return view('admin.periode-audit.index', compact('periodeAudits'));
                } else {
                    Log::warning('API periode-audits mengembalikan status gagal', [
                        'message' => $data['message'] ?? 'Unknown error',
                    ]);
                    return view('admin.periode-audit.index', [
                        'periodeAudits' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage),
                        'error' => $data['message'] ?? 'Gagal mengambil daftar periode audit.',
                    ]);
                }
            } else {
                Log::error('Gagal mengambil daftar periode audit dari API', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return view('admin.periode-audit.index', [
                    'periodeAudits' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage),
                    'error' => 'Gagal mengambil daftar periode audit dari server.',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Kesalahan saat mengambil daftar periode audit', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return view('admin.periode-audit.index', [
                'periodeAudits' => new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage),
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Membuka periode audit baru
     */
    public function open(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        try {
            // Ambil semua periode audit untuk cek status "Sedang Berjalan"
            $checkResponse = Http::withToken(session('token'))
                ->timeout(5)
                ->get("{$this->apiBaseUrl}/periode-audits", [
                    'per_page' => 1000, // ambil semua
                ]);

            if ($checkResponse->successful()) {
                $checkData = $checkResponse->json();
                if (
                    isset($checkData['data']['data']) &&
                    collect($checkData['data']['data'])->contains('status', 'Sedang Berjalan')
                ) {
                    return redirect()->back()
                        ->withErrors(['error' => 'Masih ada periode audit yang sedang berjalan. Tutup periode tersebut sebelum membuka yang baru.'])
                        ->withInput();
                }
            } else {
                Log::error('Gagal memeriksa periode audit berjalan', [
                    'status' => $checkResponse->status(),
                    'body' => $checkResponse->body(),
                ]);
                return redirect()->back()
                    ->withErrors(['error' => 'Gagal memeriksa periode audit berjalan.'])
                    ->withInput();
            }

            $response = Http::withToken(session('token'))
                ->timeout(5)
                ->post("{$this->apiBaseUrl}/periode-audits/open", $request->all());

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    return redirect()->route('admin.periode-audit.index')
                        ->with('success', $data['message']);
                } else {
                    return redirect()->back()
                        ->withErrors(['error' => $data['message'] ?? 'Gagal membuka periode audit baru.'])
                        ->withInput();
                }
            } else {
                Log::error('Gagal membuka periode audit baru', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return redirect()->back()
                    ->withErrors(['error' => 'Gagal membuka periode audit baru di server.'])
                    ->withInput();
            }
        } catch (\Exception $e) {
            Log::error('Kesalahan saat membuka periode audit baru', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Menyimpan periode audit baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date_format:d-m-Y',
            'tanggal_berakhir' => 'required|date_format:d-m-Y|after_or_equal:tanggal_mulai',
        ]);

        try {
            // Konversi format tanggal ke Y-m-d untuk API
            $data = [
                'nama_periode' => $request->nama_periode,
                'tanggal_mulai' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_mulai)->format('Y-m-d'),
                'tanggal_berakhir' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_berakhir)->format('Y-m-d'),
                'status' => 'Sedang Berjalan',
            ];

            $response = Http::withToken(session('token'))
                ->timeout(5)
                ->post("{$this->apiBaseUrl}/periode-audits", $data);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    return redirect()->route('admin.periode-audit.index')
                        ->with('success', 'Periode audit berhasil ditambahkan.');
                } else {
                    return redirect()->back()
                        ->withErrors(['error' => $data['message'] ?? 'Gagal menambahkan periode audit.'])
                        ->withInput();
                }
            } else {
                Log::error('Gagal menambahkan periode audit', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return redirect()->back()
                    ->withErrors(['error' => 'Gagal menambahkan periode audit ke server.'])
                    ->withInput();
            }
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menambahkan periode audit', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Menampilkan form untuk mengedit periode audit
     */
    public function edit($id)
    {
        try {
            $response = Http::withToken(session('token'))
                ->timeout(5)
                ->get("{$this->apiBaseUrl}/periode-audits/{$id}");

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    // Konversi tanggal ke format d-m-Y untuk form
                    $periodeAudit = $data['data'];
                    $periodeAudit['tanggal_mulai'] = \Carbon\Carbon::parse($periodeAudit['tanggal_mulai'])->format('d-m-Y');
                    $periodeAudit['tanggal_berakhir'] = \Carbon\Carbon::parse($periodeAudit['tanggal_berakhir'])->format('d-m-Y');
                    return view('admin.periode-audit.edit', compact('periodeAudit'));
                } else {
                    Log::warning('API periode-audits show mengembalikan status gagal', [
                        'id' => $id,
                        'message' => $data['message'] ?? 'Unknown error',
                    ]);
                    return redirect()->route('admin.periode-audit.index')
                        ->withErrors(['error' => 'Periode audit tidak ditemukan.']);
                }
            } else {
                Log::error('Gagal mengambil detail periode audit', [
                    'id' => $id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return redirect()->route('admin.periode-audit.index')
                    ->withErrors(['error' => 'Gagal mengambil detail periode audit dari server.']);
            }
        } catch (\Exception $e) {
            Log::error('Kesalahan saat mengambil detail periode audit', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('admin.periode-audit.index')
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Memperbarui periode audit
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date_format:d-m-Y',
            'tanggal_berakhir' => 'required|date_format:d-m-Y|after_or_equal:tanggal_mulai',
        ]);

        try {
            // Konversi format tanggal ke Y-m-d untuk API
            $data = [
                'nama_periode' => $request->nama_periode,
                'tanggal_mulai' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_mulai)->format('Y-m-d'),
                'tanggal_berakhir' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_berakhir)->format('Y-m-d'),
                'status' => $request->status ?? 'Sedang Berjalan',
            ];

            $response = Http::withToken(session('token'))
                ->timeout(5)
                ->put("{$this->apiBaseUrl}/periode-audits/{$id}", $data);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    return redirect()->route('admin.periode-audit.index')
                        ->with('success', 'Periode audit berhasil diperbarui.');
                } else {
                    return redirect()->back()
                        ->withErrors(['error' => $data['message'] ?? 'Gagal memperbarui periode audit.'])
                        ->withInput();
                }
            } else {
                Log::error('Gagal memperbarui periode audit', [
                    'id' => $id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return redirect()->back()
                    ->withErrors(['error' => 'Gagal memperbarui periode audit di server.'])
                    ->withInput();
            }
        } catch (\Exception $e) {
            Log::error('Kesalahan saat memperbarui periode audit', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Menghapus periode audit
     */
    public function destroy($id)
    {
        try {
            $response = Http::withToken(session('token'))
                ->timeout(5)
                ->delete("{$this->apiBaseUrl}/periode-audits/{$id}");

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    return redirect()->route('admin.periode-audit.index')
                        ->with('success', 'Periode audit berhasil dihapus.');
                } else {
                    return redirect()->route('admin.periode-audit.index')
                        ->withErrors(['error' => $data['message'] ?? 'Gagal menghapus periode audit.']);
                }
            } else {
                Log::error('Gagal menghapus periode audit', [
                    'id' => $id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return redirect()->route('admin.periode-audit.index')
                    ->withErrors(['error' => 'Gagal menghapus periode audit dari server.']);
            }
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menghapus periode audit', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('admin.periode-audit.index')
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Menutup periode audit
     */
    public function close(Request $request, $id)
    {
        try {
            $response = Http::withToken(session('token'))
                ->timeout(5)
                ->put("{$this->apiBaseUrl}/periode-audits/{$id}/close");

            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    return redirect()->route('admin.periode-audit.index')
                        ->with('success', 'Periode audit berhasil ditutup.');
                } else {
                    return redirect()->route('admin.periode-audit.index')
                        ->withErrors(['error' => $data['message'] ?? 'Gagal menutup periode audit.']);
                }
            } else {
                Log::error('Gagal menutup periode audit', [
                    'id' => $id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return redirect()->route('admin.periode-audit.index')
                    ->withErrors(['error' => 'Gagal menutup periode audit di server.']);
            }
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menutup periode audit', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('admin.periode-audit.index')
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
