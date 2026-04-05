<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokPelangganSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_kelompok_pelanggan')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [];

        $kelompok = [
            'Siswa',
            'Guru',
            'Staff',
            'Orang Tua',
            'Umum',
        ];

        $id = 1;

        // multi sekolah (contoh 3 sekolah)
        for ($sekolah = 1; $sekolah <= 3; $sekolah++) {

            foreach ($kelompok as $nama) {
                $data[] = [
                    'id_kelompok_pelanggan' => $id++,
                    'id_sekolah'            => $sekolah,
                    'nama_kelompok'         => $nama,
                ];
            }
        }

        DB::table('tb_kelompok_pelanggan')->insert($data);
    }
}