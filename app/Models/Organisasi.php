<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Organisasi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jobseeker_id',
        'nama_organisasi',
        'jabatan',
        'keterangan',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'jobseeker_id' => 'integer',
    ];

    public function jobseeker(): BelongsTo
    {
        return $this->belongsTo(Jobseeker::class);
    }
}
