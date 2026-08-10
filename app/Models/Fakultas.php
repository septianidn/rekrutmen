<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;

    protected $table = 'fakultas';
    protected $primaryKey = 'fakultas_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_fakultas',
    ];
    
    public function prodi()
    {
       return $this->hasMany(Prodi::class, 'fakultas_id');
    }

   
   
}
