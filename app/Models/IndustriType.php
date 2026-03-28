<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndustriType extends Model
{
    use HasFactory;
    protected $table = 'industri_type';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_industri',
        'employer_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employer_id' => 'integer',
    ];

    public function employer(): BelongsTo
    {
        return $this->belongsTo(Employer::class);
    }
}
