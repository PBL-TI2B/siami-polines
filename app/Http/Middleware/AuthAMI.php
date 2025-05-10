<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthAMI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$allowedRoles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles)
    {
        // Check if user is authenticated
        if (!$request->session()->has('token') || !$request->session()->has('role_id')) {
            Log::warning('Unauthenticated access attempt', [
                'url' => $request->url(),
                'ip' => $request->ip(),
            ]);
            return redirect()->route('login')->withErrors(['Silakan login terlebih dahulu.']);
        }

        // Verify role exists
        $role = Role::find($request->session()->get('role_id'));
        if (!$role) {
            Log::error('Invalid role_id in session', [
                'role_id' => $request->session()->get('role_id'),
                'user' => $request->session()->get('user'),
            ]);
            $request->session()->flush();
            return redirect()->route('login')->withErrors(['Sesi tidak valid. Silakan login kembali.']);
        }

        // Check if specific roles are required
        if (!empty($allowedRoles) && !in_array($role->prefix, $allowedRoles)) {
            Log::warning('Unauthorized role access attempt', [
                'user' => $request->session()->get('user'),
                'role_id' => $request->session()->get('role_id'),
                'required_roles' => $allowedRoles,
                'actual_role' => $role->prefix,
            ]);
            return redirect($role->prefix . '/dashboard')->withErrors(['Akses tidak diizinkan untuk peran ini.']);
        }

        return $next($request);
    }
}
