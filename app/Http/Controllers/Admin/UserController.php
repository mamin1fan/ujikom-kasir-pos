<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $users = User::with(['role', 'sekolah'])
            ->where('id_sekolah', $user->id_sekolah)
            ->where('is_active', 1)
            ->paginate(10);

        return view('role.admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $roles = Role::where('nama_role', '!=', 'super admin')->get(); // Admin tidak bisa buat super admin

        return view('role.admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:tb_user,username',
            'password' => 'required|string|min:8',
            'nama_lengkap' => 'required|string|max:100',
            'id_role' => 'required|exists:roles,id_role',
        ]);

        User::create([
            'id_sekolah' => Auth::user()->id_sekolah,
            'id_role' => $request->id_role,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_lengkap' => $request->nama_lengkap,
            'is_active' => 1,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $userEdit = User::where('id_user', $id)
            ->where('id_sekolah', $user->id_sekolah)
            ->firstOrFail();

        $roles = Role::where('nama_role', '!=', 'super admin')->get();

        return view('role.admin.user.edit', compact('userEdit', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $userUpdate = User::where('id_user', $id)
            ->where('id_sekolah', $user->id_sekolah)
            ->firstOrFail();

        $rules = [
            'username' => 'required|string|max:50|unique:tb_user,username,' . $id . ',id_user',
            'nama_lengkap' => 'required|string|max:100',
            'id_role' => 'required|exists:roles,id_role',
        ];

        if ($request->password) {
            $rules['password'] = 'string|min:8';
        }

        $request->validate($rules);

        $updateData = [
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'id_role' => $request->id_role,
            'updated_by' => Auth::id(),
        ];

        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        $userUpdate->update($updateData);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $userDelete = User::where('id_user', $id)
            ->where('id_sekolah', $user->id_sekolah)
            ->firstOrFail();

        $userDelete->update([
            'is_active' => 0,
            'deleted_by' => Auth::id(),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dinonaktifkan');
    }
}
