<?php

namespace App\Http\Controllers;

use App\Models\LaporanTemuan;
use App\Models\Auditing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\DB;

class LaporanTemuanController extends Controller
{
    /**
     * Helper method to fetch kriteria from API.
     */
    protected function fetchKriteria()
    {
        try {
            $response = Http::timeout(30)->retry(2, 100)->get('http://127.0.0.1:5000/api/kriteria');

            if ($response->successful()) {
                $kriteriaData = $response->json();

                if (!is_array($kriteriaData)) {
                    \Log::error('API kriteria returned invalid format: ' . json_encode($kriteriaData));
                    throw new \Exception('Format data kriteria tidak valid.');
                }

                $filteredData = array_filter($kriteriaData, fn($item) =>
                    is_array($item) &&
                    isset($item['kriteria_id'], $item['nama_kriteria']) &&
                    is_numeric($item['kriteria_id']) &&
                    is_string($item['nama_kriteria'])
                );

                if (empty($filteredData)) {
                    \Log::warning('No valid kriteria data after filtering.');
                    throw new \Exception('Tidak ada data kriteria yang valid dari API.');
                }

                return $filteredData;
            }

            \Log::error('API kriteria failed with status: ' . $response->status());
            throw new \Exception('Gagal mengambil data kriteria dari API. Status: ' . $response->status());
        } catch (\Exception $e) {
            \Log::error('Failed to fetch kriteria from API: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create kriteria map for view.
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
     */
    protected function validateKriteriaIds(array $kriteriaIds)
    {
        $kriteriaData = $this->fetchKriteria();
        if (!$kriteriaData) {
            return false;
        }

        $validIds = array_column($kriteriaData, 'kriteria_id');
        return empty(array_diff($kriteriaIds, $validIds));
    }

    /**
     * Display a listing of the laporan temuan.
     */
    public function index($auditingId)
    {
        $auditing = Auditing::findOrFail($auditingId);
        $laporanTemuans = LaporanTemuan::where('auditing_id', $auditingId)->with('kriterias')->get();
        $kriteriaMap = $this->getKriteriaMap();

        return view('auditor.laporan.index', compact('laporanTemuans', 'auditingId', 'kriteriaMap', 'auditing'));
    }

    /**
     * Show the form for creating a new laporan temuan.
     */
    public function create($auditingId)
    {
        $auditing = Auditing::findOrFail($auditingId);
        $kriterias = $this->getKriteriaList();
        $kategori_temuan = ['NC', 'AOC', 'OFI'];

        if (empty($kriterias)) {
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('error', 'Gagal memuat data kriteria. Silakan coba lagi atau hubungi administrator.');
        }

        return view('auditor.laporan.create', compact('auditingId', 'kriterias', 'kategori_temuan', 'auditing'));
    }

    /**
     * Store a newly created laporan temuan in storage.
     */
    public function store(Request $request, $auditingId)
    {
        $validator = Validator::make($request->all(), [
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'standar.*.kriteria_id' => 'required|numeric',
            'standar.*.uraian_temuan.*' => 'required|string|max:1000',
            'standar.*.kategori_temuan.*' => 'required|in:NC,AOC,OFI',
            'standar.*.saran_perbaikan.*' => 'nullable|string|max:1000',
        ], [
            'auditing_id.required' => 'ID auditing wajib diisi.',
            'standar.*.kriteria_id.required' => 'Standar wajib dipilih.',
            'standar.*.uraian_temuan.*.required' => 'Uraian temuan wajib diisi.',
            'standar.*.kategori_temuan.*.required' => 'Kategori temuan wajib dipilih.',
            'standar.*.kategori_temuan.*.in' => 'Kategori temuan harus salah satu dari NC, AOC, atau OFI.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kriteriaIds = array_map(fn($standar) => trim($standar['kriteria_id']), $request->standar);
        if (!$this->validateKriteriaIds($kriteriaIds)) {
            return redirect()->back()
                ->withErrors(['standar' => 'Salah satu atau lebih kriteria tidak valid.'])
                ->withInput();
        }

        $uraianTemuans = [];
        $kategoriTemuans = [];
        $saranPerbaikans = [];

        foreach ($request->standar as $standar) {
            foreach ($standar['uraian_temuan'] as $index => $uraian) {
                $uraianTemuans[] = str_replace(',', ';', trim($uraian));
                $kategoriTemuans[] = $standar['kategori_temuan'][$index] ?? 'NC';
                $saranPerbaikans[] = !empty($standar['saran_perbaikan'][$index] ?? '')
                    ? str_replace(',', ';', trim($standar['saran_perbaikan'][$index]))
                    : '';
            }
        }

        DB::transaction(function () use ($auditingId, $kriteriaIds, $uraianTemuans, $kategoriTemuans, $saranPerbaikans) {
            $laporan = LaporanTemuan::create([
                'auditing_id' => $auditingId,
                'uraian_temuan' => implode(',', $uraianTemuans),
                'kategori_temuan' => implode(',', $kategoriTemuans),
                'saran_perbaikan' => implode(',', $saranPerbaikans),
            ]);

            $laporan->kriterias()->sync(array_unique($kriteriaIds));
        });

        return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
            ->with('success', 'Laporan temuan berhasil disimpan.');
    }

    /**
     * Display the specified laporan temuan.
     */
    public function show($laporan_temuan_id)
    {
        $laporan = LaporanTemuan::with('kriterias')->findOrFail($laporan_temuan_id);
        $auditingId = $laporan->auditing_id;
        $kriteriaMap = $this->getKriteriaMap();

        return view('auditor.laporan.detail', compact('laporan', 'auditingId', 'kriteriaMap'));
    }

    /**
     * Show the form for editing the specified laporan temuan.
     */
    public function edit($laporan_temuan_id)
    {
        $laporan = LaporanTemuan::with('kriterias')->findOrFail($laporan_temuan_id);
        $auditingId = $laporan->auditing_id;
        $kriterias = $this->getKriteriaList();
        $kategori_temuan = ['NC', 'AOC', 'OFI'];

        if (empty($kriterias)) {
            return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
                ->with('error', 'Gagal memuat data kriteria. Silakan coba lagi atau hubungi administrator.');
        }

        return view('auditor.laporan.edit', compact('laporan', 'auditingId', 'kriterias', 'kategori_temuan'));
    }

    /**
     * Update the specified laporan temuan in storage.
     */
    public function update(Request $request, $laporan_temuan_id)
    {
        $laporan = LaporanTemuan::findOrFail($laporan_temuan_id);
        $auditingId = $laporan->auditing_id;

        $validator = Validator::make($request->all(), [
            'auditing_id' => 'required|exists:auditings,auditing_id',
            'standar.*.kriteria_id' => 'required|numeric',
            'standar.*.uraian_temuan.*' => 'required|string|max:1000',
            'standar.*.kategori_temuan.*' => 'required|in:NC,AOC,OFI',
            'standar.*.saran_perbaikan.*' => 'nullable|string|max:1000',
        ], [
            'auditing_id.required' => 'ID auditing wajib diisi.',
            'standar.*.kriteria_id.required' => 'Standar wajib dipilih.',
            'standar.*.uraian_temuan.*.required' => 'Uraian temuan wajib diisi.',
            'standar.*.kategori_temuan.*.required' => 'Kategori temuan wajib dipilih.',
            'standar.*.kategori_temuan.*.in' => 'Kategori temuan harus salah satu dari NC, AOC, atau OFI.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kriteriaIds = array_map(fn($standar) => trim($standar['kriteria_id']), $request->standar);
        if (!$this->validateKriteriaIds($kriteriaIds)) {
            return redirect()->back()
                ->withErrors(['standar' => 'Salah satu atau lebih kriteria tidak valid.'])
                ->withInput();
        }

        $uraianTemuans = [];
        $kategoriTemuans = [];
        $saranPerbaikans = [];

        foreach ($request->standar as $standar) {
            foreach ($standar['uraian_temuan'] as $index => $uraian) {
                $uraianTemuans[] = str_replace(',', ';', trim($uraian));
                $kategoriTemuans[] = $standar['kategori_temuan'][$index] ?? 'NC';
                $saranPerbaikans[] = !empty($standar['saran_perbaikan'][$index] ?? '')
                    ? str_replace(',', ';', trim($standar['saran_perbaikan'][$index]))
                    : '';
            }
        }

        DB::transaction(function () use ($laporan, $kriteriaIds, $uraianTemuans, $kategoriTemuans, $saranPerbaikans) {
            $laporan->update([
                'auditing_id' => $laporan->auditing_id,
                'uraian_temuan' => implode(',', $uraianTemuans),
                'kategori_temuan' => implode(',', $kategoriTemuans),
                'saran_perbaikan' => implode(',', $saranPerbaikans),
            ]);

            $laporan->kriterias()->sync(array_unique($kriteriaIds));
        });

        return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
            ->with('success', 'Laporan temuan berhasil diperbarui.');
    }

    /**
     * Remove the specified laporan temuan from storage.
     */
    public function destroy($laporan_temuan_id)
    {
        $laporan = LaporanTemuan::findOrFail($laporan_temuan_id);
        $auditingId = $laporan->auditing_id;

        $laporan->delete();

        return redirect()->route('auditor.laporan.index', ['auditingId' => $auditingId])
            ->with('success', 'Laporan temuan berhasil dihapus.');
    }
}

