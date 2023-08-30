<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKonten extends Model
{
    use HasFactory;

    protected $table = 'kategori_konten';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_kategori',
        'alias_url',
        'grup_konten_id',
        'deskripsi',
        'published',        
    ];

   
    public function grup_konten()
    {
        return $this->belongsTo(GrupKonten::class, 'grup_konten_id');
    }

}
