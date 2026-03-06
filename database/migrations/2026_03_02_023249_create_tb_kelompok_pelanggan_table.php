<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_kelompok_pelanggan', function (Blueprint $table) {
            $table->id('id_kelompok_pelanggan');

            $table->foreignId('id_sekolah')
                  ->constrained('tb_sekolah', 'id_sekolah')
                  ->cascadeOnDelete();

            $table->string('nama_kelompok', 50);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_kelompok_pelanggan');
    }
};