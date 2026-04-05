<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sekolah;

class SekolahController extends Controller
{
    // 🔹 Tampilkan data
    public function index()
    {
        $sekolahs = Sekolah::latest()->get();
        return view('role.super-admin.sekolah', compact('sekolahs'));
    }

    // 🔹 Simpan data baru
    public function store(Request $request)
    {
        $lastSekolah = Sekolah::orderBy('id_sekolah', 'desc')->first();

        $kode = 'SCH-001';

        if ($lastSekolah) {
            $lastNumber = (int) substr($lastSekolah->kode_sekolah, -3);
            $kode = 'SCH-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        Sekolah::create([
            'kode_sekolah' => $kode,
            'nama_sekolah' => $request->nama_sekolah,
            'alamat_sekolah' => $request->alamat_sekolah,
            'website' => $request->website,
            'is_active' => 1
        ]);

        return redirect()->back()->with('success', 'Sekolah berhasil ditambahkan');
    }

    // 🔹 Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string|max:255',
        ]);

        $sekolah = Sekolah::findOrFail($id);

        $sekolah->update([
            'nama_sekolah' => $request->nama_sekolah,
            'alamat_sekolah' => $request->alamat_sekolah,
        ]);

        return redirect()->back()->with('success', 'Sekolah berhasil diupdate');
    }

    // 🔹 Toggle status aktif / nonaktif
    public function toggleStatus(Request $request, $id)
    {
        $sekolah = Sekolah::findOrFail($id);

        $sekolah->update([
            'is_active' => $request->is_active
        ]);

        return redirect()->back()->with('success', 'Status sekolah berhasil diubah');
    }
}