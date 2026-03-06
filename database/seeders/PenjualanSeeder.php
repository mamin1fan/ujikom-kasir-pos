<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_penjualan')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('tb_penjualan')->insert([
            [
                'id_penjualan'     => 1,
                'id_sekolah'       => 1,
                'id_user'          => 1,
                'id_pelanggan'     => 1,
                'tanggal_penjualan'=> now(),
                'total_faktur'     => 15000.00,
                'total_bayar'      => 20000.00,
                'kembalian'        => 5000.00,
                'status_pembayaran'=> 'sudah bayar',
                'jenis_transaksi'  => 'tunai',
                'cara_bayar'       => 'Cash',
                'note'             => 'Penjualan pertama',
                'created_at'       => now(),
                'created_by'       => 1,
                'deleted_at'       => null,
                'deleted_by'       => null,
                'is_delete'        => 0,
            ],
        ]);
    }
}