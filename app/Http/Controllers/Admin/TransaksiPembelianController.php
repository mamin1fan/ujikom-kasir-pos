<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransaksiPembelianController extends Controller
{
    // ===================== INDEX =====================
    public function index(Request $request)
    {
        $pembelian = Pembelian::with(['supplier', 'user'])
            ->withCount('detailPembelian')
            ->where('is_delete', 0)
            ->latest('tanggal_faktur')
            ->paginate(10);

        $supplier = Supplier::where('is_delete', 0)->get();

        return view('role.admin.transaksi_pembelian', compact('pembelian', 'supplier'));
    }

    // ===================== STORE =====================
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_faktur' => 'required|date',
            'id_supplier' => 'required',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        Pembelian::create([
            'id_sekolah' => sekolah_id(),
            'id_supplier' => $request->id_supplier,
            'id_user' => Auth::id(),

            'nomor_faktur' => 'INV-' . strtoupper(Str::random(6)),
            'tanggal_faktur' => $request->tanggal_faktur,
            'total_bayar' => $request->total_bayar,

            'status_pembelian' => 'selesai',
            'jenis_transaksi' => 'pembelian',
            'cara_bayar' => 'cash',

            'note' => $request->note ?? null,

            'created_by' => Auth::id(),
            'is_delete' => 0,
        ]);

        return redirect()
            ->route('admin.transaksi-pembelian.index')
            ->with('success', 'Pembelian berhasil ditambahkan');
    }

    // ===================== UPDATE =====================
    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::where('id_pembelian', $id)
            ->where('is_delete', 0)
            ->firstOrFail();

        $request->validate([
            'tanggal_faktur' => 'required|date',
            'id_supplier' => 'required',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        $pembelian->update([
            'tanggal_faktur' => $request->tanggal_faktur,
            'id_supplier' => $request->id_supplier,
            'total_bayar' => $request->total_bayar,
            'note' => $request->note ?? null,
        ]);

        return redirect()
            ->route('admin.transaksi-pembelian.index')
            ->with('success', 'Pembelian berhasil diupdate');
    }

    // ===================== DESTROY (SOFT DELETE) =====================
    public function destroy($id)
    {
        $pembelian = Pembelian::where('id_pembelian', $id)
            ->where('is_delete', 0)
            ->firstOrFail();

        $pembelian->update([
            'is_delete' => 1,
            'deleted_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}