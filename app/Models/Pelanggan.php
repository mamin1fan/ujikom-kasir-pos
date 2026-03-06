<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'tb_pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $timestamps = false;

    protected $fillable = [
        'id_kelompok_pelanggan',
        'nama_pelanggan',
        'telepon',
        'alamat',
        'created_by',
        'updated_by',
        'deleted_by',
        'is_delete',
    ];

    // Relasi ke Kelompok Pelanggan
    public function kelompok()
    {
        return $this->belongsTo(
            KelompokPelanggan::class,
            'id_kelompok_pelanggan',
            'id_kelompok_pelanggan'
        );
    }
}