<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobFairJob extends Model
{
    protected $table = 'job_fair_job';

    protected $fillable = [
        'job_fair_id',
        'job_id',
        'employer_id',
        'status',
        'lokasi_booth',
        'kode_booth',
    ];

    public function jobFair(): BelongsTo
    {
        return $this->belongsTo(JobFair::class, 'job_fair_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    public function boothScans(): HasMany
    {
        return $this->hasMany(JobFairBoothScan::class, 'job_fair_job_id');
    }
}
