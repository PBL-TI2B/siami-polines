<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class DataUserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request): JsonResponse
    {
        $query = User::query()->with(['role', 'unitKerja']);

        // Apply search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // Apply filters (opsional)
        if ($roleId = $request->input('role_id')) {
            $query->where('role_id', $roleId);
        }

        if ($unitKerjaId = $request->input('unit_kerja_id')) {
            $query->where('unit_kerja_id', $unitKerjaId);
        }

        // Apply pagination
        $perPage = $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;
        $users = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $users->items(),
            'meta' => [
                'current_page' => $users->currentPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
                'last_page' => $users->lastPage(),
            ],
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'nip' => 'required|string|max:255|unique:users,nip',
                'password' => 'required|string|min:8',
                'role_id' => 'required|exists:roles,role_id',
                'unit_kerja_id' => 'required|exists:unit_kerja,unit_kerja_id',
            ]);

            $data = [
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'nip' => $validated['nip'],
                'password' => bcrypt($validated['password']),
                'role_id' => $validated['role_id'],
                'unit_kerja_id' => $validated['unit_kerja_id'],
            ];

            $user = User::create($data);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user->load(['role', 'unitKerja']),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Display the specified user.
     */
    public function show($id): JsonResponse
    {
        $user = User::with(['role', 'unitKerja'])->find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $user]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id . ',user_id',
                'nip' => 'required|string|max:255|unique:users,nip,' . $id . ',user_id',
                'password' => 'nullable|string|min:8',
                'role_id' => 'required|exists:roles,role_id',
                'unit_kerja_id' => 'required|exists:unit_kerja,unit_kerja_id',
            ]);

            $data = [
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                'nip' => $validated['nip'],
                'role_id' => $validated['role_id'],
                'unit_kerja_id' => $validated['unit_kerja_id'],
            ];

            if ($validated['password']) {
                $data['password'] = bcrypt($validated['password']);
            }

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user->load(['role', 'unitKerja']),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        // Pastikan tidak ada relasi yang bergantung (opsional)
        if ($user->auditor1Auditings()->exists() ||
            $user->auditor2Auditings()->exists() ||
            $user->auditee1Auditings()->exists() ||
            $user->auditee2Auditings()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete user with existing auditings',
            ], 422);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }

    /**
     * Remove multiple users.
     */
    public function bulkDestroy(Request $request): JsonResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No IDs provided'], 422);
        }

        // Cek apakah ada user dengan relasi auditing
        $usersWithAuditings = User::whereIn('user_id', $ids)
            ->where(function ($query) {
                $query->whereHas('auditor1Auditings')
                      ->orWhereHas('auditor2Auditings')
                      ->orWhereHas('auditee1Auditings')
                      ->orWhereHas('auditee2Auditings');
            })
            ->exists();

        if ($usersWithAuditings) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete users with existing auditings',
            ], 422);
        }

        User::whereIn('user_id', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Users deleted successfully']);
    }
}
