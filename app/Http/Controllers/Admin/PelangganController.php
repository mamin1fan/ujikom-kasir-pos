<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\KelompokPelanggan;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{

    public function index(Request $request)
    {
        $pelanggan = Pelanggan::with('kelompok')
            ->where('is_delete', 0)
            ->paginate(10);

        $total_pelanggan = Pelanggan::where('is_delete', 0)->count();

        $kelompok = KelompokPelanggan::get();

        return view('role.admin.pelanggan', [
            'pelanggan' => $pelanggan,
            'kelompok' => $kelompok,
            'total_pelanggan' => $total_pelanggan
        ]);
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {

        $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'id_kelompok_pelanggan' => 'required|exists:tb_kelompok_pelanggan,id_kelompok_pelanggan',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255'
        ]);

        Pelanggan::create([
            'id_kelompok_pelanggan' => $request->id_kelompok_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'created_at' => now(),
            'created_by' => Auth::id(),
            'is_delete' => 0
        ]);

        return redirect()
            ->route('admin.pelanggan.index')
            ->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'id_kelompok_pelanggan' => 'required|exists:tb_kelompok_pelanggan,id_kelompok_pelanggan',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255'
        ]);

        $pelanggan = Pelanggan::where('id_pelanggan', $id)
            ->where('is_delete', 0)
            ->firstOrFail();

        $pelanggan->update([
            'id_kelompok_pelanggan' => $request->id_kelompok_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'updated_at' => now(),
            'updated_by' => Auth::id()
        ]);

        return redirect()
            ->route('admin.pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui');
    }

    /**
     * DELETE (soft delete)
     */
    public function destroy($id)
    {

        $pelanggan = Pelanggan::where('id_pelanggan', $id)
            ->where('is_delete', 0)
            ->firstOrFail();

        $pelanggan->update([
            'is_delete' => 1,
            'deleted_at' => now(),
            'deleted_by' => Auth::id()
        ]);

        return response()->json([
            'message' => 'Data pelanggan berhasil dihapus'
        ]);
    }

}