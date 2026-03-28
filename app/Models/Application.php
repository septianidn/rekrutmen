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
    protected $fillable = [
        'jobseeker_id',
        'tanggal_apply',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'jobseeker_id' => 'integer',
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
}
