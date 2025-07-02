<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function editpassword()
    {
        return view('profile.pengaturan-akun');
    }
    public function editprofile()
    {
        return view('profile.editProfile');
    }
    public function profile()
    {
        return view('profile.profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'old_password' => 'required_with:password|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Verify old password if new password is provided
        if ($request->filled('password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Password lama salah.']);
            }
            $user->password = bcrypt($request->password);
        }

        $user->nama = $request->nama;
        $user->save();

        return back()->with('success', 'Akun berhasil diperbarui.');
    }

    public function updateSession(Request $request)
    {
        $userData = $request->only(['nama', 'email', 'nip']);
        session(['user' => array_merge(session('user', []), $userData)]);
        return response()->json(['message' => 'Session updated successfully']);
    }
}