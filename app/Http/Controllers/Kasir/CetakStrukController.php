<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Carbon\Carbon;

class CetakStrukController extends Controller
{
    public function index(Request $request)
    {
        $query = Penjualan::query();

        // WAJIB: filter global
        $query->where('is_delete', 0);

        // 🔍 FILTER
        if ($request->search) {
            $query->where('total_faktur', 'like', "%{$request->search}%");
        }

        if ($request->tanggal) {
            $query->whereDate('tanggal_penjualan', $request->tanggal);
        }

        if ($request->status) {
            $query->where('status_pembayaran', $request->status);
        }

        if ($request->metode) {
            $query->where('cara_bayar', $request->metode);
        }
        if ($request->jenis_transaksi) {
            $query->where('jenis_transaksi', $request->jenis_transaksi);
        }

        // 📊 KPI
        $transaksiHariIni = (clone $query)->count();

        $pendapatanHariIni = (clone $query)->sum('total_faktur');

        // 🔥 FIX ITEM TERJUAL (ikut filter)
        $idPenjualan = (clone $query)->pluck('id_penjualan');

        $itemTerjual = DetailPenjualan::whereIn('id_penjualan', $idPenjualan)
            ->sum('jumlah_barang');

        // 📋 DATA TABEL
        $transaksiTerakhir = $query
            ->with(['user', 'pelanggan'])
            ->orderByDesc('tanggal_penjualan')
            ->paginate(10)
            ->withQueryString();

        // 📦 METODE PEMBAYARAN (dinamis)
        $metodePembayaran = Penjualan::select('cara_bayar')
            ->whereNotNull('cara_bayar')
            ->distinct()
            ->pluck('cara_bayar');
            
        $jenisTransaksi = Penjualan::select('jenis_transaksi')
            ->whereNotNull('jenis_transaksi')
            ->distinct()
            ->pluck('jenis_transaksi');

        return view('role.kasir.cetak_struk', compact(
            'transaksiHariIni',
            'pendapatanHariIni',
            'itemTerjual',
            'transaksiTerakhir',
            'metodePembayaran',
            'jenisTransaksi'
        ));
    }


    /**
     * Endpoint AJAX untuk preview & cetak struk
     * GET /kasir/cetak.struk/{id}
     */
    public function struk($id)
    {
        $penjualan = Penjualan::with([
            'user',
            'pelanggan',
            'detailPenjualan.barang', // ← relasi yang benar sesuai model DetailPenjualan
        ])->findOrFail($id);

        $items = $penjualan->detailPenjualan->map(function ($d) {
            return [
                'nama' => $d->barang->nama_barang ?? '-', // ganti jika kolom nama barang berbeda
                'qty' => $d->jumlah_barang,
                'harga' => $d->harga_jual,
                'subtotal' => $d->subtotal,
            ];
        });

        return response()->json([
            'tanggal' => Carbon::parse($penjualan->tanggal_penjualan)->translatedFormat('d M Y'),
            'kasir' => $penjualan->user->username ?? '-',
            'pelanggan' => $penjualan->pelanggan->nama_pelanggan ?? null,
            'cara_bayar' => $penjualan->cara_bayar ?? '-',
            'note' => $penjualan->note ?? null,
            'total_faktur' => $penjualan->total_faktur,
            'total_bayar' => $penjualan->total_bayar,
            'kembalian' => $penjualan->kembalian,
            'items' => $items,
        ]);
    }
    /**
     * Endpoint AJAX untuk preview & cetak struk
     * GET /kasir/struk/{id}
     */


}
