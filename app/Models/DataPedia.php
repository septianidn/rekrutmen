<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPedia extends Model
{
    use HasFactory;

    protected $table = 'data_pedia';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_data',
        'deskripsi_data',
        'published',
    ];
    
    public function datapediadetail()
    {
        return $this->hasMany(DataPediaDetail::class, 'data_pedia_id');
    }
   
}
