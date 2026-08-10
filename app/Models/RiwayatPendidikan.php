<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPendidikan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pendidikan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jobseeker_id',
        'jenjang_id',
        'kode_prodi_id',
        'prodi_lain',
        'instansi',
        'indeks_nilai',
        'keterangan',
        'dokumen',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'jobseeker_id' => 'integer',
        'jenjang_id' => 'integer',
        'kode_prodi_id' => 'integer',
    ];

    public function jobseeker(): BelongsTo
    {
        return $this->belongsTo(Jobseeker::class);
    }

    public function jenjang(): BelongsTo
    {
        return $this->belongsTo(Jenjang::class);
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi_id', 'kode_prodi');
    }
}
