<?php

namespace App\Models;

use App\Enums\TypePertanyaanGeneralOptionEnum;
use App\Enums\TypePertanyaanGridOptionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanZone extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_zone';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pertanyaan_id',
        'kode_input_kab_kota',
        'kode_input_provinsi',
       
           
    ];

   
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
    



}
