<?php

namespace App\Models;

use App\Enums\TypePertanyaanGeneralEnum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanGeneralOption extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_general_option';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pertanyaan_id',
       
        'urutan',
        'value',
        'label',
        'kode_input_tambahan',
        'tipe',
           
    ];

    protected $enumCasts = [
        'tipe' => TypePertanyaanGeneralOption::class,
    ];

    
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
    



}
