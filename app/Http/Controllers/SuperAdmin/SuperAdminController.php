<?php
namespace App\Http\Controllers\SuperAdmin;


use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\Penjualan;
use App\Models\Pembelian;
use App\Models\Barang;


class SuperAdminController extends Controller
{
    // 🔥 set sekolah yang dipantau
    public function setMonitoring($id)
    {
        session([
            'monitoring_sekolah_id' => $id
        ]);

        return redirect()->route('super-admin.monitoring.index');
    }

    // 🔥 halaman monitoring
    public function index()
    {
        $sekolahId = session('monitoring_sekolah_id');

        if (!$sekolahId) {
            return redirect()->back()->with('error', 'Pilih sekolah dulu');
        }

        $sekolah = Sekolah::find($sekolahId);

        // ambil data
        $penjualan = Penjualan::where('id_sekolah', $sekolahId)->latest()->limit(10)->get();
        $pembelian = Pembelian::where('id_sekolah', $sekolahId)->latest()->limit(10)->get();

        return view('role.super-admin.monitoring.index', compact(
            'sekolah',
            'penjualan',
            'pembelian'
        ));
    }
    public function pantau($id)
    {
        $sekolah = Sekolah::findOrFail($id);

        // 🔥 Aktifkan mode operasional
        session([
            'mode' => 'operasional',
            'impersonate' => true,
            'impersonator_role' => 'superadmin',
            'id_sekolah' => $sekolah->getAttribute('id_sekolah'),
            'nama_sekolah' => $sekolah->getAttribute('nama_sekolah'),
        ]);

        // arahkan ke dashboard admin (biar lengkap)
        return redirect()->route('panel.operasional');
    }

    public function dashboard()
    {
        $sekolahId = session('sekolah_id');
        $today     = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        $pendapatanHariIni = Penjualan::where('id_sekolah', $sekolahId)->whereDate('created_at', $today)->sum('total_faktur');
        $pendapatanKemarin = Penjualan::where('id_sekolah', $sekolahId)->whereDate('created_at', $yesterday)->sum('total_faktur');
        $deltaPendapatan   = $pendapatanKemarin > 0 ? round((($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100) : 0;

        $transaksiHariIni  = Penjualan::where('id_sekolah', $sekolahId)->whereDate('created_at', $today)->count();
        $transaksiKemarin  = Penjualan::where('id_sekolah', $sekolahId)->whereDate('created_at', $yesterday)->count();
        $deltaTransaksi    = $transaksiHariIni - $transaksiKemarin;

        $totalStok         = Barang::where('id_sekolah', $sekolahId)->sum('stok');
        $stokTipis         = Barang::where('id_sekolah', $sekolahId)->where('stok', '<=', 10)->count();
        $pembelianHariIni  = Pembelian::where('id_sekolah', $sekolahId)->whereDate('created_at', $today)->sum('total_bayar');
        $jumlahPO          = Pembelian::where('id_sekolah', $sekolahId)->whereDate('created_at', $today)->count();

        $transaksiTerakhir = Penjualan::with(['pelanggan'])
            ->where('id_sekolah', $sekolahId)
            ->whereDate('created_at', $today)
            ->latest()->take(5)->get();

        $barangStokTipis   = Barang::where('id_sekolah', $sekolahId)->where('stok', '<=', 10)->orderBy('stok')->take(5)->get();

        // Produk terlaris hari ini (dari detail transaksi)
        $produkTerlaris = DetailPenjualan::select('id_barang')
            ->whereHas('penjualan', function($query) use ($sekolahId, $today) {
                $query->where('id_sekolah', $sekolahId)
                      ->whereDate('created_at', $today);
            })
            ->selectRaw('id_barang, SUM(jumlah_barang) as total_terjual')
            ->groupBy('id_barang')
            ->orderByDesc('total_terjual')
            ->with('barang')
            ->take(5)
            ->get();

        // Gabungkan semua data ke dalam satu array $data
        $data = [
            'pendapatanHariIni' => $pendapatanHariIni,
            'deltaPendapatan'   => $deltaPendapatan,
            'transaksiHariIni'  => $transaksiHariIni,
            'deltaTransaksi'    => $deltaTransaksi,
            'totalStok'         => $totalStok,
            'stokTipis'         => $stokTipis,
            'pembelianHariIni'  => $pembelianHariIni,
            'jumlahPO'          => $jumlahPO,
            'transaksiTerakhir' => $transaksiTerakhir,
            'barangStokTipis'   => $barangStokTipis,
            'produkTerlaris'    => $produkTerlaris,
        ];

        return view('panel.operasional', compact('data'));
    }
}