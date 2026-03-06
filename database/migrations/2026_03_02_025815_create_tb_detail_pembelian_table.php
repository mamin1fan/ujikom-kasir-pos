<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_detail_pembelian', function (Blueprint $table) {
            $table->id('id_detail_pembelian');

            $table->foreignId('id_pembelian')
                  ->constrained('tb_pembelian', 'id_pembelian')
                  ->cascadeOnDelete();

            $table->foreignId('id_barang')
                  ->constrained('tb_barang', 'id_barang')
                  ->restrictOnDelete();

            $table->string('satuan', 20);
            $table->integer('jumlah');

            $table->decimal('harga_beli', 12, 2);
            $table->decimal('subtotal', 14, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_detail_pembelian');
    }
};