<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokPelanggan extends Model
{
    protected $table = 'tb_kelompok_pelanggan';
    protected $primaryKey = 'id_kelompok_pelanggan';
    public $timestamps = false;

    protected $fillable = [
        'id_sekolah',
        'nama_kelompok',
    ];

    // Relasi ke Sekolah
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }
}