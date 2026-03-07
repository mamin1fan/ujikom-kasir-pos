<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\KelompokKategori;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Barang::with(['kategori', 'supplier'])
            ->where('is_delete', 0)
            ->where('id_sekolah', $user->id_sekolah);

        // SEARCH
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('barcode', 'like', '%' . $request->search . '%');
            });
        }
        $kategori = Kategori::whereHas('kelompok', function ($q) use ($user) {
            $q->where('id_sekolah', $user->id_sekolah)
                ->where('is_delete', 0);
        })->get();
        $suppliers = Supplier::where('id_sekolah', $user->id_sekolah)
            ->where('is_delete', 0)
            ->orderBy('nama')
            ->get();
        $kelompok_kategori = KelompokKategori::where('id_sekolah', $user->id_sekolah)
            ->orderBy('nama_kelompok')
            ->get();
        $barang = $query->orderBy('id_barang', 'desc')->paginate(10);

        

        return view('role.admin.barang', compact('barang', 'kategori', 'suppliers', 'kelompok_kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'barcode' => 'nullable|string|max:50',
            'id_kelompok_kategori' => 'required|exists:tb_kelompok_kategori,id_kelompok',
            'id_kategori' => 'required|exists:tb_kategori,id_kategori',
            'id_supplier' => 'required|exists:tb_supplier,id_supplier',
            'satuan' => 'required|string|max:20',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        Barang::create([
            'id_sekolah' => Auth::user()->id_sekolah, // otomatis sekolah login
            'id_kelompok_kategori' => $request->id_kelompok_kategori,
            'id_kategori' => $request->id_kategori,
            'id_supplier' => $request->id_supplier,
            'satuan' => $request->satuan,
            'nama' => $request->nama,
            'barcode' => $request->barcode,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'is_active' => 1,
            'is_delete' => 0,
            'updated_at' => now(),
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('admin.barang.index')->with('success', 'Data berhasil ditambahkan');
    }

    // show form for editing an existing barang

    public function update(Request $request, $id)
    {
        $barang = Barang::where('id_barang', $id)
            ->where('id_sekolah', Auth::user()->id_sekolah)
            ->firstOrFail();

        $rules = [
            'nama' => 'required',
            'barcode' => 'nullable|string|max:50',
            'id_kelompok_kategori' => 'required|exists:tb_kelompok_kategori,id_kelompok',
            'id_kategori' => 'required|exists:tb_kategori,id_kategori',
            'id_supplier' => 'required|exists:tb_supplier,id_supplier',
            'satuan' => 'required|string|max:20',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('admin.barang.index', ['edit_id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        $barang->update([
            'id_kelompok_kategori' => $request->id_kelompok_kategori,
            'id_kategori' => $request->id_kategori,
            'id_supplier' => $request->id_supplier,
            'satuan' => $request->satuan,
            'nama' => $request->nama,
            'barcode' => $request->barcode,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.barang.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $barang = Barang::where('id_barang', $id)
            ->where('id_sekolah', Auth::user()->id_sekolah)
            ->firstOrFail();

        $barang->update([
            'is_delete' => 1,
            'deleted_at' => now(),
        ]);

        return redirect()->route('admin.barang.index')->with('success', 'Data berhasil dihapus');
    }

}
