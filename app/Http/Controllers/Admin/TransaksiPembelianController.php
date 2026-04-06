<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\DetailPembelian;   // ← pastikan model ini ada
use App\Models\Supplier;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiPembelianController extends Controller
{
    // ===================== INDEX =====================
    public function index(Request $request)
    {
        $idSekolah = sekolah_id();

        $supplier = Supplier::where('id_sekolah', $idSekolah)->get();

        $barang = Barang::where('id_sekolah', $idSekolah)
            ->where('is_delete', 0)
            ->get()
            ->map(fn($b) => [
                'id_barang' => $b->id_barang,
                'nama' => $b->nama,
                'satuan' => $b->satuan ?? 'pcs',
                'stok' => $b->stok ?? 0,
                'harga_beli' => $b->harga_beli ?? 0,
            ])
            ->values()
            ->toArray();

        // Semua supplier dapat barang yang sama
        $barangPerSupplier = [];
        foreach ($supplier as $sup) {
            $barangPerSupplier[$sup->id_supplier] = $barang;
        }

        return view('role.admin.transaksi_pembelian', compact('supplier', 'barangPerSupplier'));
    }

    // ===================== STORE =====================
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_faktur' => 'required|date',
            'id_supplier' => 'required|exists:tb_supplier,id_supplier',
            'details' => 'required|array|min:1',
            'details.*.id_barang' => 'required|exists:tb_barang,id_barang',
            'details.*.jumlah' => 'required|numeric|min:1',
            'details.*.harga_beli' => 'required|numeric|min:0',
        ]);

        // Hitung total dari details
        $totalBayar = collect($request->details)
            ->sum(fn($d) => ($d['jumlah'] ?? 0) * ($d['harga_beli'] ?? 0));

        DB::transaction(function () use ($request, $totalBayar) {

            // 1. Buat header pembelian
            $pembelian = Pembelian::create([
                'id_sekolah' => sekolah_id(),
                'id_supplier' => $request->id_supplier,
                'id_user' => Auth::id(),
                'nomor_faktur' => 'INV-' . strtoupper(Str::random(8)),
                'tanggal_faktur' => $request->tanggal_faktur,
                'total_bayar' => $totalBayar,
                'status_pembelian' => 'selesai',
                'jenis_transaksi' => 'tunai',
                'cara_bayar' => 'cash',
                'note' => $request->note ?? null,
                'created_by' => Auth::id(),
                'is_delete' => 0,
            ]);

            // 2. Simpan detail & update stok barang
            foreach ($request->details as $detail) {
                $jumlah = (int) $detail['jumlah'];
                $hargaBeli = (float) $detail['harga_beli'];
                $idBarang = $detail['id_barang'];

                // Simpan detail
                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id_pembelian,
                    'id_barang'    => $idBarang,
                    'jumlah'       => $jumlah,
                    'harga_beli'   => $hargaBeli,
                    'subtotal'     => $jumlah * $hargaBeli,
                    'satuan'       => $detail['satuan'] ?? null,
                ]);

                // Update stok barang (increment)
                Barang::where('id_barang', $idBarang)
                    ->increment('stok', $jumlah);

                // Opsional: update harga_beli barang ke harga terbaru
                Barang::where('id_barang', $idBarang)
                    ->update(['harga_beli' => $hargaBeli]);
            }
        });

        return redirect()
            ->route('admin.transaksi.pembelian.index')
            ->with('success', 'Pembelian berhasil disimpan & stok diperbarui');
    }

    // ===================== SHOW =====================
    public function show($id)
    {
        $pembelian = Pembelian::with(['supplier', 'details.barang'])
            ->where('id_pembelian', $id)
            ->where('is_delete', 0)
            ->firstOrFail();

        return view('role.admin.transaksi_pembelian.show', compact('pembelian'));
    }

    // ===================== UPDATE =====================
    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::where('id_pembelian', $id)
            ->where('is_delete', 0)
            ->firstOrFail();

        $request->validate([
            'tanggal_faktur' => 'required|date',
            'id_supplier' => 'required|exists:supplier,id_supplier',
        ]);

        $pembelian->update([
            'tanggal_faktur' => $request->tanggal_faktur,
            'id_supplier' => $request->id_supplier,
            'note' => $request->note ?? null,
        ]);

        return redirect()
            ->route('admin.transaksi.pembelian.index')
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