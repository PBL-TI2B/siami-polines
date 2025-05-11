<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Role;
use App\Models\UnitKerja;

class DataUserController extends Controller
{
    private const API_BASE_URL = 'http://127.0.0.1:5000/api/data-user';

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('entries', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $response = Http::get(self::API_BASE_URL, [
            'search' => $search,
            'per_page' => $perPage,
            'page' => $currentPage,
        ]);

        if (!$response->successful()) {
            Log::error('Failed to fetch users from API', ['response' => $response->body()]);
            return view('admin.data-user.index', [
                'users' => new LengthAwarePaginator([], 0, $perPage)
            ])->with('error', 'Gagal mengambil data dari API.');
        }

        $json = $response->json();
        $usersArray = $json['data'] ?? [];
        $total = $json['total'] ?? count($usersArray); // asumsi API mengembalikan total

        $users = new LengthAwarePaginator(
            $usersArray,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.data-user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $unit_kerjas = UnitKerja::all();
        return view('admin.data-user.tambah', compact('roles', 'unit_kerjas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nip' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'roles' => 'required|exists:roles,nama_role',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,unit_kerja_id',
        ]);

        $role = Role::where('nama_role', $validated['roles'])->first();

        $payload = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'password' => Hash::make($validated['password']),
            'unit_kerja_id' => $validated['unit_kerja_id'],
            'role_id' => $role->role_id,
        ];

        $response = Http::post(self::API_BASE_URL, $payload);

        if (!$response->successful()) {
            Log::error('Failed to store user', ['response' => $response->body()]);
            return redirect()->back()->with('error', 'Gagal menambahkan user ke API.');
        }

        return redirect()->route('admin.data-user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show($id)
    {
        $response = Http::get(self::API_BASE_URL . "/{$id}");

        if (!$response->successful()) {
            Log::error('Failed to fetch user', ['id' => $id, 'response' => $response->body()]);
            return redirect()->route('admin.data-user.index')->with('error', 'Gagal mengambil data user dari API.');
        }

        $user = $response->json()['data'] ?? null;

        if (!$user) {
            return redirect()->route('admin.data-user.index')->with('error', 'User tidak ditemukan.');
        }

        return view('admin.data-user.show', compact('user'));
    }

    public function edit($id)
    {
        $response = Http::get(self::API_BASE_URL . "/{$id}");

        if (!$response->successful()) {
            Log::error('Failed to fetch user for edit', ['id' => $id, 'response' => $response->body()]);
            return redirect()->route('admin.data-user.index')->with('error', 'Gagal mengambil data user dari API.');
        }

        $user = $response->json()['data'] ?? null;

        if (!$user) {
            return redirect()->route('admin.data-user.index')->with('error', 'User tidak ditemukan.');
        }

        $roles = Role::all();
        return view('admin.data-user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nip' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'roles' => 'required|exists:roles,nama_role',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,unit_kerja_id',
        ]);

        $role = Role::where('nama_role', $validated['roles'])->first();

        $payload = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'unit_kerja_id' => $validated['unit_kerja_id'],
            'role_id' => $role->role_id,
        ];

        if (!empty($validated['password'])) {
            $payload['password'] = Hash::make($validated['password']);
        }

        $response = Http::put(self::API_BASE_URL . "/{$id}", $payload);

        if (!$response->successful()) {
            Log::error('Failed to update user', ['id' => $id, 'response' => $response->body()]);
            return redirect()->back()->with('error', 'Gagal memperbarui user di API.');
        }

        return redirect()->route('admin.data-user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $response = Http::delete(self::API_BASE_URL . "/{$id}");

        if (!$response->successful()) {
            Log::error('Failed to delete user', ['id' => $id, 'response' => $response->body()]);
            return redirect()->route('admin.data-user.index')->with('error', 'Gagal menghapus user dari API.');
        }

        return redirect()->route('admin.data-user.index')->with('success', 'User berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_users', []);

        if (empty($ids)) {
            return redirect()->route('admin.data-user.index')->with('error', 'Tidak ada user yang dipilih.');
        }

        $response = Http::post(self::API_BASE_URL . '/bulk-destroy', ['ids' => $ids]);

        if (!$response->successful()) {
            Log::error('Failed to bulk delete users', ['response' => $response->body()]);
            return redirect()->route('admin.data-user.index')->with('error', 'Gagal menghapus user dari API.');
        }

        return redirect()->route('admin.data-user.index')->with('success', 'Users berhasil dihapus');
    }
}
