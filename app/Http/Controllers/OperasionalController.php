<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penjualan;

class OperasionalController extends Controller
{
    public function dashboard()
    {
        $idSekolah = session('id_sekolah');

        return view('operasional.dashboard', [
            'sekolah' => session('nama_sekolah'),
            'totalUser' => User::where('id_sekolah', $idSekolah)->count(),
            'totalTransaksi' => Penjualan::where('id_sekolah', $idSekolah)->count(),
        ]);
    }
}
