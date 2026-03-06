<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tb_supplier')->delete();

        $sekolah = DB::table('tb_sekolah')->first();

        if (!$sekolah) {
            throw new \Exception('Sekolah belum ada!');
        }

        DB::table('tb_supplier')->insert([
            [
                'id_supplier' => 1,
                'id_sekolah' => $sekolah->id_sekolah,
                'nama' => 'Supplier Utama',
                'created_at' => now(),
                'is_delete' => 0,
            ]
        ]);
    }
}
