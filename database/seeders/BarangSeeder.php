<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_barang')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [];

        $namaBarang = [
            'Pensil 2B',
            'Pulpen Biru',
            'Pulpen Hitam',
            'Buku Tulis',
            'Penghapus',
            'Penggaris',
            'Spidol',
            'Stabilo',
            'Tip-X',
            'Kertas HVS',
        ];

        for ($i = 1; $i <= 100; $i++) {
            $randomNama = $namaBarang[array_rand($namaBarang)];

            $data[] = [
                'id_barang'            => $i,
                'id_sekolah'           => rand(1, 3),
                'barcode'              => 'BRG-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama'                 => $randomNama . ' ' . $i,
                'id_kategori'          => rand(1, 5),
                'id_kelompok_kategori' => rand(1, 3),
                'id_supplier'          => rand(1, 5),
                'satuan'               => 'PCS',
                'harga_beli'           => rand(1000, 5000),
                'harga_jual'           => rand(6000, 10000),
                'stok'                 => rand(0, 200),
                'is_active'            => 1,
                'created_at'           => now(),
                'created_by'           => 1,
                'updated_at'           => null,
                'updated_by'           => null,
                'deleted_at'           => null,
                'deleted_by'           => null,
                'is_delete'            => 0,
            ];
        }

        DB::table('tb_barang')->insert($data);
    }
}