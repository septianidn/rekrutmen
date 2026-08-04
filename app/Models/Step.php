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
        'nama_custom',
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

    /**
     * Display name of the selection stage. When the employer chose the
     * "Lainnya" catalog entry, the real stage name is stored per-job in
     * nama_custom and shown instead of the generic "Lainnya" label.
     */
    public function getLabelAttribute(): string
    {
        return $this->nama_custom ?: ($this->proses->nama_proses ?? '-');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(Progress::class);
    }
}
