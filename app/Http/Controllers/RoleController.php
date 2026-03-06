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

        // ambil nama role dari relasi
        $roleName = $user->role->nama_role ?? null;

        switch ($roleName) {

            case 'super admin':
                return redirect('/super-admin');

            case 'admin':
                return redirect('/admin');

            case 'kasir':
                return redirect('/kasir');

            default:
                return redirect('/dashboard');
        }
    }
}