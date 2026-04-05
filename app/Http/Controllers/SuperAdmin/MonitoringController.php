<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Sekolah;
use App\Models\User;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    public function monitoring()
    {
        // 🔥 TOTAL TRANSAKSI
        $totalTransaksi = Penjualan::count();

        // 🔥 TOTAL PENDAPATAN
        $totalPendapatan = Penjualan::sum('total_bayar');

        // 🔥 STATUS SEKOLAH (ambil 5 terbaru)
        $schools = Sekolah::latest()->limit(5)->get();

        // 🔥 ALERT (sekolah tidak aktif hari ini)
        $alerts = Sekolah::where('is_active', 0)
            ->pluck('nama_sekolah')
            ->map(fn($nama) => "$nama tidak aktif hari ini");

        // 🔥 AKTIVITAS USER (SIMPLE)
        $activities = User::latest('updated_at')
            ->limit(5)
            ->get()
            ->map(function ($user) {
                return (object) [
                    'nama' => $user->username,
                    'action' => 'Login / Aktivitas',
                    'time' => Carbon::parse($user->updated_at)->diffForHumans()
                ];
            });

        return view('super-admin.monitoring', compact(
            'totalTransaksi',
            'totalPendapatan',
            'schools',
            'alerts',
            'activities'
        ));
    }
}
