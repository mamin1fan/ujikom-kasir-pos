<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;

class LaporanKasirController extends Controller
{
    public function laporanKasir(Request $request)
    {
        $periode = $request->periode ?? 'today';

        $query = Penjualan::query()->where('is_delete', 0);

        if ($periode == 'today') {
            $query->whereDate('tanggal_penjualan', today());
        } elseif ($periode == 'week') {
            $query->whereBetween('tanggal_penjualan', [now()->subDays(7), now()]);
        } elseif ($periode == 'month') {
            $query->whereMonth('tanggal_penjualan', now()->month);
        }

        $totalTransaksi = (clone $query)->count();
        $totalPendapatan = (clone $query)->sum('total_faktur');
        $rataRata = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        $totalHutang = (clone $query)->where('status_pembayaran', 'hutang')->count();
        $lunas = (clone $query)->where('status_pembayaran', 'lunas')->count();
        $hutang = $totalHutang;

        $metodeStats = (clone $query)
            ->select('cara_bayar', \DB::raw('count(*) as total'))
            ->groupBy('cara_bayar')
            ->get();

        $transaksi = $query->latest()->limit(50)->get();

        return view('role.kasir.laporan_kasir', compact(
            'periode',
            'totalTransaksi',
            'totalPendapatan',
            'rataRata',
            'totalHutang',
            'lunas',
            'hutang',
            'metodeStats',
            'transaksi'
        ));
    }
}
