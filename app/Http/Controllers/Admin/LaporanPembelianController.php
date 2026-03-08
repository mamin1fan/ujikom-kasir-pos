<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;

class LaporanPembelianController extends Controller
{

    public function laporanPembelian(Request $request)
    {
        $user = auth()->user();

        $query = Pembelian::with([
            'supplier',
            'user',
            'detailPembelian.barang'
        ])
        ->where('is_delete', 0)
        ->where('id_sekolah', $user->id_sekolah);

        // Filter tanggal
        if ($request->start && $request->end) {
            $query->whereBetween('tanggal_faktur', [
                $request->start,
                $request->end
            ]);
        }

        $pembelian = $query
            ->orderBy('tanggal_faktur', 'desc')
            ->get();

        return view('role.admin.laporan_pembelian', [
            'pembelian' => $pembelian
        ]);
    }



    // PRINT
    public function printPembelian(Request $request)
    {
        $user = auth()->user();

        $query = Pembelian::with([
            'supplier',
            'user',
            'detailPembelian.barang'
        ])
        ->where('is_delete', 0)
        ->where('id_sekolah', $user->id_sekolah);

        if ($request->start && $request->end) {
            $query->whereBetween('tanggal_faktur', [
                $request->start,
                $request->end
            ]);
        }

        $pembelian = $query
            ->orderBy('tanggal_faktur', 'desc')
            ->get();

        return view('role.admin.laporan_pembelian_print', [
            'pembelian' => $pembelian
        ]);
    }

}