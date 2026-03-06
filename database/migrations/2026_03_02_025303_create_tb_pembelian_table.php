<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_pembelian', function (Blueprint $table) {
            $table->id('id_pembelian');

            $table->foreignId('id_sekolah')
                  ->constrained('tb_sekolah', 'id_sekolah')
                  ->cascadeOnDelete();

            $table->foreignId('id_supplier')
                  ->constrained('tb_supplier', 'id_supplier')
                  ->restrictOnDelete();

            $table->foreignId('id_user')
                  ->constrained('tb_user', 'id_user')
                  ->restrictOnDelete();

            $table->string('nomor_faktur', 50);
            $table->dateTime('tanggal_faktur')->useCurrent();

            $table->decimal('total_bayar', 14, 2);

            $table->enum('status_pembelian', ['draft', 'selesai'])
                  ->default('draft');

            $table->enum('jenis_transaksi', ['tunai', 'kredit'])
                  ->default('tunai');

            $table->string('cara_bayar', 50)->nullable()
                  ->comment('Cash, Transfer, QRIS dll..');

            $table->text('note')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->boolean('is_delete')->default(false);

            $table->unique(['nomor_faktur', 'id_sekolah'], 'faktur_per_sekolah');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_pembelian');
    }
};