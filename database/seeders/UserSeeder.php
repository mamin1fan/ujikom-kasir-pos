<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_user')->delete();

        $role = DB::table('roles')->where('nama_role', 'super admin')->first();
        if (!$role) {
            throw new \Exception('Role super admin belum ada!');
        }

        $sekolahs = DB::table('tb_sekolah')->whereIn('id_sekolah', [1,2])->get();

        foreach ($sekolahs as $sekolah) {
            DB::table('tb_user')->insert([
                'id_sekolah'   => $sekolah->id_sekolah,
                'id_role'      => $role->id_role,
                'username'     => 'admin' . $sekolah->id_sekolah, // admin1, admin2
                'password'     => Hash::make('admin123'),
                'nama_lengkap' => 'Super Admin ' . $sekolah->nama_sekolah,
                'is_active'    => true,
                'created_at'   => now(),
            ]);
        }
    }
}