<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_pelanggan')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [];

        $namaDepan = ['Ahmad', 'Budi', 'Siti', 'Rina', 'Dewi', 'Andi', 'Rizky', 'Putri', 'Fajar', 'Lina'];
        $namaBelakang = ['Pratama', 'Saputra', 'Wijaya', 'Sari', 'Utami', 'Hidayat', 'Ramadhan', 'Putra'];

        $id = 1;

        // asumsi ada 3 sekolah
        for ($sekolah = 1; $sekolah <= 3; $sekolah++) {

            // tiap sekolah punya 20 pelanggan
            for ($i = 1; $i <= 20; $i++) {

                $nama = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];

                $data[] = [
                    'id_pelanggan'          => $id++,
                    'id_kelompok_pelanggan' => rand(1, 15), // dari seeder kelompok pelanggan
                    'nama_pelanggan'        => $nama,
                    'telepon'               => '08' . rand(111111111, 999999999),
                    'alamat'                => 'Jl. ' . $namaBelakang[array_rand($namaBelakang)] . ' No. ' . rand(1, 100),
                    'created_at'            => now(),
                    'created_by'            => 1,
                    'updated_at'            => null,
                    'updated_by'            => null,
                    'deleted_at'            => null,
                    'deleted_by'            => null,
                    'is_delete'             => 0,
                ];
            }
        }

        DB::table('tb_pelanggan')->insert($data);
    }
}