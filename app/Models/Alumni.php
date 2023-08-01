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
        'thn_lulus',
        
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi_id');
    }
}
