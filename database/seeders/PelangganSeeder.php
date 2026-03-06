<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_pelanggan')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('tb_pelanggan')->insert([
            [
                'id_pelanggan'           => 1,
                'id_kelompok_pelanggan'  => 1, // pastikan kelompok id 1 ada
                'nama_pelanggan'         => 'Ahmad Fauzi',
                'telepon'                => '081234567890',
                'alamat'                 => 'Jl. Melati No. 5',
                'created_at'             => now(),
                'created_by'             => 1,
                'updated_at'             => null,
                'updated_by'             => null,
                'deleted_at'             => null,
                'deleted_by'             => null,
                'is_delete'              => 0,
            ],
        ]);
    }
}