<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|integer',
            'unit_kerja_id' => 'required|integer',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nama' => 'required|string|max:100',
            'nip' => 'required|unique:users,nip',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'role_id' => $request->role_id,
            'unit_kerja_id' => $request->unit_kerja_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'nip' => $request->nip,
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil.',
            'user' => $user,
            'token' => $token
        ]);
    }
}
