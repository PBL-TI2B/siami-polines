<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class LaporanTemuanController extends Controller
{
    protected $apiBaseUrl = 'http://127.0.0.1:5000/api'; // Pastikan URL ini sesuai dengan API eksternal

    /**
     * Display a listing of the laporan temuan.
     */
    public function index(Request $request, $auditingId)
    {
        try {
            // Ambil parameter pencarian dan per_page dari request Laravel
            $searchTerm = $request->query('search');
            $perPage = $request->query('per_page', 10); // Default ke 10 jika tidak ada

            // Persiapkan parameter untuk dikirim ke API eksternal
            $apiParams = [
                'auditing_id' => $auditingId,
                'per_page' => $perPage, // <-- Penting: Teruskan per_page ke API
            ];

            // Jika ada searchTerm, tambahkan ke parameter API
            if ($searchTerm) {
                $apiParams['search'] = $searchTerm; // <-- Penting: Teruskan search ke API
            }

            // 1. Fetch all relevant laporan temuan from the API for the given auditingId
            // Sertakan semua $apiParams yang relevan (termasuk search dan per_page)
            $response = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/laporan-temuan", $apiParams);

            if (!$response->successful()) {
                Log::error('API laporan-temuan failed: Status ' . $response->status() . ', Body: ' . $response->body());
                return redirect()->route('auditor.dashboard.index')
                    ->with('error', 'Gagal mengambil data laporan temuan dari API.');
            }

            $apiResponse = $response->json();

            // Pastikan struktur respons API valid
            if (!isset($apiResponse['status']) || !is_array($apiResponse['data'])) {
                Log::error('Invalid API response structure (index): ' . json_encode($apiResponse));
                return redirect()->route('auditor.dashboard.index')
                    ->with('error', 'Format respons API tidak valid.');
            }

            // Periksa status yang dikembalikan API
            if (!$apiResponse['status']) {
                Log::error('API returned failure (index): ' . ($apiResponse['message'] ?? 'No message'));
                return redirect()->route('auditor.dashboard.index')
                    ->with('error', $apiResponse['message'] ?? 'Gagal mengambil data laporan temuan.');
            }

            $laporanTemuansData = collect($apiResponse['data']);

            // 2. Group the data by kriteria_id for display with rowspan
            // Catatan: Filtering dan pagination *seharusnya* sudah dilakukan di API.
            // Grouping ini untuk tampilan agar temuan per kriteria bisa digabungkan.
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
            // Asumsi API Anda sudah memaginasi dan mengembalikan data yang *sudah* untuk halaman saat ini.
            // Jika API Anda mengembalikan SEMUA data yang difilter, maka Anda perlu melakukan slicing di sini.
            // Namun, untuk efisiensi, praktik terbaik adalah API yang melakukan pagination.
            $page = $request->query('page', 1);
            $totalGroupedItems = count($processedGroupedData); // Jumlah item setelah filtering oleh API

            $laporanTemuansPaginated = new LengthAwarePaginator(
                $processedGroupedData, // Ini adalah data yang sudah difilter & dipaginasi (jika API memaginasi)
                $totalGroupedItems,    // Total item setelah filter
                $perPage,              // Per page yang diminta
                $page,                 // Halaman saat ini
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
            $validator = Validator::make($request->all(), [
                'auditing_id' => 'required|exists:auditings,auditing_id',
                'findings' => 'required|array|min:1',
                'findings.*.kriteria_id' => 'required|numeric',
                'findings.*.uraian_temuan' => 'required|string|max:1000',
                'findings.*.kategori_temuan' => 'required|in:NC,AOC,OFI',
                'findings.*.saran_perbaikan' => 'nullable|string|max:1000',
            ], [
                'auditing_id.required' => 'Audit ID is required.',
                'auditing_id.exists' => 'Invalid audit ID.',
                'findings.required' => 'At least one finding is required.',
                'findings.min' => 'At least one finding is required.',
                'findings.*.kriteria_id.required' => 'Standard ID is required for each finding.',
                'findings.*.uraian_temuan.required' => 'Finding description is required.',
                'findings.*.kategori_temuan.required' => 'Finding category is required.',
                'findings.*.kategori_temuan.in' => 'Finding category must be NC, AOC, or OFI.',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed for storing laporan temuan: ' . json_encode($validator->errors()));
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

            $auditingId = $request->auditing_id;

            if (!$response->successful()) {
                Log::error('API store failed: Status ' . $response->status() . ', Body: ' . $response->body());
                $errorMessage = 'Gagal menyimpan laporan temuan dari API: ' . ($response->json()['message'] ?? 'Kesalahan server');
                return back()->withInput()->with('error', $errorMessage);
            }

            $apiResponse = $response->json();
            if (!isset($apiResponse['status']) || !$apiResponse['status']) {
                Log::error('API store returned failure: ' . ($apiResponse['message'] ?? 'No message'));
                $errorMessage = $apiResponse['message'] ?? 'Gagal menyimpan laporan temuan.';
                return back()->withInput()->with('error', $errorMessage);
            }

            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('success', 'Laporan temuan berhasil disimpan.');

        } catch (\Exception $e) {
            Log::error('Unexpected error in store: ' . $e->getMessage());
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
                Log::warning('Failed to fetch kriteria map for show: Status ' . $kriteriaResponse->status());
            }

            return view('auditor.laporan.detail', compact('laporan', 'auditingId', 'kriterias'));
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
                'kriteria_id' => $laporan['kriteria_id'],
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
    public function update(Request $request, $auditingId, $laporan_temuan_id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'auditing_id' => 'required|numeric',
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
                return back()->withInput()->withErrors($validator);
            }

            $payload = [
                'auditing_id' => (int)$request->auditing_id,
                'kriteria_id' => (int)$request->kriteria_id,
                'uraian_temuan' => trim($request->uraian_temuan),
                'kategori_temuan' => trim($request->kategori_temuan),
                'saran_perbaikan' => trim($request->saran_perbaikan ?? '') ?: null,
            ];

            Log::info('Update request payload: ', $payload);

            $response = Http::timeout(30)->retry(2, 100)->put("{$this->apiBaseUrl}/laporan-temuan/{$laporan_temuan_id}", $payload);

            if (!$response->successful()) {
                Log::error('API update failed: Status ' . $response->status() . ', Body: ' . $response->body());
                $errorMessage = 'Gagal memperbarui laporan temuan: ' . ($response->json()['message'] ?? 'Kesalahan server');
                return back()->withInput()->with('error', $errorMessage);
            }

            $apiResponse = $response->json();
            if (!isset($apiResponse['status']) || !$apiResponse['status']) {
                Log::error('API update returned failure: ' . ($apiResponse['message'] ?? 'No message'));
                $errorMessage = $apiResponse['message'] ?? 'Gagal memperbarui laporan temuan.';
                return back()->withInput()->with('error', $errorMessage);
            }

            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('success', 'Laporan temuan berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Unexpected error in update: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan tak terduga saat memperbarui laporan temuan.');
        }
    }

    /**
     * Update the status of an audit via API.
     * This method handles the "Submit & Kunci Jawaban", "Diterima", and "Revisi" actions.
     */
    public function updateAuditStatus(Request $request, $auditingId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|numeric|in:7,8,9', // Status: 7=Laporan Temuan, 8=Revisi, 9=Sudah revisi
            ], [
                'status.required' => 'Status tidak boleh kosong.',
                'status.numeric' => 'Format status tidak valid.',
                'status.in' => 'Status yang dipilih tidak valid.'
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed for updateAuditStatus: ' . json_encode($validator->errors()));
                return back()->withInput()->withErrors($validator);
            }

            $newStatus = (int)$request->status;

            // Payload for the external API to update the audit status
            $payload = [
                'status' => $newStatus,
            ];

            Log::info("Update audit status request for Auditing ID: {$auditingId}, new status: {$newStatus}");

            // Send PUT request to the external API for auditings
            // Assuming your external API has an endpoint like PUT /api/auditings/{id}
            $response = Http::timeout(30)->retry(2, 100)->put("{$this->apiBaseUrl}/auditings/{$auditingId}", $payload);

            if (!$response->successful()) {
                Log::error('API update audit status failed: Status ' . $response->status() . ', Body: ' . $response->body());
                $errorMessage = 'Gagal memperbarui status audit: ' . ($response->json()['message'] ?? 'Kesalahan server API.');
                return back()->with('error', $errorMessage);
            }

            $apiResponse = $response->json();
            if (!isset($apiResponse['status']) || !$apiResponse['status']) {
                Log::error('API update audit status returned failure: ' . ($apiResponse['message'] ?? 'No message'));
                $errorMessage = $apiResponse['message'] ?? 'Gagal memperbarui status audit.';
                return back()->with('error', $errorMessage);
            }

            $successMessage = '';
            switch ($newStatus) {
                case 7:
                    $successMessage = 'Laporan temuan berhasil di-Submit dan dikunci.';
                    break;
                case 8:
                    $successMessage = 'Permintaan revisi laporan temuan berhasil dikirim.';
                    break;
                case 9:
                    $successMessage = 'Laporan temuan berhasil dinyatakan Diterima.';
                    break;
                default:
                    $successMessage = 'Status audit berhasil diperbarui.';
            }

            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            Log::error('Unexpected error in updateAuditStatus: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan tak terduga saat memperbarui status audit.');
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
