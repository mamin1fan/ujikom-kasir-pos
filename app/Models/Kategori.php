<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Kategori extends Model
{
    use SoftDeletes;
    protected $table = 'tb_kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'id_kelompok',
        'nama',
        'created_by',
        'updated_by',
        'deleted_by',
        'is_delete',
    ];

    // Relasi ke KelompokKategori
    public function kelompok()
    {
        return $this->belongsTo(KelompokKategori::class, 'id_kelompok', 'id_kelompok');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}