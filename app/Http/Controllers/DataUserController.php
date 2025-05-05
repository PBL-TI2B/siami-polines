<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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

        $users = $query->paginate($perPage)->appends(['search' => $search, 'entries' => $perPage]);

        \Log::info('Users data: ', $users->toArray());

        return view('admin.data-user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.data-user.tambah');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'nip' => 'required|string|max:255|unique:users,nip',
            'password' => 'required|string|min:8',
            'roles' => 'required|in:Admin,Admin Unit,Auditor,Auditee,Kepala PMPP',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'password' => bcrypt($validated['password']),
            'role' => ['nama_role' => $validated['roles']],
            'photo' => $photoPath,
        ]);

        return redirect()->route('data-user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.data-user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'nip' => 'required|string|max:255|unique:users,nip,' . $id,
            'password' => 'nullable|string|min:8',
            'roles' => 'required|in:Admin,Admin Unit,Auditor,Auditee,Kepala PMPP',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
            'role' => ['nama_role' => $validated['roles']],
            'photo' => $validated['photo'] ?? $user->photo,
        ]);

        return redirect()->route('data-user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('data-user.index')->with('success', 'User berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('selected_users', []);

        \Log::info('Bulk destroy IDs: ', $ids);

        if (!empty($ids)) {
            $users = User::whereIn('id', $ids)->get();
            foreach ($users as $user) {
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                $user->delete();
            }
            return redirect()->route('data-user.index')->with('success', 'Users berhasil dihapus');
        }

        return redirect()->route('data-user.index')->with('error', 'Tidak ada user yang dipilih.');
    }
}
