<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';
    protected $primaryKey = 'nim';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nim',
        'email',
        'nama',
        'kode_prodi_id',
        'thn_masuk',
        'tempat_lahir',
        'thn_lulus',
        'tanggal_lahir',
        'pin',
        'nomor_handphone',
        'periode_wisuda',
        'status_tc',
        'tipe_masuk',
        'nik',
        'npwp',
        'judul_tesis'
        
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi_id');
    }
}
