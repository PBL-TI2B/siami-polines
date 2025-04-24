<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SasaranStrategis;

class SasaranStrategisController extends Controller
{
    //


    public function store(Request $request)
    {
        $request->validate([
            'nama_sasaran' => 'required|string|max:255',
        ]);

        $sasaran = SasaranStrategis::create([
            'nama_sasaran' => $request->nama_sasaran,
        ]);

        return response()->json([
            'message' => 'Sasaran Strategis berhasil ditambahkan',
            'data' => $sasaran,
        ], 201);
    }
}
