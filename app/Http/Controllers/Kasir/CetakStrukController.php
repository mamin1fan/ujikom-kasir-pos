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
            'detailPenjualan.barang'   // relasi sudah benar
        ])->findOrFail($id);

        // Mapping items dengan data lengkap
        $items = $penjualan->detailPenjualan->map(function ($detail) {
            return [
                'nama_barang' => $detail->barang->nama_barang ?? '-',
                'qty' => (int) $detail->jumlah_barang,
                'harga' => (int) $detail->harga_jual,
                'diskon' => (int) ($detail->diskon_nominal ?? 0),
                'subtotal' => (int) $detail->subtotal,
            ];
        });

        return response()->json([
            'success' => true,
            'id_penjualan' => $penjualan->id_penjualan,
            'tanggal' => Carbon::parse($penjualan->tanggal_penjualan)->translatedFormat('d M Y H:i'),
            'kasir' => $penjualan->user->username ?? $penjualan->user->name ?? '-',
            'pelanggan' => $penjualan->pelanggan?->nama_pelanggan ?? 'Umum / Cash',
            'cara_bayar' => $penjualan->cara_bayar ?? '-',
            'note' => $penjualan->note ?? null,
            'total_faktur' => (int) $penjualan->total_faktur,
            'total_bayar' => (int) $penjualan->total_bayar,
            'kembalian' => (int) $penjualan->kembalian,
            'items' => $items,
        ]);
    }
    /**
     * Endpoint AJAX untuk preview & cetak struk
     * GET /kasir/struk/{id}
     */


}
