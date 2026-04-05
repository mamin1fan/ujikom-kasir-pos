<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ImpersonateController extends Controller
{
    public function loginAs(User $user)
    {
        // hanya superadmin
        if (auth()->user()->role->nama_role !== 'superadmin') {
            abort(403);
        }

        // simpan user asli
        session([
            'impersonator_id' => auth()->id(),
            'impersonator_role' => auth()->user()->role->nama_role,
            'impersonate' => true,
        ]);

        // login sebagai admin
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function stop()
    {
        if (!session('impersonate')) {
            return redirect()->route('dashboard');
        }

        $originalUser = User::find(session('impersonator_id'));

        Auth::login($originalUser);

        session()->forget([
            'impersonate',
            'impersonator_id',
            'impersonator_role'
        ]);

        return redirect()->route('superadmin.dashboard');
    }
}
