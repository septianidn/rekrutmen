<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jobseeker extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'jobseeker';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'jenis_kelamin',
        'ttl',
        'jobseeker_id_type',
        'jobseeker_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'ttl' => 'date',
        'jobseeker_id_type' => 'integer',
        'jobseeker_type_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobseekerType(): BelongsTo
    {
        return $this->belongsTo(JobseekerType::class);
    }

    public function jobseeker(): BelongsTo
    {
        return $this->belongsTo(JobseekerType::class);
    }

    public function organisasis(): HasMany
    {
        return $this->hasMany(Organisasi::class);
    }

    public function bahasas(): HasMany
    {
        return $this->hasMany(Bahasa::class);
    }

    public function riwayatKerjas(): HasMany
    {
        return $this->hasMany(RiwayatKerja::class);
    }

    public function prestasis(): HasMany
    {
        return $this->hasMany(Prestasi::class);
    }

    public function pelatihans(): HasMany
    {
        return $this->hasMany(Pelatihan::class);
    }

    public function rekomendasis(): HasMany
    {
        return $this->hasMany(Rekomendasi::class);
    }

    public function riwayatPendidikans(): HasMany
    {
        return $this->hasMany(RiwayatPendidikan::class);
    }
}
