<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupKonten extends Model
{
    use HasFactory;

    protected $table = 'grup_konten';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_grup',
        'alias_url',
        'deskripsi',
        'published',        
    ];

   


}
