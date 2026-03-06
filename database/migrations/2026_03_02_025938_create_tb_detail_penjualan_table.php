<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_detail_penjualan', function (Blueprint $table) {

            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_barang');

            $table->integer('jumlah_barang');

            $table->decimal('harga_beli', 12, 2);
            $table->decimal('harga_jual', 12, 2);

            $table->enum('diskon_tipe', ['persen', 'nominal'])
                  ->default('nominal');

            $table->decimal('diskon_nilai', 12, 2)->default(0);
            $table->decimal('diskon_nominal', 12, 2)->default(0);

            $table->decimal('subtotal', 14, 2);

            // Composite Primary Key
            $table->primary(['id_penjualan', 'id_barang']);

            // Foreign Keys
            $table->foreign('id_penjualan')
                  ->references('id_penjualan')
                  ->on('tb_penjualan')
                  ->cascadeOnDelete();

            $table->foreign('id_barang')
                  ->references('id_barang')
                  ->on('tb_barang')
                  ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_detail_penjualan');
    }
};