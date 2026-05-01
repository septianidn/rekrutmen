<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobFair extends Model
{
    use HasFactory;

    protected $table = 'job_fair';

    protected $fillable = [
        'nama',
        'deskripsi',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'kuota',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'kuota' => 'integer',
    ];

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_fair_job', 'job_fair_id', 'job_id')
            ->withPivot('id', 'employer_id', 'status', 'lokasi_booth', 'kode_booth')
            ->withTimestamps();
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(JobFairAttendance::class, 'job_fair_id');
    }

    public function boothScans(): HasMany
    {
        return $this->hasMany(JobFairBoothScan::class, 'job_fair_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Registration is open while the fair is active and the start date
     * has not yet passed (employers must register before the event starts).
     */
    public function isRegistrationOpen(): bool
    {
        return $this->isActive() && $this->tanggal_mulai->isFuture();
    }

    /**
     * Count registrations that count against kuota (pending + approved).
     * Rejected registrations free up the slot.
     */
    public function registeredCount(): int
    {
        return $this->jobs()->wherePivotIn('status', ['pending', 'approved'])->count();
    }

    public function hasCapacity(): bool
    {
        if ($this->kuota === null) {
            return true;
        }
        return $this->registeredCount() < $this->kuota;
    }
}
