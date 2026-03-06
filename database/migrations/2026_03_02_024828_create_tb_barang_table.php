<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->id('id_barang');

            $table->foreignId('id_sekolah')
                  ->constrained('tb_sekolah', 'id_sekolah')
                  ->cascadeOnDelete();

            $table->string('barcode', 50);
            $table->string('nama', 150);

            $table->foreignId('id_kategori')
                  ->constrained('tb_kategori', 'id_kategori')
                  ->cascadeOnDelete();

            $table->foreignId('id_kelompok_kategori')
                  ->constrained('tb_kelompok_kategori', 'id_kelompok')
                  ->cascadeOnDelete();

            $table->foreignId('id_supplier')
                  ->constrained('tb_supplier', 'id_supplier')
                  ->cascadeOnDelete();

            $table->string('satuan', 20);

            $table->decimal('harga_beli', 12, 2);
            $table->decimal('harga_jual', 12, 2);

            $table->integer('stok')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->boolean('is_delete')->default(false);

            $table->unique(['barcode', 'id_sekolah'], 'barcode_per_sekolah');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_barang');
    }
};