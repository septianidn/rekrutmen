<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketSoal extends Model
{
    use HasFactory;

    protected $table = 'paket_soal';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_paket',
        'alias_url',
        'prolog_login',
        'deskripsi',
        'result_message',
        'prolog_after_logout',
        'tgl_tayang',
        'tgl_selesai_tayang',
        'untuk_lulusan',
        'tahun_pelaksanaan',
        'publish'
    ];

    public function halamanPertanyaan()
    {
       return $this->hasMany(HalamanPertanyaan::class, 'paket_soal_id');
    }

   
}
