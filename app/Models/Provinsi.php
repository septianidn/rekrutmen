<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsi';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_provinsi',
        'kode_provinsi',
        
    ];
    
    public function kabupaten()
    {
        return $this->hasMany(Kabupaten::class, 'provinsi_id');
    }
   
}
