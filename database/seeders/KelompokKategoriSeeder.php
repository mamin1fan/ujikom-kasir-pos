<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokKategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_kelompok_kategori')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [];

        $kelompok = [
            'Makanan & Minuman',
            'ATK',
            'Kesehatan',
            'Kebersihan',
            'Lainnya',
        ];

        $id = 1;

        // contoh multi sekolah (id_sekolah 1 - 3)
        for ($sekolah = 1; $sekolah <= 3; $sekolah++) {

            foreach ($kelompok as $nama) {
                $data[] = [
                    'id_kelompok'   => $id++,
                    'id_sekolah'    => $sekolah,
                    'nama_kelompok' => $nama,
                ];
            }
        }

        DB::table('tb_kelompok_kategori')->insert($data);
    }
}