<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\KelompokPelanggan;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;


class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function simpanTransaksi(Request $request)
    {
        $data = $request->validate([
            'keranjang' => 'required|array',
            'subtotal' => 'required|numeric',
            'diskon' => 'required|numeric',
            'total' => 'required|numeric',
            'jenis' => 'required|string',
            'metode' => 'nullable|string',
            'no_ref' => 'nullable|string',
            'pelanggan_id' => 'nullable|integer',
            'bayar' => 'nullable|numeric',
            'kembalian' => 'nullable|numeric',
        ]);

        DB::beginTransaction();
        try {
            $bayar = $data['bayar'] ?? 0;
            $kembalian = $data['kembalian'] ?? 0;

            // 🔽 VALIDASI STOK DULU (PENTING)
            foreach ($data['keranjang'] as $item) {
                $barang = Barang::where('id_barang', $item['id'])->lockForUpdate()->first();

                if (!$barang) {
                    throw new \Exception("Barang tidak ditemukan!");
                }

                if ($barang->stok < $item['qty']) {
                    throw new \Exception("Stok {$barang->nama_barang} tidak cukup! Sisa: {$barang->stok}");
                }
            }

            // 🔽 SIMPAN TRANSAKSI
            $transaksi = Penjualan::create([
                'id_sekolah' => auth()->user()->id_sekolah,
                'id_user' => auth()->id(),
                'id_pelanggan' => $data['pelanggan_id'] ?? null,
                'tanggal_penjualan' => now(),
                'total_faktur' => $data['subtotal'],
                'total_bayar' => $data['total'],
                'kembalian' => $kembalian,
                'status_pembayaran' => $data['total'] <= $bayar ? 'sudah bayar' : 'belum bayar',
                'jenis_transaksi' => $data['jenis'],
                'cara_bayar' => $data['metode'],
                'note' => $data['no_ref'] ?? null,
                'created_by' => auth()->id(),
                'is_delete' => 0
            ]);

            // 🔽 SIMPAN DETAIL + KURANGI STOK
            foreach ($data['keranjang'] as $item) {
                $hargaJual = $item['harga'];
                $hargaBeli = $item['harga_beli'] ?? 0;
                $jumlah = $item['qty'];
                $subtotal = $hargaJual * $jumlah;

                DetailPenjualan::create([
                    'id_penjualan' => $transaksi->id_penjualan,
                    'id_barang' => $item['id'],
                    'jumlah_barang' => $jumlah,
                    'harga_jual' => $hargaJual,
                    'harga_beli' => $hargaBeli,
                    'subtotal' => $subtotal,
                ]);

                // 🔥 UPDATE STOK (AMAN)
                Barang::where('id_barang', $item['id'])
                    ->decrement('stok', $jumlah);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function index()
    {
        $barang = Barang::with('kategori')
            ->where('is_delete', 0)
            ->where('is_active', 1)
            ->get();

        $kelompok = KelompokPelanggan::all();
        $pelanggan = Pelanggan::with('kelompok')->where('is_delete', 0)->get();

        return view('role.kasir.transaksi', compact('barang', 'pelanggan', 'kelompok'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sekolah $sekolah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sekolah $sekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah)
    {
        //
    }
}
