<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialMedia extends Model
{
    use HasFactory;
    protected $table ='social_media';

    protected $fillable = [
        'employer_id',
        'nama_pekerjaan',
        'kuota',
        'posisi_id',
    ];

    protected $casts = [
        'id' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
