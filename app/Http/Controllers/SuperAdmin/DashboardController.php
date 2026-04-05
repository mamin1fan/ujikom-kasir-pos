<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Penjualan;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        // 🔥 TOTAL SEKOLAH
        $totalSekolah = Sekolah::count();

        // 🔥 SEKOLAH AKTIF & SUSPEND (asumsi ada kolom status)
        $sekolahAktif = Sekolah::where('is_active', true)->count();

        $sekolahSuspend = Sekolah::where('is_active', false)->count();

        // 🔥 TOTAL USER
        $totalUser = User::count();

        // 🔥 TRANSAKSI HARI INI
        $transaksiHariIni = Penjualan::whereDate('created_at', Carbon::today())->count();

        // 🔥 RATA-RATA USER PER SEKOLAH
        $avgUser = $totalSekolah > 0
            ? round($totalUser / $totalSekolah)
            : 0;



        $schools = Sekolah::withCount('users')
            ->withMax('users', 'updated_at')
            ->latest('created_at')
            ->limit(5)
            ->get()
            ->map(function ($school) {

                $school->total_user = $school->users_count;

                // ✅ ambil dari users_max_updated_at
                $school->last_active = $school->users_max_updated_at
                    ? \Carbon\Carbon::parse($school->users_max_updated_at)->diffForHumans()
                    : '-';

                $school->status_text = (int) $school->is_active === 1 ? 'active' : 'suspend';

                return $school;
            });
        return view('role.super-admin.dashboard', compact(
            'totalSekolah',
            'sekolahAktif',
            'sekolahSuspend',
            'totalUser',
            'transaksiHariIni',
            'avgUser',
            'schools',

        ));
    }
}
