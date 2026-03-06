<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_supplier', function (Blueprint $table) {
            $table->id('id_supplier');

            $table->foreignId('id_sekolah')
                ->constrained('tb_sekolah', 'id_sekolah')
                ->cascadeOnDelete();

            $table->string('nama', 100);
            $table->string('no_telepon', 20)->nullable();
            $table->text('alamat_supplier')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->boolean('is_delete')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_supplier');
    }
};
