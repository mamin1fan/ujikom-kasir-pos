<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembelianSeeder extends Seeder
{
    public function run(): void
    {
        $user = DB::table('tb_user')->first();
        $supplier = DB::table('tb_supplier')->first();
        $sekolah = DB::table('tb_sekolah')->first();

        if (!$user || !$supplier || !$sekolah) {
            throw new \Exception('Data parent belum lengkap!');
        }

        DB::table('tb_pembelian')->insert([
            [
                'id_pembelian' => 1,
                'id_sekolah' => $sekolah->id_sekolah,
                'id_supplier' => $supplier->id_supplier,
                'id_user' => $user->id_user,
                'nomor_faktur' => 'INV-001',
                'tanggal_faktur' => now(),
                'total_bayar' => 500000,
                'jenis_transaksi' => 'tunai',
                'cara_bayar' => 'Cash',
                'status_pembelian' => 'selesai',
                'note' => 'Pembelian awal stok',
                'created_at' => now(),
                'created_by' => $user->id_user,
                'is_delete' => 0,
            ]
        ]);
    }
}
