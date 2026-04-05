<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ===============================
    // TAMPIL DATA
    // ===============================
    public function index()
    {
        $users = User::with(['role', 'sekolah'])->get();

        return view('role.super-admin.user', compact('users'));
    }

    // ===============================
    // TAMBAH USER
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nama_user' => 'required',
            'username' => 'required|unique:tb_user,username',
            'password' => 'required|min:5',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_user,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_active' => 1,
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    // ===============================
    // UPDATE (EDIT + TOGGLE)
    // ===============================
    public function update(Request $request, $id)
    {
        $user = User::where('id_user', $id)->firstOrFail();

        // 👉 jika ada is_active → berarti toggle
        if ($request->has('is_active')) {

            $user->update([
                'is_active' => $request->is_active
            ]);

            return redirect()->back()->with('success', 'Status user berhasil diubah');
        }

        // 👉 jika tidak → edit biasa
        $request->validate([
            'nama_user' => 'required',
            'username' => 'required|unique:tb_user,username,' . $id . ',id_user',
        ]);

        $user->update([
            'nama_lengkap' => $request->nama_user,
            'username' => $request->username,
        ]);

        return redirect()->back()->with('success', 'User berhasil diupdate');
    }
    public function activate($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();

        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'Status berhasil diubah');
    }
}