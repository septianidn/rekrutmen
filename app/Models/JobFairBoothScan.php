<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class JobFairBoothScan extends Model
{
    const COOLDOWN_MINUTES = 10;

    protected $fillable = [
        'job_fair_id',
        'job_fair_job_id',
        'jobseeker_id',
        'job_id',
        'status',
        'dipanggil_at',
        'selesai_at',
        'tidak_hadir_at',
        'catatan',
    ];

    protected $casts = [
        'dipanggil_at'   => 'datetime',
        'selesai_at'     => 'datetime',
        'tidak_hadir_at' => 'datetime',
    ];

    public function jobFair(): BelongsTo
    {
        return $this->belongsTo(JobFair::class, 'job_fair_id');
    }

    public function jobFairJob(): BelongsTo
    {
        return $this->belongsTo(JobFairJob::class, 'job_fair_job_id');
    }

    public function jobseeker(): BelongsTo
    {
        return $this->belongsTo(Jobseeker::class, 'jobseeker_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function cooldownEndsAt(): ?Carbon
    {
        if (!$this->dipanggil_at) {
            return null;
        }
        return $this->dipanggil_at->addMinutes(self::COOLDOWN_MINUTES);
    }

    public function canMarkAbsent(): bool
    {
        return $this->status === 'dipanggil'
            && $this->dipanggil_at !== null
            && $this->cooldownEndsAt()->isPast();
    }
}
