<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\User;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        // Total produk aktif
        $totalBarang = Barang::where('is_delete', 0)->count();

        // Total penjualan (sum total_faktur dari tb_penjualan)
        $totalPenjualan = Penjualan::where('is_delete', 0)->sum('total_faktur');

        // Total penjualan (sum total_faktur dari tb_penjualan)
        $totalPembelian = Pembelian::where('is_delete', 0)->sum('total_bayar');

        // Total member / user aktif
        $totalPelanggan = Pelanggan::count();

        // Total kategori aktif
        $totalKategori = Kategori::where('is_delete', 0)->count();

        // 10 transaksi terbaru
        $transaksiTerbaru = Penjualan::with('pelanggan') // relasi ke tb_pelanggan
            ->where('is_delete', 0)
            ->orderBy('tanggal_penjualan', 'desc')
            ->take(10)
            ->get();

        return view('role.admin.dashboard', compact(
            'totalBarang',
            'totalPenjualan',
            'totalPembelian',
            'totalPelanggan',
            'totalKategori',
            'transaksiTerbaru'
        ));
    }
}