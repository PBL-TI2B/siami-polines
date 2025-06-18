<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LaporanTemuanController extends Controller
{
    protected $apiBaseUrl = 'http://127.0.0.1:5000/api';

    /**
     * Helper method to fetch kriteria from API with caching.
     */
    protected function fetchKriteria()
    {
        try {
            $cacheKey = 'kriteria_data';
            $kriteriaData = Cache::remember($cacheKey, now()->addHours(1), function () {
                $response = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/kriteria");

                if (!$response->successful()) {
                    Log::error('API kriteria failed with status: ' . $response->status() . ' Body: ' . $response->body());
                    throw new \Exception('Failed to retrieve criteria data from API. Status: ' . $response->status());
                }

                $data = $response->json();
                if (!is_array($data)) {
                    Log::error('API kriteria returned invalid format: ' . json_encode($data));
                    throw new \Exception('Invalid criteria data format.');
                }

                $filteredData = array_filter($data, fn($item) =>
                    is_array($item) &&
                    isset($item['kriteria_id'], $item['nama_kriteria']) &&
                    is_numeric($item['kriteria_id']) &&
                    is_string($item['nama_kriteria'])
                );

                if (empty($filteredData)) {
                    Log::warning('No valid kriteria data after filtering.');
                }

                return array_values($filteredData); // Re-index array to ensure sequential numeric keys
            });

            return $kriteriaData;
        } catch (\Exception $e) {
            Log::error('Failed to fetch kriteria from API: ' . $e->getMessage());
            return null; // Return null to indicate failure, handled by caller
        }
    }

    /**
     * Create kriteria map for view.
     * Used for displaying kriteria names based on ID.
     */
    protected function getKriteriaMap()
    {
        $kriteriaData = $this->fetchKriteria();
        if (!$kriteriaData) {
            return [];
        }

        return array_column($kriteriaData, 'nama_kriteria', 'kriteria_id');
    }

    /**
     * Get kriteria list for select input.
     * Used for populating dropdowns with ID and Name.
     */
    protected function getKriteriaList()
    {
        $kriteriaData = $this->fetchKriteria();
        if (!$kriteriaData) {
            return [];
        }

        return array_map(fn($item) => [
            'kriteria_id' => $item['kriteria_id'],
            'nama_kriteria' => $item['nama_kriteria'],
        ], $kriteriaData);
    }

    /**
     * Validate kriteria_id against API data.
     * Ensures submitted kriteria IDs are valid.
     */
    protected function validateKriteriaIds(array $kriteriaIds)
    {
        $kriteriaData = $this->fetchKriteria();
        if (!$kriteriaData) {
            return false; // Cannot validate if kriteria data cannot be fetched
        }

        $validIds = array_column($kriteriaData, 'kriteria_id');
        // Check if all provided kriteriaIds exist in the validIds list
        return empty(array_diff($kriteriaIds, $validIds));
    }

    /**
     * Display a listing of the laporan temuan.
     */
    public function index($auditingId)
    {
        try {
            $response = Http::timeout(30)->retry(2, 100)->get("{$this->apiBaseUrl}/laporan-temuan", [
                'auditing_id' => $auditingId
            ]);

            if (!$response->successful()) {
                Log::error('API kriteria failed with status: ' . $response->status() . ' Body: ' . $response->body());
                return redirect()->route('auditor.dashboard.index')
                    ->with('error', 'Gagal mengambil data laporan temuan. Status: ' . $response->status());
            }

            $apiResponse = $response->json();
            Log::info('API Response for auditingId ' . $auditingId . ': ' . json_encode($apiResponse));

            if (!isset($apiResponse['status']) || !is_array($apiResponse['data'])) {
                Log::error('Invalid API response structure (index): ' . json_encode($apiResponse));
                return redirect()->route('auditor.dashboard.index')
                    ->with('error', 'Format respons API tidak valid.');
            }

            if (!$apiResponse['status']) {
                Log::error('API returned status false (index): ' . ($apiResponse['message'] ?? 'No message provided'));
                return redirect()->route('auditor.dashboard.index')
                    ->with('error', $apiResponse['message'] ?? 'Gagal mengambil data laporan temuan.');
            }

            $laporanTemuans = $apiResponse['data'];
            $kriteriaMap = $this->getKriteriaMap();

            return view('auditor.laporan.index', compact('laporanTemuans', 'auditingId', 'kriteriaMap'));
        } catch (RequestException $e) {
            Log::error('Network error fetching laporan temuan (index): ' . $e->getMessage());
            return redirect()->route('auditor.dashboard.index')
                ->with('error', 'Koneksi ke API gagal. Silakan coba lagi.');
        } catch (\Exception $e) {
            Log::error('Unexpected error fetching laporan temuan (index): ' . $e->getMessage());
            return redirect()->route('auditor.dashboard.index')
                ->with('error', 'Gagal memuat data laporan temuan. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for creating a new laporan temuan.
     */
    public function create($auditingId)
    {
        $kriterias = $this->getKriteriaList();
        $kategori_temuan = ['NC', 'AOC', 'OFI'];

        if (empty($kriterias)) {
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('error', 'Failed to load criteria data. Please try again or contact administrator.');
        }

        return view('auditor.laporan.create', compact('auditingId', 'kriterias', 'kategori_temuan'));
    }

    /**
     * Store a newly created laporan temuan in storage.
     * This method now handles multiple findings, each associated with a single top-level kriteria.
     */
    public function store(Request $request, $auditingId)
    {
        Log::info('Store Laporan Temuan Request Data:', $request->all());

        // Validate the incoming nested structure
        $validator = Validator::make($request->all(), [
            'auditing_id' => 'required|numeric',
            'kriterias' => 'required|array|min:1', // At least one kriteria block
            'kriterias.*.kriteria_id' => 'required|numeric', // Kriteria ID for each block
            'kriterias.*.findings' => 'required|array|min:1', // At least one finding per kriteria block
            'kriterias.*.findings.*.uraian_temuan' => 'required|string|max:1000',
            'kriterias.*.findings.*.kategori_temuan' => 'required|in:NC,AOC,OFI',
            'kriterias.*.findings.*.saran_perbaikan' => 'nullable|string|max:1000',
        ], [
            'auditing_id.required' => 'Auditing ID is required.',
            'kriterias.required' => 'At least one standard block must be added.',
            'kriterias.min' => 'At least one standard block must be added.',
            'kriterias.*.kriteria_id.required' => 'Standard must be selected for each block.',
            'kriterias.*.kriteria_id.numeric' => 'Invalid standard ID format.',
            'kriterias.*.findings.required' => 'At least one finding must be entered for each standard.',
            'kriterias.*.findings.min' => 'At least one finding must be entered for each standard.',
            'kriterias.*.findings.*.uraian_temuan.required' => 'Finding description is required.',
            'kriterias.*.findings.*.kategori_temuan.required' => 'Finding category is required.',
            'kriterias.*.findings.*.kategori_temuan.in' => 'Finding category must be one of NC, AOC, or OFI.',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed for store laporan temuan:', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $allSuccess = true;
        $successMessages = [];
        $errorMessages = [];

        foreach ($request->kriterias as $kriteriaIndex => $kriteriaBlock) {
            $currentKriteriaId = (int)$kriteriaBlock['kriteria_id'];

            // Validate the kriteria ID for this block against the API's valid kriteria list
            if (!$this->validateKriteriaIds([$currentKriteriaId])) {
                $errorMessages[] = "Standard Block " . ($kriteriaIndex + 1) . ": Selected standard is invalid.";
                $allSuccess = false;
                continue; // Skip processing findings in this invalid block
            }

            foreach ($kriteriaBlock['findings'] as $findingIndex => $findingData) {
                // Each finding is associated with the kriteria of its parent block
                $kriteriaIdsForThisFinding = [$currentKriteriaId];

                // Prepare payload for a single finding
                $payload = [
                    'auditing_id' => (int)$auditingId,
                    'uraian_temuan' => trim($findingData['uraian_temuan']),
                    'kategori_temuan' => trim($findingData['kategori_temuan']),
                    'saran_perbaikan' => trim($findingData['saran_perbaikan'] ?? ''),
                    'kriteria_ids' => $kriteriaIdsForThisFinding, // Send as an array containing the single ID
                ];

                Log::info("Store Laporan Temuan API Payload for Kriteria #{$kriteriaIndex}, Finding #{$findingIndex}:", $payload);

                try {
                    $response = Http::timeout(30)->retry(2, 100)->post("{$this->apiBaseUrl}/laporan-temuan", $payload);

                    Log::info("API Response for Kriteria #{$kriteriaIndex}, Finding #{$findingIndex}:", [
                        'status' => $response->status(),
                        'body' => $response->json(),
                    ]);

                    if (!$response->successful()) {
                        $errorMessages[] = "Finding " . ($findingIndex + 1) . " in Standard Block " . ($kriteriaIndex + 1) . ": Failed to save. Status: " . $response->status() . ". Message: " . ($response->json()['message'] ?? 'No specific message.');
                        $allSuccess = false;
                    } else {
                        $apiResponse = $response->json();
                        if (!isset($apiResponse['status']) || !$apiResponse['status']) {
                            $errorMessages[] = "Finding " . ($findingIndex + 1) . " in Standard Block " . ($kriteriaIndex + 1) . ": Failed to save. Message: " . ($apiResponse['message'] ?? 'No specific message.');
                            $allSuccess = false;
                        } else {
                            $successMessages[] = "Finding " . ($findingIndex + 1) . " in Standard Block " . ($kriteriaIndex + 1) . " saved successfully.";
                        }
                    }
                } catch (RequestException $e) {
                    Log::error("Network error storing Kriteria #{$kriteriaIndex}, Finding #{$findingIndex}: " . $e->getMessage());
                    $errorMessages[] = "Finding " . ($findingIndex + 1) . " in Standard Block " . ($kriteriaIndex + 1) . ": API connection failed. " . $e->getMessage();
                    $allSuccess = false;
                } catch (\Exception $e) {
                    Log::error("Unexpected error storing Kriteria #{$kriteriaIndex}, Finding #{$findingIndex}: " . $e->getMessage());
                    $errorMessages[] = "Finding " . ($findingIndex + 1) . " in Standard Block " . ($kriteriaIndex + 1) . ": An unexpected error occurred. " . $e->getMessage();
                    $allSuccess = false;
                }
            }
        }

        // Return appropriate redirect based on results
        if ($allSuccess && !empty($successMessages)) {
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('success', implode('<br>', $successMessages));
        } elseif (!empty($errorMessages)) {
            return redirect()->back()
                ->with('error', implode('<br>', $errorMessages))
                ->withInput(); // Keep old input for fields that passed validation
        } else {
            return redirect()->back()
                ->with('error', 'No findings saved or a general error occurred.')
                ->withInput();
        }
    }

    /**
     * Store a new kriteria via API.
     * This method is called via AJAX from the 'create' form.
     */
    public function storeNewKriteria(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kriteria' => 'required|string|max:255|unique:kriteria,nama_kriteria', // Assuming 'kriteria' table and unique name
        ], [
            'nama_kriteria.required' => 'Standard name is required.',
            'nama_kriteria.unique' => 'This standard name already exists.',
            'nama_kriteria.max' => 'Standard name cannot exceed 255 characters.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422); // Unprocessable Entity
        }

        $namaKriteria = $request->nama_kriteria;

        try {
            // Assume your API has an endpoint for creating kriteria
            $response = Http::timeout(30)->post("{$this->apiBaseUrl}/kriteria", [
                'nama_kriteria' => $namaKriteria,
            ]);

            if (!$response->successful()) {
                Log::error('Failed to create new kriteria via API:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to save new standard. API message: ' . ($response->json()['message'] ?? 'No specific message.')
                ], $response->status());
            }

            $apiResponse = $response->json();

            if (!isset($apiResponse['status']) || !$apiResponse['status']) {
                Log::error('API response for new kriteria creation indicates failure:', $apiResponse);
                return response()->json([
                    'status' => false,
                    'message' => $apiResponse['message'] ?? 'Failed to save new standard.'
                ], 400); // Bad Request
            }

            // Clear the cache for kriteria data so the next fetch will get the new one
            Cache::forget('kriteria_data');

            // Return the newly created kriteria data (assuming API returns it)
            return response()->json([
                'status' => true,
                'message' => $apiResponse['message'] ?? 'Standard added successfully.',
                'kriteria' => [
                    'kriteria_id' => $apiResponse['data']['kriteria_id'] ?? null, // Adjust based on actual API response structure
                    'nama_kriteria' => $apiResponse['data']['nama_kriteria'] ?? $namaKriteria, // Adjust based on actual API response structure
                ]
            ], 201); // Created
        } catch (RequestException $e) {
            Log::error('Network error creating new kriteria:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'API connection failed while trying to add standard.'
            ], 500); // Internal Server Error
        } catch (\Exception $e) {
            Log::error('Unexpected error creating new kriteria:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occurred while adding standard.'
            ], 500);
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
                Log::error('Failed to fetch laporan temuan (show): Status ' . $response->status() . ' Body: ' . $response->body());
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal mengambil data laporan temuan. Status: ' . $response->status());
            }

            $apiResponse = $response->json();
            Log::info('API Response for laporan_temuan_id ' . $laporan_temuan_id . ': ' . json_encode($apiResponse));

            if (!isset($apiResponse['status']) || !isset($apiResponse['data']) || !is_array($apiResponse['data'])) {
                Log::error('Invalid API response structure (show): ' . json_encode($apiResponse));
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Format respons API tidak valid.');
            }

            if (!$apiResponse['status']) {
                Log::error('API returned status false (show): ' . ($apiResponse['message'] ?? 'No message provided'));
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', $apiResponse['message'] ?? 'Gagal mengambil data laporan temuan.');
            }

            $laporan = $apiResponse['data'];
            $kriteriaMap = $this->getKriteriaMap();

            return view('auditor.laporan.detail', compact('laporan', 'auditingId', 'kriteriaMap'));
        } catch (RequestException $e) {
            Log::error('Network error fetching laporan temuan (show): ' . $e->getMessage());
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('error', 'Koneksi ke API gagal. Silakan coba lagi.');
        } catch (\Exception $e) {
            Log::error('Unexpected error fetching laporan temuan (show): ' . $e->getMessage());
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('error', 'Gagal memuat data laporan temuan. Silakan coba lagi.');
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
                Log::error('Failed to fetch laporan temuan from API (edit):', [
                    'laporan_temuan_id' => $laporan_temuan_id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal memuat laporan temuan. Silakan coba lagi.');
            }

            $apiResponse = $response->json();
            if (!isset($apiResponse['data']) || empty($apiResponse['data'])) {
                Log::warning('Empty or invalid laporan temuan data from API (edit):', ['response' => $apiResponse]);
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Laporan temuan tidak ditemukan.');
            }

            $laporan = $apiResponse['data'];
            if ((string)$laporan['auditing_id'] !== (string)$auditingId) { // Cast to string for strict comparison
                Log::warning('Mismatched auditingId for laporan_temuan_id (edit): ' . $laporan_temuan_id . ' from API: ' . $laporan['auditing_id'] . ' vs route: ' . $auditingId);
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Laporan temuan tidak ditemukan untuk audit ini.');
            }

            $kriterias = $this->getKriteriaList();
            $kategori_temuan = ['NC', 'AOC', 'OFI'];

            if (empty($kriterias)) {
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Gagal memuat data kriteria. Silakan coba lagi atau hubungi administrator.');
            }

            // Extract associated kriteria IDs for pre-selection in multi-select
            $selectedKriteriaIds = [];
            if (isset($laporan['kriterias']) && is_array($laporan['kriterias'])) {
                $selectedKriteriaIds = collect($laporan['kriterias'])->pluck('kriteria_id')->toArray();
            }

            $findingData = [
                'laporan_temuan_id' => $laporan['laporan_temuan_id'],
                'auditing_id' => $laporan['auditing_id'],
                'uraian_temuan' => $laporan['uraian_temuan'],
                'kategori_temuan' => $laporan['kategori_temuan'],
                'saran_perbaikan' => $laporan['saran_perbaikan'],
                'selected_kriteria_ids' => $selectedKriteriaIds, // Pass selected IDs for the multi-select
            ];

            return view('auditor.laporan.edit', compact('auditingId', 'kriterias', 'kategori_temuan', 'findingData'));
        } catch (RequestException $e) {
            Log::error('Request exception while fetching laporan temuan (edit):', [
                'laporan_temuan_id' => $laporan_temuan_id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()
                ->with('error', 'Gagal memuat laporan temuan. Silakan coba lagi atau hubungi administrator.');
        } catch (\Exception $e) {
            Log::error('Unexpected error fetching laporan temuan (edit): ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memuat laporan temuan. Silakan coba lagi.')
                ->withInput();
        }
    }


    /**
     * Update the specified laporan temuan in storage.
     */
    public function update(Request $request, $auditingId, $laporan_temuan_id)
    {
        Log::info('Update Laporan Temuan Request Data:', $request->all());

        $validator = Validator::make($request->all(), [
            'auditing_id' => 'required|numeric',
            'uraian_temuan' => 'required|string|max:1000',
            'kategori_temuan' => 'required|in:NC,AOC,OFI',
            'saran_perbaikan' => 'nullable|string|max:1000',
            'kriteria_ids' => 'required|array|min:1', // At least one criteria
            'kriteria_ids.*' => 'required|numeric', // Each kriteria_id is numeric
        ], [
            'auditing_id.required' => 'Auditing ID is required.',
            'uraian_temuan.required' => 'Finding description is required.',
            'kategori_temuan.required' => 'Finding category is required.',
            'kategori_temuan.in' => 'Finding category must be one of NC, AOC, or OFI.',
            'kriteria_ids.required' => 'At least one related standard must be selected.',
            'kriteria_ids.min' => 'At least one related standard must be selected.',
            'kriteria_ids.*.numeric' => 'Invalid standard ID format.',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed for update laporan temuan:', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kriteriaIds = array_map('intval', $request->kriteria_ids);
        if (!$this->validateKriteriaIds($kriteriaIds)) {
            Log::warning('Invalid kriteria IDs:', ['kriteria_ids' => $kriteriaIds]);
            return redirect()->back()
                ->withErrors(['kriteria_ids' => 'One or more selected criteria are invalid.'])
                ->withInput();
        }

        $payload = [
            'auditing_id' => (int)$auditingId,
            'uraian_temuan' => trim($request->uraian_temuan),
            'kategori_temuan' => trim($request->kategori_temuan),
            'saran_perbaikan' => trim($request->saran_perbaikan ?? ''),
            'kriteria_ids' => $kriteriaIds, // Send as an array
        ];

        Log::info('Update Laporan Temuan API Payload:', $payload);

        try {
            $response = Http::timeout(30)->retry(2, 100)->put("{$this->apiBaseUrl}/laporan-temuan/{$laporan_temuan_id}", $payload);

            Log::info('Update Laporan Temuan API Response:', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            if ($response->successful()) {
                $apiResponse = $response->json();
                if (!isset($apiResponse['status']) || !$apiResponse['status']) {
                    Log::error('API update failed: ' . ($apiResponse['message'] ?? 'No message provided'));
                    return redirect()->back()
                        ->with('error', $apiResponse['message'] ?? 'Failed to update finding report.')
                        ->withInput();
                }
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('success', 'Finding report updated successfully.');
            } else {
                Log::error('Failed to update laporan temuan via API', [
                    'laporan_temuan_id' => $laporan_temuan_id,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return redirect()->back()
                    ->with('error', 'Failed to update finding report. API message: ' . ($response->json()['message'] ?? 'No specific message.'))
                    ->withInput();
            }
        } catch (RequestException $e) {
            Log::error('Request exception while updating laporan temuan:', [
                'laporan_temuan_id' => $laporan_temuan_id,
                'error' => $e->getMessage(),
            ]);
            return redirect()->back()
                ->with('error', 'Failed to update finding report. Please try again or contact administrator.')
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected error updating laporan temuan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to update finding report. Please try again.')
                ->withInput();
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
                Log::error('Failed to delete laporan temuan: Status ' . $response->status() . ' Body: ' . $response->body());
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', 'Failed to delete finding report. Status: ' . $response->status());
            }

            $apiResponse = $response->json();
            if (!isset($apiResponse['status']) || !$apiResponse['status']) {
                Log::error('API delete failed: ' . ($apiResponse['message'] ?? 'No message provided'));
                return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                    ->with('error', $apiResponse['message'] ?? 'Failed to delete finding report.');
            }

            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('success', 'Finding report deleted successfully.');
        } catch (RequestException $e) {
            Log::error('Network error deleting laporan temuan: ' . $e->getMessage());
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('error', 'API connection failed. Please try again.');
        } catch (\Exception $e) {
            Log::error('Unexpected error deleting laporan temuan: ' . $e->getMessage());
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('error', 'Failed to delete finding report. Please try again.');
        }
    }
}
