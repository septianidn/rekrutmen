<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'membership';

    protected $fillable = [
        'nama_membership',
        'harga',
        'durasi_hari',
        'can_post_job',
        'can_post_article',
        'deskripsi',
    ];

    protected $casts = [
        'id' => 'integer',
        'harga' => 'decimal:2',
        'durasi_hari' => 'integer',
        'can_post_job' => 'boolean',
        'can_post_article' => 'boolean',
    ];

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }
}
