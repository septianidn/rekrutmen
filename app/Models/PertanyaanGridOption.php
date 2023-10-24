<?php

namespace App\Models;

use App\Enums\TypePertanyaanGeneralOptionEnum;
use App\Enums\TypePertanyaanGridOptionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanGridOption extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_grid_option';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pertanyaan_id',
        'kode',
        'urutan',
        'value',
        'label',
        'tipe_grid',
       
           
    ];

    protected $enumCasts = [
        'tipe_grid' => TypePertanyaanGridOptionEnum::class,
    ];

    
    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
    



}
