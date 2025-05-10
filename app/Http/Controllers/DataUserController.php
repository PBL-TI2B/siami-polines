<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DataUserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('entries', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $users = $query->with('role')->paginate($perPage)->appends(['search' => $search, 'entries' => $perPage]);

        return view('admin.data-user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.data-user.tambah');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'nip' => 'required|string|max:255|unique:users,nip',
            'password' => 'required|string|min:8',
            'roles' => 'required|string|in:Admin,Admin Unit,Auditor,Auditee,Kepala PMPP', // Hanya satu role
            'unit_kerja_id' => 'nullable|exists:unit_kerja,unit_kerja_id',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('photos', 'public');
        }

        // Cari role berdasarkan nama
        $role = Role::where('nama_role', $validated['roles'])->first();

        if (!$role) {
            return redirect()->back()->withErrors(['roles' => 'Role tidak ditemukan.']);
        }

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'password' => Hash::make($validated['password']),
            'photo' => $fotoPath,
            'unit_kerja_id' => $validated['unit_kerja_id'],
            'role_id' => $role->role_id,
        ]);

        return redirect()->route('admin.data-user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::with('role')->findOrFail($id);
        return view('admin.data-user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id . ',user_id',
            'nip' => 'required|string|max:255|unique:users,nip,' . $id . ',user_id',
            'password' => 'nullable|string|min:8',
            'roles' => 'required|string|in:Admin,Admin Unit,Auditor,Auditee,Kepala PMPP',
            'unit_kerja_id' => 'nullable|exists:unit_kerja,unit_kerja_id',
        ]);

        $fotoPath = $user->photo;
        if ($request->hasFile('foto')) {
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('photos', 'public');
        }

        // Cari role berdasarkan nama
        $role = Role::where('nama_role', $validated['roles'])->first();

        if (!$role) {
            return redirect()->back()->withErrors(['roles' => 'Role tidak ditemukan.']);
        }

        $user->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            'photo' => $fotoPath,
            'unit_kerja_id' => $validated['unit_kerja_id'] ?? $user->unit_kerja_id,
            'role_id' => $role->role_id,
        ]);

        return redirect()->route('admin.data-user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('admin.data-user.index')->with('success', 'User berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_users', []);

        if (!empty($ids)) {
            $users = User::whereIn('user_id', $ids)->get();
            foreach ($users as $user) {
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                $user->delete();
            }
            return redirect()->route('admin.data-user.index')->with('success', 'Users berhasil dihapus');
        }

        return redirect()->route('admin.data-user.index')->with('error', 'Tidak ada user yang dipilih.');
    }
}
