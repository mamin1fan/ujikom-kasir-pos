<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tb_user')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ambil role
        $roles = DB::table('roles')->pluck('id_role', 'nama_role');

        if (!isset($roles['super admin'])) {
            throw new \Exception('Role super admin belum ada!');
        }

        // =========================
        // 🔥 1. SUPER ADMIN (GLOBAL)
        // =========================
        DB::table('tb_user')->insert([
            'id_sekolah'   => null, // TANPA SEKOLAH
            'id_role'      => $roles['super admin'], // role 1
            'username'     => 'superadmin',
            'password'     => Hash::make('admin123'),
            'nama_lengkap' => 'Super Admin Global',
            'is_active'    => 1,
            'created_at'   => now(),
        ]);

        // =========================
        // 🔥 2. ADMIN & USER SEKOLAH
        // =========================

        $sekolahs = DB::table('tb_sekolah')->pluck('id_sekolah')->toArray();

        if (empty($sekolahs)) {
            throw new \Exception('Data sekolah belum ada!');
        }

        $data = [];

        foreach ($sekolahs as $sekolah) {

            // ADMIN (role 2)
            $data[] = [
                'id_sekolah'   => $sekolah,
                'id_role'      => 2,
                'username'     => 'admin' . $sekolah,
                'password'     => Hash::make('admin123'),
                'nama_lengkap' => 'Admin Sekolah ' . $sekolah,
                'is_active'    => 1,
                'created_at'   => now(),
            ];

            // KASIR / USER (role 3)
            $data[] = [
                'id_sekolah'   => $sekolah,
                'id_role'      => 3,
                'username'     => 'kasir' . $sekolah,
                'password'     => Hash::make('admin123'),
                'nama_lengkap' => 'Kasir Sekolah ' . $sekolah,
                'is_active'    => 1,
                'created_at'   => now(),
            ];
        }

        DB::table('tb_user')->insert($data);
    }
}