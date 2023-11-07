<?php

namespace App\Models;

use App\Enums\TypePertanyaanEnum;
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

    protected $enumCasts = [
        'tipe_pertanyaan' => TypePertanyaanEnum::class,
    ];

  
    public function halamanPertanyaan()
    {
        return $this->belongsTo(HalamanPertanyaan::class, 'halaman_id');
    }
    
    public function pertanyaanGeneral()
    {
        return $this->hasOne(PertanyaanGeneral::class, 'pertanyaan_id');
    }

    public function pertanyaanGeneralOption()
    {
        return $this->hasMany(PertanyaanGeneralOption::class, 'pertanyaan_id');
    }

    public function pertanyaanZona()
    {
        return $this->hasOne(PertanyaanZone::class, 'pertanyaan_id');
    }
    public function pertanyaanDropdown()
    {
        return $this->hasOne(PertanyaanDropdown::class, 'pertanyaan_id');
    }

    public function pertanyaanGridOption()
    {
        return $this->hasMany(PertanyaanGridOption::class, 'pertanyaan_id');
    }
    


}
