<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelompokPelanggan;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;

class KelompokPelangganController extends Controller
{

    /**
     * LIST DATA
     */
    public function index(Request $request)
    {
        $id_sekolah = sekolah_id();

        $kelompok = KelompokPelanggan::withCount('pelanggan')
            ->where('id_sekolah', $id_sekolah)
            ->paginate(10);

        $total_kelompok = KelompokPelanggan::where('id_sekolah', $id_sekolah)->count();

        return view('role.admin.kelompok_pelanggan', [
            'kelompok' => $kelompok,
            'total_kelompok' => $total_kelompok
        ]);
    }


    /**
     * STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|max:100'
        ]);

        KelompokPelanggan::create([
            'id_sekolah' => sekolah_id(),
            'nama_kelompok' => $request->nama_kelompok
        ]);

        return redirect()
            ->route('admin.kelompok.pelanggan.index')
            ->with('success', 'Kelompok pelanggan berhasil ditambahkan');
    }


    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|max:100'
        ]);

        $id_sekolah = sekolah_id();

        $kelompok = KelompokPelanggan::where('id_kelompok_pelanggan', $id)
            ->where('id_sekolah', $id_sekolah)
            ->firstOrFail();

        $kelompok->update([
            'nama_kelompok' => $request->nama_kelompok
        ]);

        return redirect()
            ->route('admin.kelompok.pelanggan.index')
            ->with('success', 'Kelompok pelanggan berhasil diperbarui');
    }


    /**
     * DELETE
     */
    public function destroy($id)
    {
        $id_sekolah = sekolah_id();

        $kelompok = KelompokPelanggan::where('id_kelompok_pelanggan', $id)
            ->where('id_sekolah', $id_sekolah)
            ->firstOrFail();

        // cek apakah masih dipakai pelanggan di sekolah yang sama
        $digunakan = Pelanggan::where('id_kelompok_pelanggan', $id)
            ->whereHas('kelompok', function ($q) use ($id_sekolah) {
                $q->where('id_sekolah', $id_sekolah);
            })
            ->exists();

        if ($digunakan) {
            return response()->json([
                'message' => 'Kelompok pelanggan masih digunakan oleh data pelanggan.'
            ], 422);
        }

        // jika tidak ada relasi -> hard delete
        $kelompok->delete();

        return response()->json([
            'message' => 'Kelompok pelanggan berhasil dihapus.'
        ]);
    }
}