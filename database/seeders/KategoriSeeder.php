<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_kategori')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            // KELOMPOK 1 - MAKANAN & MINUMAN
            ['id_kategori' => 1, 'id_kelompok' => 1, 'nama' => 'Makanan Ringan'],
            ['id_kategori' => 2, 'id_kelompok' => 1, 'nama' => 'Makanan Berat'],
            ['id_kategori' => 3, 'id_kelompok' => 1, 'nama' => 'Minuman Dingin'],
            ['id_kategori' => 4, 'id_kelompok' => 1, 'nama' => 'Minuman Panas'],

            // KELOMPOK 2 - ATK
            ['id_kategori' => 5, 'id_kelompok' => 2, 'nama' => 'Alat Tulis'],
            ['id_kategori' => 6, 'id_kelompok' => 2, 'nama' => 'Buku & Kertas'],
            ['id_kategori' => 7, 'id_kelompok' => 2, 'nama' => 'Perlengkapan Sekolah'],

            // KELOMPOK 3 - LAINNYA
            ['id_kategori' => 8, 'id_kelompok' => 3, 'nama' => 'Kebersihan'],
            ['id_kategori' => 9, 'id_kelompok' => 3, 'nama' => 'Kesehatan'],
            ['id_kategori' => 10, 'id_kelompok' => 3, 'nama' => 'Lain-lain'],
        ];

        // tambahin field tambahan
        $finalData = [];
        foreach ($data as $item) {
            $finalData[] = [
                'id_kategori' => $item['id_kategori'],
                'id_kelompok' => $item['id_kelompok'],
                'nama' => $item['nama'],
                'created_at' => now(),
                'created_by' => 1,
                'is_delete' => 0,
            ];
        }

        DB::table('tb_kategori')->insert($finalData);
    }
}