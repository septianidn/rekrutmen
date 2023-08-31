<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    use HasFactory;

    protected $table = 'konten';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'judul',
        'kategori_konten_id',
        'isi_konten',
        'alias_url',        
        'waktu_terbit',        
        'waktu_tutup',        
        'gambar_headline',        
        'meta_key',        
        'meta_desc',  
        'tags',     
        'status_terbit_id' 
    ];

    public function kategori_konten()
    {
       return $this->belongsTo(KategoriKonten::class, 'kategori_konten_id');
    }

    public function status_terbit()
    {
       return $this->belongsTo(StatusTerbit::class, 'status_terbit_id');
    }


}
