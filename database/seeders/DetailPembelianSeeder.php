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

        $data = [];

        $id = 1;

        // asumsi ada 20 pembelian
        for ($pembelian = 1; $pembelian <= 20; $pembelian++) {

            // tiap pembelian punya 2 - 5 barang
            $jumlahItem = rand(2, 5);

            for ($i = 0; $i < $jumlahItem; $i++) {

                $harga = rand(1000, 5000);
                $qty = rand(1, 50);
                $subtotal = $harga * $qty;

                $data[] = [
                    'id_detail_pembelian' => $id++,
                    'id_pembelian' => $pembelian,
                    'id_barang' => rand(1, 100), // sesuaikan dengan barang seeder
                    'satuan' => 'PCS',
                    'jumlah' => $qty,
                    'harga_beli' => $harga,
                    'subtotal' => $subtotal,
                ];
            }
        }

        DB::table('tb_detail_pembelian')->insert($data);
    }
}