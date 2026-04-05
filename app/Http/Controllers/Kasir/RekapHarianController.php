<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;

class RekapHarianController extends Controller
{
    public function rekapHarian(Request $request)
    {
            $tanggal = $request->tanggal ?? today();

            $query = Penjualan::whereDate('tanggal_penjualan', $tanggal)
                ->where('is_delete', 0);

            $totalTransaksi = $query->count();
            $totalPendapatan = $query->sum('total_faktur');

        $metode = (clone $query)
            ->select('cara_bayar', \DB::raw('COUNT(*) as total'))
            ->groupBy('cara_bayar')
            ->get();

        $kasir = (clone $query)
            ->select(
                'id_user',
                \DB::raw('COUNT(*) as total_transaksi'),
                \DB::raw('SUM(total_faktur) as total_penjualan')
            )
            ->with('user')
            ->groupBy('id_user')
            ->get();

        $transaksi = $query->latest()->paginate(10);

        return view('role.kasir.rekap_harian', compact(
            'tanggal',
            'totalTransaksi',
            'totalPendapatan',
            'metode',
            'kasir',
            'transaksi'
        ));
    }
}