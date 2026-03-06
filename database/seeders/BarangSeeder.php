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

        DB::table('tb_barang')->insert([
            [
                'id_barang'            => 1,
                'id_sekolah'           => 1,
                'barcode'              => 'BRG-001',
                'nama'                 => 'Pensil 2B',
                'id_kategori'          => 1,
                'id_kelompok_kategori' => 1,
                'id_supplier'          => 1,
                'satuan'               => 'PCS',
                'harga_beli'           => 2000.00,
                'harga_jual'           => 3000.00,
                'stok'                 => 100,
                'is_active'            => 1,
                'created_at'           => now(),
                'created_by'           => 1,
                'updated_at'           => null,
                'updated_by'           => null,
                'deleted_at'           => null,
                'deleted_by'           => null,
                'is_delete'            => 0,
            ],
        ]);
    }
}