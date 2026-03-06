<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_kategori', function (Blueprint $table) {
            $table->id('id_kategori');

            $table->foreignId('id_kelompok')
                  ->constrained('tb_kelompok_kategori', 'id_kelompok')
                  ->cascadeOnDelete();

            $table->string('nama', 100);

            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->boolean('is_delete')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_kategori');
    }
};