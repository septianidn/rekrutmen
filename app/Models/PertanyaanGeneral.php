<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanGeneral extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_general';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pertanyaan_id',
        'tipe_pertanyaan_general',
        'max_character_jawaban',
        'min_character_jawaban',
    
    ];

  
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
    


}
