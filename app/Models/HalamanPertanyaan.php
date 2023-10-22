<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HalamanPertanyaan extends Model
{
    use HasFactory;

    protected $table = 'halaman_pertanyaan';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paket_soal_id',
        'urutan',
        'nama_halaman',
        
    ];

    public function pertanyaan()
    {
       return $this->hasMany(Pertanyaan::class, 'halaman_id');
    }


}
