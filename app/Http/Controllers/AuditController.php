<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function auditeeIndexPage()
    {
        return view('auditee.audit.index');
    }

    public function getAuditingsByUser()
    {
        $userId = session('user')['user_id'] ?? null;

        if (!$userId) {
            return response()->json(['message' => 'User tidak login'], 401);
        }

        try {
            $response = Http::get("http://127.0.0.1:5000/api/auditings/userID={$userId}");

            if ($response->successful()) {
                $data = $response->json();

                // Ambil jenis_unit_id jika tersedia
                $jenisUnitId = $data['data'][0]['unit_kerja']['jenis_unit_id'] ?? null;
                $auditingId = $data['data'][0]['auditing_id'] ?? null;
                $status = $data['data'][0]['status'] ?? null;
                $unitKerjaId = $data['data'][0]['unit_kerja']['unit_kerja_id'] ?? null;

                // Simpan ke session (opsional)
                if ($jenisUnitId !== null) {
                    session(['jenis_unit_id' => $jenisUnitId]);
                }
                if ($auditingId !== null) {
                    session(['auditing_id' => $auditingId]);
                }
                if ($status !== null) {
                    session(['status' => $status]);
                }
                if ($unitKerjaId !== null) {
                    session(['unit_kerja_id' => $unitKerjaId]);
                }

                // Kembalikan respons seperti biasa, bisa juga sertakan jenis_unit_id
                return response()->json([
                    'message' => $data['message'],
                    'jenis_unit_id' => $jenisUnitId,
                    'data' => $data['data']
                ]);
            } else {
                return response()->json([
                    'message' => 'Gagal mengambil data dari API',
                    'status' => $response->status(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menghubungi API',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function auditorIndexPage()
    {
        return view('auditor.audit.index');
    }

     public function auditorAuditPage()
    {
        return view('auditor.audit.audit');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
