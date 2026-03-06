<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SekolahSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_sekolah')->delete();

        DB::table('tb_sekolah')->insert([
            [
                'id_sekolah'     => 1,
                'kode_sekolah'   => 'KOPERASI-001',
                'nama_sekolah'   => 'Sekolah Percontohan',
                'alamat_sekolah' => null,
                'website'        => null,
                'is_active'      => 1,
                'created_at'     => '2026-02-11 06:24:15',
            ],
            
            [
                'id_sekolah'     => 2,
                'kode_sekolah'   => 'KOPERASI-002',
                'nama_sekolah'   => 'Sekolah Percontohan 2',
                'alamat_sekolah' => null,
                'website'        => null,
                'is_active'      => 1,
                'created_at'     => '2026-02-11 06:24:15',
            ],

        ]);
    }
}