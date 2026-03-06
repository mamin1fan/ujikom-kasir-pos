<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'tb_supplier';
    protected $primaryKey = 'id_supplier';

    public $timestamps = false; 
    // karena hanya ada created_at manual

    protected $fillable = [
        'id_sekolah',
        'nama',
        'no_telepon',
        'alamat_supplier',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'is_delete',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }
}
