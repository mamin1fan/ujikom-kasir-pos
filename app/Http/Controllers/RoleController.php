<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function redirectByRole()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/');
        }

        // 🔴 CEK STATUS AKTIF
        if ($user->is_active == 0) {
            Auth::logout();
            return redirect('/')->with('error', 'Akun tidak aktif');
        }

        $roleName = $user->role->nama_role ?? null;

        // ✅ Mapping role (lebih clean & scalable)
        $routes = [
            'super admin' => 'super-admin.dashboard',
            'admin' => 'admin.dashboard',
            'kasir' => 'kasir.dashboard',
        ];

        // ✅ Kalau role ada → redirect
        if (isset($routes[$roleName])) {
            return redirect()->route($routes[$roleName]);
        }

        // ❗ Kalau role tidak dikenali tapi masih login
        // fallback: logout biar tidak nyangkut
        // Auth::logout();
        // return redirect('/')->with('error', 'Role tidak dikenali');
    }
}