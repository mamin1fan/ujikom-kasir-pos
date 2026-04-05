<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_supplier')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $sekolahs = DB::table('tb_sekolah')->pluck('id_sekolah')->toArray();

        if (empty($sekolahs)) {
            throw new \Exception('Sekolah belum ada!');
        }

        $data = [];
        $id = 1;

        $namaSupplier = [
            'Supplier ATK Jaya',
            'CV Sumber Makmur',
            'PT Sinar Abadi',
            'Toko Grosir Sejahtera',
            'Distributor Nusantara',
        ];

        foreach ($sekolahs as $sekolah) {

            foreach ($namaSupplier as $nama) {

                // random soft delete
                $isDelete = rand(0, 1);

                $deletedAt = $isDelete
                    ? now()->subDays(rand(1, 30))
                    : null;

                $data[] = [
                    'id_supplier' => $id++,
                    'id_sekolah'  => $sekolah,
                    'nama'        => $nama,
                    'created_at'  => now(),
                    'deleted_at'  => $deletedAt,
                    'is_delete'   => $isDelete,
                ];
            }
        }

        DB::table('tb_supplier')->insert($data);
    }
}