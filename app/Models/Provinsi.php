<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsi';
    protected $primaryKey ='kode_provinsi';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_provinsi',
        'kode_provinsi',
        
    ];
    
    public function kabupatenKota()
    {
        return $this->hasMany(KabupatenKota::class, 'provinsi_id', 'kode_provinsi');
    }
    
 
}
