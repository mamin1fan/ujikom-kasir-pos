<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Supplier;
use Carbon\Carbon;

class LaporanPembelianController extends Controller
{
    public function index(Request $request)
    {
        $manualFilter =
            $request->filled('search') ||
            $request->filled('from') ||
            $request->filled('to') ||
            $request->filled('id_supplier') ||
            $request->filled('status_pembelian') ||
            $request->filled('month');

        $query = Pembelian::with([
            'supplier',
            'user',
            'detailPembelian.barang'
        ])
            ->where('is_delete', 0)
            ->where('id_sekolah', sekolah_id());

        // 🔍 SEARCH (nomor_faktur atau supplier)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_faktur', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Quick Mode Filter
        if ($request->mode === 'today') {
            $query->whereDate('tanggal_faktur', today());
        } elseif ($request->mode === 'yesterday') {
            $query->whereDate('tanggal_faktur', today()->subDay());
        } elseif ($request->mode === '7days') {
            $query->whereBetween('tanggal_faktur', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ]);
        } elseif ($request->mode === 'all') {
            // semua data
        }

        // 📅 DATE RANGE (manual)
        if ($request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $to = Carbon::parse($request->to)->endOfDay();
            $query->whereBetween('tanggal_faktur', [$from, $to]);
        }

        // 📅 BULAN
        if ($request->filled('month')) {
            $query->whereMonth('tanggal_faktur', $request->month);
            // Opsional: tambah whereYear jika perlu
            // $query->whereYear('tanggal_faktur', Carbon::now()->year);
        }

        // Supplier
        if ($request->filled('id_supplier')) {
            $query->where('id_supplier', $request->id_supplier);
        }

        // Status
        if ($request->filled('status_pembelian')) {
            $query->where('status_pembelian', $request->status_pembelian);
        }

        // Default: Hari Ini (jika tidak ada filter sama sekali)
        if (!$manualFilter && !$request->filled('mode')) {
            $query->whereDate('tanggal_faktur', today());
        }

        // Clone untuk statistik (supaya tidak terpengaruh pagination)
        $filteredQuery = (clone $query);

        $totalTransaksi = $filteredQuery->count();
        $totalPembelian = $filteredQuery->sum('total_bayar');

        // Jumlah barang dibeli (total dari semua detail)
        $barangDibeli = $filteredQuery->get()
            ->flatMap(fn($p) => $p->detailPembelian)
            ->sum('jumlah');

        // Pagination untuk tabel
        $pembelian = (clone $query)
            ->latest('tanggal_faktur')
            ->paginate(15)
            ->withQueryString();

        // Data untuk dropdown filter
        $suppliers = Supplier::where('id_sekolah', sekolah_id())
            ->orderBy('nama')
            ->get();

        $statuses = Pembelian::select('status_pembelian')
            ->distinct()
            ->pluck('status_pembelian');

        $months = range(1, 12);

        return view('role.admin.laporan_pembelian', compact(
            'pembelian',
            'totalTransaksi',
            'totalPembelian',
            'barangDibeli',
            'suppliers',
            'statuses',
            'months',
            'manualFilter'
        ));
    }

    /**
     * Cetak Laporan (Print)
     */
    public function cetak(Request $request)
    {
        $query = Pembelian::with([
            'supplier',
            'user',
            'detailPembelian.barang'
        ])
            ->where('is_delete', 0)
            ->where('id_sekolah', sekolah_id());

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_faktur', 'like', "%{$search}%")
                    ->orWhereHas('supplier', fn($q2) => $q2->where('nama', 'like', "%{$search}%"));
            });
        }

        // Quick Mode
        if ($request->mode === 'today') {
            $query->whereDate('tanggal_faktur', today());
        } elseif ($request->mode === 'yesterday') {
            $query->whereDate('tanggal_faktur', today()->subDay());
        } elseif ($request->mode === '7days') {
            $query->whereBetween('tanggal_faktur', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ]);
        } elseif ($request->mode === 'all') {
            // semua data
        }

        // Manual Date Range
        if ($request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $to = Carbon::parse($request->to)->endOfDay();
            $query->whereBetween('tanggal_faktur', [$from, $to]);
        }

        // Bulan
        if ($request->filled('month')) {
            $query->whereMonth('tanggal_faktur', $request->month);
        }

        // Supplier & Status
        if ($request->filled('id_supplier')) {
            $query->where('id_supplier', $request->id_supplier);
        }

        if ($request->filled('status_pembelian')) {
            $query->where('status_pembelian', $request->status_pembelian);
        }

        $pembelian = $query->latest('tanggal_faktur')->get();

        return view('role.admin.laporan_pembelian_print', compact('pembelian'));
    }
}