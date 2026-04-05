<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Pelanggan extends Model
{
    use SoftDeletes;
    protected $table = 'tb_pelanggan';
    protected $primaryKey = 'id_pelanggan';
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