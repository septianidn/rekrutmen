<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class LaporanTS extends Model implements HasMedia
{

    use HasFactory, InteractsWithMedia;

    protected $table = 'laporan_ts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paket_soal_id',
      
        'lokasi_laporan',
        'deskripsi',
        'published'
    ];

    public function paket_soal()
    {
        return $this->belongsTo(PaketSoal::class, 'paket_soal_id');
    }
}
