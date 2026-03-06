<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokPelangganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_kelompok_pelanggan')->delete();

        DB::table('tb_kelompok_pelanggan')->insert([
            [
                'id_kelompok_pelanggan' => 1,
                'id_sekolah'            => 1,
                'nama_kelompok'         => 'Siswa',
            ],
            [
                'id_kelompok_pelanggan' => 2,
                'id_sekolah'            => 1,
                'nama_kelompok'         => 'Guru',
            ],
            [
                'id_kelompok_pelanggan' => 3,
                'id_sekolah'            => 1,
                'nama_kelompok'         => 'Umum',
            ],
        ]);
    }
}