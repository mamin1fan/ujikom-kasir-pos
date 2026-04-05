<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Supplier;

class RestoreController extends Controller
{
    // mapping biar scalable
    private function getModel($type)
    {
        return match ($type) {
            'barang' => Barang::class,
            'kategori' => Kategori::class,
            'pelanggan' => Pelanggan::class,
            'pembelian' => Pembelian::class,
            'penjualan' => Penjualan::class,
            'supplier' => Supplier::class,
            default => abort(404)
        };
    }
    private function getColumns($type)
    {
        return match ($type) {
            'barang' => ['key' => 'id_barang', 'name' => 'nama'],
            'kategori' => ['key' => 'id_kategori', 'name' => 'nama'],
            'pelanggan' => ['key' => 'id_pelanggan', 'name' => 'nama'],
            'pembelian' => ['key' => 'id_pembelian', 'name' => 'no_faktur'],
            'penjualan' => ['key' => 'id_penjualan', 'name' => 'kode_penjualan'],
            'supplier' => ['key' => 'id_supplier', 'name' => 'nama'],
            default => ['key' => 'id', 'name' => 'name'],
        };
    }
    // ✅ INDEX (VIEW)
    public function index($type)
    {
        $model = $this->getModel($type);

        $columns = $this->getColumns($type);
        $keyName = $columns['key'];
        $displayName = $columns['name'];

        $data = $model::onlyTrashed()
            ->where('id_sekolah', session('id_sekolah'))
            ->latest()
            ->paginate(10);

        return view('role.super-admin.restore', compact('data', 'type', 'keyName', 'displayName'));
    }

    // ✅ RESTORE
    public function restore($type, $id)
    {
        $model = $this->getModel($type);

        $item = $model::onlyTrashed()
            ->where('id_sekolah', session('id_sekolah'))
            ->findOrFail($id);

        // Restore data
        $item->restore();

        // Update is_delete ke 0 karena sudah direstore
        $item->is_delete = 0;
        $item->save();

        return back()->with('success', 'Data berhasil direstore');
    }

    // ✅ FORCE DELETE (HAPUS PERMANEN)
    public function forceDelete($type, $id)
    {
        $model = $this->getModel($type);

        $item = $model::onlyTrashed()
            ->where('id_sekolah', session('id_sekolah'))
            ->findOrFail($id);
        $item->forceDelete();

        return back()->with('success', 'Data dihapus permanen');
    }
}