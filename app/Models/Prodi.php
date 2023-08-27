<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $primaryKey = 'kode_prodi';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
        'jenjang_id',
        'fakultas_id'
        
    ];

    


    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }
   
    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_id');
    }

    public function alumni()
    {
        return $this->hasMany(Alumni::class, 'kode_prodi');
    }

    public function kaprodi()
    {
        return $this->hasMany(Kaprodi::class, 'kode_prodi_id', 'kode_prodi');
    }
}
