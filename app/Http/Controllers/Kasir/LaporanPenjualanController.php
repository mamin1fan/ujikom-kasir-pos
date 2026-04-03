<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\KelompokPelanggan;
use Carbon\Carbon;

class LaporanPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $manualFilter =
            $request->filled('search') ||
            $request->filled('from') ||
            $request->filled('to') ||
            $request->filled('status_pembayaran') ||
            $request->filled('month') ||
            $request->filled('pelanggan') ||
            $request->filled('id_pelanggan');

        $query = Penjualan::with(['pelanggan', 'user', 'detailPenjualan.barang'])
            ->where('is_delete', 0);

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('note', 'like', '%' . $request->search . '%')
                    ->orWhereHas('pelanggan', function ($q2) use ($request) {
                        $q2->where('nama_pelanggan', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // 📅 DATE RANGE
        if ($request->mode === 'today') {
            $query->whereDate('tanggal_penjualan', today());
        } elseif ($request->mode === 'yesterday') {
            $query->whereDate('tanggal_penjualan', today()->subDay());
        } elseif ($request->mode === '7days') {
            $query->whereBetween('tanggal_penjualan', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ]);
        } elseif ($request->mode === 'all') {
            // tidak pakai filter tanggal
        }

        if ($request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $to = Carbon::parse($request->to)->endOfDay();

            $query->whereBetween('tanggal_penjualan', [$from, $to]);
        }

        // 📅 BULAN
        if ($request->filled('month')) {
            $query->whereMonth('tanggal_penjualan', $request->month);
        }

        // 💳 STATUS
        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        // 👤 PELANGGAN / NON
        if ($request->filled('pelanggan')) {
            if ($request->pelanggan == 'non') {
                $query->whereNull('id_pelanggan');
            } elseif ($request->pelanggan == 'ada') {
                $query->whereNotNull('id_pelanggan');
            }
        }

        // 👤 ID PELANGGAN
        if ($request->filled('id_pelanggan')) {
            $query->where('id_pelanggan', $request->id_pelanggan);
        }

        // ✅ DEFAULT HARI INI
        if (
            !$request->filled('search') &&
            !$request->filled('month') &&
            !$request->filled('status_pembayaran') &&
            !$request->filled('pelanggan') &&
            !$request->filled('from') &&
            !$request->filled('to') &&
            !$request->filled('mode')
        ) {
            $query->whereDate('tanggal_penjualan', today());
        }

        if (!$manualFilter) {

            if ($request->mode === 'today') {
                $query->whereDate('tanggal_penjualan', today());
            } elseif ($request->mode === 'yesterday') {
                $query->whereDate('tanggal_penjualan', today()->subDay());
            } elseif ($request->mode === '7days') {
                $query->whereBetween('tanggal_penjualan', [
                    now()->subDays(6)->startOfDay(),
                    now()->endOfDay()
                ]);
            } elseif ($request->mode === 'all') {
                // semua data
            } else {
                // default
                $query->whereDate('tanggal_penjualan', today());
            }
        }

        // ✅ CLONE QUERY
        $filteredPenjualan = (clone $query)->get();

        $totalTransaksi = $filteredPenjualan->count();
        $totalPenjualan = $filteredPenjualan->sum('total_bayar');
        $produkTerjual = $filteredPenjualan
            ->flatMap(fn($p) => $p->detailPenjualan)
            ->sum('jumlah_barang');

        $penjualan = (clone $query)->latest()->paginate(10);

        $statuses = Penjualan::select('status_pembayaran')
            ->distinct()
            ->pluck('status_pembayaran');

        $pelanggan = Pelanggan::all();
        $months = range(1, 12);

        return view('role.kasir.penjualan', compact(
            'penjualan',
            'statuses',
            'pelanggan',
            'months',
            'totalTransaksi',
            'totalPenjualan',
            'produkTerjual',
            'manualFilter'
        ));
    }

    public function cetak(Request $request)
    {
        $query = Penjualan::with(['pelanggan', 'user', 'detailPenjualan.barang'])
            ->where('is_delete', 0);

        // 🔍 Filter sama seperti index
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('no_transaksi', 'like', "%{$request->search}%")
                    ->orWhereHas('pelanggan', fn($q2) => $q2->where('nama_pelanggan', 'like', "%{$request->search}%"));
            });
        }



        if ($request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $to = Carbon::parse($request->to)->endOfDay();

            $query->whereBetween('tanggal_penjualan', [$from, $to]);
        }

        if ($request->status_pembayaran) {
            $query->where('cara_bayar', $request->status_pembayaran);
        }

        if ($request->pelanggan == 'ada' && $request->id_pelanggan) {
            $query->where('id_pelanggan', $request->id_pelanggan);
        }

        $penjualan = $query->get();

        // Bisa langsung return view cetak
        return view('role.kasir.cetak_penjualan', compact('penjualan'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}


