<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelompokKategori extends Model
{
    use HasFactory;

    protected $table = 'tb_kelompok_kategori';
    protected $primaryKey = 'id_kelompok';



    protected $fillable = [
        'id_sekolah',
        'nama_kelompok',
        'created_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    public function kategori()
    {
        return $this->hasMany(Kategori::class, 'id_kelompok', 'id_kelompok');
    }
}