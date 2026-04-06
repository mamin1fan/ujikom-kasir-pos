<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;
use App\Models\KelompokKategori;
use App\Models\Barang;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $kategori = Kategori::with('kelompok', 'creator', 'updater')
            ->whereHas('kelompok', function ($q) use ($user) {
                $q->where('id_sekolah', sekolah_id())
                    ->where('is_delete', 0);
            })
            ->where('is_delete', 0)
            ->paginate(10);

        $total_kategori = Kategori::whereHas('kelompok', function ($q) use ($user) {
            $q->where('id_sekolah', sekolah_id());
        })->where('is_delete', 0)->count();

        $kelompok_kategori = KelompokKategori::where('id_sekolah', sekolah_id())
            ->orderBy('nama_kelompok')
            ->get();

        return view('role.admin.kategori', compact(
            'kategori',
            'kelompok_kategori',
            'total_kategori'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'id_kelompok_kategori' => 'required|exists:tb_kelompok_kategori,id_kelompok'
        ]);

        Kategori::create([
            'nama' => $request->nama,
            'id_kelompok' => $request->id_kelompok_kategori,
            'is_delete' => 0,
            'created_by' => Auth::id(),
            'created_at' => now()
        ]);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'id_kelompok_kategori' => 'required|exists:tb_kelompok_kategori,id_kelompok'
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->update([
            'nama' => $request->nama,
            'id_kelompok' => $request->id_kelompok_kategori,
            'updated_by' => Auth::id(),
            'updated_at' => now()
        ]);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);


        $kategori->update([
            'is_delete' => 1,
            'deleted_by' => Auth::id(),
            'deleted_at' => now()
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}