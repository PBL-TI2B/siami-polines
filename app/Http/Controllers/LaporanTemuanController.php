<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator; // Penting: tambahkan ini

class LaporanTemuanController extends Controller
{
    protected $apiBaseUrl = 'http://127.0.0.1:5000/api'; // Pastikan URL ini sesuai dengan API eksternal

    /**
     * Display a listing of the laporan temuan.
     */
    public function index(Request $request, $auditingId)
    {
        try {
            // 1. Fetch all relevant laporan temuan from the API for the given auditingId
            $response = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/laporan-temuan", [
                'auditing_id' => $auditingId,
            ]);

            if (!$response->successful()) {
                Log::error('API laporan-temuan failed: Status ' . $response->status() . ', Body: ' . $response->body());
                return redirect()->route('auditor.dashboard.index')
                    ->with('error', 'Gagal mengambil data laporan temuan dari API.');
            }

            $apiResponse = $response->json();

            if (!isset($apiResponse['status']) || !is_array($apiResponse['data'])) {
                Log::error('Invalid API response structure (index): ' . json_encode($apiResponse));
                return redirect()->route('auditor.dashboard.index')
                    ->with('error', 'Format respons API tidak valid.');
            }

            if (!$apiResponse['status']) {
                Log::error('API returned failure (index): ' . ($apiResponse['message'] ?? 'No message'));
                return redirect()->route('auditor.dashboard.index')
                    ->with('error', $apiResponse['message'] ?? 'Gagal mengambil data laporan temuan.');
            }

            $laporanTemuansData = collect($apiResponse['data']);

            // 2. Group the data by kriteria_id for display with rowspan
            $groupedLaporanTemuans = $laporanTemuansData->groupBy('kriteria_id');

            // 3. Transform grouped data for easier rendering and consistent structure
            $processedGroupedData = $groupedLaporanTemuans->map(function ($itemsInGroup, $kriteriaId) {
                $firstItem = $itemsInGroup->first();
                return [
                    'kriteria_id' => $kriteriaId,
                    'nama_kriteria' => $firstItem['nama_kriteria'] ?? 'Tidak ada kriteria',
                    'findings' => $itemsInGroup->map(function ($finding) {
                        return [
                            'laporan_temuan_id' => $finding['laporan_temuan_id'],
                            'uraian_temuan' => $finding['uraian_temuan'],
                            'kategori_temuan' => $finding['kategori_temuan'],
                            'saran_perbaikan' => $finding['saran_perbaikan'],
                            'auditing_id' => $finding['auditing_id'],
                        ];
                    })->values()->all(),
                ];
            })->values()->all();

            // 4. Manual Pagination for the grouped items (each "item" in paginator is a kriteria group)
            $page = $request->query('page', 1);
            $perPage = $request->query('per_page', 10); // Default perPage for groups
            $totalGroupedItems = count($processedGroupedData);

            $paginatedCollection = Collection::make($processedGroupedData);
            $itemsForCurrentPage = $paginatedCollection->slice(($page - 1) * $perPage, $perPage)->values();

            $laporanTemuansPaginated = new LengthAwarePaginator(
                $itemsForCurrentPage,
                $totalGroupedItems,
                $perPage,
                $page,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );

            return view('auditor.laporan.index', compact('laporanTemuansPaginated', 'auditingId'));

        } catch (\Exception $e) {
            Log::error('Unexpected error in index: ' . $e->getMessage());
            return redirect()->route('auditor.dashboard.index')
                ->with('error', 'Terjadi kesalahan saat memuat data laporan temuan.');
        }
    }

    /**
     * Show the form for creating a new laporan temuan.
     */
    public function create($auditingId)
    {
        try {
            $response = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/kriteria");
            $kriterias = [];

            if ($response->successful()) {
                $kriteriaData = $response->json();
                $kriterias = array_map(function ($item) {
                    return [
                        'kriteria_id' => $item['kriteria_id'] ?? null,
                        'nama_kriteria' => $item['nama_kriteria'] ?? 'Standar ' . ($item['kriteria_id'] ?? 'Unknown'),
                    ];
                }, $kriteriaData);
            } else {
                Log::error('Failed to fetch kriteria for create: Status ' . $response->status() . ', Body: ' . $response->body());
            }

            $kategori_temuan = ['NC', 'AOC', 'OFI'];

            if (empty($kriterias)) {
                Log::warning('No kriteria data available for create view.');
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal memuat data kriteria dari API.');
            }

            return view('auditor.laporan.create', compact('auditingId', 'kriterias', 'kategori_temuan'));
        } catch (\Exception $e) {
            Log::error('Unexpected error in create: ' . $e->getMessage());
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('error', 'Terjadi kesalahan saat memuat formulir.');
        }
    }

    /**
     * Store a newly created laporan temuan via API.
     */
    public function store(Request $request)
    {
        try {
            // Menggunakan Validator Facade
            $validator = Validator::make($request->all(), [
                'auditing_id' => 'required|numeric',
                'findings' => 'required|array|min:1',
                'findings.*.kriteria_id' => 'required|numeric',
                'findings.*.uraian_temuan' => 'required|string|max:1000',
                'findings.*.kategori_temuan' => 'required|in:NC,AOC,OFI',
                'findings.*.saran_perbaikan' => 'nullable|string|max:1000',
            ], [
                'auditing_id.required' => 'ID audit wajib diisi.',
                'findings.required' => 'Setidaknya satu temuan harus ditambahkan.',
                'findings.min' => 'Setidaknya satu temuan harus ditambahkan.',
                'findings.*.kriteria_id.required' => 'Standar wajib dipilih untuk setiap temuan.',
                'findings.*.uraian_temuan.required' => 'Uraian temuan wajib diisi.',
                'findings.*.kategori_temuan.required' => 'Kategori temuan wajib dipilih.',
                'findings.*.kategori_temuan.in' => 'Kategori temuan harus NC, AOC, atau OFI.',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed in store: ', $validator->errors()->toArray());
                // Menggunakan redirect back dengan errors untuk formulir HTML standar
                return back()->withInput()->withErrors($validator);
            }

            $payload = [
                'auditing_id' => (int)$request->auditing_id,
                'findings' => array_map(function ($finding) {
                    return [
                        'kriteria_id' => (int)$finding['kriteria_id'],
                        'uraian_temuan' => trim($finding['uraian_temuan']),
                        'kategori_temuan' => trim($finding['kategori_temuan']),
                        'saran_perbaikan' => trim($finding['saran_perbaikan'] ?? '') ?: null,
                    ];
                }, $request->findings),
            ];

            Log::info('Store request payload: ', $payload);

            $response = Http::timeout(30)->retry(2, 100)->post("{$this->apiBaseUrl}/laporan-temuan", $payload);

            // Mendapatkan auditing_id untuk redirect jika berhasil atau gagal API
            $auditingId = $request->auditing_id;

            if (!$response->successful()) {
                Log::error('API store failed: Status ' . $response->status() . ', Body: ' . $response->body());
                $errorMessage = 'Gagal menyimpan laporan temuan dari API: ' . ($response->json()['message'] ?? 'Kesalahan server');
                // Redirect back dengan pesan error
                return back()->withInput()->with('error', $errorMessage);
            }

            $apiResponse = $response->json();
            if (!isset($apiResponse['status']) || !$apiResponse['status']) {
                Log::error('API store returned failure: ' . ($apiResponse['message'] ?? 'No message'));
                $errorMessage = $apiResponse['message'] ?? 'Gagal menyimpan laporan temuan.';
                // Redirect back dengan pesan error dari API
                return back()->withInput()->with('error', $errorMessage);
            }

            // Jika berhasil, redirect ke halaman index dengan pesan sukses
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('success', 'Laporan temuan berhasil disimpan.');

        } catch (\Exception $e) {
            Log::error('Unexpected error in store: ' . $e->getMessage());
            // Tangani exception tak terduga dengan redirect back dan pesan error
            return back()->withInput()->with('error', 'Terjadi kesalahan tak terduga saat menyimpan laporan temuan.');
        }
    }

    /**
     * Display the specified laporan temuan.
     */
    public function show($auditingId, $laporan_temuan_id)
    {
        try {
            $response = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/laporan-temuan/{$laporan_temuan_id}");

            if (!$response->successful()) {
                Log::error('API show failed: Status ' . $response->status() . ', Body: ' . $response->body());
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal mengambil data laporan temuan.');
            }

            $apiResponse = $response->json();

            if (!isset($apiResponse['status']) || !isset($apiResponse['data']) || !is_array($apiResponse['data'])) {
                Log::error('Invalid API response structure (show): ' . json_encode($apiResponse));
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Format respons API tidak valid.');
            }

            if (!$apiResponse['status']) {
                Log::error('API show returned failure: ' . ($apiResponse['message'] ?? 'No message'));
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', $apiResponse['message'] ?? 'Gagal mengambil data laporan temuan.');
            }

            $laporan = $apiResponse['data'];
            $kriteriaResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/kriteria");
            $kriteriaMap = [];
            if ($kriteriaResponse->successful()) {
                $kriteriaData = $kriteriaResponse->json();
                $kriteriaMap = array_column($kriteriaData, 'nama_kriteria', 'kriteria_id');
            } else {
                Log::warning('Failed to fetch kriteria map for show: Status ' . $kriteriaResponse->status());
            }

            return view('auditor.laporan.detail', compact('laporan', 'auditingId', 'kriteriaMap'));
        } catch (\Exception $e) {
            Log::error('Unexpected error in show: ' . $e->getMessage());
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('error', 'Terjadi kesalahan saat memuat data laporan temuan.');
        }
    }

    /**
     * Show the form for editing the specified laporan temuan.
     */
    public function edit($auditingId, $laporan_temuan_id)
    {
        try {
            $response = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/laporan-temuan/{$laporan_temuan_id}");
            if ($response->failed()) {
                Log::error('API edit failed: Status ' . $response->status() . ', Body: ' . $response->body());
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal memuat data laporan temuan.');
            }

            $apiResponse = $response->json();
            if (!isset($apiResponse['data']) || empty($apiResponse['data'])) {
                Log::warning('Empty or invalid data for edit: ' . json_encode($apiResponse));
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Laporan temuan tidak ditemukan.');
            }

            $laporan = $apiResponse['data'];
            if ((string)$laporan['auditing_id'] !== (string)$auditingId) {
                Log::warning('Mismatched auditingId for edit: ' . $laporan['auditing_id'] . ' vs ' . $auditingId);
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Laporan temuan tidak ditemukan untuk audit ini.');
            }

            $kriteriaResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/kriteria");
            $kriterias = [];
            if ($kriteriaResponse->successful()) {
                $kriteriaData = $kriteriaResponse->json();
                $kriterias = array_map(function ($item) {
                    return [
                        'kriteria_id' => $item['kriteria_id'] ?? null,
                        'nama_kriteria' => $item['nama_kriteria'] ?? 'Standar ' . ($item['kriteria_id'] ?? 'Unknown'),
                    ];
                }, $kriteriaData);
            } else {
                Log::warning('Failed to fetch kriteria for edit: Status ' . $kriteriaResponse->status());
            }

            $kategori_temuan = ['NC', 'AOC', 'OFI'];

            if (empty($kriterias)) {
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal memuat data kriteria.');
            }

            $findingData = [
                'laporan_temuan_id' => $laporan['laporan_temuan_id'],
                'auditing_id' => $laporan['auditing_id'],
                'kriteria_id' => $laporan['kriteria_id'], // Pass single kriteria_id
                'uraian_temuan' => $laporan['uraian_temuan'],
                'kategori_temuan' => $laporan['kategori_temuan'],
                'saran_perbaikan' => $laporan['saran_perbaikan'],
            ];

            return view('auditor.laporan.edit', compact('auditingId', 'kriterias', 'kategori_temuan', 'findingData'));
        } catch (\Exception $e) {
            Log::error('Unexpected error in edit: ' . $e->getMessage());
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('error', 'Terjadi kesalahan saat memuat formulir edit.');
        }
    }

    /**
     * Update the specified laporan temuan via API.
     */
    public function update(Request $request, $auditingId, $laporan_temuan_id) // Tambahkan $auditingId, $laporan_temuan_id dari route
    {
        try {
            // Validasi input dari request
            $validator = Validator::make($request->all(), [
                'auditing_id' => 'required|numeric', // tetap diperlukan jika dikirim dari form
                'kriteria_id' => 'required|numeric',
                'uraian_temuan' => 'required|string|max:1000',
                'kategori_temuan' => 'required|in:NC,AOC,OFI',
                'saran_perbaikan' => 'nullable|string|max:1000',
            ], [
                'auditing_id.required' => 'ID audit wajib diisi.',
                'kriteria_id.required' => 'Standar wajib dipilih.',
                'uraian_temuan.required' => 'Uraian temuan wajib diisi.',
                'kategori_temuan.required' => 'Kategori temuan wajib dipilih.',
                'kategori_temuan.in' => 'Kategori harus NC, AOC, atau OFI.',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed in update: ', $validator->errors()->toArray());
                // Untuk formulir tradisional, redirect back dengan errors
                return back()->withInput()->withErrors($validator);
            }

            // Payload yang akan dikirim ke API eksternal
            $payload = [
                'auditing_id' => (int)$request->auditing_id, // Ambil dari request body
                'kriteria_id' => (int)$request->kriteria_id,
                'uraian_temuan' => trim($request->uraian_temuan),
                'kategori_temuan' => trim($request->kategori_temuan),
                'saran_perbaikan' => trim($request->saran_perbaikan ?? '') ?: null,
            ];

            Log::info('Update request payload: ', $payload); // Pindahkan log ini ke sini

            // Kirim PUT request ke API eksternal
            $response = Http::timeout(30)->retry(2, 100)->put("{$this->apiBaseUrl}/laporan-temuan/{$laporan_temuan_id}", $payload); // Gunakan $laporan_temuan_id dari route

            if (!$response->successful()) {
                Log::error('API update failed: Status ' . $response->status() . ', Body: ' . $response->body());
                $errorMessage = 'Gagal memperbarui laporan temuan: ' . ($response->json()['message'] ?? 'Kesalahan server');
                // Untuk formulir tradisional, redirect back dengan pesan error
                return back()->withInput()->with('error', $errorMessage);
            }

            $apiResponse = $response->json();
            if (!isset($apiResponse['status']) || !$apiResponse['status']) {
                Log::error('API update returned failure: ' . ($apiResponse['message'] ?? 'No message'));
                $errorMessage = $apiResponse['message'] ?? 'Gagal memperbarui laporan temuan.';
                // Untuk formulir tradisional, redirect back dengan pesan error
                return back()->withInput()->with('error', $errorMessage);
            }

            // Jika berhasil, redirect ke halaman index dengan pesan sukses
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('success', 'Laporan temuan berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Unexpected error in update: ' . $e->getMessage());
            // Tangani exception tak terduga dengan redirect back dan pesan error
            return back()->withInput()->with('error', 'Terjadi kesalahan tak terduga saat memperbarui laporan temuan.');
        }
    }


    /**
     * Remove the specified laporan temuan from storage.
     */
    public function destroy($auditingId, $laporan_temuan_id)
    {
        try {
            $response = Http::timeout(30)->retry(2, 100)->delete("{$this->apiBaseUrl}/laporan-temuan/{$laporan_temuan_id}");

            if (!$response->successful()) {
                Log::error('API destroy failed: Status ' . $response->status() . ', Body: ' . $response->body());
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal menghapus laporan temuan.');
            }

            $apiResponse = $response->json();
            if (!isset($apiResponse['status']) || !$apiResponse['status']) {
                Log::error('API destroy returned failure: ' . ($apiResponse['message'] ?? 'No message'));
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', $apiResponse['message'] ?? 'Gagal menghapus laporan temuan.');
            }

            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('success', 'Laporan temuan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Unexpected error in destroy: ' . $e->getMessage());
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('error', 'Terjadi kesalahan saat menghapus laporan temuan.');
        }
    }
}
