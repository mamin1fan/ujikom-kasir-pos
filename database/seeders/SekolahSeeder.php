<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SekolahSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_sekolah')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [];

        $namaSekolah = [
            'SMA Negeri 1',
            'SMA Negeri 2',
            'SMK Teknologi',
            'SMP Harapan Bangsa',
            'SD Nusantara',
        ];

        $id = 1;

        foreach ($namaSekolah as $nama) {
            $data[] = [
                'id_sekolah'     => $id,
                'kode_sekolah'   => 'KOPERASI-' . str_pad($id, 3, '0', STR_PAD_LEFT),
                'nama_sekolah'   => $nama,
                'alamat_sekolah' => 'Jl. Pendidikan No. ' . rand(1, 100),
                'website'        => 'www.' . strtolower(str_replace(' ', '', $nama)) . '.sch.id',
                'is_active'      => 1,
                'created_at'     => now(),
            ];
            $id++;
        }

        DB::table('tb_sekolah')->insert($data);
    }
}