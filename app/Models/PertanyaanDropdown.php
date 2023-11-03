<?php

namespace App\Models;

use App\Enums\TypePertanyaanGeneralOptionEnum;
use App\Enums\TypePertanyaanGridOptionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanDropdown extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_dropdown';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pertanyaan_id',
        'data_pedia_id',
        'placeholder',
       
           
    ];

   
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
    



}
