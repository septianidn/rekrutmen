<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanTS extends Model
{
    use HasFactory;

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

    public function paketSoal()
    {
        return $this->hasOne(PaketSoal::class, 'id', 'paket_soal_id');
    }
}
