<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_penjualan')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = DB::table('tb_user')->pluck('id_user')->toArray();
        $pelanggans = DB::table('tb_pelanggan')->pluck('id_pelanggan')->toArray();
        $sekolahs = DB::table('tb_sekolah')->pluck('id_sekolah')->toArray();

        if (empty($users) || empty($pelanggans) || empty($sekolahs)) {
            throw new \Exception('Data user / pelanggan / sekolah belum ada!');
        }

        $data = [];
        $id = 1;

        // buat 30 transaksi penjualan
        for ($i = 1; $i <= 30; $i++) {

            $user = $users[array_rand($users)];
            $pelanggan = $pelanggans[array_rand($pelanggans)];
            $sekolah = $sekolahs[array_rand($sekolahs)];

            $totalFaktur = rand(10000, 100000);
            $totalBayar  = $totalFaktur + rand(0, 20000);
            $kembalian   = $totalBayar - $totalFaktur;

            $data[] = [
                'id_penjualan'      => $id++,
                'id_sekolah'        => $sekolah,
                'id_user'           => $user,
                'id_pelanggan'      => $pelanggan,
                'tanggal_penjualan' => now()->subDays(rand(0, 30)),
                'total_faktur'      => $totalFaktur,
                'total_bayar'       => $totalBayar,
                'kembalian'         => $kembalian,
                'status_pembayaran' => 'sudah bayar',
                'jenis_transaksi'   => rand(0, 1) ? 'tunai' : 'non tunai',
                'cara_bayar'        => rand(0, 1) ? 'Cash' : 'Transfer',
                'note'              => 'Transaksi ke-' . $i,
                'created_at'        => now(),
                'created_by'        => $user,
                'deleted_at'        => null,
                'deleted_by'        => null,
                'is_delete'         => 0,
            ];
        }

        DB::table('tb_penjualan')->insert($data);
    }
}