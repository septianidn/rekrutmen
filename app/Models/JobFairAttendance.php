<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobFairAttendance extends Model
{
    protected $fillable = [
        'job_fair_id',
        'jobseeker_id',
        'kode_qr',
        'checked_in_at',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function jobFair(): BelongsTo
    {
        return $this->belongsTo(JobFair::class, 'job_fair_id');
    }

    public function jobseeker(): BelongsTo
    {
        return $this->belongsTo(Jobseeker::class, 'jobseeker_id');
    }

    public function isCheckedIn(): bool
    {
        return $this->checked_in_at !== null;
    }
}
