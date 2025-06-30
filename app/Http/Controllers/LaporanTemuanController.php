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

            // 2. Fetch kriteria data for mapping
            $kriteriaResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/kriteria");
            $kriteriaMap = [];
            if ($kriteriaResponse->successful()) {
                $kriteriaData = $kriteriaResponse->json();
                foreach ($kriteriaData as $kriteria) {
                    $kriteriaMap[$kriteria['kriteria_id']] = $kriteria['nama_kriteria'] ?? 'Kriteria ' . $kriteria['kriteria_id'];
                }
            } else {
                Log::warning('Failed to fetch kriteria for index: Status ' . $kriteriaResponse->status());
            }

            // 3. Fetch standards data for mapping
            $standardsResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/response-tilik/auditing/{$auditingId}");
            $standardsMap = [];
            if ($standardsResponse->successful()) {
                $standardsData = $standardsResponse->json();

                // Handle both possible response structures
                $dataArray = null;
                if (isset($standardsData['data']['data']) && is_array($standardsData['data']['data'])) {
                    $dataArray = $standardsData['data']['data'];
                } elseif (isset($standardsData['data']) && is_array($standardsData['data'])) {
                    $dataArray = $standardsData['data'];
                }

                if ($dataArray !== null) {
                    foreach ($dataArray as $item) {
                        if (isset($item['response_tilik_id']) && isset($item['standar_nasional'])) {
                            $standardsMap[$item['response_tilik_id']] = $item['standar_nasional'];
                        }
                    }
                }
            } else {
                Log::warning('Failed to fetch standards for index: Status ' . $standardsResponse->status());
            }

            // 4. Group the data by kriteria_id for display with rowspan
            $groupedLaporanTemuans = $laporanTemuansData->groupBy('kriteria_id');

            // 5. Transform grouped data for easier rendering and consistent structure
            $processedGroupedData = $groupedLaporanTemuans->map(function ($itemsInGroup, $kriteriaId) use ($kriteriaMap, $standardsMap) {
                return [
                    'kriteria_id' => $kriteriaId,
                    'nama_kriteria' => $kriteriaMap[$kriteriaId] ?? 'Kriteria tidak ditemukan',
                    'findings' => $itemsInGroup->map(function ($finding) use ($standardsMap) {
                        // Determine standar_id from the finding data
                        $standarId = $finding['standar_id'] ?? $finding['response_tilik_id'] ?? null;

                        return [
                            'laporan_temuan_id' => $finding['laporan_temuan_id'],
                            'uraian_temuan' => $finding['uraian_temuan'],
                            'kategori_temuan' => $finding['kategori_temuan'],
                            'saran_perbaikan' => $finding['saran_perbaikan'],
                            'auditing_id' => $finding['auditing_id'],
                            'kriteria_id' => $finding['kriteria_id'],
                            // Map standar_id and standar_nasional using the standardsMap
                            'standar_id' => $standarId,
                            'standar_nasional' => $standarId ? ($standardsMap[$standarId] ?? 'Standar tidak ditemukan') : 'Tidak ada standar',
                        ];
                    })->values()->all(),
                ];
            })->values()->all();

            // 6. Manual Pagination for the grouped items (each "item" in paginator is a kriteria group)
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
            $standardsResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/response-tilik/auditing/{$auditingId}");
            $allStandardsData = [];
            $standardsByKriteria = [];

            if ($standardsResponse->successful()) {
                $standardsData = $standardsResponse->json();
                Log::info('Standards API response structure for create:', ['data' => $standardsData]);

                // Handle both possible response structures
                $dataArray = null;
                if (isset($standardsData['data']['data']) && is_array($standardsData['data']['data'])) {
                    // New structure: {"data": {"success": true, "data": [...]}}
                    $dataArray = $standardsData['data']['data'];
                } elseif (isset($standardsData['data']) && is_array($standardsData['data'])) {
                    // Old structure: {"data": [...]}
                    $dataArray = $standardsData['data'];
                }

                if ($dataArray !== null) {
                    Log::info('Processing standards data for create, count: ' . count($dataArray));

                    foreach ($dataArray as $item) {
                        // Validate that all required keys exist
                        if (!isset($item['response_tilik_id']) || !isset($item['standar_nasional']) || !isset($item['tilik']['kriteria_id'])) {
                            Log::warning('Standard item missing required fields in create:', [
                                'has_response_tilik_id' => isset($item['response_tilik_id']),
                                'has_standar_nasional' => isset($item['standar_nasional']),
                                'has_tilik_kriteria_id' => isset($item['tilik']['kriteria_id']),
                                'item_keys' => array_keys($item),
                                'tilik_keys' => isset($item['tilik']) ? array_keys($item['tilik']) : 'tilik not set'
                            ]);
                            continue; // Skip this item
                        }

                        // Extract kriteria_id from nested structure
                        $kriteriaId = $item['tilik']['kriteria_id'];

                        Log::debug('Processing standard item for create:', [
                            'response_tilik_id' => $item['response_tilik_id'],
                            'standar_nasional' => $item['standar_nasional'],
                            'kriteria_id' => $kriteriaId,
                            'tilik_structure' => $item['tilik']
                        ]);

                        $standardData = [
                            'response_tilik_id' => $item['response_tilik_id'],
                            'standar_nasional' => $item['standar_nasional'],
                            'kriteria_id' => $kriteriaId,
                        ];

                        $allStandardsData[] = $standardData;

                        // Group by kriteria_id for dropdown filtering
                        if (!isset($standardsByKriteria[$kriteriaId])) {
                            $standardsByKriteria[$kriteriaId] = [];
                        }

                        // Avoid duplicates within the same kriteria
                        $exists = false;
                        foreach ($standardsByKriteria[$kriteriaId] as $existing) {
                            if ($existing['standar_id'] == $item['response_tilik_id']) {
                                $exists = true;
                                break;
                            }
                        }

                        if (!$exists) {
                            $standardsByKriteria[$kriteriaId][] = [
                                'standar_id' => $item['response_tilik_id'],
                                'nama_standar' => $item['standar_nasional']
                            ];
                        }
                    }
                } else {
                    Log::warning('Response-tilik API response structure not recognized for create:', ['response' => $standardsData]);
                }
            } else {
                Log::error('Failed to fetch standards for create: Status ' . $standardsResponse->status() . ', Body: ' . $standardsResponse->body());

                // Jika 404, kemungkinan auditing ID tidak memiliki data response-tilik
                if ($standardsResponse->status() === 404) {
                    Log::warning('No response-tilik data found for auditingId: ' . $auditingId);
                    return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                        ->with('error', 'Tidak ada data response tilik untuk audit ini. Silakan lengkapi data response tilik terlebih dahulu sebelum membuat laporan temuan.');
                }
            }

            Log::info('Processed standards data for create:', [
                'allStandardsData_count' => count($allStandardsData),
                'standardsByKriteria_count' => count($standardsByKriteria),
                'standardsByKriteria_structure' => $standardsByKriteria
            ]);

            if (empty($kriterias)) {
                Log::error('No kriteria data available');
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Data kriteria tidak tersedia. Silakan hubungi administrator.');
            }

            if (empty($allStandardsData)) {
                Log::error('No standards data available for auditingId: ' . $auditingId);
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Tidak ada data standar (response tilik) untuk audit ini. Silakan lengkapi data response tilik terlebih dahulu.');
            }

            Log::info('Successfully prepared data for create view', [
                'auditingId' => $auditingId,
                'kriterias_count' => count($kriterias),
                'allStandardsData_count' => count($allStandardsData),
                'standardsByKriteria_keys' => array_keys($standardsByKriteria)
            ]);

            return view('auditor.laporan.create', compact('auditingId', 'kriterias', 'allStandardsData', 'standardsByKriteria'));
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
                Log::info('Kriteria API response for edit:', ['count' => count($kriteriaData), 'data' => $kriteriaData]);
                $kriterias = array_map(function ($item) {
                    return [
                        'kriteria_id' => $item['kriteria_id'] ?? null,
                        'nama_kriteria' => $item['nama_kriteria'] ?? 'Kriteria ' . ($item['kriteria_id'] ?? 'Unknown'),
                    ];
                }, $kriteriaData);
                Log::info('Processed kriterias for edit:', ['count' => count($kriterias), 'data' => $kriterias]);
            } else {
                Log::warning('Failed to fetch kriteria for edit: Status ' . $kriteriaResponse->status());
            }

            // Fetch Standards from response-tilik API, filtered by auditing_id
            $standardsResponse = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/response-tilik/auditing/{$auditingId}");
            $allStandardsData = [];
            $standardsByKriteria = [];

            if ($standardsResponse->successful()) {
                $standardsData = $standardsResponse->json();
                Log::info('Standards API response structure for edit:', ['data' => $standardsData]);

                // Handle both possible response structures
                $dataArray = null;
                if (isset($standardsData['data']['data']) && is_array($standardsData['data']['data'])) {
                    // New structure: {"data": {"success": true, "data": [...]}}
                    $dataArray = $standardsData['data']['data'];
                } elseif (isset($standardsData['data']) && is_array($standardsData['data'])) {
                    // Old structure: {"data": [...]}
                    $dataArray = $standardsData['data'];
                }

                if ($dataArray !== null) {
                    Log::info('Processing standards data for edit, count: ' . count($dataArray));

                    foreach ($dataArray as $item) {
                        // Validate that all required keys exist
                        if (!isset($item['response_tilik_id']) || !isset($item['standar_nasional']) || !isset($item['tilik']['kriteria_id'])) {
                            Log::warning('Standard item missing required fields in edit:', [
                                'has_response_tilik_id' => isset($item['response_tilik_id']),
                                'has_standar_nasional' => isset($item['standar_nasional']),
                                'has_tilik_kriteria_id' => isset($item['tilik']['kriteria_id']),
                                'item_keys' => array_keys($item),
                                'tilik_keys' => isset($item['tilik']) ? array_keys($item['tilik']) : 'tilik not set'
                            ]);
                            continue; // Skip this item
                        }

                        // Extract kriteria_id from nested structure
                        $kriteriaId = $item['tilik']['kriteria_id'];

                        Log::debug('Processing standard item for edit:', [
                            'response_tilik_id' => $item['response_tilik_id'],
                            'standar_nasional' => $item['standar_nasional'],
                            'kriteria_id' => $kriteriaId,
                            'tilik_structure' => $item['tilik']
                        ]);

                        $standardData = [
                            'response_tilik_id' => $item['response_tilik_id'],
                            'standar_nasional' => $item['standar_nasional'],
                            'kriteria_id' => $kriteriaId,
                        ];

                        $allStandardsData[] = $standardData;

                        // Group by kriteria_id for dropdown filtering
                        if (!isset($standardsByKriteria[$kriteriaId])) {
                            $standardsByKriteria[$kriteriaId] = [];
                        }

                        // Avoid duplicates within the same kriteria
                        $exists = false;
                        foreach ($standardsByKriteria[$kriteriaId] as $existing) {
                            if ($existing['standar_id'] == $item['response_tilik_id']) {
                                $exists = true;
                                break;
                            }
                        }

                        if (!$exists) {
                            $standardsByKriteria[$kriteriaId][] = [
                                'standar_id' => $item['response_tilik_id'],
                                'nama_standar' => $item['standar_nasional']
                            ];
                        }
                    }
                } else {
                    Log::warning('Response-tilik API response structure not recognized for edit:', ['response' => $standardsData]);
                }
            } else {
                Log::error('Failed to fetch standards for edit: Status ' . $standardsResponse->status() . ', Body: ' . $standardsResponse->body());

                // Jika 404, kemungkinan auditing ID tidak memiliki data response-tilik
                if ($standardsResponse->status() === 404) {
                    Log::warning('No response-tilik data found for auditingId: ' . $auditingId);
                    return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                        ->with('error', 'Tidak ada data response tilik untuk audit ini. Silakan lengkapi data response tilik terlebih dahulu sebelum mengedit laporan temuan.');
                }
            }

            Log::info('Processed standards data for edit:', [
                'allStandardsData_count' => count($allStandardsData),
                'standardsByKriteria_count' => count($standardsByKriteria),
                'standardsByKriteria_structure' => $standardsByKriteria
            ]);

            $kategori_temuan = ['NC', 'AOC', 'OFI'];

            Log::info('Final data check for edit before view:', [
                'kriterias_count' => count($kriterias),
                'allStandardsData_count' => count($allStandardsData),
                'kriterias_empty' => empty($kriterias),
                'allStandardsData_empty' => empty($allStandardsData),
                'auditingId' => $auditingId
            ]);

            if (empty($kriterias) || empty($allStandardsData)) {
                Log::error('Data is empty for edit view:', [
                    'kriterias_empty' => empty($kriterias),
                    'allStandardsData_empty' => empty($allStandardsData),
                    'kriterias_count' => count($kriterias),
                    'allStandardsData_count' => count($allStandardsData)
                ]);
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal memuat data kriteria atau standar.');
            }

            $findingData = [
                'laporan_temuan_id' => $laporan['laporan_temuan_id'],
                'auditing_id' => $laporan['auditing_id'],
                'kriteria_id' => $laporan['kriteria_id'],
                'standar_id' => $laporan['response_tilik_id'] ?? $laporan['standar_id'] ?? null, // Use response_tilik_id from API
                'uraian_temuan' => $laporan['uraian_temuan'],
                'kategori_temuan' => $laporan['kategori_temuan'],
                'saran_perbaikan' => $laporan['saran_perbaikan'],
            ];

            return view('auditor.laporan.edit', compact('auditingId', 'kriterias', 'kategori_temuan', 'findingData', 'allStandardsData', 'standardsByKriteria'));
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
                'response_tilik_id' => (int)$request->standar_id, // Include standar_id in payload
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
