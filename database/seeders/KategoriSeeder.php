<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {


        DB::table('tb_kategori')->delete();

        DB::table('tb_kategori')->insert([
            [
                'id_kategori' => 1,
                'id_kelompok' => 1,
                'nama' => 'Makanan',
                'created_at' => now(),
                'created_by' => 1,
                'is_delete' => 0,
            ],
        ]);
    }
}
