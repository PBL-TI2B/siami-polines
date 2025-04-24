<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataUserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        //$this->middleware('auth');
        // Tambahkan middleware untuk otorisasi jika hanya admin yang boleh akses
        // $this->middleware('role:admin');
    }

    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Pencarian berdasarkan nama, email, atau NIP
        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%');
        }

        // Jumlah entri per halaman
        $perPage = $request->input('entries', 10);

        $users = $query->paginate($perPage)->appends(['search' => $search, 'entries' => $perPage]);

        return view('admin.data-user.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.data-user.tambah');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|max:2048', // Maksimum 2MB
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|string|max:255|unique:users,nip',
            'password' => 'required|string|min:8',
            'roles' => 'required|array|min:1',
            'roles.*' => 'in:Admin,Admin Unit,Auditor,Auditee,Kepala PMPP',
        ]);

        try {
            $user = new User();
            $user->name = $validated['nama'];
            $user->email = $validated['email'];
            $user->nip = $validated['nip'];
            $user->password = bcrypt($validated['password']);
            $user->roles = json_encode($validated['roles']);

            if ($request->hasFile('photo')) {
                $user->photo = $request->file('photo')->store('photos', 'public');
            }

            $user->save();

            return redirect()->route('data-user.index')->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menambahkan user: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.data-user.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'photo' => 'nullable|image|max:2048',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nip' => 'required|string|max:255|unique:users,nip,' . $id,
            'password' => 'nullable|string|min:8',
            'roles' => 'required|array|min:1',
            'roles.*' => 'in:Admin,Admin Unit,Auditor,Auditee,Kepala PMPP',
        ]);

        $user->name = $validated['nama'];
        $user->email = $validated['email'];
        $user->nip = $validated['nip'];
        if ($validated['password']) {
            $user->password = bcrypt($validated['password']);
        }
        $user->roles = json_encode($validated['roles']);
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('photos', 'public');
        }
        $user->save();

        return redirect()->route('data-user.index')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus foto jika ada
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('data-user.index')->with('success', 'User berhasil dihapus');
    }
}
