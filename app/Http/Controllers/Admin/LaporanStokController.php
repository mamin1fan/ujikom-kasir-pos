<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanStokExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanStokController extends Controller
{

    /**
     * Query filter laporan stok
     */
    private function filterQuery(Request $request)
    {
        $query = Barang::with(['kategori','supplier','creator','updater']);

        // SEARCH
        if ($request->filled('search')) {
            $query->where('nama','like','%'.$request->search.'%');
        }

        // KATEGORI
        if ($request->filled('kategori')) {
            $query->where('kategori_id',$request->kategori);
        }

        // SUPPLIER
        if ($request->filled('supplier')) {
            $query->where('supplier_id',$request->supplier);
        }

        // STATUS
        if ($request->filled('status')) {

            if ($request->status == 'aman') {
                $query->where('stok','>=',10);
            }

            if ($request->status == 'menipis') {
                $query->whereBetween('stok',[1,9]);
            }

            if ($request->status == 'habis') {
                $query->where('stok',0);
            }
        }

        // TANGGAL
        if ($request->filled('from')) {
            $query->whereDate('created_at','>=',$request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at','<=',$request->to);
        }

        return $query;
    }



    // ================= HALAMAN LAPORAN =================
    public function stok(Request $request)
    {

        $query = $this->filterQuery($request);

        // clone untuk statistik
        $statQuery = clone $query;

        $barang = $query->latest()->paginate(20);

        // ================= STATISTIK =================

        $totalProduk = (clone $statQuery)->count();

        $stokAman = (clone $statQuery)
            ->where('stok','>=',10)
            ->count();

        $stokMenipis = (clone $statQuery)
            ->whereBetween('stok',[1,9])
            ->count();

        $stokHabis = (clone $statQuery)
            ->where('stok',0)
            ->count();

        $nilaiStok = (clone $statQuery)
            ->get()
            ->sum(function($b){
                return $b->stok * $b->harga_beli;
            });

        $kategori = Kategori::orderBy('nama')->get();
        $supplier = Supplier::orderBy('nama')->get();

        return view('role.admin.laporan_stok', compact(
            'barang',
            'kategori',
            'supplier',
            'totalProduk',
            'stokAman',
            'stokMenipis',
            'stokHabis',
            'nilaiStok'
        ));
    }



    // ================= EXPORT EXCEL =================
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanStokExport($request),
            'laporan-stok.xlsx'
        );
    }



    // ================= EXPORT PDF =================
    public function exportPdf(Request $request)
    {

        $barang = $this->filterQuery($request)
            ->latest()
            ->get();

        $pdf = Pdf::loadView('exports.laporan_stok_pdf',[
            'barang'=>$barang,
            'request'=>$request
        ])->setPaper('A4','landscape');

        return $pdf->download('laporan-stok.pdf');
    }

}