<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'application';

    protected $fillable = [
        'jobseeker_id',
        'job_id',
        'tanggal_apply',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
        'jobseeker_id' => 'integer',
        'job_id' => 'integer',
        'tanggal_apply' => 'date',
    ];

    public function progress(): HasMany
    {
        return $this->hasMany(Progress::class);
    }

    public function jobseeker(): BelongsTo
    {
        return $this->belongsTo(Jobseeker::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
