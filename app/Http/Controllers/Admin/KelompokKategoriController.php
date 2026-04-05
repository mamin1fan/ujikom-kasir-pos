<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KelompokKategori;
use App\Models\Kategori;

class KelompokKategoriController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $kelompok_kategori = KelompokKategori::where('id_sekolah', sekolah_id())
            ->withCount([
                'kategori' => function ($q) {
                    $q->where('is_delete', 0);
                }
            ])
            ->orderBy('nama_kelompok')
            ->paginate(10);

        $total_kelompok_kategori = KelompokKategori::where('id_sekolah', sekolah_id())->count();

        return view('role.admin.kelompok_kategori', compact(
            'kelompok_kategori',
            'total_kelompok_kategori'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|max:100'
        ]);

        KelompokKategori::create([
            'id_sekolah' => sekolah_id(),
            'nama_kelompok' => $request->nama_kelompok,
            'created_at' => now(),
            'created_by' => Auth::id()
        ]);

        return redirect()
            ->route('admin.kelompok-kategori.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|max:100'
        ]);

        $kelompok = KelompokKategori::where('id_kelompok', $id)
            ->where('id_sekolah', sekolah_id())
            ->firstOrFail();

        $kelompok->update([
            'nama_kelompok' => $request->nama_kelompok
        ]);

        return redirect()
            ->route('admin.kelompok-kategori.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $kelompok = KelompokKategori::where('id_kelompok', $id)
            ->where('id_sekolah', sekolah_id())
            ->firstOrFail();

        $kategori = Kategori::where('id_kelompok', $id)
            ->where('is_delete', 0)
            ->count();

        if ($kategori > 0) {
            return response()->json([
                'status' => 'error',
                'message' => "Kelompok masih memiliki $kategori kategori"
            ], 400);
        }

        // HARD DELETE
        $kelompok->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}