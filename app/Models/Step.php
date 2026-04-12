<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Step extends Model
{
    use HasFactory;

    protected $table = 'step';

    protected $fillable = [
        'job_id',
        'proses_id',
        'urutan',
        'deskripsi',
    ];

    protected $casts = [
        'id' => 'integer',
        'job_id' => 'integer',
        'proses_id' => 'integer',
        'urutan' => 'integer',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function proses(): BelongsTo
    {
        return $this->belongsTo(Proses::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(Progress::class);
    }
}
