<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembelianSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_pembelian')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = DB::table('tb_user')->pluck('id_user')->toArray();
        $suppliers = DB::table('tb_supplier')->pluck('id_supplier')->toArray();
        $sekolahs = DB::table('tb_sekolah')->pluck('id_sekolah')->toArray();

        if (empty($users) || empty($suppliers) || empty($sekolahs)) {
            throw new \Exception('Data user / supplier / sekolah belum ada!');
        }

        $data = [];
        $id = 1;

        // buat 30 transaksi pembelian
        for ($i = 1; $i <= 30; $i++) {

            $user = $users[array_rand($users)];
            $supplier = $suppliers[array_rand($suppliers)];
            $sekolah = $sekolahs[array_rand($sekolahs)];

            $total = rand(100000, 1000000);

            $data[] = [
                'id_pembelian'      => $id++,
                'id_sekolah'        => $sekolah,
                'id_supplier'       => $supplier,
                'id_user'           => $user,
                'nomor_faktur'      => 'INV-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'tanggal_faktur'    => now()->subDays(rand(0, 30)),
                'total_bayar'       => $total,
                'jenis_transaksi'   => rand(0, 1) ? 'tunai' : 'kredit',
                'cara_bayar'        => rand(0, 1) ? 'Cash' : 'Transfer',
                'status_pembelian'  => 'selesai',
                'note'              => 'Pembelian ke-' . $i,
                'created_at'        => now(),
                'created_by'        => $user,
                'is_delete'         => 0,
            ];
        }

        DB::table('tb_pembelian')->insert($data);
    }
}