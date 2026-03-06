<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            abort(403, 'Belum login');
        }

        $user = Auth::user();

        if (
            !$user->role ||
            strtolower($user->role->nama_role) !== strtolower($role)
        ) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}