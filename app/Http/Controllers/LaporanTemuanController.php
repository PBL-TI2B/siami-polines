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
                'per_page' => $perPage,
            ];

            // Jika ada searchTerm, tambahkan ke parameter API
            if ($searchTerm) {
                $apiParams['search'] = $searchTerm;
            }

            // 1. Fetch all relevant laporan temuan from the API for the given auditingId
            $response = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/laporan-temuan", $apiParams);

            if (!$response->successful()) {
                Log::error('API laporan-temuan failed: Status ' . $response->status() . ', Body: ' . $response->body());
                return redirect()->route('auditor.dashboard.index')
                    ->with('error', 'Gagal mengambil data laporan temuan dari API.');
            }

            $apiResponse = $response->json();

            // Pastikan struktur respons API valid (diasumsikan API ini selalu mengembalikan 'data' langsung di root)
            if (!isset($apiResponse['status']) || !is_array($apiResponse['data'])) {
                Log::error('Invalid API response structure (index for findings): ' . json_encode($apiResponse));
                return redirect()->route('auditor.dashboard.index')
                    ->with('error', 'Format respons API laporan temuan tidak valid.');
            }

            // Periksa status yang dikembalikan API
            if (!$apiResponse['status']) {
                Log::error('API returned failure (index for findings): ' . ($apiResponse['message'] ?? 'No message'));
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
                            // Add standar_id and standar_nasional if available in the API response for index view
                            'standar_id' => $finding['standar_id'] ?? null,
                            'standar_nasional' => $finding['standar_nasional'] ?? null,
                        ];
                    })->values()->all(),
                ];
            })->values()->all();

            // 4. Manual Pagination for the grouped items (each "item" in paginator is a kriteria group)
            $page = $request->query('page', 1);
            $totalGroupedItems = count($processedGroupedData);

            $laporanTemuansPaginated = new LengthAwarePaginator(
                $processedGroupedData,
                $totalGroupedItems,
                $perPage,
                $page,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );

            // Fetch the specific audit status for button control
            $auditResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/auditings/{$auditingId}");
            $currentAuditStatus = null;
            if ($auditResponse->successful()) {
                $apiAuditData = $auditResponse->json();
                if (isset($apiAuditData['status'])) {
                    $currentAuditStatus = $apiAuditData['status'];
                } else {
                    Log::warning("Audit status key 'status' not found in API response for auditingId {$auditingId}. Response: " . json_encode($apiAuditData));
                }
            } else {
                Log::warning("Failed to fetch current audit status from API for auditingId {$auditingId}. Status: " . $auditResponse->status() . ", Body: " . $auditResponse->body());
            }

            return view('auditor.laporan.index', compact('laporanTemuansPaginated', 'auditingId', 'currentAuditStatus'));

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
            // Fetch Kriteria
            $kriteriaResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/kriteria");
            $kriterias = [];
            if ($kriteriaResponse->successful()) {
                $kriteriaData = $kriteriaResponse->json();
                $kriterias = array_map(function ($item) {
                    return [
                        'kriteria_id' => $item['kriteria_id'] ?? null,
                        'nama_kriteria' => $item['nama_kriteria'] ?? 'Kriteria ' . ($item['kriteria_id'] ?? 'Unknown'),
                    ];
                }, $kriteriaData);
            } else {
                Log::error('Failed to fetch kriteria for create: Status ' . $kriteriaResponse->status() . ', Body: ' . $kriteriaResponse->body());
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal memuat data kriteria dari API.');
            }

            // Fetch Standards from response-tilik API, filtered by auditing_id
            // CHANGED: Using the specific endpoint for auditing_id filter
            $standardsResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/response-tilik/auditing/{$auditingId}");
            $standards = [];
            if ($standardsResponse->successful()) {
                $standardsData = $standardsResponse->json();
                if (isset($standardsData['data']) && is_array($standardsData['data'])) {
                    $uniqueStandards = new Collection();
                    foreach ($standardsData['data'] as $item) {
                        if (isset($item['standar_nasional']) && $item['standar_nasional'] !== null) {
                            $uniqueKey = $item['standar_nasional'] . '|' . ($item['response_tilik_id'] ?? 'null');
                            if (!$uniqueStandards->has($uniqueKey)) {
                                $uniqueStandards->put($uniqueKey, [
                                    'standar_id' => $item['response_tilik_id'], // Using response_tilik_id as the value for the dropdown
                                    'nama_standar' => $item['standar_nasional']
                                ]);
                            }
                        }
                    }
                    $standards = $uniqueStandards->values()->all(); // Get only the values
                } else {
                    Log::warning('Response-tilik API did not return data or has invalid structure.');
                }
            } else {
                Log::error('Failed to fetch standards for create: Status ' . $standardsResponse->status() . ', Body: ' . $standardsResponse->body());
            }

            if (empty($kriterias) || empty($standards)) {
                Log::warning('Missing kriteria or standards data for create view.');
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal memuat data kriteria atau standar dari API. Pastikan kedua API berfungsi.');
            }

            return view('auditor.laporan.create', compact('auditingId', 'kriterias', 'standards'));
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
                'auditing_id' => 'required|numeric',
                'findings' => 'required|array|min:1',
                'findings.*.kriteria_id' => 'required|numeric',
                'findings.*.standar_id' => 'required|numeric', // Add validation for standar_id
                'findings.*.uraian_temuan' => 'required|string|max:1000',
                'findings.*.kategori_temuan' => 'required|in:NC,AOC,OFI',
                'findings.*.saran_perbaikan' => 'nullable|string|max:1000',
            ], [
                'auditing_id.required' => 'Audit ID is required.',
                'findings.required' => 'At least one finding is required.',
                'findings.min' => 'At least one finding is required.',
                'findings.*.kriteria_id.required' => 'Kriteria wajib dipilih untuk setiap temuan.',
                'findings.*.standar_id.required' => 'Standar wajib dipilih untuk setiap temuan.',
                'findings.*.uraian_temuan.required' => 'Uraian temuan wajib diisi.',
                'findings.*.kategori_temuan.required' => 'Kategori temuan wajib diisi.',
                'findings.*.kategori_temuan.in' => 'Kategori temuan harus NC, AOC, atau OFI.',
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
                        'response_tilik_id' => (int)$finding['standar_id'], // Include standar_id in payload
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

            $laporan = isset($apiResponse['data']) ? $apiResponse['data'] : $apiResponse;

            if (empty($laporan)) {
                Log::error('Empty or invalid data for show: ' . json_encode($apiResponse));
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Laporan temuan tidak ditemukan atau format respons API tidak valid.');
            }

            $kriteriaResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/kriteria");
            $kriterias = [];
            if ($kriteriaResponse->successful()) {
                $kriteriaData = $kriteriaResponse->json();
                $kriterias = array_map(function ($item) {
                    return [
                        'kriteria_id' => $item['kriteria_id'] ?? null,
                        'nama_kriteria' => $item['nama_kriteria'] ?? 'Kriteria ' . ($item['kriteria_id'] ?? 'Unknown'),
                    ];
                }, $kriteriaData);
            } else {
                Log::warning('Failed to fetch kriteria map for show: Status ' . $kriteriaResponse->status());
            }

            // Standards are not typically needed for a simple 'show' view unless explicitly displayed
            // However, if $laporan already contains 'standar_id' and 'standar_nasional', it's sufficient.

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
            $laporan = isset($apiResponse['data']) ? $apiResponse['data'] : $apiResponse;

            if (empty($laporan)) {
                Log::warning('Empty or invalid data for edit: ' . json_encode($apiResponse));
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Laporan temuan tidak ditemukan.');
            }

            if ((string)$laporan['auditing_id'] !== (string)$auditingId) {
                Log::warning('Mismatched auditingId for edit: ' . $laporan['auditing_id'] . ' vs ' . $auditingId);
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Laporan temuan tidak ditemukan untuk audit ini.');
            }

            // Fetch Kriteria
            $kriteriaResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/kriteria");
            $kriterias = [];
            if ($kriteriaResponse->successful()) {
                $kriteriaData = $kriteriaResponse->json();
                $kriterias = array_map(function ($item) {
                    return [
                        'kriteria_id' => $item['kriteria_id'] ?? null,
                        'nama_kriteria' => $item['nama_kriteria'] ?? 'Kriteria ' . ($item['kriteria_id'] ?? 'Unknown'),
                    ];
                }, $kriteriaData);
            } else {
                Log::warning('Failed to fetch kriteria for edit: Status ' . $kriteriaResponse->status());
            }

            // Fetch Standards from response-tilik API, filtered by auditing_id
            // CHANGED: Using the specific endpoint for auditing_id filter
            $standardsResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/response-tilik/auditing/{$auditingId}");
            $standards = [];
            if ($standardsResponse->successful()) {
                $standardsData = $standardsResponse->json();
                if (isset($standardsData['data']) && is_array($standardsData['data'])) {
                    $uniqueStandards = new Collection();
                    foreach ($standardsData['data'] as $item) {
                        if (isset($item['standar_nasional']) && $item['standar_nasional'] !== null) {
                             $uniqueKey = $item['standar_nasional'] . '|' . ($item['response_tilik_id'] ?? 'null');
                            if (!$uniqueStandards->has($uniqueKey)) {
                                $uniqueStandards->put($uniqueKey, [
                                    'standar_id' => $item['response_tilik_id'], // Using response_tilik_id as the value for the dropdown
                                    'nama_standar' => $item['standar_nasional']
                                ]);
                            }
                        }
                    }
                    $standards = $uniqueStandards->values()->all();
                } else {
                    Log::warning('Response-tilik API did not return data or has invalid structure for edit.');
                }
            } else {
                Log::error('Failed to fetch standards for edit: Status ' . $standardsResponse->status() . ', Body: ' . $standardsResponse->body());
            }

            $kategori_temuan = ['NC', 'AOC', 'OFI'];

            if (empty($kriterias) || empty($standards)) {
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal memuat data kriteria atau standar.');
            }

            $findingData = [
                'laporan_temuan_id' => $laporan['laporan_temuan_id'],
                'auditing_id' => $laporan['auditing_id'],
                'kriteria_id' => $laporan['kriteria_id'],
                'standar_id' => $laporan['standar_id'] ?? null, // Ensure standar_id is passed
                'uraian_temuan' => $laporan['uraian_temuan'],
                'kategori_temuan' => $laporan['kategori_temuan'],
                'saran_perbaikan' => $laporan['saran_perbaikan'],
            ];

            return view('auditor.laporan.edit', compact('auditingId', 'kriterias', 'kategori_temuan', 'findingData', 'standards'));
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
                'standar_id' => 'required|numeric', // Add validation for standar_id
                'uraian_temuan' => 'required|string|max:1000',
                'kategori_temuan' => 'required|in:NC,AOC,OFI',
                'saran_perbaikan' => 'nullable|string|max:1000',
            ], [
                'auditing_id.required' => 'ID audit wajib diisi.',
                'kriteria_id.required' => 'Kriteria wajib dipilih.',
                'standar_id.required' => 'Standar wajib dipilih.',
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
                'standar_id' => (int)$request->standar_id, // Include standar_id in payload
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
            $response = Http::timeout(30)->retry(2, 100)->put("{$this->apiBaseUrl}/auditings/{$auditingId}", $payload);

            if (!$response->successful()) {
                Log::error('API update audit status failed: Status ' . $response->status() . ', Body: ' . $response->body());
                $errorMessage = 'Gagal memperbarui status audit: ' . ($response->json()['message'] ?? 'Kesalahan server API.');
                return back()->with('error', $errorMessage);
            }

            $apiResponse = $response->json();
            if (!isset($apiResponse['success']) || !$apiResponse['success']) {
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
                $errorMessage = $apiResponse['message'] ?? 'Gagal menghapus laporan temuan.';
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', $errorMessage);
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
