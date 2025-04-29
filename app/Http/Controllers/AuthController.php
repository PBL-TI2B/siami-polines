<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            // Kirim POST JSON ke API login
            $response = Http::asJson()->post('http://localhost:5000/api/login', [
                'email' => $request->email,
                'password' => $request->password
            ]);

            if ($response->successful()) {
                $result = $response->json();

                session([
                    'token' => $result['token'],
                    'user' => $result['user'] ?? null,
                ]);

                // << Inilah yang langsung lempar ke dashboard_url
                return redirect($result['dashboard_url']);
            } else {
                // API mengembalikan error
                $error = $response->json('message') ?? 'Login gagal.';
                return back()->withErrors($error);
            }
        } catch (\Exception $e) {
            // Gagal koneksi ke API
            return back()->withErrors('Tidak dapat menghubungi server login.');
        }
    }
}