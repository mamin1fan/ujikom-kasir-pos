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

        $data = [];
        $id = 1;

        // asumsi ada 20 transaksi penjualan
        for ($penjualan = 1; $penjualan <= 20; $penjualan++) {

            // tiap transaksi 2 - 5 item
            $jumlahItem = rand(2, 5);

            for ($i = 0; $i < $jumlahItem; $i++) {

                $qty = rand(1, 10);
                $hargaBeli = rand(1000, 5000);
                $hargaJual = $hargaBeli + rand(1000, 3000);

                // random tipe diskon
                $diskonTipe = rand(0, 1) ? 'nominal' : 'persen';

                if ($diskonTipe === 'nominal') {
                    $diskonNominal = rand(0, 2000);
                    $diskonNilai = 0;
                } else {
                    $diskonNilai = rand(0, 20); // persen
                    $diskonNominal = ($hargaJual * $qty) * ($diskonNilai / 100);
                }

                $subtotalKotor = $hargaJual * $qty;
                $subtotal = $subtotalKotor - $diskonNominal;

                $data[] = [
                    'id_detail_penjualan' => $id++,
                    'id_penjualan'        => $penjualan,
                    'id_barang'           => rand(1, 100),
                    'jumlah_barang'       => $qty,
                    'harga_beli'          => $hargaBeli,
                    'harga_jual'          => $hargaJual,
                    'diskon_tipe'         => $diskonTipe,
                    'diskon_nilai'        => $diskonNilai,
                    'diskon_nominal'      => $diskonNominal,
                    'subtotal'            => $subtotal,
                ];
            }
        }

        DB::table('tb_detail_penjualan')->insert($data);
    }
}