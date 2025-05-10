<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index()
    {
        if (session('token') && session('role_id')) {
            $role = Role::find(session('role_id'));
            return redirect($role->prefix . '/dashboard');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $response = Http::asJson()->post('http://localhost:5000/api/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $result = $response->json();

                if (empty($result['token']) || empty($result['role']) || empty($result['dashboard_url'])) {
                    Log::error('Invalid API response: Missing token, role, or dashboard_url', [
                        'response' => $result,
                    ]);
                    return back()->withErrors('Respons server tidak valid.');
                }

                $role = Role::whereRaw('LOWER(nama_role) = ?', [strtolower($result['role'])])
                    ->orWhere('prefix', $result['role'])
                    ->first();

                if (!$role) {
                    Log::error('Role not found in database', [
                        'api_role' => $result['role'],
                    ]);
                    return back()->withErrors('Peran tidak ditemukan di sistem.');
                }

                session([
                    'token' => $result['token'],
                    'user' => $result['user'] ?? null,
                    'role_id' => $role->role_id,
                    'role_name' => $role->nama_role,
                    'prefix' => $role->prefix,
                ]);

                Log::info('User logged in successfully', [
                    'email' => $request->email,
                    'role_id' => $role->role_id,
                    'role_name' => $role->nama_role,
                ]);

                return redirect($result['dashboard_url']);
            } else {
                $error = $response->json('message') ?? 'Login gagal: Kesalahan server.';
                Log::warning('API login failed', [
                    'status' => $response->status(),
                    'error' => $error,
                    'response' => $response->body(),
                ]);
                return back()->withErrors($error);
            }
        } catch (\Exception $e) {
            Log::error('Failed to connect to login API', [
                'error' => $e->getMessage(),
                'email' => $request->email,
            ]);
            return back()->withErrors('Tidak dapat menghubungi server login: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $token = session('token');

        if ($token) {
            try {
                $response = Http::withToken($token)->delete('http://localhost:5000/api/logout');

                if ($response->successful()) {
                    Log::info('User logged out successfully via API', [
                        'token' => substr($token, 0, 10) . '...',
                    ]);
                } else {
                    Log::warning('API logout failed', [
                        'status' => $response->status(),
                        'response' => $response->body(),
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Failed to connect to logout API', [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        session()->flush();

        Log::info('Session cleared on logout');

        return redirect()->route('login');
    }
}
