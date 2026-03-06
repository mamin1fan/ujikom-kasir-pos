<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sekolah;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolahs = Sekolah::get();
        return view('role.super-admin.sekolah', compact('sekolahs'));
    }

    public function updateStatus(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

        $sekolah->update([
            'is_active' => $request->is_active
        ]);

        return back()->with('success', 'Status sekolah berhasil diperbarui');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string|max:500',
            'website' => 'nullable|url|max:255',
        ]);

        // Ambil kode terakhir
        $last = Sekolah::latest('id_sekolah')->first();
        $number = $last ? (int)substr($last->kode_sekolah, 9) + 1 : 1; // "KOPERASI-001"
        $kode = 'KOPERASI-' . str_pad($number, 3, '0', STR_PAD_LEFT);

        Sekolah::create([
            'kode_sekolah' => $kode,
            'nama_sekolah' => $request->nama_sekolah,
            'alamat_sekolah' => $request->alamat_sekolah,
            'website' => $request->website,
            'is_active' => 1,
        ]);

        return back()->with('success', 'Sekolah berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string|max:500',
            'website' => 'nullable|url|max:255',
        ]);

        $sekolah = Sekolah::findOrFail($id);
        $sekolah->update([
            'nama_sekolah' => $request->nama_sekolah,
            'alamat_sekolah' => $request->alamat_sekolah,
            'website' => $request->website,
        ]);

        return back()->with('success', 'Sekolah berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        //
    }
}
