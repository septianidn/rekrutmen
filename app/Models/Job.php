<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;
    protected $table = 'job';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employer_id',
        'nama_pekerjaan',
        'alamat',
        'posisi',
        'requirement',
        'deskripsi_pekerjaan',
        'ekspektasi_gaji',
        'worktime',
        'application_deadline',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employer_id' => 'integer',
        'posisi_id' => 'integer',
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class)->orderBy('urutan');
    }

    public function posisi(): BelongsTo
    {
        return $this->belongsTo(Posisi::class);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function jobFairs(): BelongsToMany
    {
        return $this->belongsToMany(JobFair::class, 'job_fair_job', 'job_id', 'job_fair_id')
            ->withPivot('employer_id', 'status')
            ->withTimestamps();
    }
}
