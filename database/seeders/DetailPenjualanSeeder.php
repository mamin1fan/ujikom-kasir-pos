<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPenjualanSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_detail_penjualan')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('tb_detail_penjualan')->insert([
            [
                'id_penjualan'   => 1,
                'id_barang'      => 1,
                'jumlah_barang'  => 5,
                'harga_beli'     => 2000.00,
                'harga_jual'     => 3000.00,
                'diskon_tipe'    => 'nominal',
                'diskon_nilai'   => 0,
                'diskon_nominal' => 0,
                'subtotal'       => 15000.00,
            ],
        ]);
    }
}