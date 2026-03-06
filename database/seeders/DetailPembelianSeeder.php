<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailPembelianSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_detail_pembelian')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('tb_detail_pembelian')->insert([
            [
                'id_detail_pembelian' => 1,
                'id_pembelian'        => 1,
                'id_barang'           => 1,
                'satuan'              => 'PCS',
                'jumlah'              => 50,
                'harga_beli'          => 2000.00,
                'subtotal'            => 100000.00,
            ],
        ]);
    }
}