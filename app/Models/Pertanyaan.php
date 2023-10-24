<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_soal',
        'halaman_id',
        'urutan',
        'pertanyaan',
        'tipe_pertanyaan',
        'wajib_dijawab',
        
    ];

  
    public function halamanPertanyaan()
    {
        return $this->belongsTo(HalamanPertanyaan::class, 'halaman_id');
    }
    
    public function pertanyaanGeneral()
    {
        return $this->hasOne(PertanyaanGeneral::class, 'pertanyaan_id');
    }
    


}
