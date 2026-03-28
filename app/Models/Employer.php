<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'employer';
    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'deskripsi_perusahaan',
        'industriType_id',
        'alamat_perusahaan',
        'telp_perusahaan',
        'website'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'industriType_id' => 'integer',
    ];

    public function industriTypes(): HasMany
    {
        return $this->hasMany(IndustriType::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function industriType(): BelongsTo
    {
        return $this->belongsTo(IndustriType::class);
    }
}
