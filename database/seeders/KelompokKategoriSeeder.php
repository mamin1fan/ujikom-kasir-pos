<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KelompokKategori;
use Illuminate\Support\Facades\DB;

class KelompokKategoriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_kelompok_kategori')->delete();

        DB::table('tb_kelompok_kategori')->insert([
            [
                'id_kelompok'   => 1,
                'id_sekolah'    => 1,
                'nama_kelompok' => 'Produk',
            ],
        ]);
    }
}
