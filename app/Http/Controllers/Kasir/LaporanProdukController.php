<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use App\Models\Barang;

class LaporanProdukController extends Controller
{
    protected int $batasHampirHabis = 10;

    public function laporanProduk(Request $request)
    {
        $periode = $request->input('periode', 'month');
        [$tanggalMulai, $tanggalSelesai] = $this->getRentangTanggal($periode);

        // 🔥 Produk paling laris
        $produkLaris = DetailPenjualan::with(['barang', 'penjualan'])
            ->whereHas('penjualan', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            })
            ->selectRaw('id_barang, SUM(jumlah_barang) as total_terjual')
            ->groupBy('id_barang')
            ->orderByDesc('total_terjual')
            ->take(10)
            ->get();

        $idsTerlaris = $produkLaris->pluck('id_barang');

        // 🐢 Produk paling sedikit terjual
        $produkSepi = DetailPenjualan::with(['barang', 'penjualan'])
            ->whereHas('penjualan', function ($q) use ($tanggalMulai, $tanggalSelesai) {
                $q->whereBetween('created_at', [$tanggalMulai, $tanggalSelesai]);
            })
            ->whereNotIn('id_barang', $idsTerlaris)
            ->selectRaw('id_barang, SUM(jumlah_barang) as total_terjual')
            ->groupBy('id_barang')
            ->orderBy('total_terjual')
            ->take(10)
            ->get();

        // 📦 Semua stok + total terjual (pakai relasi)
        $semuaProduk = Barang::withSum('detailPenjualan as total_terjual', 'jumlah_barang')
            ->orderBy('nama')
            ->get();

        // ⚠️ Barang hampir habis
        $hampirHabis = Barang::whereBetween('stok', [1, $this->batasHampirHabis - 1])
            ->orderBy('stok')
            ->get();

        // KPI summary
        $totalProduk = Barang::count();
        $totalTerjual = $produkLaris->sum('total_terjual');
        $totalStok = Barang::sum('stok');
        $hampirHabisCount = $hampirHabis->count();
        $barangs = Barang::all();
        $kategoriList = $barangs->pluck('kategori')->unique();

        return view('role.kasir.laporan_produk', compact(
            'kategoriList',
            'barangs',
            'produkLaris',
            'produkSepi',
            'semuaProduk',
            'hampirHabis',
            'totalProduk',
            'totalTerjual',
            'totalStok',
            'hampirHabisCount',
            'periode',
        ) + ['batasHampirHabis' => $this->batasHampirHabis]);
    }

    private function getRentangTanggal(string $periode): array
    {
        $now = now();

        return match ($periode) {
            'today' => [$now->copy()->startOfDay(), $now->copy()->endOfDay()],
            'week' => [$now->copy()->subDays(6)->startOfDay(), $now->copy()->endOfDay()],
            'month' => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
            'all' => ['2000-01-01 00:00:00', '2099-12-31 23:59:59'],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
        };
    }
}